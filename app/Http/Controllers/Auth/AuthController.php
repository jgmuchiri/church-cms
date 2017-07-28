<?php

namespace App\Http\Controllers\Auth;

use App\Log;
use App\Models\Billing\Membership;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Mail;

use App\Permission;
use App\Role;
use Illuminate\Support\Facades\View;

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
            return redirect('dashboard');
        }

        flash()->error('Username or password incorrect');
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
            flash()->error('No confirmation code found');
            return redirect('/');
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if (!$user) {
            flash()->error('Confirmation code is invalid or expired');
            return redirect('/');
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        flash()->success('You have successfully verified your account.');
        return redirect('/');
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function roles()
    {
        $roles = Role::all();
        return view('admin.roles', compact('roles'));
    }

    /**
     * find roles
     */
    function rolesJson()
    {
        $q = $_GET['q'];
        $roles = DB::table('roles')
            ->distinct()
            ->select('*')
            ->where('display_name', 'like', "%$q%")
            ->get();

        $json = array();
        foreach ($roles as $role) {
            array_push($json, array(
                    'id' => $role->id,
                    'name' => $role->display_name)
            );
        }
        echo json_encode($json);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function newRole(Request $request)
    {
        $rules = [
            'name' => 'required|max:50|unique:roles',
            'display_name' => 'required|max:50|unique:roles',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role = new Role();
        $role->name = $request['name'];
        $role->display_name = $request['display_name'];
        $role->description = $request['description'];
        $role->save();

        flash()->success('Role added');
        return redirect()->back();
    }


    /**
     * @param null $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    function permissions($key = null)
    {
        if (Request()->ajax()) {
            if (empty($key)) {
                $permissions = Permission::paginate(20);
                return Response()->json(View::make('admin.permissions-ajax',
                    [
                        'noPaginate' => 1, 'permissions' => $permissions
                    ])->render());
            } else {
                $permissions = Permission::where('name', 'LIKE', '%' . $key . '%')->paginate(20);
                return Response()->json(View::make('admin.permissions-ajax',
                    [
                        'noPaginate' => 1, 'permissions' => $permissions
                    ])->render());
            }
        } else {
            $my_perm = array();
            if (isset($_GET['perm'])) {
                $my_perm = Permission::findOrFail($_GET['perm']);
            }

            $permissions = Permission::paginate(15);
            return view('admin.permissions', compact('permissions', 'my_perm'));
        }
    }
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    function storePermission(Request $request)
    {
        $rules = [
            'module' => 'required|max:50',
            'perms' => 'required',
            'roles' => 'required'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $module = $request->module;

        if ($request->has('special')) {
            $perm = new Permission();
            $perm->name = $request->name;
            $perm->display_name = $request->display_name;
            $perm->description = $request->description;
            $perm->save();

            foreach ($request->roles as $r) {
                $role = Role::find($r);
                $role->detachPermission($perm);
                $role->attachPermission($perm);
            }
        } else {

            $perms = str_split($request->perms, 1);

            foreach ($perms as $p) {
                $permName = self::permName($p);
                $pName = $module . '-' . $permName;
                $oldP = Permission::where('name', $pName)->first();
                if (count($oldP) > 0) {
                    $perm = $oldP;
                } else {
                    //create permission
                    $perm = new Permission();
                    $perm->name = $pName;
                    $perm->display_name = ucwords($permName) . ' ' . ucwords($module);
                    $perm->description = $request->description;
                    $perm->save();
                }

                //assign permission to role
                foreach ($request->roles as $r) {
                    $role = Role::find($r);
                    $role->detachPermission($perm);
                    $role->attachPermission($perm);
                }

            }
        }

        flash()->success('Permission added');
        return redirect()->back();
    }

    /**
     * @param $perm
     * @return string
     */
    function permName($perm)
    {
        switch ($perm) {
            case 'c':
                $perm = 'create';
                break;
            case 'r':
                $perm = 'read';
                break;
            case 'u':
                $perm = 'update';
                break;
            case 'd':
                $perm = 'delete';
                break;
        }
        return $perm;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updatePermission(Request $request)
    {
        $id = $request->perm_id;
        $rules = [
            'name' => 'required|max:50',
            //'description' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $perm = Permission::find($id);
        $perm->name = $request->name;
        $perm->display_name = $request->display_name;
        $perm->description = $request->description;
        $perm->save();

        //dump permission roles
        DB::table('permission_role')->where('permission_id', $perm->id)->delete();
        //attach to role
        foreach ($request->roles as $r) {
            $role = Role::find($r);
            //new roles
            $role->attachPermission($perm);

        }

        flash()->success('Permission updated');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function deletePermission($id)
    {
        $perm = Permission::findOrFail($id);
        $perm->delete();
        flash()->success('Deleted!');
        Log::add('deleted ' . $perm->name . ' permission', 'system', 'admin', $perm);
        return redirect('permissions');
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
            flash()->error('Error! Check fields and try again');
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
            $m->from(env('EMAIL'),
                env('APP_NAME'));

            $m->to($request['email'], $request['first_name'])->subject('Verify your email address');
        });

        //subscribe to mailchimp
        //Newsletter::subscribe($request['email'],['firstName'=>$request['first_name']]);

        flash()->success('Thanks for signing up! Please check your email.');

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
            flash()->success('This account is already verified');
            return redirect('account');
        }

        if ($user->confirmation_code == null) {
            $user->confirmation_code = sha1(time());
            $user->save();
        }
        Mail::send('emails.accounts-verify', ['confirmation_code' => $user->confirmation_code], function ($m) use ($request, $user) {
            $m->from(env('EMAIL'), env('APP_NAME'));
            $m->to($user->email, $user->first_name)->subject('Verify your email address');
        });
        flash()->success('Please check  email to verify your account');
        return redirect('dashboard');
    }
}