<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickRearing extends Model
{
    protected $fillable = [
        'chick_tag_id',
        'hatch_date',
        'age_days',
        'growth_stage',
        'feed_type',
        'feeding_schedule',
        'health_status',
        'vaccination_status',
        'last_vaccination_date',
        'treatment_notes',
        'mortality_status',
        'remarks',
    ];

    protected $casts = [
        'hatch_date' => 'date',
        'last_vaccination_date' => 'date',
    ];
}
