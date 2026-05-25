<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->string('nopol')->primary();
            $table->string('id_customer');
            $table->timestamps();

            // Relasi
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
