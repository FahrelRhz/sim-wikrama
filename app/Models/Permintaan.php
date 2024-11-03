<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan_barang';

    protected $fillable = [
        'barang',
        'user_id',
        'tanggal_permintaan',
        'alasan_permintaan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
