<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paycheck extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'path',
        'month',
        'year',
        'type_file_id',
        'user_id',
    ];

}
