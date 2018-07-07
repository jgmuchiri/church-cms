<?php

namespace App\Models\Ministry;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $table = 'ministries';
    protected $fillable =['name','category_id','desc','active'];
    function category(){
        return $this->belongsTo(MinistryCats::class,'category_id');
    }
}
