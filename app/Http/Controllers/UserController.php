<?php

namespace App\Http\Controllers;

use App\Models\Billing\Subscriptions;
use App\Models\Billing\Transactions;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-users',['only'=>['users','user','findUser']]);
        $this->middleware('permission:create-users',['only'=>['registerUser']]);
        $this->middleware('permission:update-users',['only'=>['updateUser','updateUserRoles']]);

        $this->middleware('permission:read-profile',['only'=>['profile']]);
        $this->middleware('permission:update-profile',['only'=>['updateProfile']]);
        $this->middleware('permission:read-birthdays',['only'=>['birthdays']]);

    }

    /**
     * list all users
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function user($id)
    {

        $user = User::whereId($id)->first();

        $roles = Role::all();
        $currentRole = $user->roles->first();
        if ($currentRole == null)
            $currentRole = 0;
        else
            $currentRole =$currentRole->id;

        $gifts = Transactions::whereUserId($user->id)->get();
        return view('admin.user', compact('user', 'gifts', 'roles','currentRole'));

    }

    /**
     * register new user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'username' => 'required|max:50|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'dob' => 'required'
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $confirmation_code = str_random(30);

        //create stripe customer
        $customer = Transactions::createCustomer($request);

        $password = str_random(6);

        //create customer
        $request['confirmation_code'] = $confirmation_code;
        $request['password'] = bcrypt($password);
        $request['stripe_id'] = $customer->id;
        $user = User::create($request->all());

        //give basic role
        $user->attachRole(env('DEFAULT_ROLE'));

        //notify user to activate account
        Mail::send('emails.accounts-verify', ['email' => $request->email, 'password' => $password, 'confirmation_code' => $confirmation_code],
            function ($m) use ($request) {
                $m->from(env('EMAIL_FROM_ADDRESS'), env('EMAIL_FROM_NAME'));
                $m->to($request['email'], $request['first_name'])->subject('Your new account');
            });

        flash()->success(__("Account has been registered successfully").' '.__("Account confirmation email has been sent"));

        return redirect('users');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateUser(Request $request, $id)
    {
        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'dob' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Input::has('password')) {
            if (Input::get('password') == Input::get('password_confirm')) {
                $request['password']= bcrypt($request['password']);
            } else {
                flash()->warning(__("Error! Password confirmation does not match"));
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

        flash()->success(__("Profile updated!"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function updateUserRoles(Request $request)
    {
        $user = User::find($request->id);

        //admin cant take away their rights
        $me = User::find(Auth::user()->id);

        if ($me->hasRole('admin') && Auth::user()->id == $request->id) {
            flash()->error('You cannot change your own rights. Another admin should.');
        } else {
            //remove all
            $user->detachRoles();
            $user->attachRole($request->role);
            flash()->success(__("Roles updated"));
        }

        return redirect('user/' . $request->id . '#roles');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function userAccount()
    {
        $txns = Transactions::whereUserId(Auth::user()->id)->simplePaginate('50');
        return view('account.dashboard', compact('txns'));
    }

    /**
     * get current  user profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('account.profile', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function account()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = User::whereId(Auth::user()->id)->first();

        //$subscription = Subscriptions::whereStripeId($user->stripe_id)->orderBy('created_at','DESC')->first();
        try {
            if (Auth::user()->stripe_id !== "") {
                $cu = Customer::retrieve(Auth::user()->stripe_id);
                $subscription = $cu->subscriptions;
            } else {
                $subscription = null;
            }

        } catch (InvalidRequest $e) {

            $cu = null;
        }

        $transactions = Subscriptions::whereUserId($user->id)->get();
        $purchases = Transactions::whereUserId($user->id)->get();
        return view('auth.profile', compact('user', 'subscription', 'transactions', 'purchases'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'dob' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);

        if ($request->has('password')) {
            $rules =[
                'password'=>'min:6|confirmed'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $request['password'] = bcrypt($request['password']);
        }else{
            unset($request['password']);
        }

        if ($user->stripe_id == null || $user->stripe_id == "") {//create stripe customer
            $customer = Transactions::createCustomer($request);
            $request['stripe_id']= $customer->id;
        }
        $user->fill($request->all());
        $user->save();

        flash()->success(__("Profile updated!"));
        return redirect()->back();
    }


    /**
     * find users
     */
    function findUser()
    {
        $q = $_GET['q'];
        $users = DB::table('users')
            ->distinct()
            ->select('id', 'first_name', 'last_name', 'email', 'phone')
            ->where('first_name','like',"%$q%")
            ->orwhere('last_name','like',"%$q%")
            ->get();

        $json = array();
        foreach($users as $user){
            array_push($json, array(
                    'id'=>$user->id,
                    'name'=>$user->first_name.' '.$user->last_name.' ('.$user->email.')')
            );
        }
        echo json_encode($json);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param null $month
     * @internal param null $year
     */
    function birthdays()
    {

        if (isset($_GET['y']))
            $year = $_GET['y'];
        else
            $year = "%";

        if (isset($_GET['m']))
            $month = sprintf("%02d", $_GET['m']);
        else
            $month = date('m');

        if (isset($_GET['d']))
            $day = $_GET['d'];
        else
            $day = "%";

        $users = User::where('dob', 'LIKE', "$year-$month-$day")->get();

        $months = array();
        for ($i = 1; $i <= 12; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = date('F', $timestamp);
        }
        ksort($months);
        return view('admin.birthdays', compact('users', 'months'));
    }
}
