<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Jurusan;
use Yajra\DataTables\DataTables;

class DaftarBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mendapatkan jurusan user yang login
            $userJurusanId = Auth::user()->jurusan_id;
    
            // Mengambil data barang sesuai dengan jurusan user yang login
            $barangs = Barang::with('jurusan')
                ->where('jurusan_id', $userJurusanId)
                ->select(['id', 'kode_barang', 'nama_barang', 'merk_barang', 'sumber_dana','kondisi_barang', 'deskripsi_barang', 'tanggal_pengadaan']);
    
            return DataTables::of($barangs)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $showBtn = '<a href="#" class="bi bi-eye btn btn-info btn-sm me-2 show-barang" 
                    data-id="' . $row->id . '"
                    data-kode_barang="' . $row->kode_barang . '"
                    data-nama_barang="' . $row->nama_barang . '" 
                    data-merk_barang="' . $row->merk_barang . '"
                    data-sumber_dana="' . $row->sumber_dana . '"
                    data-kondisi_barang="' . $row->kondisi_barang . '"
                    data-deskripsi_barang="' . $row->deskripsi_barang . '"
                    data-tanggal_pengadaan="' . $row->tanggal_pengadaan . '">
                    </a>';
                    $editBtn = '<a href="' . route('user.daftar-barang.edit', $row->id) . '" class="bi bi-card-checklist btn btn-warning btn-sm me-2"></a>';
                    $deleteBtn = '<button class="bi bi-trash btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteBarang(' . $row->id . ')"></button>';
                    return $showBtn . $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    
        return view('pages.user.daftar-barang.index');
    }
    public function create()
    {
        $jurusans = Jurusan::all();
        $userJurusanId = auth()->user()->jurusan_id;
    
        return view('pages.user.daftar-barang.create', compact('jurusans', 'userJurusanId'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_barang' => 'required|string|max:255',
            'tanggal_pengadaan' => 'required|date',
            'sumber_dana' => 'required|string|max:255',
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
            'kondisi_barang' => $request->kondisi_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('user.daftar-barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barangs = Barang::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('pages.user.daftar-barang.show', compact('barangs', 'jurusans'));
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
