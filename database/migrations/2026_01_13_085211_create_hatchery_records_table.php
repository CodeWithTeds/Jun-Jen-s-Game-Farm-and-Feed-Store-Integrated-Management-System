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
        Schema::create('hatchery_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('egg_collection_id')->constrained('egg_collections')->onDelete('cascade');
            $table->string('incubator_id');
            $table->decimal('temperature', 5, 2);
            $table->decimal('humidity', 5, 2);
            $table->string('turning_schedule');
            $table->date('candling_date')->nullable();
            $table->decimal('fertility_rate', 5, 2)->nullable();
            $table->decimal('hatch_rate', 5, 2)->nullable();
            $table->string('hatch_result')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hatchery_records');
    }
};
