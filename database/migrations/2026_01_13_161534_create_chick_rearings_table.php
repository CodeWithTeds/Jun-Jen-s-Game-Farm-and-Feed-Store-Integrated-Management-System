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
        Schema::create('chick_rearings', function (Blueprint $table) {
            $table->id();
            $table->string('chick_tag_id')->unique();
            $table->date('hatch_date');
            $table->integer('age_days');
            $table->string('growth_stage'); // Brooder / Starter / Grower
            $table->string('feed_type');
            $table->string('feeding_schedule');
            $table->string('health_status'); // Healthy / Weak / Sick
            $table->string('vaccination_status'); // Pending / Completed
            $table->date('last_vaccination_date')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->string('mortality_status')->default('Alive'); // Alive / Deceased
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chick_rearings');
    }
};
