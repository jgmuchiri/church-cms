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
        if (count($setting) > 0) {
            return $setting->$item;
        }
        return "";
    }

    /**
     * @param $option
     * @param $value
     * @return bool
     */
    public static function set_option($option,$value){

        if(count(DB::table('sys_options')->where('option_name',$option)->first())){//option exists, update
            self::update_option($option,$value);
        }else{
            $option=DB::table('sys_options')->insert(['option_name'=>$option,'option_value'=>$value]);
            if($option){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $option
     * @param $value
     * @return bool
     */
    public static function update_option($option,$value){
        $option=DB::table('sys_options')->where('option_name',$option)->update(['option_name'=>$option,'option_value'=>$value]);
        if($option){
            return true;
        }
        return false;
    }
    /**
     * @param $option_name
     * @return string
     */
    public static function get_option($option_name){
        $option = DB::table('sys_options')->where('option_name',$option_name)->first();
        if(count($option)){
            return $option->option_value;
        }else{
            return '';
        }
    }

    /**
     * @return array
     */
    public static function get_options(){
        $options = DB::table('sys_options')->where('autoload','yes')->get();
        if(count($options)){
            return $options;
        }else{
            return array();
        }
    }

    /**
     * @param $option
     * @return bool
     */
    public static function remove_option($option){
        $option =  DB::table('sys_options')->where('option_name',$option)->delete();
        if($option){
            return true;
        }
        return false;
    }
}
