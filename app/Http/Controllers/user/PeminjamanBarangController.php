<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Barang;
use GuzzleHttp\Client;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;

class PeminjamanBarangController extends Controller
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
        $rombelList = [];
        $rayonList = [];

        foreach ($rows as $row) {
            if (count($row) < 4)
                continue;

            $rombel = trim($row[2]);
            $rayon = trim($row[3]);
            $jurusanSiswa = strtoupper(trim(explode(' ', preg_replace('/[^A-Za-z0-9 ]/', '', $rombel))[0]));

            if (strpos($jurusanSiswa, $namaJurusan) !== false) {
                $siswa[] = [
                    'no' => trim($row[0]),
                    'nama' => trim($row[1]),
                    'rayon' => $rayon,
                    'rombel' => $rombel,
                    'jurusan' => $jurusanSiswa,
                ];
            }

            if (!in_array($rayon, $rayonList)) {
                $rayonList[] = $rayon;
            }

            if (!in_array($rombel, $rombelList)) {
                $rombelList[] = $rombel;
            }
        }

        return response()->json([
            'rayon' => $rayonList,
            'rombel' => $rombelList,
            'siswa' => $siswa
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $jurusanId = $user->jurusan_id;

        // Ambil data siswa dari Google Spreadsheet
        $siswaData = $this->getSpreadsheetData()->original;

        if ($request->ajax()) {
            $peminjamans = Peminjaman::with(['barang'])
                ->whereHas('barang', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                })
                ->select(['id', 'siswa', 'rombel', 'rayon', 'barang_id', 'tanggal_pinjam', 'tanggal_kembali', 'ruangan_peminjam', 'status_pinjam']);

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('siswa', function ($peminjaman) use ($siswaData) {
                    return collect($siswaData['siswa'])->firstWhere('nama', $peminjaman->siswa)['nama'] ?? '-';
                })
                ->addColumn('rombel', function ($peminjaman) use ($siswaData) {
                    return collect($siswaData['siswa'])->firstWhere('nama', $peminjaman->siswa)['rombel'] ?? '-';
                })
                ->addColumn('rayon', function ($peminjaman) use ($siswaData) {
                    return collect($siswaData['siswa'])->firstWhere('nama', $peminjaman->siswa)['rayon'] ?? '-';
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
            $barangTerakhir = Peminjaman::where('barang_id', $validatedData['barang_id'])
                ->orderBy('id', 'desc')
                ->first();

            if ($barangTerakhir) {
                Log::info('Status terakhir barang:', [
                    'barang_id' => $validatedData['barang_id'],
                    'status' => $barangTerakhir->status_pinjam
                ]);

                if ($barangTerakhir->status_pinjam === 'dipinjam') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Barang ini masih dipinjam dan belum dikembalikan.'
                    ], 422);
                }
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

    public function downloadPdf(Request $request)
    {
        $user = Auth::user();
        $jurusanId = $user->jurusan_id;

        // Ambil tanggal yang dipilih dari request, default ke bulan & tahun ini jika kosong
        $date = $request->input('date', now()->format('Y-m'));
        [$year, $month] = explode('-', $date); // Pisahkan tahun & bulan

        $peminjamans = Peminjaman::with('barang')
            ->whereHas('barang', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            })
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        \Log::info('Peminjaman data:', $peminjamans->toArray());

        $pdf = Pdf::loadView('pages.user.peminjaman-barang.pdf', [
            'peminjamans' => $peminjamans,
            'date' => "{$year}-{$month}",
        ]);

        return $pdf->download("laporan-peminjaman-barang-{$year}-{$month}.pdf");
    }
}
