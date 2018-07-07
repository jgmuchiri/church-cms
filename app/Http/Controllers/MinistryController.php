<?php

namespace App\Http\Controllers;

use App\Http\Requests\MinistryRequest;
use App\Http\Requests\UpdateMinistryRequest;
use App\Models\Ministry\Ministry;
use App\Models\Ministry\MinistryCats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MinistryController extends Controller
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
        if(isset($_GET['cat'])) {
            $cat = MinistryCats::where('name', $_GET['cat'])->first();
            if(!$cat) return view('errors.404');

            $ministries = Ministry::whereCat($cat->id)->whereActive(1)->get();
        } else {
            $cat = array();
            $ministries = Ministry::whereActive(1)->get();
        }
        $title = (__("Ministries"));
        $categories = MinistryCats::get();
        return view('ministries.index', compact('ministries', 'cat', 'title', 'categories'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show($id)
    {

        if(isset($_GET['preview']) && \Trust::can('ministries-update')) {

            $ministry = Ministry::findOrFail($id);

        } else {

            $ministry = Ministry::whereActive(1)->findOrFail($id);

        }

        if(!$ministry) return view("errors.404");

        $title = (__("View ministry"));

        $categories = MinistryCats::get();

        return view('ministries.show', compact('ministry', 'title', 'categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create()
    {

        $title = (__("New Ministry"));

        return view('ministries.create', compact('title'));

    }

    /**
     * @param MinistryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(MinistryRequest $request)
    {

        Ministry::create($request->all());

        flash()->success(__("Ministry added"));

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $ministry = Ministry::findOrFail($id);

        $title = (__("Edit ministry"));

        return view('ministries.edit', compact('ministry', 'title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(MinistryRequest $request)
    {

        $ministry = Ministry::findOrFail($request->id);

        $ministry->update($request->all());

        flash()->success(__("Ministry updated"));

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $ministry = Ministry::find($id);

        $ministry->delete();

        flash()->success(__("Ministry deleted"));

        return redirect()->back();
    }

    function admin()
    {
        if(isset($_GET['s'])) {
            $ministries = Ministry::where('name', 'like', '%'.$_GET['s'].'%')->paginate(10);
        } else {
            $ministries = Ministry::paginate(10);
        }

        $title = (__("Ministries"));

        return view('ministries.admin', compact('ministries', 'title'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function categories()
    {
        $cats = MinistryCats::get();
        $title = (__("Ministry Categories"));
        $myCat = array();
        if(isset($_GET['cat'])) {
            $myCat = MinistryCats::findOrFail($_GET['cat']);
        }
        return view('ministries.categories', compact('cats', 'title', 'myCat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function storeCat(Request $request)
    {
        MinistryCats::create($request->all());
        flash()->success(__("Category created"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateCat(Request $request, $id)
    {
        $mc = MinistryCats::findOrFail($id);

        $mc->update($request->all());

        flash()->success(__("Category updated"));
        return redirect()->back();

    }
}
