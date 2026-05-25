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
        Schema::create('detail_notas', function (Blueprint $table) {
            $table->id(); // ID Auto Increment untuk tabel pivot
            $table->string('id_nota');
            $table->string('id_barang');
            $table->integer('banyaknya');
            $table->integer('sub_total');
            $table->timestamps();

            // Relasi
            $table->foreign('id_nota')->references('id_nota')->on('notas')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_notas');
    }
};
