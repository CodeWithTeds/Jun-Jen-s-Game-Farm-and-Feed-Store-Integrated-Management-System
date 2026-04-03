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
            $table->string('classification')->nullable()->after('sex');
            $table->string('conditioning_status')->nullable()->after('classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->dropColumn(['classification', 'conditioning_status']);
        });
    }
};
