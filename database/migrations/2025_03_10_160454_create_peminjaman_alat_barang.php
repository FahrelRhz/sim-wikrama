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
        Schema::create('peminjaman_alat_barang', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_peminjam'); 
            $table->unsignedBigInteger('alat_barang_id'); 
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('ruangan_peminjam')->nullable();
            $table->string('keperluan');
            $table->enum('status_pinjam', ['dipinjam', 'kembali']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_alat_barang');
    }
};
