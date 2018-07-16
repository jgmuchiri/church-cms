<?php

namespace App\Models\Billing;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /**
     * subscribe new user to trial default plan
     *
     * @param $data
     * @return \Stripe\Customer
     */
    public static function newUserTrialPlan($data)
    {

        \Stripe\Stripe::setApiKey(config('app.env') == "local" ? config('app.stripe.test.secret') : config('app.stripe.live.secret'));


        $customer = \Stripe\Customer::create(array(
                "plan" => config('stripe.plans.default.name'),
                "email" => $data['email'])
        );
        return $customer;
    }

    //todo
    public static function allCustomers()
    {
        \Stripe\Stripe::setApiKey(config('app.env') == "local" ? config('app.stripe.test.secret') : config('app.stripe.live.secret'));

        $data = array();

        $users = User::all();
        foreach ($users as $user) { //each user

            if($user->stripe_id == "")//get stripe id
                continue;

            $cu = \Stripe\Customer::retrieve($user->stripe_id);
            $sub_id = $cu->subscriptions->data[0]->id;

            $subscription = $cu->subscriptions->retrieve($sub_id);
        }

    }

    /**
     * @param $request
     * @return \Stripe\Customer
     */
    public static function registerUserStripe($request, $stripe_secret)
    {
        \Stripe\Stripe::setApiKey($stripe_secret);

        $customer = \Stripe\Customer::create(array(
                "email" => $request->email)
        );
        return $customer;
    }
}
