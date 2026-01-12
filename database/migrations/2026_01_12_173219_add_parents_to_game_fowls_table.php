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
            $table->foreignId('sire_id')->nullable()->constrained('game_fowls')->onDelete('set null');
            $table->foreignId('dam_id')->nullable()->constrained('game_fowls')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->dropForeign(['sire_id']);
            $table->dropForeign(['dam_id']);
            $table->dropColumn(['sire_id', 'dam_id']);
        });
    }
};
