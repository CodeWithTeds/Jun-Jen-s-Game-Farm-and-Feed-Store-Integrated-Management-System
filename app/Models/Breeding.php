<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breeding extends Model
{
    protected $fillable = [
        'sire_id',
        'dam_id',
        'breeding_date',
        'type',
        'pen_number',
        'expected_hatch_date',
        'clutch_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'breeding_date' => 'date',
        'expected_hatch_date' => 'date',
    ];

    public function sire(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class, 'sire_id');
    }

    public function dam(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class, 'dam_id');
    }
}
