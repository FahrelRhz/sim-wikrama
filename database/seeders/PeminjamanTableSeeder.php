<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Peminjaman;

class PeminjamanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peminjaman = [
            [
                'siswa' => 1,
                'barang_id' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(3),
                'tanggal_kembali' => Carbon::now()->subDays(1),
                'status_pinjam' => 'kembali',
            ],
        ];

        // Menyimpan data ke database
        foreach ($peminjaman as $pinjam) {
            Peminjaman::create($pinjam);
        }
    }
}
