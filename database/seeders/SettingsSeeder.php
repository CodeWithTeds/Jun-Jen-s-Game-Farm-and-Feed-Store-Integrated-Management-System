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
            // General
            [
                'key' => 'site_name',
                'value' => 'Feed Store',
                'group' => 'general',
                'type' => 'string',
                'label' => 'Site Name',
                'description' => 'The name of your application.',
                'is_system' => true,
                'is_public' => true,
                'validation_rules' => 'required|string|max:255',
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'group' => 'general',
                'type' => 'string',
                'label' => 'Site Logo URL',
                'description' => 'URL to the site logo.',
                'is_system' => false,
                'is_public' => true,
                'validation_rules' => 'nullable|url',
            ],
            [
                'key' => 'support_email',
                'value' => 'support@example.com',
                'group' => 'general',
                'type' => 'string',
                'label' => 'Support Email',
                'description' => 'Email address for support inquiries.',
                'is_system' => false,
                'is_public' => true,
                'validation_rules' => 'required|email',
            ],

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

            // Notifications
            [
                'key' => 'enable_email_notifications',
                'value' => '1',
                'group' => 'notifications',
                'type' => 'boolean',
                'label' => 'Enable Email Notifications',
                'description' => 'Global switch to enable/disable email notifications.',
                'is_system' => true,
                'is_public' => false,
                'validation_rules' => 'boolean',
            ],
            [
                'key' => 'notification_email_sender',
                'value' => 'noreply@feedstore.com',
                'group' => 'notifications',
                'type' => 'string',
                'label' => 'Sender Email',
                'description' => 'Email address used as sender.',
                'is_system' => false,
                'is_public' => false,
                'validation_rules' => 'required|email',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
