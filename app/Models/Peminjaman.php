<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nip',
        'nama_guru',
        'nama-barang',
        'tanggal_peminjaman',
        'jumlah_barang_dipinjam',
        'id_barang',
        'status_peminjaman',
        'keperluan',
        'keterangan',
        'kategori_barang',
        'tempat_ruangan',
    ];
}
