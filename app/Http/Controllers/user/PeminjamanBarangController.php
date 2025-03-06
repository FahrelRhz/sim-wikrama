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
use GuzzleHttp\Exception\RequestException;

class PeminjamanBarangController extends Controller
{

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

    public function downloadPdf(Request $request)
    {
        $user = Auth::user();
        $jurusanId = $user->jurusan_id;

        // Ambil tanggal dari request atau default ke bulan & tahun ini
        $date = $request->input('date', now()->toDateString());
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        // Ambil data peminjaman berdasarkan bulan & tahun yang dipilih
        $peminjamans = Peminjaman::with('barang')
            ->whereHas('barang', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            })
            ->whereYear('tanggal_pinjam', $year)
            ->whereMonth('tanggal_pinjam', $month)
            ->get();

        \Log::info('Peminjaman data:', $peminjamans->toArray());

        $pdf = Pdf::loadView('pages.user.peminjaman-barang.pdf', [
            'peminjamans' => $peminjamans,
            'date' => "{$year}-{$month}",
        ]);

        return $pdf->download("laporan-peminjaman-barang-{$year}-{$month}.pdf");
    }

}
