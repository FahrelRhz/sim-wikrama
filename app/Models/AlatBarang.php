<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatBarang extends Model
{
    use HasFactory;

    protected $table = 'alat_barang';

    protected $fillable = [
        'jenis',
        'barang_merk',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah_harga',
        'keterangan',
        'link_siplah',
    ];
    
}
