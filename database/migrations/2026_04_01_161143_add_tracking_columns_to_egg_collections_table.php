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
        Schema::table('egg_collections', function (Blueprint $table) {
            // Add incubated_count to track how many eggs have been put in the incubator
            $table->integer('incubated_count')->default(0)->after('egg_count');
            // failed_count tracks how many incubated eggs did not hatch
            $table->integer('failed_count')->nullable()->default(0)->after('hatched_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egg_collections', function (Blueprint $table) {
            $table->dropColumn(['incubated_count', 'failed_count']);
        });
    }
};
