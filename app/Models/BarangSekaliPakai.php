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

    public function kurangiStok($jumlah)
    {
        if ($this->jml_barang < $jumlah) {
            throw new \Exception("Jumlah barang tidak mencukupi.");
        }

        $this->jml_barang -= $jumlah;
        $this->save();
    }

    public function kembalikanStok($jumlah)
    {
        $this->jml_barang += $jumlah;
        $this->save();
    }

    public function peminjamanSekaliPakai()
    {
        return $this->hasMany(PeminjamanSekaliPakai::class, 'barang_sekali_pakai_id', 'id');
    }
}
