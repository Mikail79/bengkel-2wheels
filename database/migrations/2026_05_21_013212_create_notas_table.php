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
        Schema::create('notas', function (Blueprint $table) {
            $table->string('id_nota')->primary();
            $table->date('tanggal');
            $table->integer('total_jumlah');
            $table->string('nopol');
            $table->string('id_petugas_admin');
            $table->string('id_petugas_mekanik')->nullable(); // Bisa null jika cuma beli oli tanpa pasang
            $table->timestamps();

            // Relasi
            $table->foreign('nopol')->references('nopol')->on('motors');
            $table->foreign('id_petugas_admin')->references('id_petugas')->on('petugas');
            $table->foreign('id_petugas_mekanik')->references('id_petugas')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
