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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('merk_barang')->nullable();
            $table->date('tanggal_pengadaan');
            $table->string('sumber_dana')->nullable();
            $table->integer('jumlah_barang');
            $table->string('kategori_barang');
            $table->string('kondisi_barang');
            $table->text('deskripsi_barang')->nullable();
            $table->unsignedBigInteger('jurusan_id');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
