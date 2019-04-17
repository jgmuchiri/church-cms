<?php
/**
 * @package     church-cms
 * @file        AdminController.php
 * @copyright   2019 A&M Digital Technologies, LLC
 * @author      John Muchiri <hello[at]johnmuchiri.com>
 * @link        https://amdtllc.com
 * @modified    4/17/19 7:01 PM
 * @license     MIT
 *
 */

namespace App\Http\Controllers;

use App\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function settings()
    {
        $envFile = "../.env";
        $fhandle = fopen($envFile, "rw");
        $size = filesize($envFile);
        $envContent = "";
        if($size == 0) {
            flash()->error('Your .env file is empty');
        } else {
            $envContent = fread($fhandle, $size);
            fclose($fhandle);
        }
        return view('admin.settings', compact('envContent'));

    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    function backupEnv(Request $request)
    {
        $envFile = "../.env";
        return response()->download($envFile, config('app.name').'-ENV-'.date('Y-m-d_H-i').'.txt');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateEnv(Request $request)
    {
        $envFile = "../.env";
        $fhandle = fopen($envFile, "w");
        fwrite($fhandle, $request->envContent);
        fclose($fhandle);
        flash()->success(__("Settings have been update. Please verify that your application is working properly"));
        return redirect()->back();
    }

    /**
     * upload logo
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadLogo(Request $request)
    {
        if($request->logo !== NULL) {
            $path = 'images/';
            Tools::uploadImage(Input::file('logo'), $path, 'logo');
        }

        flash()->success(__("Logo uploaded updated!"));
        return redirect()->back();
    }
}
