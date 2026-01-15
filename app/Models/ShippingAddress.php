<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_name',
        'contact_person',
        'phone_number',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'location_type',
        'is_default',
        'status',
        'remarks',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
