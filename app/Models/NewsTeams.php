<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NewsTeams extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'news_id',
        'company_area_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('news')->logOnly(['news_id', 'company_area_id']);
    }

}
