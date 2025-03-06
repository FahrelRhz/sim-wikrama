<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PeminjamanSekaliPakai;
use App\Models\BarangSekaliPakai;
use App\Http\Controllers\Controller;

class PeminjamanSekaliPakaiController extends Controller
{
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
        return view('pages.admin.peminjaman-sekali-pakai.create', compact('barang_sekali_pakai'));
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
