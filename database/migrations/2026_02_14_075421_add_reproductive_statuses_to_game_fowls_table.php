<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->string('reproductive_status')->nullable()->after('sex');
            $table->string('gender_identification')->nullable()->after('reproductive_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->dropColumn(['reproductive_status', 'gender_identification']);
        });
    }
};
