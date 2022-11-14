<?php

namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Membership extends JetstreamMembership
{
    use LogsActivity;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('teams');
    }
}
