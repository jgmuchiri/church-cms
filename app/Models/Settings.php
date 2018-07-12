<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    /**
     * @param $item
     * @return string
     */
    public static function read($item)
    {
        $setting = self::first();

        if(!empty($setting)>0) return $setting->$item;

        return "";
    }


}
