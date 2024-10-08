<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
            'nama_guru',
            'nama_barang',
            'tanggal_pengadaan',
            'jumlah_barang_diminta',
            'id_barang',
    ];
}
