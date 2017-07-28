<?php

namespace App\Http\Controllers;

use App\Models\Billing\Transactions;
use App\Settings;
use App\User;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return mixed
     */
    function downloadGiftsToDate(){
        $table =Transactions::get();
        $filename= "transactions_to_date";
        // the csv file with the first row
        $output = implode(",", array(
            'Date','TXN ID','Item', 'Amount','Member','Member ID'
        ));
        $output .= "\n";

        foreach ($table as $row) {
            $user = User::find($row->user_id);
            // iterate over each
            $output .= implode(",", array(
                $row->created_at,
                $row->txn_id,
                $row->item,
                Settings::read('currency_symbol').$row->amount,
                $user->first_name.' '.$user->last_name,
                $row->customer_id

            ));
            $output .= "\n";
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
        );
        return Response::make(rtrim($output, "\n"), 200, $headers);
    }
}
