<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use App\Models\Settings;
use App\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * @return mixed
     */
    function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {
            return view('admin.dashboard');
        } else {
            return redirect('account');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function settings()
    {
        if (Settings::isDemo()) return redirect()->back();

        $envFile = "../.env";
        $fhandle = fopen($envFile, "rw");
        $size = filesize($envFile);
        $envContent = "";
        if ($size == 0) {
            flash()->error('Your .env file is empty');
        } else {
            $envContent = fread($fhandle, $size);
            fclose($fhandle);
        }
        return view('admin.settings', compact('envContent'));


    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    function backupEnv(Request $request)
    {
        $envFile = "../.env";
        return response()->download($envFile, env('APP_NAME') . '-ENV-' . date('Y-m-d_H-i') . '.txt');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateEnv(Request $request)
    {
        $envFile = "../.env";
        $fhandle = fopen($envFile, "w");
        fwrite($fhandle, $request->envContent);
        fclose($fhandle);
        flash()->success('Settings have been update. Please verify that your application is working properly.');
        return redirect()->back();
    }

    /**
     * upload logo
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadLogo(Request $request)
    {
        if ($request->logo !== null) {
            $path = 'images/';
           Tools::uploadImage(Input::file('logo'), $path, 'logo');
        }

        flash()->success('Logo uploaded updated!');
        return redirect()->back();
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

        $menu = new MainMenu();
        $menu->title = $request->title;
        $menu->path = $request->path;
        $menu->order = $request->order;
        $menu->active = $request->active;
        $menu->parent = $request->parent;
        $menu->icon = $request->icon;
        $menu->save();
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

        $msg = '';

        $menu->title = $request->title;
        $menu->path = $request->path;
        $menu->order = $request->order;
        $menu->parent = $request->parent;
        $menu->icon = $request->icon;
        $menu->active = $request->active;
        $menu->save();

        flash()->success('Menu item updated ' . $msg);
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
                $c = $id_ary[$i]-1;
                if($c>0){
                    $p = MainMenu::find($c);
                    if($p->parent ==0) //assign only to parents
                        $q->parent = $p->id;
                    else
                        $q->parent =0;
                }
                $q->order = $i;
                $q->save();
            }
            return 'success';
        }
        return '';
    }

}
