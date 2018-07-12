<?php

namespace App\Http\Controllers;

use App\Models\Kb;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KbController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index', 'topic', 'search']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        $kbs = Kb::whereActive(1)->paginate();
        $kbCats = DB::table('kb_cats')->get();
        return view('kb.index', compact('kbs', 'kbCats'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function topic($id)
    {
        $cat = DB::table('kb_cats')->where('name', 'like', $id)->first();
        if (!empty($cat))
            $topics = Kb::whereCategory($cat->id)->whereActive(1)->simplePaginate(25);
        else
            $topics = array();
        return view('kb.topic', compact(__("topics")));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function search()
    {
        if (isset($_GET['s'])) {
            $term = $_GET['s'];
        } else {
            $term = "";
        }
        $topics = Kb::where('active', 1)
            ->where('answer', 'LIKE', "%$term%")
            ->orWhere('question', 'LIKE', "%$term%")
            ->orWhere('question_desc', 'LIKE', "%$term%")
            ->simplePaginate(25);
        return view('kb.topic', compact(__("topics")));
    }


    /**
     * post a question by user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function sendQuestion(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'desc' => 'required|max:150'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->cat !== "") {
            $cat = DB::table('kb_cats')->where('name', $request->cat)->first();
            if (!empty($cat)) {
                $cat = $cat->id;
            } else {
                $cat = 1;
            }
        } else {
            $cat = 1;
        }
        $kb = new Kb();
        $kb->question = $request->name;
        $kb->question_desc = $request->desc;
        $kb->category = $cat;
        $kb->created_at = date('Y-m-d H:i:s');
        $kb->active = 0;
        $kb->save();
        flash()->success(__("Thank you! We will respond as soon as possible"));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create()
    {
        return view('kb.edit-question');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        $rules = [
            'question' => 'required|max:100',
            'question_desc' => 'required|max:350',
            'answer' => 'max:350'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cat = DB::table('kb_cats')->where('name', $request->cat)->first();

        if (!empty($cat)) {
            $cat = $cat->id;
        } else {
            $cat = 1;
        }

        $kb = new Kb();
        $kb->question = $request->question;
        $kb->question_desc = $request->question_desc;
        $kb->answer = $request->answer;
        $kb->category = $cat;
        $kb->created_at = date('Y-m-d H:i:s');
        $kb->active = $request->active;
        $kb->save();
        flash()->success(__("Question added"));
        return redirect()->back();
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function questions($id = null)
    {

        if ($id !== null) {
            $cat = DB::table('kb_cats')->where('name', $id)->first()->id;
            $questions = Kb::whereActive(0)->whereCategory($cat)->get();
        } else {
            $questions = Kb::get();
        }

        return view('kb.questions', compact('questions'));
    }

    /**
     * for admins
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function question($id)
    {

        $qn = Kb::findOrFail($id);
        $kbCats = DB::table('kb_cats')->get();
        return view('kb.edit-question', compact('qn', 'kbCats'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    function updateQuestion(Request $request, $id)
    {
        $rules = [
            'question' => 'required|max:100',
            'question_desc' => 'required|max:350'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $qn = Kb::findOrFail($id);
        $qn->update($request->all());
        $qn->save();

        flash()->success(__("Question updated"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $q = Kb::findOrFail($id);
        $q->delete();
        flash()->success(__("Question deleted"));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function categories()
    {
        $cats = DB::table('kb_cats')->get();
        return view('kb.categories', compact('cats'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    function storeCategory(Request $request)
    {
        $rules = [
            'name' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'icon' => $request->icon,
            'order' => $request->order
        );
        DB::table('kb_cats')->insert($data);
        flash()->success(__("Category added"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    function updateCategory(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'icon' => $request->icon,
            'order' => $request->order
        );
        DB::table('kb_cats')->where('id', $id)->update($data);
        flash()->success(__("Category updated"));
        return redirect()->back();
    }
}
