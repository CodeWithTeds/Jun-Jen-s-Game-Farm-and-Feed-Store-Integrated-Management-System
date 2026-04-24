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
        'reproductive_status',
        'gender_identification',
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
        'price',
        'sale_status',
        'classification',
        'conditioning_status',
    ];

    protected $casts = [
        'date_hatched' => 'date',
        'acquisition_date' => 'date',
        'price' => 'decimal:2',
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

    public function fightSchedules(): HasMany
    {
        return $this->hasMany(FightSchedule::class)->orderBy('date', 'desc');
    }

    public function scopeAvailable($query)
    {
        return $query->where('initial_health_status', '!=', 'Dead')
            ->where(function ($subQuery) {
                $subQuery->whereNull('sale_status')
                    ->orWhere('sale_status', '!=', 'sold');
            });
    }

    public function isFitToFight(): bool
    {
        if ($this->classification !== 'Fighter') {
            return false;
        }

        if (!in_array($this->stage_growth_phase, ['Stag', 'Bullstag', 'Cock'])) {
            return false;
        }

        return ! $this->medicalRecords()
            ->whereIn('type', ['Sick', 'Weak', 'Treatment'])
            ->where('status', '!=', 'Completed')
            ->exists();
    }

    public function scopeFitToFight($query)
    {
        return $query->where('classification', 'Fighter')
            ->whereIn('stage_growth_phase', ['Stag', 'Bullstag', 'Cock'])
            ->whereDoesntHave('medicalRecords', function ($q) {
                $q->whereIn('type', ['Sick', 'Weak', 'Treatment'])
                    ->where('status', '!=', 'Completed');
            });
    }
}
