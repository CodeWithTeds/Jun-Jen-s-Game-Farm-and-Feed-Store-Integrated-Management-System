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
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('special_notes');
            $table->string('sale_status')->default('not_for_sale')->after('price'); // not_for_sale, for_sale, sold
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('feed_id')->nullable()->change();
            $table->foreignId('game_fowl_id')->nullable()->constrained()->onDelete('cascade')->after('feed_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_fowls', function (Blueprint $table) {
            $table->dropColumn(['price', 'sale_status']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('feed_id')->nullable(false)->change();
            $table->dropConstrainedForeignId('game_fowl_id');
        });
    }
};
