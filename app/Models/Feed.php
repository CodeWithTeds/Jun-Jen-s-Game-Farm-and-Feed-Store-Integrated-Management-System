<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_name',
        'image',
        'feed_type',
        'brand',
        'quantity',
        'price',
        'unit',
        'batch_number',
        'expiration_date',
        'supplier',
        'date_received',
        'reorder_level',
        'storage_location',
        'status',
        'is_displayed',
        'remarks',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'date_received' => 'date',
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'reorder_level' => 'integer',
        'is_displayed' => 'boolean',
    ];
}
