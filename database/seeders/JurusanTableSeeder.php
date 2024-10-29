<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan= [
            ['nama_jurusan' => 'PPLG'],
            ['nama_jurusan' => 'DKV'],
            ['nama_jurusan' => 'TJKT'],
            ['nama_jurusan' => 'MPLB'],
            ['nama_jurusan' => 'PMN'],
            ['nama_jurusan' => 'KLN'],
            ['nama_jurusan' => 'HTL'],
        ];

        foreach ($jurusan as $jur) {
            Jurusan::create($jur);
        }
    }
}
