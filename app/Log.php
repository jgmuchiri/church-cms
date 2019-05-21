<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    /**
     * @param $event
     * @param null|string $action
     * @param null $data
     * @internal param null $category
     */
    public static function add($event, $action = 'update', $data = null)
    {
        if ($data !== null) {
            $data = serialize($data);
        }

        $fp = fopen(storage_path() . '/logs/logs.csv', 'w');

        fputcsv($fp, array(date('Y-m-d H:i:s'), Auth::user()->id . ': ' . Auth::user()->name, $event, $data));

        fclose($fp);
    }

}
