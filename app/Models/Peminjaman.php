<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; 

    protected $fillable = [
        'siswa',
        'rombel',
        'rayon',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'ruangan_peminjam',
        'status_pinjam',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
