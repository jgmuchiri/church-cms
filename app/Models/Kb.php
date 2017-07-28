<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kb extends Model
{
    protected $table = 'kb';

    protected $fillable = ['question', 'question_desc', 'answer', 'category', 'active', 'upvote', 'downvote', 'created_at', 'updated_at'];
}
