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
        Schema::create('peminjaman_sekali_pakai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_sekali_pakai_id'); 
            $table->string('nama_peminjam');
            $table->integer('jml_barang');
            $table->string('keperluan');
            $table->date('tanggal_pinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_sekali_pakai');
    }
};
