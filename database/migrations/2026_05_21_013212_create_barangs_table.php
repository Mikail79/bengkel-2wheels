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
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('id_barang')->primary();
            $table->string('nama');
            $table->string('jenis'); // Jasa / Part
            $table->integer('stok')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('diskon')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
