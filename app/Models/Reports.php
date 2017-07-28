<?php

namespace App\Models;

use App\Models\Billing\Transactions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{

    /**
     * @return string
     */
    public static function usersByMonth($year=null)
    {
        if($year==null)  $year=date('Y');
        $stats = array();
        for ($m = 1; $m <= 12; $m++) {
            if ($m < 10)
                $m = '0' . $m;
            $date = $year.'-' . $m;
            $stats[] = User::where('created_at', 'LIKE', $date . '%')->count();
        }
        return implode(',', $stats);
    }

    /**
     * @return string
     */
    public static function montlyGiving($year=null)
    {

        if($year==null) $year =date('Y');

        $stats = array();
        for ($m = 1; $m <= 12; $m++) {
            if ($m < 10)
                $m = '0' . $m;
            $date = $year.'-' . $m;
            $stats[] = Transactions::where('created_at', 'LIKE', $date . '%')->sum('amount');
        }
        return implode(',', $stats);
    }

}
