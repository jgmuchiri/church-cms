<?php

namespace App\Http\Controllers;

use App\Models\Sermons;
use App\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SermonsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['show','index','publicSermons']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index(){
        if (isset($_GET['s'])) {
            $term = $_GET['s'];

            $sermons = Sermons::whereStatus('published')
                ->where('desc', 'LIKE', "%$term%")
                ->orWhere('title', 'LIKE', "%$term%")
                ->orWhere('speaker', 'LIKE', "%$term%")
                ->orWhere('topic', 'LIKE', "%$term%")
                ->simplePaginate(25);
        } else {
            $sermons = Sermons::whereStatus('published')->simplePaginate(25);
        }
        return view('sermons.sermons',compact('sermons'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function sermonsAdmin()
    {
        if (isset($_GET['s'])) {
            $term = $_GET['s'];

            $sermons = Sermons::where('desc', 'LIKE', "%$term%")
                ->orWhere('title', 'LIKE', "%$term%")
                ->orWhere('speaker', 'LIKE', "%$term%")
                ->orWhere('topic', 'LIKE', "%$term%")
                ->simplePaginate(25);
        } else {
            $r = Request()->segment(3);
            if ($r == "drafts") {
                $status = "draft";
            } else {
                $status = "published";
            }
            $sermons = Sermons::whereStatus($status)->simplePaginate(25);
        }
        return view('sermons.index', compact('sermons'));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show($slug)
    {
        $sermon = Sermons::where('slug', $slug)->first();
        if(count($sermon)==0) return view('errors.404');
        $sermons = Sermons::simplePaginate(10);
        return view('sermons.show', compact('sermon', 'sermons'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create()
    {
        return view('sermons.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {

        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $s = new Sermons();

        $path = 'uploads/sermons';

        $file = Input::file('audio');
        if (($file !== null)) {
            $s->audio = Tools::uploadImage($request->audio,$path.'/audio/',time(),716,600);
        }

        $cover = Input::file('cover');
        if ($cover !== null) {
            $s->cover = Tools::uploadImage($request->cover,$path.'/cover/',time(),716,600);
        }

        //keep slugs unique
        $slug = Sermons::whereSlug($request->slug)->first();
        if(count($slug)>0){
            $slug = $slug.'_1';
        }else{
            $slug = date('m_d_Y') . '_' . str_replace(' ', '_', $request->title);
        }

        $s->user_id = Auth::user()->id;
        $s->title = $request->title;
        $s->slug = $slug;
        $s->desc = $request->desc;
        $s->message = $request->message;
        $s->video = $request->video;
        $s->topic = $request->topic;
        $s->sub_topic = $request->sub_topic;
        $s->speaker = $request->speaker;
        $s->scripture = $request->scripture;
        $s->created_at = $request->created_at;
        $s->status = $request->status;
        $s->save();

        flash()->success(__("Sermon added"));
        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $sermon = Sermons::whereId($id)->first();
        if (count($sermon) == 0)
            return view('errors.404');
        return view('sermons.edit', compact('sermon'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'name'=>'unique:sermons,name,'.$id
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $s = Sermons::find($id);

        $path = 'uploads/sermons';

        $file = Input::file('audio');
        if (($file !== null)) {
            if($s->audio !==null)
                @unlink($path.'/audio/'.$s->audio);
            $s->audio = Tools::uploadImage($request->audio,$path.'/audio/',time(),716,600);
        }

        $cover = Input::file('cover');
        if ($cover !== null) {
            if($s->cover !==null)
                @unlink($path.'/cover/'.$s->cover);
            $s->cover = Tools::uploadImage($request->cover,$path.'/cover/',time(),716,600);
        }

        $s->user_id = Auth::user()->id;
        $s->title = $request->title;
        $s->desc = $request->desc;
        $s->message = $request->message;
        $s->video = $request->video;
        $s->topic = $request->topic;
        $s->sub_topic = $request->sub_topic;
        $s->speaker = $request->speaker;
        $s->scripture = $request->scripture;
        $s->created_at = $request->created_at;
        $s->updated_at = date('Y-m-d H:i:s');
        $s->status = $request->status;
        $s->save();

        flash()->success(__("Sermon updated"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $s = Sermons::whereId($id)->first();
        if (count($s) > 0) {
            flash()->success(__("Sermon deleted"));
            $s->delete();
        } else {
            flash()->error(__("Sermon not found"));
        }
        return redirect()->back();
    }

}
