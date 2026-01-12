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
        Schema::create('breedings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sire_id')->constrained('game_fowls')->onDelete('cascade');
            $table->foreignId('dam_id')->constrained('game_fowls')->onDelete('cascade');
            $table->date('breeding_date');
            $table->string('type')->default('Natural'); // Natural, AI, etc.
            $table->string('pen_number')->nullable();
            $table->date('expected_hatch_date')->nullable();
            $table->string('clutch_number')->nullable();
            $table->string('status')->default('Active'); // Active, Completed, Failed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breedings');
    }
};
