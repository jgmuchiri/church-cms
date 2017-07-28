<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Events extends Model
{

    /**
     * @return mixed
     */
    public static function churchSchedule(){
        return DB::table('church_schedule')->orderBy('order','ASC')->get();
    }
}
