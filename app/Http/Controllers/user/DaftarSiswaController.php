<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;
use Yajra\DataTables\Facades\DataTables;

class DaftarSiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $siswas = Siswa::with('jurusan')->select(['id', 'nis', 'nama_siswa', 'rombel','rayon','jurusan_id']);
            return DataTables::of($siswas)
                ->addIndexColumn()
                ->addColumn('jurusan', function ($user) {
                    return $user->jurusan->nama_jurusan ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="' . route('user.daftar-siswa.edit', $row->id) . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteSiswa(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.user.daftar-siswa.index');
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('pages.user.daftar-siswa.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:255',
            'nama_siswa' => 'required|string|max:255',
            'rombel' => 'required|string|max:255',
            'rayon' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('user.daftar-siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('pages.user.daftar-siswa.edit', compact('siswa', 'jurusans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string|max:255',
            'nama_siswa' => 'required|string|max:255',
            'rombel' => 'required|string|max:255',
            'rayon' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('user.daftar-siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return response()->json(['success' => 'Siswa berhasil dihapus.']);
    }

}
