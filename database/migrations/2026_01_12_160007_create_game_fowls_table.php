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
        Schema::create('game_fowls', function (Blueprint $table) {
            $table->id();
            $table->string('tag_id')->unique();
            $table->string('name');
            $table->string('sex');
            $table->date('date_hatched');
            $table->string('stage_growth_phase');
            $table->string('color_feather_pattern');
            $table->string('distinctive_markings')->nullable();
            $table->date('acquisition_date');
            $table->string('initial_health_status');
            $table->string('sexual_maturity_status');
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_fowls');
    }
};
