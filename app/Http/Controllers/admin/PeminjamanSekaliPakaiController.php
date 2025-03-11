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
            $peminjamans = PeminjamanSekaliPakai::with('barangSekaliPakai')->get();

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('nama_barang', function ($row) {
                    return $row->barangSekaliPakai->nama_barang ?? '-';
                })
                ->addColumn('jml_barang', function ($row) {
                    // Menampilkan jumlah barang dari peminjaman_sekali_pakai
                    return $row->jml_barang;
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
        $nama_peminjam = $this->getSpreadsheetData();

        return view('pages.admin.peminjaman-sekali-pakai.create', compact('barang_sekali_pakai', 'nama_peminjam'));
    }

    public function store(Request $request)
{
    $request->validate([
        'barang_sekali_pakai_id' => 'required|exists:barang_sekali_pakai,id',
        'nama_peminjam' => 'required|string|max:255',
        'jml_barang' => 'required|integer|min:1',
        'keperluan' => 'required|string|max:255',
        'tanggal_pinjam' => 'required|date',
    ]);

    $barang = BarangSekaliPakai::findOrFail($request->barang_sekali_pakai_id);

    // Validasi jumlah barang
    if ($request->jml_barang > $barang->jml_barang) {
        return redirect()->back()->withErrors([
            'error' => 'Jumlah barang yang diminta melebihi stok yang tersedia.',
        ])->withInput();
    }

    if ($request->jml_barang <= 0) {
        return redirect()->back()->withErrors([
            'error' => 'Jumlah barang yang diminta harus lebih dari 0.',
        ])->withInput();
    }

    // Kurangi stok barang
    $barang->jml_barang -= $request->jml_barang;
    $barang->save();

    // Buat data peminjaman
    PeminjamanSekaliPakai::create($request->all());

    return redirect()->route('admin.peminjaman-sekali-pakai.index')->with('success', 'Peminjaman berhasil ditambahkan.');
}



    public function edit($id)
    {
        $peminjaman_sekali_pakai = PeminjamanSekaliPakai::findOrFail($id);
        $barang_sekali_pakai = BarangSekaliPakai::all();
        $nama_peminjam = $this->getSpreadsheetData();

        return view('pages.admin.peminjaman-sekali-pakai.edit', compact('peminjaman_sekali_pakai', 'barang_sekali_pakai', 'nama_peminjam'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'barang_sekali_pakai_id' => 'required|exists:barang_sekali_pakai,id',
        'jml_barang' => 'required|integer|min:1',
        'keperluan' => 'required|string',
        'tanggal_pinjam' => 'required|date',
    ]);

    $peminjaman = PeminjamanSekaliPakai::findOrFail($id);
    $barangLama = BarangSekaliPakai::findOrFail($peminjaman->barang_sekali_pakai_id);

    // Kembalikan stok barang lama
    $barangLama->jml_barang += $peminjaman->jml_barang;
    $barangLama->save();

    $barangBaru = BarangSekaliPakai::findOrFail($validated['barang_sekali_pakai_id']);

    // Validasi jumlah barang baru
    if ($validated['jml_barang'] > $barangBaru->jml_barang) {
        // Kembalikan stok barang lama jika validasi gagal
        $barangLama->jml_barang -= $peminjaman->jml_barang;
        $barangLama->save();

        return redirect()->back()->withErrors([
            'error' => 'Jumlah barang yang diminta melebihi stok yang tersedia.',
        ])->withInput();
    }

    if ($validated['jml_barang'] <= 0) {
        // Kembalikan stok barang lama jika validasi gagal
        $barangLama->jml_barang -= $peminjaman->jml_barang;
        $barangLama->save();

        return redirect()->back()->withErrors([
            'error' => 'Jumlah barang yang diminta harus lebih dari 0.',
        ])->withInput();
    }

    // Kurangi stok barang baru
    $barangBaru->jml_barang -= $validated['jml_barang'];
    $barangBaru->save();

    // Update data peminjaman
    $peminjaman->update([
        'barang_sekali_pakai_id' => $validated['barang_sekali_pakai_id'],
        'jml_barang' => $validated['jml_barang'],
        'keperluan' => $validated['keperluan'],
        'tanggal_pinjam' => $validated['tanggal_pinjam'],
    ]);

    return redirect()->route('admin.peminjaman-sekali-pakai.index')->with('success', 'Peminjaman berhasil diperbarui.');
}



    public function destroy($id)
    {
        $peminjaman = PeminjamanSekaliPakai::findOrFail($id);

        // Kembalikan stok barang
        $barang = $peminjaman->barangSekaliPakai;
        if ($barang) {
            $barang->kembalikanStok($peminjaman->jml_barang);
        }

        // Hapus data peminjaman
        $peminjaman->delete();

        return response()->json(['success' => 'Peminjaman berhasil dihapus.']);
    }
}
