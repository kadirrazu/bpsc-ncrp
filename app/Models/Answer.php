<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'exam_id',
        'post_code',
        'set_code',
        'answers',
    ];
}
