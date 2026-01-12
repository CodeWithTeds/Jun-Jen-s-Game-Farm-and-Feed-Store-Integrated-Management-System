<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'image',
        'sire_id',
        'dam_id',
    ];

    protected $casts = [
        'date_hatched' => 'date',
        'acquisition_date' => 'date',
    ];

    public function getCurrentAgeAttribute()
    {
        return $this->date_hatched->diffForHumans(null, true);
    }

    public function sire(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class, 'sire_id');
    }

    public function dam(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class, 'dam_id');
    }

    public function offspringAsSire(): HasMany
    {
        return $this->hasMany(GameFowl::class, 'sire_id');
    }

    public function offspringAsDam(): HasMany
    {
        return $this->hasMany(GameFowl::class, 'dam_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
