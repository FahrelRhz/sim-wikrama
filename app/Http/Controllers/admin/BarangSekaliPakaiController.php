<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BarangSekaliPakai;
use App\Http\Controllers\Controller;

class BarangSekaliPakaiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = BarangSekaliPakai::all();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="#" class="btn btn-sm mb-1 mx-1 btn-warning edit-button" 
                        data-id="' . $row->id . '" 
                        data-nama_barang="' . $row->nama_barang . '"
                        data-jml-barang="' . $row->jml_barang . '"
                        data-bs-toggle="modal" 
                        data-bs-target="#editBarangModal">Edit
                </a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteBarang(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.admin.barang-sekali-pakai.index');
    }

    public function create()
    {
        $barang_sekali_pakais = BarangSekaliPakai::all();
        return view('pages.admin.barang-sekali-pakai.create', compact('barang_sekali_pakais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jml_barang' => 'required|int|min:1',
        ]);

        $barang = BarangSekaliPakai::where('nama_barang', $request->nama_barang)->first();

        if ($barang) {
            $barang->increment('jml_barang', $request->jml_barang);
            return redirect()->route('admin.barang-sekali-pakai.index')->with('success', 'Stok barang berhasil diperbarui.');
        } else {
            BarangSekaliPakai::create([
                'nama_barang' => $request->nama_barang,
                'jml_barang' => $request->jml_barang,
            ]);

            return redirect()->route('admin.barang-sekali-pakai.index')->with('success', 'Barang berhasil ditambahkan.');
        }
    }

    public function edit($id)
    {
        $barang_sekali_pakais = BarangSekaliPakai::findOrFail($id);
        return view('pages.admin.barang-sekali-pakai.edit', compact('barang_sekali_pakais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jml_barang' => 'required|integer',
        ]);

        $barang_sekali_pakai = BarangSekaliPakai::findOrFail($id);
        $barang_sekali_pakai->update([
            'nama_barang' => $request->nama_barang,
            'jml_barang' => $request->jml_barang,
        ]);

        return redirect()->route('admin.barang-sekali-pakai.index')->with('success', 'Barang berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $barang_sekali_pakai = BarangSekaliPakai::findOrFail($id);
        $barang_sekali_pakai->delete();

        return response()->json(['success' => 'Barang berhasil di hapus']);
    }
}
