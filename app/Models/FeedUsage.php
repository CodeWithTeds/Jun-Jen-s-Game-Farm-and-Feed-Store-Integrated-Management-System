<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedUsage extends Model
{
    protected $fillable = [
        'feed_id',
        'chick_rearing_id',
        'used_date',
        'quantity',
        'remarks',
    ];

    protected $casts = [
        'used_date' => 'date',
        'quantity' => 'decimal:2',
    ];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    public function chickRearing(): BelongsTo
    {
        return $this->belongsTo(ChickRearing::class);
    }
}
