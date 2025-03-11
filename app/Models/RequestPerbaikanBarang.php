<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPerbaikanBarang extends Model
{
    protected $table = 'request_perbaikan_barang';

    protected $fillable = [
        'barang_id',
        'user_id',
        'tanggal_request',
        'gambar',
        'status',
        'deskripsi_kerusakan'
    ];


    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
