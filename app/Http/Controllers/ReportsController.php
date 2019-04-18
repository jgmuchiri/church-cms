<?php

namespace App\Http\Controllers;

use App\Models\Billing\Transactions;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'role:admin' => ['only' => 'downloadGiftsToDate'],
            ]
        );
    }

    /**
     * @return mixed
     */
    function downloadGiftsToDate()
    {
        $table = Transactions::get();
        $filename = "transactions_to_date";
        // the csv file with the first row
        $output = implode(",", [
            'Date', 'TXN ID', 'Member', 'Customer ID', 'Item', 'Description', 'Amount',
        ]);
        $output .= "\n";

        foreach ($table as $row) {
            // iterate over each
            $output .= implode(",", [
                date('d M Y', strtotime($row->created_at)),
                $row->txn_id,
                $row->name,
                $row->customer_id,
                $row->item,
                $row->desc,
                config('app.currency.symbol').$row->amount,
            ]);
            $output .= "\n";
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
        ];
        return Response::make(rtrim($output, "\n"), 200, $headers);
    }
}
