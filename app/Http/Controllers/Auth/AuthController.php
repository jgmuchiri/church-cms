<?php

namespace App\Http\Controllers\Auth;

use App\Models\Billing\Membership;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'name' => 'required',
                'phone' => 'required'
            ]);
        if ($validator->fails()) {
            flash()->error(__('Error').'!'.__("Check fields and try again"));
            return redirect('/login')->withErrors($validator)->withInput();
        }

        $confirmation_code = Str::random(30);

        //subscribe to trial plan
        $customer = Membership::newUserTrialPlan([
            'email' => $request['email'],
            'plan'=>$request->plan
        ]);
        $subscription = $customer['subscriptions']->data[0];
        //log transaction
        //$subscription->id;

        $user = new User();
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
            $m->from(config('mail.from.address'),
                config('app.name'));

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
            $m->from(config('mail.from.address'), config('app.name'));
            $m->to($user->email, $user->first_name)->subject(__("Verify your email address"));
        });
        flash()->success(__("Please check  email to verify your account"));
        return redirect()->back();
    }
}