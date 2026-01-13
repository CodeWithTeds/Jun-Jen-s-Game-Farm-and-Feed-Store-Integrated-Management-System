<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EggCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_date',
        'dam_id',
        'sire_id',
        'egg_count',
        'egg_condition',
        'collection_staff',
        'storage_location',
        'incubation_start_date',
        'expected_hatch_date',
        'incubation_status',
        'hatched_count',
        'remarks',
    ];

    public function dam()
    {
        return $this->belongsTo(GameFowl::class, 'dam_id');
    }

    public function sire()
    {
        return $this->belongsTo(GameFowl::class, 'sire_id');
    }

    public function hatcheryRecord()
    {
        return $this->hasOne(HatcheryRecord::class);
    }
}
