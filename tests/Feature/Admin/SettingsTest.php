<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Models\AuditLog;
use App\Livewire\Settings\Index;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_settings_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.settings.index'))
            ->assertStatus(200);
    }

    public function test_non_admin_cannot_view_settings_page()
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)
            ->get(route('admin.settings.index'))
            ->assertStatus(403);
    }

    public function test_settings_are_loaded()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Setting::create([
            'key' => 'test_setting',
            'value' => 'initial_value',
            'group' => 'general',
            'type' => 'string',
            'label' => 'Test Setting',
        ]);

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->assertSee('Test Setting')
            ->assertSet('form.test_setting', 'initial_value');
    }

    public function test_can_update_setting()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Setting::create([
            'key' => 'test_setting',
            'value' => 'initial_value',
            'group' => 'general',
            'type' => 'string',
            'label' => 'Test Setting',
            'validation_rules' => 'required|string',
        ]);

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->set('form.test_setting', 'new_value')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('settings', [
            'key' => 'test_setting',
            'value' => 'new_value',
        ]);
    }

    public function test_setting_update_creates_audit_log()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $setting = Setting::create([
            'key' => 'test_setting',
            'value' => 'initial_value',
            'group' => 'general',
            'type' => 'string',
            'label' => 'Test Setting',
        ]);

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->set('form.test_setting', 'new_value')
            ->call('save');

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Setting::class,
            'auditable_id' => $setting->id,
            'event' => 'updated',
            'user_id' => $admin->id,
        ]);
    }

    public function test_can_rollback_setting()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $setting = Setting::create([
            'key' => 'test_setting',
            'value' => 'initial_value',
            'group' => 'general',
            'type' => 'string',
            'label' => 'Test Setting',
        ]);

        // Make a change to create history
        $setting->value = 'new_value';
        $setting->save();

        // Ensure audit log exists
        $log = AuditLog::where('auditable_id', $setting->id)
            ->where('event', 'updated')
            ->first();
        $this->assertNotNull($log);

        // Perform rollback
        Livewire::actingAs($admin)
            ->test(Index::class)
            ->set('activeTab', 'history')
            ->call('rollback', $log->id);

        $this->assertDatabaseHas('settings', [
            'key' => 'test_setting',
            'value' => 'initial_value',
        ]);
    }

    public function test_load_history_does_not_throw_exception()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $setting = Setting::create([
            'key' => 'test_setting',
            'value' => 'initial_value',
            'group' => 'general',
            'type' => 'string',
            'label' => 'Test Setting',
        ]);
        
        // Trigger some history
        $setting->value = 'changed';
        $setting->save();

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->set('activeTab', 'history')
            ->assertHasNoErrors();
    }
}
