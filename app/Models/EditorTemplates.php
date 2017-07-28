<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorTemplates extends Model
{

    public  static function editorTemplates(){
        return self::whereActive(1)->get();
    }
}
