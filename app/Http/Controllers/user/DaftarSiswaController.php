<?php
namespace App\Http\Controllers\User;

use App\Models\Jurusan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class DaftarSiswaController extends Controller
{
    public function getSpreadsheetData()
    {
        $csvUrl = "https://docs.google.com/spreadsheets/d/1s1gkoXOJ3YDeKSPRtavD4SivjEtDeE0lj_bdhfDsvzM/gviz/tq?tqx=out:csv";
        $response = Http::get($csvUrl);
    
        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data dari Google Spreadsheet'], 500);
        }
    
        $rows = array_map("str_getcsv", explode("\n", trim($response->body())));
        array_shift($rows);
    
        $user = auth()->user();
    
        if (!$user || !$user->jurusan_id) {
            return response()->json(['error' => 'User tidak memiliki jurusan'], 400);
        }
    
        $userJurusan = Jurusan::find($user->jurusan_id);
    
        if (!$userJurusan) {
            return response()->json(['error' => 'Jurusan tidak ditemukan'], 400);
        }
    
        $namaJurusan = strtoupper(trim($userJurusan->nama_jurusan));
    
        $siswa = [];
    
        foreach ($rows as $row) {
            if (count($row) < 4) continue;
    
            $rombel = trim($row[2]);
            $jurusanSiswa = strtoupper(trim(explode(' ', preg_replace('/[^A-Za-z0-9 ]/', '', $rombel))[0]));
    
            if (strpos($jurusanSiswa, $namaJurusan) !== false) {
                $siswa[] = [
                    'no' => trim($row[0]),
                    'nama' => trim($row[1]),
                    'rayon' => trim($row[3]),
                    'rombel' => $rombel,
                    'jurusan' => $jurusanSiswa,
                ];
            }
        }
    
        $semuaJurusan = array_unique(array_map(function ($row) {
            return strtoupper(trim(explode(' ', trim($row[2]))[0]));
        }, $rows));
    
        return response()->json([
            'user_jurusan' => $namaJurusan,
            'jurusan_dalam_csv' => $semuaJurusan,
            'data_ditemukan' => count($siswa),
            'siswa' => $siswa
        ]);
    }    
}
