<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use  Billable;

    use LaratrustUserTrait;
    use Notifiable;
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    protected $fillable =[
        'name','first_name','last_name','email',
        'address','phone','photo','dob',
        'password','confirmed','status','remember_token',
        'stripe_id', 'card_brand','card_last_four','trial_ends_at'
    ];
 
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return string
     */
    public static function userStats()
    {
        $stats = array();
        for ($i = 1; $i <= 12; $i++) {
            $stats[] = self::stats($i);
        }
        return json_encode($stats);
    }
    /**
     * @param $month
     * @return int
     */
    public static function  usersByMonth()
    {
        //$stats = self::whereUserId(Auth::user()->id)->get();

        $stats = self::stats('01')
            . ',' . self::stats('02')
            . ',' . self::stats('03')
            . ',' . self::stats('04')
            . ',' . self::stats('05')
            . ',' . self::stats('06')
            . ',' . self::stats('07')
            . ',' . self::stats('08')
            . ',' . self::stats('09')
            . ',' . self::stats('10')
            . ',' . self::stats('11')
            . ',' . self::stats('12');
        return $stats;
    }

    static function stats($m)
    {
        $year = date('Y');
        $dayFirst = date('Y') . '-' . $m . '-01';
        switch ($m) {
            case (01 || 03 || 05 || 07 || '08' || 10 || 12):
                $dayLast = $year . '-' . $m . '-31';
                break;
            case '02' && ($year % 29 == 0):
                $dayLast = $year . '-' . $m . '-29';
                break;
            case '02' && ($year % 28 == 0):
                $dayLast = $year . '-' . $m . '-28';
                break;
            case '04' || '06' || '09' || '11':
                $dayLast = $year . '-' . $m . '-31';
                break;
            default:
                $dayLast = $year . '-' . $m . '-30';
                break;
        }
        return self::where('created_at', '>=', $dayFirst)
            ->where('created_at', '<=', $dayLast)
            ->count();
    }

    /**
     * user activities
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function logs()
    {
        return $this->hasMany(\App\Log::class);
    }
    /**
     * resend user account confirmation code
     * @param $id
     */
    public static function resendConfirmation($id)
    {
        $user = self::find($id);

        Mail::send('emails.accounts-verify', ['confirmation_code' => $user->confirmation_code], function ($m) use ($user) {
            $m->from(config('mail.from.address'), config('app.name'));
            $m->to($user->email, $user->name)->subject(__('Verify your email address'));
        });
    }
    /**
     * @param $request
     */
    public static function registrationNotice($request)
    {
        Mail::send('emails.accounts-registration', ['name' => $request['name']], function ($m) use ($request) {
            $m->from(config('mail.from.address'), config('app.name'));
            $m->to($request['email'], $request['name'])->subject('Your account is active!');
        });
    }
    function name(){
        return $this->getAttribute('first_name').' '.$this->getAttribute('last_name');
    }
}