<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmRecord extends Model
{
    protected $fillable = [
        'record_type',
        'record_date',
        'related_module',
        'reference_id',
        'description',
        'quantity',
        'recorded_by',
        'status',
        'remarks',
    ];

    protected $casts = [
        'record_date' => 'date',
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
