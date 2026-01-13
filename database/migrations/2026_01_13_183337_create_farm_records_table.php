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
        Schema::create('farm_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_type'); // Feeding / Cleaning / Mortality / Inspection
            $table->date('record_date');
            $table->string('related_module'); // Chick Rearing / Feeding / Medical
            $table->unsignedBigInteger('reference_id')->nullable(); // Related pen, batch, or animal
            $table->text('description');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('Normal'); // Normal / Issue / Critical
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_records');
    }
};
