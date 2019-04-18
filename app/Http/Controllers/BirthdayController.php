<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,manager');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param null $month
     * @internal param null $year
     */
    function index()
    {
        if(isset($_GET['y']))
            $year = $_GET['y'];
        else
            $year = "%";

        if(isset($_GET['m']))
            $month = sprintf("%02d", $_GET['m']);
        else
            $month = date('m');

        if(isset($_GET['d']))
            $day = $_GET['d'];
        else
            $day = "%";

        $users = User::where('dob', 'LIKE', "$year-$month-$day")->get();

        $months = array();
        for ($i = 1; $i<=12; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = date('F', $timestamp);
        }

        ksort($months);

        return view('admin.birthdays', compact('users', 'months'));
    }
}
