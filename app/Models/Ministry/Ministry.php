<?php

namespace App\Models\Ministry;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $table = 'ministries';
    protected $fillable =['name','cat','desc','active','slug'];
    function category(){
        return $this->hasOne(\App\Models\Ministry\MinistryCats::class,'id','cat');
    }
}
