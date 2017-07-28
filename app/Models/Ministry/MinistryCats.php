<?php

namespace App\Models\Ministry;

use Illuminate\Database\Eloquent\Model;

class MinistryCats extends Model
{
    protected $fillable = ['name','slug','desc'];

    function ministries(){
        return $this->hasMany(\App\Models\Ministry\Ministry::class,'cat','id');
    }
}
