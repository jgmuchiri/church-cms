<?php

namespace App\Http\Controllers\Auth;

use App\Models\Billing\Membership;
use App\Models\Modules;
use App\Permission;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Mail;

use App\Models\PermissionRole;

use App\Role;

class AuthController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','confirmAccount']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('account');
        }

        flash()->error(__('Username or password is incorrect'));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }
    /**
     * @param $confirmation_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmAccount($confirmation_code)
    {
        if (!$confirmation_code) {
            flash()->error(__('No confirmation code found'));
            return redirect('/');
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if (!$user) {
            flash()->error(__('Confirmation code is invalid or expired'));
            return redirect('/');
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        flash()->success(__('You have successfully verified your account'));
        return redirect('/');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function permissions($role_id, $module_id)
    {
        if (request()->ajax()) {
            $module = Modules::find($module_id);
            $levels = ['create', 'read', 'update', 'delete'];
            $rolePerms = array();
            foreach ($levels as $level) {
                $perm = Permission::where('name', $level . '-' . $module->name)->first();
                $role = null;
                if (count($perm) > 0)
                    $role = DB::table('permission_role')->where('role_id', $role_id)->where('permission_id', $perm->id)->first();
                if ($role == null)
                    $selected = false;
                else
                    $selected = true;
                $rolePerms[] = array(
                    'selected' => $selected,
                    'level' => $level
                );
            }
            return view('admin.permissions', compact('rolePerms'));
        }
    }


    function updateRolePermissions(Request $request)
    {
        if ($request->ajax()) {
            $role = $request->role;
            $module = Modules::find($request->module);
            $perms = $request->permissions;
            if (is_array($perms)) {
                //flush all permissions for this module
                $ps = ['create', 'update', 'read', 'delete'];
                foreach ($ps as $p) {
                    $permission = $p . '-' . $module->name;
                    $res = Permission::firstOrCreate(['name' => $permission, 'display_name' => ucwords($p) . ' ' . ucwords($module->name)]);
                    PermissionRole::where('permission_id', $res->id)->where('role_id', $role)->delete();
                }
                //assign new
                foreach ($perms as $perm) {
                    $permission = $perm . '-' . $module->name;
                    //find the permission
                    $p = Permission::where('name', $permission)->first();
                    DB::table('permission_role')->insert([
                        'permission_id' => $p->id,
                        'role_id' => $role
                    ]);
                }
            } else {
                DB::table('permission_role')->where('role_id', $role)->delete();
            }

            echo json_encode(['status' => 'success', 'message' => __('Role permissions updated')]);
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function roles()
    {
        $roles = Role::all();
        $modules = Modules::all();
        return view('admin.roles', compact('roles', 'modules'));
    }

    function showRole(Request $request)
    {
        if ($request->ajax()) {
            $role = Role::find($request->role_id);
            $data = array(
                'name' => $role->name,
                'display_name' => $role->display_name,
                'desc' => $role->desc
            );
            return $data;
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function newRole(Request $request)
    {
        $rules = [
            'name' => 'required|max:50|unique:roles',
            'display_name' => 'required|max:50|unique:roles'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $request->name = str_clean($request->name);
        Role::create($request->all());

        flash()->success('Role added');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateRole(Request $request,$id){
        $rules = [
            'display_name' => 'required|max:50|unique:roles,display_name,'.$id
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);

        $role->fill($request->all());
        $role->save();

        flash()->success(__('Role updated'));
        return redirect()->back();
    }
    /**
     * capture user submitted data
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function quickSignUp(Request $request)
    {
        $rules = [
            'email' => 'required|max:50|email|unique:users_temp',
            'phone' => 'unique:users_temp'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            //stay silent

        } else {
            //capture data
            $data = array(
                'first_name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'other' => $request->other,
                'created_at' => date('Y-m-d H:i:s')
            );
            DB::table('users_temp')->insert($data);
        }


        return view('auth.template');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return User
     * @internal param array $data
     */
    protected function createUser(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'username' => 'required|max:50|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'name' => 'required',
                'phone' => 'required'
            ]);
        if ($validator->fails()) {
            flash()->error(__('Error').'!'.__("Check fields and try again"));
            return redirect('/login')->withErrors($validator)->withInput();
        }

        $confirmation_code = str_random(30);

        //subscribe to trial plan
        $customer = Membership::newUserTrialPlan(['email' => $request['email']]);
        $subscription = $customer['subscriptions']->data[0];
        //log transaction
        //$subscription->id;

        $user = new User();
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->name =$request->name;
        $user->created_at = date('Y-m-d H:i:s');
        $user->confirmation_code = $confirmation_code;
       $user->stripe_id = $customer->id;
        $user->trial_ends_at = date('Y-m-d H:i:s', $subscription->trial_end);
        $user->subscription_id = $subscription->id;
        $user->save();

        //add to default role
        $user->attachRole('user');

        //delete if in temp table
        DB::table('users_temp')->where('email', $request->email)->delete();

        //notify user to activate account
        Mail::send('emails.accounts-verify', ['confirmation_code' => $confirmation_code], function ($m) use ($request) {
            $m->from(env('EMAIL_FROM_ADDRESS'),
                env('APP_NAME'));

            $m->to($request['email'], $request['first_name'])->subject('Verify your email address');
        });

        //subscribe to mailchimp
        //Newsletter::subscribe($request['email'],['firstName'=>$request['first_name']]);

        flash()->success(__("Thanks for signing up").__("Please check your email"));

        return redirect('login');

    }


    /**
     * allows posting email to send verification
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function resendConfirmation(Request $request)
    {
        if ($request->email !== null) { //post has email
            $user = User::whereEmail($request->email)->first();
        } else {
            if (Auth::guest()) return redirect('login');
            $user = User::find(Auth::user()->id);
        }

        if ($user->confirmed == 1) {//check if its verified
            flash()->success(__("This account is already verified"));
            return redirect('account');
        }

        if ($user->confirmation_code == null) {
            $user->confirmation_code = sha1(time());
            $user->save();
        }
        Mail::send('emails.accounts-verify', ['confirmation_code' => $user->confirmation_code], function ($m) use ($request, $user) {
            $m->from(env('EMAIL_FROM_ADDRESS'), env('APP_NAME'));
            $m->to($user->email, $user->first_name)->subject(__("Verify your email address"));
        });
        flash()->success(__("Please check  email to verify your account"));
        return redirect()->back();
    }
}