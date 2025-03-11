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
        Schema::create('alat_barang', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); 
            $table->string('barang_merk'); 
            $table->integer('volume');
            $table->string('satuan'); 
            $table->decimal('harga_satuan', 15, 2); 
            $table->decimal('jumlah_harga', 15, 2);
            $table->text('keterangan')->nullable(); 
            $table->string('link_siplah')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_barang');
    }
};
