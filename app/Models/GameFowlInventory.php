<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameFowlInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_fowl_id',
        'quantity',
        'status',
        'location',
        'notes',
    ];

    public function gameFowl(): BelongsTo
    {
        return $this->belongsTo(GameFowl::class);
    }
}
