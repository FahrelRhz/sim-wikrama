<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Siswa;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjamans = Peminjaman::with(['siswa', 'barang'])->select(['id', 'siswa_id', 'barang_id', 'tanggal_pinjam', 'tanggal_kembali', 'status_pinjam']);
            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('siswa', function ($user) {
                    return $user->siswa->nama_siswa ?? '-';
                })
                ->addColumn('barang', function ($user) {
                    return $user->barang->nama_barang ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="#" class="bi bi-card-checklist edit-button" 
                                data-id="' . $row->id . '" 
                                data-tanggal_pinjam="' . $row->tanggal_pinjam . '"
                                data-tanggal_kembali="' . $row->tanggal_kembali . '"
                                data-status_pinjam="' . $row->status_pinjam . '"
                            ></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $siswas = Siswa::all();
        $barangs = Barang::all();

        return view('pages.user.peminjaman-barang.index', compact('siswas', 'barangs'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $barangs = Barang::all();
        return view('pages.user.peminjaman-barang.create', compact('siswas', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "siswa_id" => "required|exists:siswa,id",
            "barang_id" => "required|exists:barang,id",
            "tanggal_pinjam" => "required|date",
            "tanggal_kembali" => "nullable|date",
            "status_pinjam" => "required",
        ]);

        $statusPinjam = $request->status_pinjam === 'dipinjam' ? 'dipinjam' : 'kembali';

        $peminjaman = Peminjaman::create([
            'siswa_id' => $request->siswa_id,
            'barang_id' => $request->barang_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status_pinjam' => $statusPinjam,
        ]);

        return redirect()->route('user.peminjaman-barang.index')->with('success', 'Daftar Peminjam berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $siswas = Siswa::all();
        $barangs = Barang::all();
        return view('pages.user.peminjaman-barang.edit', compact('siswas', 'barangs'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            "tanggal_pinjam" => "required|date",
            "tanggal_kembali" => "nullable|date", 
            "status_pinjam" => "required",
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $dataToUpdate = [
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status_pinjam' => $request->status_pinjam
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
