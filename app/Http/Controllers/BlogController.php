<?php

namespace App\Http\Controllers;

use App\Models\Blog\Blog;
use App\Models\Blog\BlogComments;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index', 'show']]);
        $this->middleware(['permission:create-blog'], ['only' => ['admin', 'create', 'store', 'createCat']]);
        $this->middleware(['permission:update-blog'], ['only' => ['update', 'edit', 'updateCat']]);
        $this->middleware(['permission:delete-blog'], ['only' => ['destroy', 'deleteComment']]);
        $this->middleware(['ability:admin|owner'], ['only' => ['deleteComment']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {

        if(isset($_GET['cat'])) {

            $cat = DB::table('blog_cats')->where('name', $_GET['cat'])->first();

            if(!$cat)
                $blog = Blog::whereStatus('published')
                    ->orderBy('created_at', 'DESC')
                    ->simplePaginate(25);
            else
                $blog = Blog::whereStatus('published')
                    ->whereRaw("find_in_set($cat->id,category)")
                    ->orderBy('created_at', 'DESC')
                    ->simplePaginate(25);
        } else {
            $blog = Blog::whereStatus('published')
                ->orderBy('created_at', 'DESC')
                ->simplePaginate(25);
        }

        $cats = DB::table('blog_cats')->get();
        return view('blog.index', compact('blog', 'cats'));
    }

    /**
     * @param $article_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $id
     */
    function show($article_id)
    {
        $article = Blog::findOrFail($article_id);
        $comments = BlogComments::whereArticleId($article_id)->simplePaginate(25);
        $cats = DB::table('blog_cats')->get();
        return view('blog.article', compact('article', 'comments', 'cats'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function admin()
    {

        $blog = Blog::simplePaginate(25);

        return view('blog.admin', compact('blog'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create()
    {
        return view('blog.create', compact('create'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $cats = Input::get('categories');
        if(is_array($cats)) {
            $allCats = implode(',', $cats);
        } else {
            $allCats = $cats;
        }

        $blog = new Blog();
        $blog->category = $allCats;
        $blog->user_id = Auth::user()->id;
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->status = $request->status;
        $blog->published_at = $request->published_at;
        $blog->created_at = date('Y-m-d H:i:s');
        $blog->save();

        flash()->success(__("Blog posted"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $blog = Blog::find($id);
        return view('blog.edit', compact('blog'));
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
            'body' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cats = Input::get('categories');
        if(is_array($cats)) {
            $allCats = implode(',', $cats);
        } else {
            $allCats = $cats;
        }

        $blog = Blog::find($id);
        $blog->category = $allCats;
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->status = $request->status;
        $blog->published_at = $request->published_at;
        $blog->updated_at = date('Y-m-d H:i:s');
        $blog->save();

        flash()->success(__("Blog updated"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        flash()->success(__("Blog deleted"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function postComment(Request $request, $id)
    {
        $rules = [
            'comment' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cm = new BlogComments();
        $cm->article_id = $id;
        $cm->user_id = Auth::user()->id;
        $cm->parent_id = $request->parent_id;
        $cm->comment = $request->comment;
        $cm->save();
        flash()->success(__("Comment posted"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function deleteComment($id)
    {
        $cm = BlogComments::findOrFail($id);
        $cm->delete();

        flash()->success(__("Comment deleted"));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function categories()
    {
        $cats = DB::table('blog_cats')->get();
        return view('blog.categories', compact('cats'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function storeCat(Request $request)
    {
        $rules = [
            'name' => 'required|max:50|unique:blog_cats'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = array(
            'name' => str_replace(array('&', '?'), 'and', $request->name),
            'desc' => $request->desc
        );
        DB::table('blog_cats')->insert($data);
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
        $rules = [
            'name' => 'required|max:50|unique:blog_cats,name,'.$id
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = array(
            'name' => str_replace(array('&', '?'), 'and', $request->name),
            'desc' => $request->desc
        );
        DB::table('blog_cats')->where('id', $id)->update($data);
        flash()->success(__("Category updated"));
        return redirect()->back();

    }
}
