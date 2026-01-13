<?php

namespace Tests\Feature;

use App\Models\EggCollection;
use App\Models\GameFowl;
use App\Models\HatcheryRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HatcheryRecordRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_redirects_to_correct_route()
    {
        $user = User::factory()->create();

        $dam = GameFowl::create([
            'tag_id' => 'DAM001',
            'name' => 'Hen 1',
            'sex' => 'Female',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $sire = GameFowl::create([
            'tag_id' => 'SIRE001',
            'name' => 'Rooster 1',
            'sex' => 'Male',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $eggCollection = EggCollection::create([
            'collection_date' => '2023-10-27',
            'egg_count' => 5,
            'dam_id' => $dam->id,
            'sire_id' => $sire->id,
            'egg_condition' => 'Normal',
            'collection_staff' => 'John Doe',
            'storage_location' => 'Room A',
        ]);

        $data = [
            'egg_collection_id' => $eggCollection->id,
            'incubator_id' => 'INC-01',
            'temperature' => 37.5,
            'humidity' => 55.0,
            'turning_schedule' => 'Every 4 hours',
        ];

        $response = $this->actingAs($user)->post(route('staff.hatchery-records.store'), $data);

        $response->assertRedirect(route('staff.hatchery-records.index'));
    }

    public function test_update_redirects_to_correct_route()
    {
        $user = User::factory()->create();

        $dam = GameFowl::create([
            'tag_id' => 'DAM001',
            'name' => 'Hen 1',
            'sex' => 'Female',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $sire = GameFowl::create([
            'tag_id' => 'SIRE001',
            'name' => 'Rooster 1',
            'sex' => 'Male',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $eggCollection = EggCollection::create([
            'collection_date' => '2023-10-27',
            'egg_count' => 5,
            'dam_id' => $dam->id,
            'sire_id' => $sire->id,
            'egg_condition' => 'Normal',
            'collection_staff' => 'John Doe',
            'storage_location' => 'Room A',
        ]);

        $hatcheryRecord = HatcheryRecord::create([
            'egg_collection_id' => $eggCollection->id,
            'incubator_id' => 'INC-01',
            'temperature' => 37.5,
            'humidity' => 55.0,
            'turning_schedule' => 'Every 4 hours',
        ]);

        $data = [
            'egg_collection_id' => $eggCollection->id,
            'incubator_id' => 'INC-02',
            'temperature' => 37.6,
            'humidity' => 55.1,
            'turning_schedule' => 'Every 5 hours',
        ];

        $response = $this->actingAs($user)->put(route('staff.hatchery-records.update', $hatcheryRecord), $data);

        $response->assertRedirect(route('staff.hatchery-records.index'));
    }

    public function test_destroy_redirects_to_correct_route()
    {
        $user = User::factory()->create();

        $dam = GameFowl::create([
            'tag_id' => 'DAM001',
            'name' => 'Hen 1',
            'sex' => 'Female',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $sire = GameFowl::create([
            'tag_id' => 'SIRE001',
            'name' => 'Rooster 1',
            'sex' => 'Male',
            'date_hatched' => '2023-01-01',
            'acquisition_date' => '2023-01-01',
            'stage_growth_phase' => 'Adult',
            'color_feather_pattern' => 'Red',
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
        ]);

        $eggCollection = EggCollection::create([
            'collection_date' => '2023-10-27',
            'egg_count' => 5,
            'dam_id' => $dam->id,
            'sire_id' => $sire->id,
            'egg_condition' => 'Normal',
            'collection_staff' => 'John Doe',
            'storage_location' => 'Room A',
        ]);

        $hatcheryRecord = HatcheryRecord::create([
            'egg_collection_id' => $eggCollection->id,
            'incubator_id' => 'INC-01',
            'temperature' => 37.5,
            'humidity' => 55.0,
            'turning_schedule' => 'Every 4 hours',
        ]);

        $response = $this->actingAs($user)->delete(route('staff.hatchery-records.destroy', $hatcheryRecord));

        $response->assertRedirect(route('staff.hatchery-records.index'));
    }
}
