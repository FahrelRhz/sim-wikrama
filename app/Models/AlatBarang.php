<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlatBarang extends Model
{
    use HasFactory;

    protected $table = 'alat_barang';

    protected $fillable = [
        'id',
        'jenis',
        'barang_merk',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah_harga',
        'keterangan',
        'link_siplah',
    ];

    public function alat_barang()
    {
        return $this->hasMany(PeminjamanAlatBarang::class, 'alat_barang_id', 'id');
    }
    
}
