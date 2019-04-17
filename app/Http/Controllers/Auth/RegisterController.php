<?php

namespace App\Http\Controllers\Auth;

use App\Models\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function create(array $data)
    {
        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => Str::random(32),
            'confirmed' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'role_id' => function () {
                return Roles::where('name', config('auth.defaults.role'))->find()->id;
            },
        ];
    }

    /**
     * @param $confirmation_code
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmAccount($confirmation_code)
    {
        if(!$confirmation_code) {
            flash()->error(__("No confirmation code found"));
            return redirect('/');
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if(!$user) {
            flash()->error(__("Confirmation code is invalid or expired"));
            return redirect('/');
        }
        $user->confirmed = 1;
        $user->confirmation_code = NULL;
        $user->save();

        flash()->success(__("You have successfully verified your account"));
        return redirect('/');
    }

    /**
     * allows posting email to send verification
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function resendConfirmation(Request $request)
    {
        if($request->email !== NULL) { //post has email
            $user = User::whereEmail($request->email)->first();
        } else {
            if(Auth::guest()) return redirect('login');

            $user = User::find(Auth::user()->id);
        }

        if($user->confirmed == 1) {//check if its verified
            flash()->success(__("This account is already verified"));
            return redirect('/');
        }

        if($user->confirmation_code == NULL) {
            $user->confirmation_code = Str::random(32);
            $user->save();
        }
        Mail::send('emails.accounts-verify', ['confirmation_code' => $user->confirmation_code], function ($m) use ($request, $user) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user->email, $user->name)->subject(__("Verify your email address"));
        });
        flash()->success(__("Please check  email to verify your account"));
        return redirect('/');
    }
}
