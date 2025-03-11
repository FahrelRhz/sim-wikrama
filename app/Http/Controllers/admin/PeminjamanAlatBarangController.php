<?php

namespace App\Http\Controllers\admin;

use App\Models\PeminjamanAlatBarang;
use App\Models\AlatBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class PeminjamanAlatBarangController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $peminjamans = PeminjamanAlatBarang::with('alat_barang_id');

        return DataTables::of($peminjamans)
            ->addIndexColumn()
            ->addColumn('alat_barang_id', function ($row) {
                return $row->alat_barang_id->barang_merk ?? '-';
            })
            ->addColumn('actions', function ($row) {
                $editBtn = '<a href="' . route('peminjaman-alat-barang.edit', $row->id) . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" onclick="deletePeminjaman(' . $row->id . ')">Hapus</button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('pages.admin.peminjaman-alat-barang.index');
}



    // public function create()
    // {
    //     $alatBarangs = AlatBarang::all();
    //     return view('pages.admin.peminjaman-alat-barang.create', compact('alatBarangs'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_peminjam' => 'required|string|max:255',
    //         'alat_barang_id' => 'required|exists:alat_barang,id',
    //         'tanggal_pinjam' => 'required|date',
    //         'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
    //         'ruangan_peminjam' => 'nullable|string|max:255',
    //         'keperluan' => 'required|string|max:1000',
    //         'status_pinjam' => 'required|in:dipinjam,kembali',
    //     ]);

    //     PeminjamanAlatBarang::create($request->all());

    //     return redirect()->route('peminjaman-alat-barang.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    // }

    // public function edit($id)
    // {
    //     $peminjaman = PeminjamanAlatBarang::findOrFail($id);
    //     $alatBarangs = AlatBarang::all();
    //     return view('pages.admin.peminjaman-alat-barang.edit', compact('peminjaman', 'alatBarangs'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_peminjam' => 'required|string|max:255',
    //         'alat_barang_id' => 'required|exists:alat_barang,id',
    //         'tanggal_pinjam' => 'required|date',
    //         'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
    //         'ruangan_peminjam' => 'nullable|string|max:255',
    //         'keperluan' => 'required|string|max:1000',
    //         'status_pinjam' => 'required|in:dipinjam,kembali',
    //     ]);

    //     $peminjaman = PeminjamanAlatBarang::findOrFail($id);
    //     $peminjaman->update($request->all());

    //     return redirect()->route('peminjaman-alat-barang.index')->with('success', 'Peminjaman berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     $peminjaman = PeminjamanAlatBarang::findOrFail($id);
    //     $peminjaman->delete();

    //     return response()->json(['success' => 'Peminjaman berhasil dihapus.']);
    // }
}
