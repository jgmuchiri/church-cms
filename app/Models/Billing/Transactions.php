<?php

namespace App\Models\Billing;

use App\Settings;
use App\User;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Transactions extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function user(){
        return $this->belongsTo(\App\User::class,'user_id','id');
    }

    /**
     * @return string
     */
    function getNameAttribute()
    {
        $user_id =$this->attributes['user_id'];
        $user = User::find($user_id);

        return $user->first_name.' '.$user->last_name;
    }

    /**
     * @param $value
     * @return false|string
     */
    function getCreatedAtAttribute($value){
        return date('d M, Y',strtotime($value));
    }

    /**
     * @param $value
     * @return float
     */
    public static function convertToCents($value)
    {
        // strip out commas
        $value = preg_replace("/\,/i", "", $value);
        // strip out all but numbers and dot
        $value = preg_replace("/([^0-9\.])/i", "", $value);
        // make sure we are dealing with a proper number now, no +.4393 or 3...304 or 76.5895,94
        if (!is_numeric($value)) {
            return 0.00;
        }
        // convert to a float explicitly
        $value = (float)$value;
        return round($value, 2) * 100;
    }

    /**
     * get all customer charges from stripe
     *
     * @param $customer
     * @return \Stripe\Collection
     */
    public static function customerCharges($customer)
    {
        $user = User::whereStripeId($customer)->first();
        $charges = \Stripe\Charge::all(array("customer" => $user->stripe_id));
        return $charges;
    }

    /**
     * send thank you for giving
     * @param $user
     * @param $amount
     */

    /**
     * @return string
     */
    public static function getGiftStats()
    {
        $stats = array();
        for ($i = 1; $i <= 12; $i++) {
            $stats[] = Transactions::giftByMonth($i);
        }
        return json_encode($stats);
    }

    /**
     * @param $month
     * @return int
     */
    private static function  giftByMonth($month)
    {
//            $txns = Transactions::get()
//                ->groupBy(function($date){
//                    return Carbon::parse($date->created_at)->format('m');
//                });
        $year = date('Y');
        if ($month < 10) {
            $month = '0' . $month;
        }
        $search = $year . '-' . $month;
        $revenues = self::where('created_at', 'like', $search . '%')->get();
        $sum = 0;
        foreach ($revenues as $revenue) {
            $sum += $revenue->amount;
        }
        return $sum;
    }

    /**
     * create new user to stripe without card
     * @param $request
     * @return \Stripe\Customer
     */
    public static function createCustomer($request)
    {
        if (env('APP_ENV') =="production" && env('STRIPE_SECRET') == null) {
            die("Stripe is not setup for this account");
        }
        if (env('APP_ENV') =="local" && env('STRIPE_TEST_SECRET') == null) {
            die("Stripe is not setup for this account");
        }

        if(env('APP_ENV')=="production"){
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        }else{
            \Stripe\Stripe::setApiKey(env('STRIPE_TEST_SECRET'));
        }

        $customer = \Stripe\Customer::create(array(
            "email" => $request->email,
            "description" => "Customer for ".env('COMPANY_NAME'),
            "source" => $request->stripeToken
        ));

        //alert admin
        if ($customer->id !== null || $customer->id !== "") {

            Mail::send('emails.user-registered-stripe', [
                'email' => $request->email,
                'first_name' => $request->first_name
            ],
                function ($m) use ($request) {
                    $m->from(env('EMAIL'), env('COMPANY_NAME'));
                    $m->to(env('EMAIL'), env('COMPANY_NAME'))->subject('Notice: New user');
                });
        }


        return $customer;
    }

    public static function charge($request, $stripe_id)
    {
        //process payment
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => self::convertToCents($request->amount),
                "currency" => env('CURRENCY'),
                "customer" => $stripe_id,
                "description" => $request->desc
            ));
            //todo add new card to file
        } catch (\Stripe\Error\Card $e) {
            flash()->error('Card has been declined. Please try another card');
            return redirect()->back()->withInput();
        }
        return $charge;
    }


    /**
     * @param $user
     * @param $amount
     */
    public static function sendThankYou($user, $amount, $desc = "")
    {
        Mail::send('emails.thank-you-for-giving', [
            'email' => $user->email,
            'first_name' => $user->first_name,
            'amount' => $amount,
            'desc' => $desc
        ],
            function ($m) use ( $user, $desc) {
                $m->from(env('EMAIL'), env('COMPANY_NAME'));
                $m->to($user->email, $user->first_name)->subject(env('COMPANY_NAME') . ' Receipt- Thank you!');
            });

    }
}
