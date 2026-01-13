<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameFowl;

class GameFowlDamSireSeeder extends Seeder
{
    public function run(): void
    {
        $sires = [
            ['tag' => 'SIRE-001', 'name' => 'Thunder', 'pattern' => 'Black'],
            ['tag' => 'SIRE-002', 'name' => 'Blaze', 'pattern' => 'Red'],
            ['tag' => 'SIRE-003', 'name' => 'Titan', 'pattern' => 'Brown'],
            ['tag' => 'SIRE-004', 'name' => 'Apollo', 'pattern' => 'Gold'],
            ['tag' => 'SIRE-005', 'name' => 'Rogue', 'pattern' => 'Grey'],
        ];

        $dams = [
            ['tag' => 'DAM-001', 'name' => 'Ruby', 'pattern' => 'Red'],
            ['tag' => 'DAM-002', 'name' => 'Scarlet', 'pattern' => 'Chestnut'],
            ['tag' => 'DAM-003', 'name' => 'Luna', 'pattern' => 'Silver'],
            ['tag' => 'DAM-004', 'name' => 'Iris', 'pattern' => 'Brown'],
            ['tag' => 'DAM-005', 'name' => 'Nova', 'pattern' => 'Black'],
        ];

        foreach ($sires as $i => $s) {
            GameFowl::firstOrCreate(
                ['tag_id' => $s['tag']],
                [
                    'name' => $s['name'],
                    'sex' => 'Male',
                    'date_hatched' => now()->subMonths(12 + $i)->toDateString(),
                    'stage_growth_phase' => 'Adult',
                    'color_feather_pattern' => $s['pattern'],
                    'distinctive_markings' => null,
                    'acquisition_date' => now()->subMonths(6 + $i)->toDateString(),
                    'initial_health_status' => 'Healthy',
                    'sexual_maturity_status' => 'Mature',
                    'special_notes' => null,
                    'image' => null,
                    'sire_id' => null,
                    'dam_id' => null,
                ]
            );
        }

        foreach ($dams as $i => $d) {
            GameFowl::firstOrCreate(
                ['tag_id' => $d['tag']],
                [
                    'name' => $d['name'],
                    'sex' => 'Female',
                    'date_hatched' => now()->subMonths(12 + $i)->toDateString(),
                    'stage_growth_phase' => 'Adult',
                    'color_feather_pattern' => $d['pattern'],
                    'distinctive_markings' => null,
                    'acquisition_date' => now()->subMonths(6 + $i)->toDateString(),
                    'initial_health_status' => 'Healthy',
                    'sexual_maturity_status' => 'Mature',
                    'special_notes' => null,
                    'image' => null,
                    'sire_id' => null,
                    'dam_id' => null,
                ]
            );
        }
    }
}

