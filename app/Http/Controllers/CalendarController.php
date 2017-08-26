<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index', 'show']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        $events = Events::whereStatus('active')->get();
        $latestEvents = Events::whereStatus('active')->orderBy('created_at', 'ASC')->simplePaginate(15);
        return view('events.public', compact('events', 'latestEvents'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show($id)
    {
        $event = Events::findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * @return string
     */
    function eventsJSON(){
        if(request()->ajax()) {
            $events = Events::whereStatus('active')->get();
            return json_encode($events);
        }else{
            echo 'Invalid request';
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function calendarAdmin()
    {
        $events = Events::get();
        return view('events.calendar', compact('events'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function eventsList()
    {
        if (isset($_GET['s'])) {

            $term = $_GET['s'];
            $events = Events::where('desc', 'LIKE', "%$term%")
                ->orWhere('title', 'LIKE', "%$term%")
                ->orWhere('start', 'LIKE', "%$term%")
                ->orWhere('end', 'LIKE', "%$term%")
                ->simplePaginate(25);
        } else {
            $events = Events::simplePaginate(25);
        }
        return view('events.list', compact('events'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'title' => 'required|max:50',
                'start' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $e = new Events();
            $e->title = $request->title;
            $e->start = $request->start . ' ' . $request->startTime;
            if (!Input::has(__("allDay")))
                $e->end = $request->end . ' ' . $request->endTime;
            $e->desc = $request->desc;
            $e->allDay = $request->allDay;
            $e->url = $request->url;
            $e->registration = $request->registration;
            $e->form_id = $request->form_id;
            $e->status = $request->status;
            $e->created_at = date('Y-m-d H:i:s');
            $e->save();

            echo 'success';
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $event = Events::whereId($id)->first();

        return view('events.edit', compact('event'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:50',
            'start' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $e = Events::whereId($id)->first();
        $e->title = $request->title;
        $e->start = $request->start . ' ' . $request->startTime;
        if (!Input::has(__("allDay")))
            $e->end = $request->end . ' ' . $request->endTime;
        $e->desc = $request->desc;
        $e->allDay = $request->allDay;
        $e->url = $request->url;
        $e->registration = $request->registration;
        $e->form_id = $request->form_id;
        $e->status = $request->status;
        $e->created_at = date('Y-m-d H:i:s');
        $e->save();


        flash()->success(__("Event updated!"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $e = Events::whereId($id)->first();
        $e->delete();
        flash()->success(__("Event deleted!"));
        return redirect()->back();
    }

    /**
     * @param $e
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function registerEvent($e)
    {
        $event = Events::whereId($e)->first();;
        return view('events.registerEvent', compact('event'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function churchSchedule()
    {
        $schedule = DB::table(__("church_schedule"))->orderBy('order', 'ASC')->get();
        return view('events.church-schedule', compact(__("schedule")));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function churchScheduleStore(Request $request)
    {
        $rules = [
            'event' => 'required|max:50',
            'start' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'event' => $request->event,
            'start' => $request->start,
            'end' => $request->end,
            'desc' => $request->desc,
            'order' => $request->order
        );
        DB::table(__("church_schedule"))->insert($data);
        flash()->success(__("Event added"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function churchScheduleUpdate(Request $request, $id)
    {
        $rules = [
            'event' => 'required|max:50',
            'start' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'event' => $request->event,
            'start' => $request->start,
            'end' => $request->end,
            'desc' => $request->desc,
            'order' => $request->order
        );
        DB::table(__("church_schedule"))->where('id', $id)->update($data);
        flash()->success(__("Event updated"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function churchScheduleDelete($id)
    {
        DB::table(__("church_schedule"))->where('id', $id)->delete();
        flash()->success(__("Event deleted"));
        return redirect()->back();
    }
}
