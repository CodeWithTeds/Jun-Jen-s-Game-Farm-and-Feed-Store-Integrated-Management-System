<?php

namespace Tests\Feature;

use App\Models\FightSchedule;
use App\Models\GameFowl;
use App\Models\GameFowlInventory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperationalGuardsTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_and_admin_can_access_pos_but_customers_cannot(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($staff)
            ->get(route('staff.pos.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.pos.index'))
            ->assertOk();

        $this->actingAs($customer)
            ->get(route('staff.pos.index'))
            ->assertForbidden();

        $this->actingAs($customer)
            ->get(route('admin.pos.index'))
            ->assertForbidden();
    }

    public function test_cannot_schedule_a_game_fowl_with_another_active_fight(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $gameFowl = $this->createFightReadyGameFowl();

        FightSchedule::create([
            'game_fowl_id' => $gameFowl->id,
            'date' => '2026-05-01',
            'time' => '10:00',
            'location' => 'Main Arena',
            'status' => 'Scheduled',
        ]);

        $this->actingAs($staff)
            ->from(route('staff.fight-schedules.create'))
            ->post(route('staff.fight-schedules.store'), [
                'game_fowl_id' => $gameFowl->id,
                'date' => '2026-05-02',
                'time' => '11:00',
                'location' => 'Secondary Arena',
                'status' => 'Scheduled',
            ])
            ->assertRedirect(route('staff.fight-schedules.create'))
            ->assertSessionHasErrors('game_fowl_id');
    }

    public function test_can_update_existing_schedule_without_triggering_conflict_for_same_record(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $gameFowl = $this->createFightReadyGameFowl();

        $schedule = FightSchedule::create([
            'game_fowl_id' => $gameFowl->id,
            'date' => '2026-05-01',
            'time' => '10:00',
            'location' => 'Main Arena',
            'status' => 'Scheduled',
        ]);

        $this->actingAs($staff)
            ->put(route('staff.fight-schedules.update', $schedule), [
                'game_fowl_id' => $gameFowl->id,
                'date' => '2026-05-03',
                'time' => '13:00',
                'location' => 'Updated Arena',
                'status' => 'Scheduled',
            ])
            ->assertRedirect(route('staff.fight-schedules.index'));

        $this->assertDatabaseHas('fight_schedules', [
            'id' => $schedule->id,
            'location' => 'Updated Arena',
        ]);
    }

    public function test_marking_a_game_fowl_dead_updates_inventory_and_removes_it_from_selection_lists(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $gameFowl = $this->createFightReadyGameFowl();

        GameFowlInventory::create([
            'game_fowl_id' => $gameFowl->id,
            'quantity' => 3,
            'status' => 'Available',
            'location' => 'Pen A',
        ]);

        $payload = array_merge($gameFowl->only([
            'tag_id',
            'name',
            'sex',
            'reproductive_status',
            'gender_identification',
            'date_hatched',
            'stage_growth_phase',
            'color_feather_pattern',
            'distinctive_markings',
            'acquisition_date',
            'sexual_maturity_status',
            'special_notes',
            'sire_id',
            'dam_id',
            'classification',
            'conditioning_status',
        ]), [
            'initial_health_status' => 'Dead',
        ]);

        $this->actingAs($staff)
            ->put(route('staff.game-fowls.update', $gameFowl), $payload)
            ->assertRedirect(route('staff.game-fowls.index'));

        $this->assertDatabaseHas('game_fowl_inventories', [
            'game_fowl_id' => $gameFowl->id,
            'quantity' => 0,
            'status' => 'Deceased',
        ]);

        $this->actingAs($staff)
            ->get(route('staff.game-fowl-inventory.create'))
            ->assertDontSee($gameFowl->name);
    }

    private function createFightReadyGameFowl(array $overrides = []): GameFowl
    {
        return GameFowl::create(array_merge([
            'tag_id' => 'GF-' . fake()->unique()->numerify('####'),
            'name' => fake()->firstName(),
            'sex' => 'Male',
            'reproductive_status' => 'Not Applicable',
            'gender_identification' => 'Visual',
            'date_hatched' => now()->subYear()->toDateString(),
            'stage_growth_phase' => 'Stag',
            'color_feather_pattern' => 'Red',
            'distinctive_markings' => 'None',
            'acquisition_date' => now()->subMonths(10)->toDateString(),
            'initial_health_status' => 'Healthy',
            'sexual_maturity_status' => 'Mature',
            'special_notes' => null,
            'classification' => 'Fighter',
            'conditioning_status' => 'Ready',
            'sale_status' => 'not_for_sale',
        ], $overrides));
    }
}
