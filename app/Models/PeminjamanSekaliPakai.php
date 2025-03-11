<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanSekaliPakai extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_sekali_pakai';
    protected $fillable = [
        'id',
        'barang_sekali_pakai_id',
        'nama_peminjam',
        'jml_barang',
        'keperluan',
        'tanggal_pinjam',
    ];

    public function barangSekaliPakai()
    {
        return $this->belongsTo(BarangSekaliPakai::class, 'barang_sekali_pakai_id', 'id');
    }

}
