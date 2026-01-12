<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GameFowl extends Model
{
    protected $fillable = [
        'tag_id',
        'name',
        'sex',
        'date_hatched',
        'stage_growth_phase',
        'color_feather_pattern',
        'distinctive_markings',
        'acquisition_date',
        'initial_health_status',
        'sexual_maturity_status',
        'special_notes',
    ];

    protected $casts = [
        'date_hatched' => 'date',
        'acquisition_date' => 'date',
    ];

    public function getCurrentAgeAttribute()
    {
        return $this->date_hatched->diffForHumans(null, true);
    }
}
