<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Jurusan;
use Yajra\DataTables\DataTables;

class DaftarBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::with('jurusan')->select(['id', 'kode_barang', 'nama_barang', 'merk_barang','kategori_barang','jumlah_barang']);
            return DataTables::of($barangs)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="' . route('user.daftar-barang.edit', $row->id) . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteBarang(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.user.daftar-barang.index');
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('pages.user.daftar-barang.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_barang' => 'required|string|max:255',
            'tanggal_pengadaan' => 'required|date',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'kategori_barang' => 'required|string|max:255',
            'kondisi_barang' => 'required|string|max:255',
            'deskripsi_barang' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $barang = Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'merk_barang' => $request->merk_barang,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'sumber_dana' => $request->sumber_dana,
            'jumlah_barang' => $request->jumlah_barang,
            'kategori_barang' => $request->kategori_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('user.daftar-barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('pages.user.daftar-barang.edit', compact('barang', 'jurusans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_barang' => 'required|string|max:255',
            'tanggal_pengadaan' => 'required|date',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'kategori_barang' => 'required|string|max:255',
            'kondisi_barang' => 'required|string|max:255',
            'deskripsi_barang' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'merk_barang' => $request->merk_barang,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'sumber_dana' => $request->sumber_dana,
            'jumlah_barang' => $request->jumlah_barang,
            'kategori_barang' => $request->kategori_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('user.daftar-barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['success' => 'Barang berhasil dihapus.']);
    }

}
