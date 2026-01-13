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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('schedule_type'); // Feeding / Vaccination / Cleaning / Collection
            $table->string('related_module'); // Chick Rearing / Feeding / Medical / Hatchery
            $table->unsignedBigInteger('target_id')->nullable();
            $table->date('start_date');
            $table->date('due_date')->nullable();
            $table->string('repeat_type')->default('None'); // None / Daily / Weekly / Monthly
            $table->string('priority')->default('Medium'); // Low / Medium / High
            $table->string('status')->default('Pending'); // Pending / Completed / Missed
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->time('reminder_time')->nullable();
            $table->string('notification_method')->default('System'); // System / Email
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
