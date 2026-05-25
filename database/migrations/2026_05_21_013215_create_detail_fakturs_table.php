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
        Schema::create('detail_fakturs', function (Blueprint $table) {
            $table->id();
            $table->string('id_faktur');
            $table->string('id_barang');
            $table->integer('qty');
            $table->integer('total_harga'); // sub total untuk item ini
            $table->timestamps();

            // Relasi
            $table->foreign('id_faktur')->references('id_faktur')->on('fakturs')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_fakturs');
    }
};
