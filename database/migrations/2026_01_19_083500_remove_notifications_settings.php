<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::where('group', 'notifications')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot easily restore deleted data without a backup.
        // But we can re-seed if needed, or leave it empty.
        // For strict reversal, we would need to insert them back.
        // But since this is a "remove" request, down() is usually no-op or re-seed.
        $settings = [
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
            Setting::create($setting);
        }
    }
};
