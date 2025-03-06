<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BarangSekaliPakai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\PeminjamanSekaliPakai;

class PeminjamanSekaliPakaiController extends Controller
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
    
        $pegawai = [];
        foreach ($rows as $row) {
            if (isset($row[1])) {
                $pegawai[] = trim($row[1]);
            }
        }
    
        return $pegawai;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjamans = PeminjamanSekaliPakai::with('barangSekaliPakai')
                ->get();

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('nama_barang', function ($row) {
                    return $row->barangSekaliPakai->nama_barang ?? '-';
                })
                ->addColumn('jml_barang', function ($row) {
                    return $row->barangSekaliPakai->jml_barang ?? 0; // Menampilkan jumlah barang atau 0 jika null
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="' . route('admin.peminjaman-sekali-pakai.edit', $row->id) . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deletePeminjaman(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.admin.peminjaman-sekali-pakai.index');
    }

    public function create()
    {
        $barang_sekali_pakai = BarangSekaliPakai::all();
        $nama_peminjam = $this->getSpreadsheetData(); // Ambil data peminjam dari spreadsheet
    
        return view('pages.admin.peminjaman-sekali-pakai.create', compact('barang_sekali_pakai', 'nama_peminjam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_sekali_pakai_id' => 'required|exists:barang_sekali_pakai,id',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);

        PeminjamanSekaliPakai::create($request->all());

        return redirect()->route('admin.peminjaman-sekali-pakai.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman_sekali_pakai = PeminjamanSekaliPakai::findOrFail($id);
        $barang_sekali_pakai = BarangSekaliPakai::all();
        return view('pages.admin.peminjaman-sekali-pakai.edit', compact('peminjaman_sekali_pakai', 'barang_sekali_pakai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_sekali_pakai_id' => 'required|exists:barang_sekali_pakai,id',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);

        $peminjaman_sekali_pakai = PeminjamanSekaliPakai::findOrFail($id);
        $peminjaman_sekali_pakai->update($request->all());

        return redirect()->route('admin.peminjaman-sekali-pakai.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman_sekali_pakai = PeminjamanSekaliPakai::findOrFail($id);
        $peminjaman_sekali_pakai->delete();

        return response()->json(['success' => 'Peminjaman berhasil dihapus.']);
    }
}
