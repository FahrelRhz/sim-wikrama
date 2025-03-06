<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangSekaliPakai extends Model
{
    use HasFactory;

    protected $table = 'barang_sekali_pakai';
    protected $fillable = [
        'id',
        'nama_barang',
        'jml_barang',
    ];

    public function peminjamanSekaliPakai()
    {
        return $this->hasMany(PeminjamanSekaliPakai::class, 'barang_sekali_pakai_id', 'id');
    }
}
