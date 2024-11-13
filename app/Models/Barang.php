<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'id',
        'kode_barang',
        'nama_barang',
        'merk_barang',
        'tanggal_pengadaan',
        'sumber_dana',
        'jumlah_barang',
        'kategori_barang',
        'kondisi_barang',
        'deskripsi_barang',
        'jurusan_id'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function requestPerbaikanBarang()
    {
        return $this->hasMany(RequestPerbaikanBarang::class);
    }
}
