<?php

namespace App\Http\Controllers\user;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Siswa;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class PeminjamanBarangController extends Controller
{

    private $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchDataSiswa(Request $request)
    {
        try {
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmlzIjpudWxsLCJuYW1lIjoiQWRtaW4iLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsInBob3RvX3Byb2ZpbGUiOm51bGwsInJvbGUiOm51bGwsImtlbGFzIjpudWxsLCJyb21iZWwiOm51bGwsInJheW9uIjpudWxsLCJqdXJ1c2FuIjpudWxsLCJpYXQiOjE3MzEzMzYxMjN9.oKqf3se7FM7k6K2i9dEF6fflMvhJVuOadPqifqiGtwE'; // token API Anda

            $user = Auth::user();
            $jurusanId = $user->jurusan_id;

            $jurusan = Jurusan::find($jurusanId);
            if (!$jurusan) {
                return response()->json(['error' => 'Jurusan tidak ditemukan'], 404);
            }
            $namaJurusan = $jurusan->nama_jurusan;

            // Ambil data siswa dari API
            $response = $this->client->request('GET', 'https://api-ra.smkwikrama.sch.id/api/user/get-siswa', [
                'headers' => [
                    'api-token' => $token,
                ]
            ]);

            $siswaData = json_decode($response->getBody(), true)['data'];

            // Filter siswa berdasarkan jurusan yang login
            $filteredSiswaData = array_filter($siswaData, function ($siswa) use ($namaJurusan) {
                return isset($siswa['jurusan']) && $siswa['jurusan'] === $namaJurusan;
            });

            // Jika ada pencarian, filter berdasarkan nilai pencarian
            $searchValue = $request->input('search.value', '');
            if (!empty($searchValue)) {
                $filteredSiswaData = array_filter($filteredSiswaData, function ($siswa) use ($searchValue) {
                    return strpos(strtolower($siswa['nis']), strtolower($searchValue)) !== false ||
                        strpos(strtolower($siswa['name']), strtolower($searchValue)) !== false ||
                        strpos(strtolower($siswa['rayon']), strtolower($searchValue)) !== false;
                });
            }

            // Pagination (jika diperlukan)
            $start = $request->input('start', 0);
            $length = $request->input('length', count($filteredSiswaData));  // Ambil semua data
            $paginatedData = array_slice($filteredSiswaData, $start, $length);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data siswa',
                'data' => array_map(function ($siswa) {
                    return [
                        'name' => $siswa['name'],
                        'nis' => $siswa['nis'],
                        'rayon' => $siswa['rayon'],
                        // Tambahkan data lain yang dibutuhkan
                    ];
                }, $paginatedData),
                'recordsTotal' => count($siswaData),
                'recordsFiltered' => count($filteredSiswaData),
            ]);
        } catch (RequestException $e) {
            \Log::error('API Error', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null,
            ]);
            return response()->json(['error' => 'Data tidak dapat diambil'], 500);
        }
    }

    public function index(Request $request)
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Ambil ID jurusan dari user
        $jurusanId = $user->jurusan_id;

        if ($request->ajax()) {
            // Ambil data peminjaman sesuai jurusan user
            $peminjamans = Peminjaman::with(['barang'])
                ->whereHas('barang', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                })
                ->select(['id', 'siswa', 'barang_id', 'tanggal_pinjam', 'tanggal_kembali', 'ruangan_peminjam', 'status_pinjam']);

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('siswa', function ($peminjaman) {
                    return $peminjaman->siswa ?? '-';
                })
                ->addColumn('barang', function ($peminjaman) {
                    return $peminjaman->barang
                        ? $peminjaman->barang->nama_barang . ' - ' . $peminjaman->barang->kode_barang
                        : '-';
                })
                ->addColumn('actions', function ($peminjaman) {
                    return '<a href="#" class="bi bi-card-checklist edit-button" 
                        data-id="' . $peminjaman->id . '" 
                        data-tanggal_pinjam="' . $peminjaman->tanggal_pinjam . '"
                        data-tanggal_kembali="' . $peminjaman->tanggal_kembali . '"
                        data-ruangan_peminjam="' . $peminjaman->ruangan_peminjam . '"
                        data-status_pinjam="' . $peminjaman->status_pinjam . '"
                    ></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // Kirim semua barang ke view (opsional)
        $barangs = Barang::where('jurusan_id', $jurusanId)->get();

        return view('pages.user.peminjaman-barang.index', compact('barangs'));
    }



    public function create(Request $request)
    {
        // Ambil barang yang tidak dipinjam
        $barangs = Barang::whereDoesntHave('peminjaman', function ($query) {
            $query->where('status_pinjam', 'dipinjam');
        })->get();

        return view('pages.user.peminjaman-barang.create', compact('barangs'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa' => 'required|string',
            'barang_id' => 'required|exists:barang,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'ruangan_peminjam' => 'required|string',
            'status_pinjam' => 'required|in:kembali,dipinjam',
        ]);

        Log::info('Data yang diterima: ', $validatedData);

        try {
            $barangDipinjam = Peminjaman::where('barang_id', $validatedData['barang_id'])
                ->where('status_pinjam', 'dipinjam')
                ->exists();

            if ($barangDipinjam) {
                Log::warning('Barang ini sedang dipinjam:', ['barang_id' => $validatedData['barang_id']]);
                return response()->json([
                    'success' => false,
                    'message' => 'Barang ini sedang dipinjam.'
                ], 422);
            }

            $peminjaman = Peminjaman::create([
                'siswa' => $validatedData['siswa'],
                'barang_id' => $validatedData['barang_id'],
                'tanggal_pinjam' => $validatedData['tanggal_pinjam'],
                'tanggal_kembali' => $validatedData['tanggal_kembali'] ?? null,
                'ruangan_peminjam' => $validatedData['ruangan_peminjam'],
                'status_pinjam' => $validatedData['status_pinjam'],
            ]);

            Log::info('Data berhasil disimpan:', ['id' => $peminjaman->id]);

            return response()->json([
                'success' => true,
                'data' => $peminjaman
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan peminjaman: ', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $siswas = Siswa::all();
        $barangs = Barang::all();
        return view('pages.user.peminjaman-barang.edit', compact('siswas', 'barangs'))
            ->withInput($peminjaman->toArray());
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'tanggal_pinjam' => 'required|date',
            'status_pinjam' => 'required',
            'ruangan_peminjam' => 'required|string',
        ];

        if ($request->status_pinjam === 'kembali') {
            $rules['tanggal_kembali'] = 'required|date';
        } else {
            $rules['tanggal_kembali'] = 'nullable|date';
        }

        $request->validate($rules);

        $peminjaman = Peminjaman::findOrFail($id);

        $dataToUpdate = [
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status_pinjam' => $request->status_pinjam,
            'ruangan_peminjam' => $request->ruangan_peminjam,
        ];

        if ($request->status_pinjam === 'dipinjam') {
            $dataToUpdate['tanggal_kembali'] = null;
        } else {
            $dataToUpdate['tanggal_kembali'] = $request->tanggal_kembali;
        }

        $peminjaman->update($dataToUpdate);

        return redirect()->route('user.peminjaman-barang.index')->with('success', 'Daftar Peminjam berhasil diperbarui.');
    }




    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return response()->json(['success' => 'Daftar Peminjam berhasil dihapus.']);
    }
}
