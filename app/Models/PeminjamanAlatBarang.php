<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PeminjamanAlatBarang extends Model
{
    use HasFactory;

    protected $table = [
        'nama_peminjam',
        'alat_barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'ruangan_peminjam',
        'keperluan',
        'status_pinjam'

    ];

    public function alat_barang_id()
    {
        return $this->belongsTo(AlatBarang::class, 'alat_barang_id');
    }
}
