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
        Schema::create('egg_collections', function (Blueprint $table) {
            $table->id();
            $table->date('collection_date');
            $table->foreignId('dam_id')->constrained('game_fowls');
            $table->foreignId('sire_id')->constrained('game_fowls');
            $table->integer('egg_count');
            $table->string('egg_condition');
            $table->string('collection_staff');
            $table->string('storage_location');
            $table->date('incubation_start_date')->nullable();
            $table->date('expected_hatch_date')->nullable();
            $table->string('incubation_status')->default('Pending');
            $table->integer('hatched_count')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egg_collections');
    }
};
