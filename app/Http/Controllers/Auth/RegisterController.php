<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    //protected $redirectTo = '/home';

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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {


//        $user = User::create([
//            'username' => $data['username'],
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            'confirmation_code' => $data['confirmation_code'],
//            'confirmed' => 0
//        ]);

        $input = array(
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone'=>$data['phone'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => str_random(28),
            'confirmed' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $user_id = DB::table('users')->insertGetId($input);

        //assign role
        $user = User::find($user_id);
        $user->roles()->attach(env('DEFAULT_ROLE'));

        //send activation notice
        User::activationNotice($input);

        return $user;
    }

    function registerAjax(Request $request)
    {
        $rules = [
            'username' => 'required|min:4|unique:users',
            'phone'=>'required',
            'email' => 'required|email|unique:users',
            'address'=>'required',
            'password'=>'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            //return redirect()->back()->withErrors($validator)->withInput();
            return $validator->errors();
        }
        //register
        $request->confirmation_code = str_random(30);
        $data = array(
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone'=>$request->phone,
            'password' => bcrypt($request['password']),
            'confirmation_code' => $request->confirmation_code,
            'address'=>$request->address,
            'confirmed' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        $user_id = DB::table('users')->insertGetId($data);

        //assign role
        $user = User::find($user_id);
        if($request->has('role'))
            $user->roles()->attach($request->role);
        else
            $user->roles()->attach(3);

        //send activation notice
        //self::activationNotice($request);

        //login
        //flash()->info('Your account was created');
        return json_encode(['message'=>__("success")]);
    }


    /**
     * @param $confirmation_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmAccount($confirmation_code)
    {
        if (!$confirmation_code) {
            flash()->error(__("No confirmation code found"));
            return redirect('/');
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if (!$user) {
            flash()->error(__("Confirmation code is invalid or expired"));
            return redirect('/');
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        flash()->success(__("You have successfully verified your account"));
        return redirect('/');
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
            return redirect('/');
        }

        if ($user->confirmation_code == null) {
            $user->confirmation_code =str_random(28);
            $user->save();
        }
        Mail::send('emails.accounts-verify', ['confirmation_code' => $user->confirmation_code], function ($m) use ($request, $user) {
            $m->from(env('EMAIL_FROM_ADDRESS'), env('APP_NAME'));
            $m->to($user->email, $user->name)->subject(__("Verify your email address"));
        });
        flash()->success(__("Please check  email to verify your account"));
        return redirect('/');
    }
}
