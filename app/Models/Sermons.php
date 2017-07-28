<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sermons extends Model
{
    /**
     * retrieve a random post
     * @param int $limit
     * @return mixed
     */
    public static function randomSermons($limit=1){
        $count= self::count();
        $skip = rand(0,$count);
        $sermons = self::skip($skip)->take($limit)->get();
        return $sermons;
    }

    /**
     * retrieve latest sermon
     * @param int $skip
     * @param int $limit
     * @return mixed
     */
    public static function latestSermon($skip=1,$limit=1){
        $sermons = self::skip($skip)->take($limit)->get();
        return $sermons;
    }
}
