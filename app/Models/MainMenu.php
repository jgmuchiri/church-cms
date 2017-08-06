<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $table='main_menu';
    protected $fillable=['title','path','parent','order','active','icon'];


    /**
     * @param array $opts
     * @return mixed
     */
    public static function getMenu($opts=array()){
        if(isset($opts['order']))
        {
            $order = $opts['order'];
        }else{
            $order = 'ASC';
        }

        if(isset($opts['parent']))
        {
            $parent = $opts['parent'];
        }else{
            $parent = 0;
        }
        return self::whereActive(1)->orderBy('order',$order)->where('parent',$parent)->get();
    }

    function subMenu(){
        return $this->hasMany(self::class,'parent','id');
    }
}
