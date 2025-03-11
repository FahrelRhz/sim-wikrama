<?php

namespace App\Models;

use App\Models\AlatBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PeminjamanAlatBarang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_alat_barang';

    protected $fillable = [
        'nama_peminjam',
        'alat_barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'ruangan_peminjam',
        'keperluan',
        'status_pinjam'

    ];

    public function alat_barang()
    {
        return $this->belongsTo(AlatBarang::class, 'alat_barang_id');
    }
}
