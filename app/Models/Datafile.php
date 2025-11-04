<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datafile extends Model
{

     protected $fillable = [
        'exam_id',
        'post_code',
        'bnd_number',
        'file_type',
        'file_name',
    ];

}
