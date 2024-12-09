<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = ['nama_jurusan'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
