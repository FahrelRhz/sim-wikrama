<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = [
            [
                'kode_barang' => 'B001',
                'nama_barang' => 'Laptop',
                'merk_barang' => 'Asus',
                'tanggal_pengadaan' => '2022-01-01',
                'sumber_dana' => 'Dana Pemerintah',
                'jumlah_barang' => 5,
                'kategori_barang' => 'Elektronik',
                'kondisi_barang' => 'Baik',
                'deskripsi_barang' => 'Laptop dengan spesifikasi tinggi',
                'jurusan_id' => 1
                
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
