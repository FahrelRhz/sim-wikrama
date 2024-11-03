<?php

namespace App\Http\Controllers\user;

use GuzzleHttp\Client;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Exception\RequestException;

class DaftarSiswaController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    // eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmlzIjpudWxsLCJuYW1lIjoiQWRtaW4iLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsInBob3RvX3Byb2ZpbGUiOm51bGwsInJvbGUiOm51bGwsImtlbGFzIjpudWxsLCJyb21iZWwiOm51bGwsInJheW9uIjpudWxsLCJqdXJ1c2FuIjpudWxsLCJpYXQiOjE3MzAyNjY5MDR9._AjAi76GnmcIGkwbVwtY0cOXy3CjUvr4aJxCHsys9F8
    public function fetchDataSiswa(Request $request)
    {
        $token = ' eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmlzIjpudWxsLCJuYW1lIjoiQWRtaW4iLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsInBob3RvX3Byb2ZpbGUiOm51bGwsInJvbGUiOm51bGwsImtlbGFzIjpudWxsLCJyb21iZWwiOm51bGwsInJheW9uIjpudWxsLCJqdXJ1c2FuIjpudWxsLCJpYXQiOjE3MzAyNjY5MDR9._AjAi76GnmcIGkwbVwtY0cOXy3CjUvr4aJxCHsys9F8';
    
        try {
            // Ambil data pengguna yang login
            $user = Auth::user();
            $jurusanId = $user->jurusan_id;
    
            // Ambil nama_jurusan dari tabel jurusans
            $jurusan = Jurusan::find($jurusanId); 
            if (!$jurusan) {
                return response()->json([
                    'error' => 'Jurusan tidak ditemukan',
                ], 404);
            }
            $namaJurusan = $jurusan->nama_jurusan;
    
            // Ambil data siswa dari API
            $response = $this->client->request('GET', 'https://api-ra.smkwikrama.sch.id/api/user/get-siswa', [
                'headers' => [
                    'api-token' => $token,
                ]
            ]);
    
            $siswaData = json_decode($response->getBody(), true)['data'];
    
            // Filter siswa berdasarkan nama_jurusan
            $filteredData = array_filter($siswaData, function ($siswa) use ($namaJurusan) {
                return isset($siswa['jurusan']) && $siswa['jurusan'] === $namaJurusan;
            });
    
            // Jika ada pencarian
            $searchValue = $request->input('search.value', '');
            if (!empty($searchValue)) {
                $filteredData = array_filter($filteredData, function ($siswa) use ($searchValue) {
                    return strpos(strtolower($siswa['nis']), strtolower($searchValue)) !== false ||
                           strpos(strtolower($siswa['name']), strtolower($searchValue)) !== false ||
                           strpos(strtolower($siswa['rayon']), strtolower($searchValue)) !== false;
                });
            }
    
            $totalRecordsFiltered = count($filteredData);
    
            // Pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $paginatedData = array_slice($filteredData, $start, $length);
    
            // Mengembalikan response
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => count($siswaData),
                'recordsFiltered' => $totalRecordsFiltered,
                'data' => array_map(function ($siswa) {
                    return [
                        'nis' => $siswa['nis'],
                        'name' => $siswa['name'],
                        'nama_rombel' => $siswa['nama_rombel'],
                        'rayon' => $siswa['rayon'],
                        'jurusan' => $siswa['jurusan'] // Langsung ambil jurusan dari data siswa
                    ];
                }, $paginatedData)
            ]);
    
        } catch (RequestException $e) {
            \Log::error('API Error', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null,
            ]);
    
            return response()->json([
                'error' => 'Data tidak dapat diambil: ' . $e->getMessage(), // Tambahkan pesan error
            ], 500);
        }
    }
    
    public function index(Request $request)
    {
        // Hanya digunakan untuk tampilan awal
        return view('pages.user.daftar-siswa.index');
    }
}
