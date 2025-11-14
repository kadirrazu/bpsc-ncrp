<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cutmark extends Model
{
    protected $fillable = [
        'exam_id',
        'post_code',
        'cut_mark',
    ];
}
