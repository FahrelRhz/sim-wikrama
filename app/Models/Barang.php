<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'tanggal_pengadaan',
        'sumber_dana',
        'jumlah_barang',
        'merek_barang',
        'jenis_barang',
        'kategori_barang',
        'kondisi_barang',
        'deskripsi_barang',
    ];
}
