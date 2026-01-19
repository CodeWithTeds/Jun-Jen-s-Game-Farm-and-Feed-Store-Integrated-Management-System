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
        Setting::where('group', 'general')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $settings = [
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
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
};
