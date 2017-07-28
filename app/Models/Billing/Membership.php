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
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create(array(
                "plan" => env('DEFAULT_STRIPE_PLAN'),
                "email" => $data['email'])
        );
        return $customer;
    }

    //todo
    public static function allCustomers()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $data = array();

        $users = User::all();
        foreach ($users as $user) { //each user

            if ($user->stripe_id == "")//get stripe id
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
    public static function registerUserStripe($request,$stripe_secret)
    {
        \Stripe\Stripe::setApiKey($stripe_secret);

        $customer = \Stripe\Customer::create(array(
                "email" => $request->email)
        );
        return $customer;
    }
}
