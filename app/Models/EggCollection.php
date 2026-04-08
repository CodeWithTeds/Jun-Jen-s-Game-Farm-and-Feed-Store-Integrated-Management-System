<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EggCollection extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function (EggCollection $eggCollection) {
            if ($eggCollection->wasChanged(['incubation_status', 'hatched_count'])) {
                if ($eggCollection->incubation_status === 'Completed') {
                    // Auto-create HatcheryRecord if it doesn't exist
                    $hatcheryRecordExists = \App\Models\HatcheryRecord::where('egg_collection_id', $eggCollection->id)->exists();
                    if (!$hatcheryRecordExists) {
                        $rate = null;
                        if ($eggCollection->incubated_count > 0 && $eggCollection->hatched_count !== null) {
                            $rate = round(($eggCollection->hatched_count / $eggCollection->incubated_count) * 100, 2);
                        }
                        \App\Models\HatcheryRecord::create([
                            'egg_collection_id' => $eggCollection->id,
                            'incubator_id' => 'AUTO-INC',
                            'temperature' => 37.5,
                            'humidity' => 55.0,
                            'turning_schedule' => 'Auto',
                            'hatch_rate' => $rate,
                            'hatch_result' => $rate !== null ? ($rate > 0 ? 'Successful' : 'Failed') : null,
                            'remarks' => 'Auto-generated hatchery record upon completion of egg collection #' . $eggCollection->id,
                        ]);
                    }
                }

                if ($eggCollection->incubation_status === 'Completed' && $eggCollection->hatched_count > 0) {
                    // Check if we already created a batch for this collection
                    $tagId = 'Batch-EC-' . $eggCollection->id;
                    $exists = \App\Models\ChickRearing::where('chick_tag_id', $tagId)->exists();
                    
                    if (!$exists) {
                        \App\Models\ChickRearing::create([
                            'chick_tag_id' => $tagId,
                            'hatch_date' => $eggCollection->expected_hatch_date ?: now()->toDateString(),
                            'age_days' => 0,
                            'growth_stage' => 'Brooder',
                            'feed_type' => 'Starter',
                            'feeding_schedule' => 'Ad Libitum',
                            'health_status' => 'Healthy',
                            'vaccination_status' => 'N/A',
                            'mortality_status' => 'Alive',
                            'remarks' => 'Auto-generated batch for ' . $eggCollection->hatched_count . ' chicks hatched from Egg Collection #' . $eggCollection->id,
                        ]);
                    }
                }
            }
        });
    }

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
        'incubated_count',
        'hatched_count',
        'failed_count',
        'remarks',
    ];

    protected $casts = [
        'collection_date'       => 'date',
        'incubation_start_date' => 'date',
        'expected_hatch_date'   => 'date',
        'egg_count'             => 'integer',
        'incubated_count'       => 'integer',
        'hatched_count'         => 'integer',
        'failed_count'          => 'integer',
    ];

    // ─── Computed / virtual properties ───────────────────────────────────────

    /**
     * Eggs not yet sent to incubation.
     * remaining = total_eggs - incubated_count
     */
    public function getRemainingEggsAttribute(): int
    {
        return max(0, $this->egg_count - ($this->incubated_count ?? 0));
    }

    /**
     * Incubated eggs not yet accounted for (hatched or failed).
     * incubation_balance = incubated_count - (hatched_count + failed_count)
     */
    public function getIncubationBalanceAttribute(): int
    {
        $incubated = $this->incubated_count ?? 0;
        $hatched   = $this->hatched_count   ?? 0;
        $failed    = $this->failed_count    ?? 0;

        return max(0, $incubated - ($hatched + $failed));
    }

    /**
     * Auto-derive the incubation_status based on quantities.
     *  - 'Pending'    → nothing incubated yet
     *  - 'Incubating' → eggs placed but results not complete
     *  - 'Completed'  → all incubated eggs have results
     */
    public function getAutoStatusAttribute(): string
    {
        if (($this->incubated_count ?? 0) === 0) {
            return 'Pending';
        }

        if ($this->incubationBalance > 0) {
            return 'Incubating';
        }

        return 'Completed';
    }

    // ─── Relationships ────────────────────────────────────────────────────────

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
