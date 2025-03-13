<?php

namespace App\Http\Controllers\admin;

use Log;
use App\Models\AlatBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\PeminjamanAlatBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanAlatBarangController extends Controller
{

    public function getSpreadsheetData()
    {
        $csvUrl = "https://docs.google.com/spreadsheets/d/1L9jnY5Dhk17gthF9kwsLYwAAcv9U1a1SGyyiqcj1dgI/gviz/tq?tqx=out:csv";
        $response = Http::get($csvUrl);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data dari Google Spreadsheet'], 500);
        }

        $rows = array_map("str_getcsv", explode("\n", trim($response->body())));
        array_shift($rows);

        $nama_peminjam = [];
        foreach ($rows as $row) {
            if (isset($row[1])) {
                $nama_peminjam[] = ['nama_peminjam' => trim($row[1])];
            }
        }

        return response()->json($nama_peminjam);
    }

    public function index(Request $request)
    {
        $alat_barangs = AlatBarang::whereDoesntHave('alat_barang', function ($query) {
            $query->where('status_pinjam', 'dipinjam');
        })->get();

        $nama_peminjam = $this->getSpreadsheetData();

        if ($request->ajax()) {
            $peminjamans = PeminjamanAlatBarang::with('alat_barang');

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('alat_barang_id', function ($row) {
                    return $row->alat_barang->barang_merk ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm mb-1 mx-1 btn-warning edit-button"
                                    data-id="' . $row->id . '"

                                    data-tanggal_pinjam="' . $row->tanggal_pinjam . '"
                                    data-tanggal_kembali="' . $row->tanggal_kembali . '"

                                    data-status_pinjam="' . $row->status_pinjam . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPeminjamanAlatBarangModal">Edit
                                </a>
                            </div>';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.admin.peminjaman-alat-barang.index', compact('alat_barangs', 'nama_peminjam'));
    }

    public function createBarangs()
    {
        $alat_barangs = AlatBarang::whereDoesntHave('alat_barang', function ($query) {
            $query->where('status_pinjam', 'dipinjam');
        });
        return view('pages.admin.peminjaman-alat-barang.create', compact($alat_barangs));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_peminjam' => 'required|string',
            'alat_barang_id' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'ruangan_peminjam' => 'required|string',
            'keperluan' => 'required|string',
        ]);

        try {
            PeminjamanAlatBarang::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $peminjaman_alat_barang = PeminjamanAlatBarang::findOrFail($id);
        $alat_barangs = AlatBarang::all();
        return view('pages.admin.peminjaman-alat-barang.edit', compact('peminjaman_alat_barang', 'alat_barangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status_pinjam' => 'required|in:dipinjam,kembali',
        ]);

        $peminjaman = PeminjamanAlatBarang::findOrFail($id);

        // Jika status diubah menjadi "dipinjam", kosongkan tanggal_kembali
        if ($request->status_pinjam === 'dipinjam') {
            $request->merge(['tanggal_kembali' => null]);
        }

        $peminjaman->update($request->all());

        return redirect()->route('admin.peminjaman-alat-barang.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = PeminjamanAlatBarang::findOrFail($id);
        $peminjaman->delete();

        return response()->json(['success' => 'Peminjaman berhasil dihapus.']);
    }

    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', now()->format('m'));

        $peminjamans = PeminjamanAlatBarang::with('alat_barang')
            ->whereMonth('created_at', $month)
            ->get();

        Log::info('PeminjamanAlatBarang data:', $peminjamans->toArray());

        // Generate PDF
        $pdf = Pdf::loadView('pages.admin.peminjaman-alat-barang.pdf', [
            'peminjamans' => $peminjamans,
            'month' => $month,
        ]);

        return $pdf->download("laporan-peminjaman-alat-barang-{$month}.pdf");
    }
}
