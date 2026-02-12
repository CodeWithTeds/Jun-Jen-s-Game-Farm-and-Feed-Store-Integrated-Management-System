<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FightSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_fowl_id',
        'date',
        'time',
        'location',
        'opponent',
        'status',
        'result',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function gameFowl(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class);
    }
}
