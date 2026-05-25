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
        Schema::create('fakturs', function (Blueprint $table) {
            $table->string('id_faktur')->primary();
            $table->string('no_faktur')->nullable(); // Nomor seri faktur fisik dari supplier
            $table->string('id_suplier');
            $table->string('id_petugas'); // Petugas gudang yang menerima
            $table->date('tanggal');
            $table->string('termin')->nullable();
            $table->string('syarat_pembayaran')->nullable();
            $table->integer('sub_total');
            $table->integer('diskon')->default(0);
            $table->integer('ppn')->default(0);
            $table->integer('total');
            $table->timestamps();

            // Relasi
            $table->foreign('id_suplier')->references('id_suplier')->on('supliers');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakturs');
    }
};
