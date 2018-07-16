<?php

namespace App\Http\Controllers;

use App\Models\Giving\GiftOptions;
use Illuminate\Http\Request;

use App\Models\Billing\Transactions;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Subscription;
use Mockery\CountValidator\Exception;

class GivingController extends Controller
{
    function __construct()
    {
        $this->middleware('auth', ['except' => ['manualGift', 'getOptionInfo']]);

        \Stripe\Stripe::setApiKey(config('app.env') == 'local' ? config('app.stripe.test.secret') : config('app.stripe.live.secret'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show($id)
    {
        $txn = Transactions::whereTxnId($id)->first();
        return view('giving.gifts-admin', compact('txn'));
    }

    /**
     * show all gifts
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function gifts()
    {
        $txns = Transactions::get();
        return view('giving.gifts-admin', compact('txns'));
    }

    /**
     * show single gift
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function showGift(Request $request)
    {
        if($request->ajax()) {
            $txn = Transactions::whereTxnId($request->id)->first();
            echo json_encode($txn);
        }
    }

    function give(Request $request)
    {
        $request['email'] = Auth::user()->email;
        $request['user_id'] = Auth::user()->id;
        return self::manualGift($request);
    }

    /**
     * process manual gift
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function manualGift(Request $request)
    {
        $rules = [
            'interval' => 'required',
            'amount' => 'required|max:50'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $opt = GiftOptions::find($request->gift_options_id);
        $desc = $opt->desc;

        //find user
        if($request->has(__("email"))) { //guest giving
            $user = User::whereEmail($request->email)->first();
        } else {
            $user = User::find($request->user_id);
        }

        if(empty($user)) { //user does not exist so create one
            $user = new User();
            $user->phone = '123456789';
            $user->email = $request->email;
            $user->password = bcrypt(str_random(6));
            $user->first_name = 'guest';
            $user->last_name = 'guest';
            $user->created_at = date('Y-m-d H:i:s');
            $user->confirmation_code = str_random(30);

            //create stripe customer
            $customer = Transactions::createCustomer($request);
            $stripe_id = $customer->id;
            $user->stripe_id = $stripe_id;
            $user->save();
        }

        // Create a Customer if not exists
        $stripe_id = $user->stripe_id;
        if($stripe_id == null) {
            //just in case...
            try {
                $customer = \Stripe\Customer::create(array(
                        "source" => $request->stripeToken,
                        "email" => $user->email,
                        "description" => $user->email)
                );
            } catch (\Stripe\Error\Base $e) {
                flash()->error(__("Unable to create a Stripe Account. Please contact us."));
                return redirect()->back()->withInput();
            }
            $stripe_id = $customer->id;
            //update stripe customer id
            $user->stripe_id = $stripe_id;
            $user->save();
        }

        //save new source
        $token = $request->stripeToken;
        try {
            $cu = \Stripe\Customer::retrieve($stripe_id);
            $cu->source = $token;
            $cu->save();
        } catch (\Stripe\Error\Base $e) {
            //create customer if not exist.
            //e.g. They have stripe id on local database but not in stripe account
            $error = $e->jsonBody['error'];
            if($error['type'] == "invalid_request_error") {
                if(strpos($error['message'], 'No such customer') !== false) {
                    $request['email'] = $user->email;
                    $request['first_name'] = $user->first_name;
                    $customer = Transactions::createCustomer($request);
                    $stripe_id = $customer->id;
                    $user->stripe_id = $stripe_id;
                    $user->save();
                }
            } else {
                flash()->error(__("Unable to create a Stripe Account. Please contact us."));
                return redirect()->back()->withInput();
            }

        }

        //process card payment
        try {
            if($request->interval == "once") {
                //one time payment
                $charge = \Stripe\Charge::create(array(
                    "amount" => Transactions::convertToCents($request->amount),
                    "currency" => env(__("CURRENCY")),
                    "customer" => $stripe_id,
                    "description" => $desc
                ));
            } else {
                $request->email = $user->email;
                $charge = self::customSubscriptionPlan($request, $user->email);
            }

        } catch (\Stripe\Error\Card $e) {
            flash()->error(__("Card has been declined. Please try another card"));
            return redirect()->back()->withInput();
        }

        //log transaction
        $txn = new Transactions();
        $txn->txn_id = $charge->id;
        $txn->user_id = $user->id;
        $txn->stripeToken = $request->stripeToken;
        $txn->item = $desc;
        $txn->desc = "Online Contribution";
        $txn->amount = number_format(($request->amount), 2);
        $txn->customer_id = $user->stripe_id;
        $txn->currency = env(__("CURRENCY"));
        $txn->save();

        //send thank you

        Transactions::sendThankYou($user, $request->amount, $desc);

        flash()->success(__("Thank you! Gift processed. We have sent email confirmation."));

        return redirect()->back();
    }

    /**
     * create a custom subscription for user
     * @param $request
     * @return \Stripe\Subscription
     */
    function customSubscriptionPlan($request, $email)
    {
        //recurrent contribution
        //create a plan for this customer
        $user = User::whereEmail($email)->first();

        $current_time = time();
        $plan_name = strval($current_time);
        $customer_plan = \Stripe\Plan::create(array(
                "amount" => Transactions::convertToCents($request->amount),
                "interval" => $request->interval,
                "name" => " $request->desc ".$user->email.'_'.rand(1111, 9999),
                "currency" => env(__("CURRENCY")),
                "id" => $plan_name
            )
        );

        //subscribe this customer to plan and charge now
        $charge = \Stripe\Subscription::create(array(
            "customer" => $user->stripe_id,
            "plan" => $plan_name
        ));

        //remember locally to allow user to cancel or suspend
        $subsc = new Subscription();
        $subsc->user_id = $user->id;
        $subsc->subscription_id = $charge->id;
        $subsc->amount = $request->amount;
        $subsc->interval = $request->interval;
        $subsc->status = 'active';
        $subsc->save();

        return $charge;
    }

    /**
     * @deprecated
     * process anonymous gift
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function guestGift(Request $request)
    {
        $rules = [
            'amount' => 'required|max:50'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        //check if user exists if so, charge their account
        $myUser = User::whereEmail($request->email)->first();
        if(!empty($myUser)) { //user exists
            $user = User::find($myUser->id);
        } else {
            //create new user
            $user = new User();
            $user->phone = '123456789';
            $user->email = $request->email;
            $user->password = bcrypt(str_random(6));
            $user->first_name = 'guest';
            $user->last_name = 'guest';
            $user->created_at = date('Y-m-d H:i:s');
            $user->confirmation_code = str_random(30);
            $user->company = env(__("name"));
            //create stripe customer
            $customer = Transactions::createCustomer($request);
            $stripe_id = $customer->id;
            $user->stripe_id = $stripe_id;
            $user->save();
        }
        //charge user
        if($request->interval == "once") {
            $charge = Transactions::charge($request, $user->stripe_id);

        } else { //for recurring request
            $charge = self::customSubscriptionPlan($request, $request->email);
        }

        //log transaction
        $txn = new Transactions();
        $txn->txn_id = $charge->id;
        $txn->user_id = $user->id;
        $txn->stripeToken = $request->stripeToken;
        $txn->item = $request->desc;
        $txn->desc = "Online Contribution";
        $txn->amount = number_format(($request->amount), 2);
        $txn->customer_id = $user->stripe_id;
        $txn->currency = env(__("currency"));
        $txn->save();

        //send thank you
        Transactions::sendThankYou($user, $request->amount, $request->desc);

        flash()->success(__("Gift processed. Thank you! A confirmation has been sent to your email"));
        return redirect()->back();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function givingHistory()
    {
        if(isset($_GET['y']) && $_GET['y'] !== "") {
            $start = $_GET['y'].'-01-01 00:00:00';
            $end = $_GET['y'].'-12-31 00:00:00';
            $gifts = Transactions::whereBetween('created_at', array($start, $end))
                ->where('user_id', Auth::user()->id)
                ->get();
        }
        return view('giving.print-user-history', compact(__("gifts")));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function recurringGifts()
    {
        $gifts = Subscription::whereUserId(Auth::user()->id)->get();
        return view('giving.recurring', compact(__("gifts")));
    }

    /**
     * @param $id
     * @param $action
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateGiftPlan($id, $action)
    {

        $subsc = Subscription::whereUserId(Auth::user()->id)->whereId($id)->first();

        if(!empty($subsc)) {
            switch ($action) {

                case "cancel":
                    try {
                        $subscription = \Stripe\Subscription::retrieve($subsc->subscription_id);
                        //remove the array to cancel immediately,
                        //otherwise, subscription will end at the end of the current cycle.
                        $subscription->cancel(array('at_period_end' => true));

                        //update db
                        $subsc->status = "cancelled";
                        $subsc->save();
                    } catch (Exception $e) {
                        flash()->error(__("Unable to deactivate your recurring gift. Please contact us."));
                        return redirect()->back();
                    }
                    break;

                case "suspend":

                    break;

                case "activate": //activates cancelled plan before trial end
                    $subscription = \Stripe\Subscription::retrieve($subsc->subscription_id);
                    $subscription->plan = $subscription->plan->id;
                    $subscription->save();

                    //update db
                    $subsc->status = "active";
                    $subsc->save();
                    flash()->error(__("Plan has reactivated"));
                    break;
                default:
                    flash(__("Unable to process your request"));
                    break;
            }
        } else {
            flash()->error(__("Transaction not found"));
        }
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function giftOptions()
    {
        $gOptions = DB::table(__("gift_options"))->get();
        $gOption = array();
        if(isset($_GET['option'])) {
            $gOption = DB::table(__("gift_options"))->where('id', $_GET['option'])->first();
        }
        return view('giving.gift-options', compact('gOptions', 'gOption'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function storeGiftOption(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        GiftOptions::create($request->all());
        flash()->success(__("Gift option added"));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateGiftOption(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:50',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flash()->error(__("Error! Check fields and try again"));
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $option = GiftOptions::findOrFail($id);
        $option->find($request->all());
        $option->save();
        flash()->success(__("Gift option added"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return string
     */
    function getOptionInfo($id)
    {
        if(request()->ajax()) {
            $option = GiftOptions::find($id);
            return json_encode($option);
        }
    }
}
