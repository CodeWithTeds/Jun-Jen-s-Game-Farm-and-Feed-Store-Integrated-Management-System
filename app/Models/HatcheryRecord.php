<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HatcheryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'egg_collection_id',
        'incubator_id',
        'temperature',
        'humidity',
        'turning_schedule',
        'candling_date',
        'fertility_rate',
        'hatch_rate',
        'hatch_result',
        'remarks',
    ];

    public function eggCollection()
    {
        return $this->belongsTo(EggCollection::class);
    }
}
