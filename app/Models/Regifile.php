<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regifile extends Model
{
    protected $fillable = [
        'exam_id',
        'post_code',
        'file_type',
        'file_name',
    ];
}
