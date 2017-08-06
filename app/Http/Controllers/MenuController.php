<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function mainMenu()
    {
        $mainMenu = MainMenu::whereParent(0)->orderBy('order', 'ASC')->get();
        $subMenu = MainMenu::where('parent', '!=', 0)->orderBy('order', 'ASC')->get();


        $items = MainMenu::pluck('title', 'id');
        $items = array_add($items, '0', 'None');
        $items = $items->all();
        ksort($items);

        $menuItem=array();
        if (isset($_GET['m']))
        {
            $menuItem =MainMenu::findOrFail($_GET['m']);
        }
        $menu = MainMenu::get();
        return view('admin.mainmenu', compact('mainMenu', 'subMenu', 'items','menu','menuItem'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function storeMainMenu(Request $request)
    {
        $rules = [
            'title' => 'required|max:50:unique:main_menu',
            'path' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        MainMenu::create($request->all());
        flash()->success('Menu item added');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateMainMenu(Request $request)
    {
        $rules = [
            'title' => 'required|max:50:unique:main_menu,title,' . $request->id,
            'path' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $menu = MainMenu::find($request->id);
        $menu->fill($request->all());
        $menu->save();

        flash()->success('Menu item updated');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return string
     */
    function sortMenu(Request $request){
        if ($request->ajax()) {
            $id_ary = explode(",", $request->sort_order);
            for ($i = 0; $i < count($id_ary); $i++) {
                $q = MainMenu::find($id_ary[$i]);
                //get parent if any and move the sub menu over
//                $c = $id_ary[$i]-1;
//                if($c>0){
//                    $p = MainMenu::find($c);
//                    if($p->parent ==0) //assign only to parents
//                        $q->parent = $p->id;
//                    else
//                        $q->parent =0;
//                }
                $q->order = $i;
                $q->save();
            }
            return 'success';
        }
        return '';
    }

    function deleteMenuItem($id){
        $m = MainMenu::findOrFail($id);
        //reset all children
        $c = MainMenu::find($m->parent);
        $c->parent=0;
        $c->save();
        $m->delete();
        flash()->success('Menu deleted!');
        return redirect()->back();
    }

}
