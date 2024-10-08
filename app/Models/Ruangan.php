<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'tanggal_pengadaan',
        'sumber_dana',
        'jumlah_barang',
        'merek_barang',
        'kondisi_barang',
        'deskripsi_barang',
        'penanggungjawab_ruangan',
        'nama_ruangan',
    ];
}
