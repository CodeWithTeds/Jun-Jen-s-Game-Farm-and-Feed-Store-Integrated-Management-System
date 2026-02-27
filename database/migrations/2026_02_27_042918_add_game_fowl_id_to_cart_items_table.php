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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('feed_id')->nullable()->change();
            $table->foreignId('game_fowl_id')->nullable()->after('feed_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('feed_id')->nullable(false)->change();
            $table->dropForeign(['game_fowl_id']);
            $table->dropColumn('game_fowl_id');
        });
    }
};
