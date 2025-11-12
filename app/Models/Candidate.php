<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'exam_id',
        'post_code',
        'reg_number',
        'user_id',
        'name',
        'dob',
        'district',
        'center_code',
    ];
}
