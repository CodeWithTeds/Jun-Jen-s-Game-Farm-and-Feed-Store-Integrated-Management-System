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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_fowl_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('type'); // Vaccination, Treatment, Injury, Checkup, Deworming, Vitamin
            $table->string('medication_name')->nullable();
            $table->string('dosage')->nullable();
            $table->string('administered_by')->nullable();
            $table->text('notes')->nullable();
            $table->date('next_schedule_date')->nullable();
            $table->string('status')->default('Completed'); // Completed, Pending, Scheduled
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('technician_name')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
