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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('feed_name');
            $table->string('feed_type');
            $table->string('brand');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->string('batch_number');
            $table->date('expiration_date');
            $table->string('supplier');
            $table->date('date_received');
            $table->integer('reorder_level');
            $table->string('storage_location');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
