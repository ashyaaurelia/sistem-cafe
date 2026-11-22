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
            $table->string('email')->nullable()->change();
            $table->string('nomor_hp')->nullable()->unique();
            $table->boolean('wajib_ganti_password')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_nomor_hp_unique');
            $table->dropColumn([
                'nomor_hp',
                'wajib_ganti_password'
            ]);
            $table->string('email')->nullable(false)->change();
        });
    }
};