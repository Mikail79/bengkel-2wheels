<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add petugas link and role column to users table.
     * This bridges Laravel's auth system with the existing domain entity (petugas).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_petugas')->nullable()->after('name');
            $table->string('role')->default('Admin')->after('id_petugas'); // Admin, Kasir, Mekanik
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_petugas']);
            $table->dropColumn(['id_petugas', 'role']);
        });
    }
};
