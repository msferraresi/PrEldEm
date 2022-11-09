<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'path',
        'month',
        'year',
        'type_file_id',
        'user_id',
    ];

}
