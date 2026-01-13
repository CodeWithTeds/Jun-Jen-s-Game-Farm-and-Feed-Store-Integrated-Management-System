<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ChickRearing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChickRearingRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_view_chick_rearing_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('staff.chick-rearings.index'));
        $response->assertStatus(200);
    }

    public function test_staff_can_create_chick_rearing()
    {
        $user = User::factory()->create();
        $data = [
            'chick_tag_id' => 'CHICK-001',
            'hatch_date' => '2023-01-01',
            'age_days' => 10,
            'growth_stage' => 'Brooder',
            'feed_type' => 'Starter Feed',
            'feeding_schedule' => 'Twice a day',
            'health_status' => 'Healthy',
            'vaccination_status' => 'Pending',
            'mortality_status' => 'Alive',
        ];

        $response = $this->actingAs($user)->post(route('staff.chick-rearings.store'), $data);
        
        $response->assertRedirect(route('staff.chick-rearings.index'));
        $this->assertDatabaseHas('chick_rearings', ['chick_tag_id' => 'CHICK-001']);
    }

    public function test_staff_can_update_chick_rearing()
    {
        $user = User::factory()->create();
        $chickRearing = ChickRearing::create([
            'chick_tag_id' => 'CHICK-001',
            'hatch_date' => '2023-01-01',
            'age_days' => 10,
            'growth_stage' => 'Brooder',
            'feed_type' => 'Starter Feed',
            'feeding_schedule' => 'Twice a day',
            'health_status' => 'Healthy',
            'vaccination_status' => 'Pending',
            'mortality_status' => 'Alive',
        ]);

        $data = [
            'chick_tag_id' => 'CHICK-001-UPDATED',
            'hatch_date' => '2023-01-01',
            'age_days' => 11,
            'growth_stage' => 'Starter',
            'feed_type' => 'Starter Feed',
            'feeding_schedule' => 'Twice a day',
            'health_status' => 'Healthy',
            'vaccination_status' => 'Pending',
            'mortality_status' => 'Alive',
        ];

        $response = $this->actingAs($user)->put(route('staff.chick-rearings.update', $chickRearing), $data);

        $response->assertRedirect(route('staff.chick-rearings.index'));
        $this->assertDatabaseHas('chick_rearings', ['chick_tag_id' => 'CHICK-001-UPDATED']);
    }

    public function test_staff_can_delete_chick_rearing()
    {
        $user = User::factory()->create();
        $chickRearing = ChickRearing::create([
            'chick_tag_id' => 'CHICK-001',
            'hatch_date' => '2023-01-01',
            'age_days' => 10,
            'growth_stage' => 'Brooder',
            'feed_type' => 'Starter Feed',
            'feeding_schedule' => 'Twice a day',
            'health_status' => 'Healthy',
            'vaccination_status' => 'Pending',
            'mortality_status' => 'Alive',
        ]);

        $response = $this->actingAs($user)->delete(route('staff.chick-rearings.destroy', $chickRearing));

        $response->assertRedirect(route('staff.chick-rearings.index'));
        $this->assertDatabaseMissing('chick_rearings', ['id' => $chickRearing->id]);
    }
}
