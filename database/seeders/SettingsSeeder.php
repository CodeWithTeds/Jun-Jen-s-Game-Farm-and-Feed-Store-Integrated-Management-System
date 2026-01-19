<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Security
            [
                'key' => 'enable_2fa',
                'value' => '0',
                'group' => 'security',
                'type' => 'boolean',
                'label' => 'Enable 2FA',
                'description' => 'Force Two-Factor Authentication for all admins.',
                'is_system' => true,
                'is_public' => false,
                'validation_rules' => 'boolean',
            ],
            [
                'key' => 'session_lifetime',
                'value' => '120',
                'group' => 'security',
                'type' => 'integer',
                'label' => 'Session Lifetime (minutes)',
                'description' => 'Number of minutes before session expires.',
                'is_system' => true,
                'is_public' => false,
                'validation_rules' => 'required|integer|min:1',
            ],
            [
                'key' => 'password_expiry_days',
                'value' => '90',
                'group' => 'security',
                'type' => 'integer',
                'label' => 'Password Expiry (days)',
                'description' => 'Days before user must change password.',
                'is_system' => false,
                'is_public' => false,
                'validation_rules' => 'required|integer|min:0',
            ],

            // Performance
            [
                'key' => 'cache_ttl',
                'value' => '60',
                'group' => 'performance',
                'type' => 'integer',
                'label' => 'Cache TTL (minutes)',
                'description' => 'Time to live for cached data.',
                'is_system' => false,
                'is_public' => false,
                'validation_rules' => 'required|integer|min:0',
            ],
            [
                'key' => 'enable_query_log',
                'value' => '0',
                'group' => 'performance',
                'type' => 'boolean',
                'label' => 'Enable Query Log',
                'description' => 'Log database queries for debugging.',
                'is_system' => false,
                'is_public' => false,
                'validation_rules' => 'boolean',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
