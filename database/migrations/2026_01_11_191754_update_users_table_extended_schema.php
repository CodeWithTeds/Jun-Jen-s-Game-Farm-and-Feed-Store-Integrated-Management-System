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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('id');
            $table->string('first_name')->nullable()->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->string('username')->unique()->nullable()->after('last_name');
            $table->string('status')->default('active')->after('role');
            $table->string('account_type')->nullable()->after('status');
            $table->string('phone_number')->nullable()->after('account_type');
            $table->foreignId('created_by')->nullable()->after('created_at');
            $table->foreignId('updated_by')->nullable()->after('updated_at');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->timestamp('password_changed_at')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture',
                'first_name',
                'middle_name',
                'last_name',
                'username',
                'status',
                'account_type',
                'phone_number',
                'created_by',
                'updated_by',
                'last_login_at',
                'password_changed_at'
            ]);
        });
    }
};
