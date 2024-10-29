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
        Schema::create('request_perbaikan_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->date('tanggal_request');
            $table->enum('status', ['pending', 'dalam perbaikan', 'selesai']);
            $table->text('deskripsi_kerusakan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_perbaikan_barang');
    }
};
