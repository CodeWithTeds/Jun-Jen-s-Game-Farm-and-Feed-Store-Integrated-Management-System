<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
        'game_fowl_id',
        'date',
        'type',
        'medication_name',
        'dosage',
        'administered_by',
        'notes',
        'next_schedule_date',
        'status',
        'cost',
        'technician_name',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
        'next_schedule_date' => 'date',
    ];

    public function gameFowl(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class);
    }
}
