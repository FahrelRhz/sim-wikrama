<?php


namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\AlatBarang;
use App\Http\Controllers\Controller;

class AlatBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alatBarang = AlatBarang::all();
            return DataTables::of($alatBarang)
                ->addIndexColumn()
                ->addColumn('harga_satuan', function ($row) {
                    return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
                })
                ->addColumn('jumlah_harga', function ($row) {
                    return 'Rp. ' . number_format($row->jumlah_harga, 0, ',', '.');
                })
                
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="' . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteAlatBarang(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.admin.alat-barang.index');
    }



    public function create()
    {
        $alat_barangs = AlatBarang::all();
        return view('pages.admin.alat-barang.create', compact('alat_barangs'));
    }

    public function store(Request $request)
{
    // Validasi data input
    $request->validate([
        'jenis' => 'required|string|max:255',
        'barang_merk' => 'required|string|max:255',
        'volume' => 'required|integer|min:1',
        'satuan' => 'required|string|max:50',
        'harga_satuan' => 'required|string|min:0', // Diubah ke string karena akan diformat
        'jumlah_harga' => 'required|string|min:0', // Diubah ke string karena akan diformat
        'keterangan' => 'nullable|string|max:1000',
        'link_siplah' => 'nullable|url',
    ]);

    // Format ulang nilai input 'harga_satuan' dan 'jumlah_harga'
    $request->merge([
        'harga_satuan' => str_replace(['Rp.', '.'], '', $request->harga_satuan),
        'jumlah_harga' => str_replace(['Rp.', '.'], '', $request->jumlah_harga),
    ]);

    // Simpan data ke database
    $alatBarang = AlatBarang::create([
        'jenis' => $request->jenis,
        'barang_merk' => $request->barang_merk,
        'volume' => $request->volume,
        'satuan' => $request->satuan,
        'harga_satuan' => $request->harga_satuan,
        'jumlah_harga' => $request->jumlah_harga,
        'keterangan' => $request->keterangan,
        'link_siplah' => $request->link_siplah,
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.alat-barang.index')->with('success', 'Alat atau Barang berhasil ditambahkan.');
}


    // public function edit($id)
    // {
    //     $alat_barang = AlatBarang::findOrFail($id); 
    //     return view('pages.admin.alat-barang.edit', compact('alat_barang')); 
    // }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'jenis' => 'required|string|max:255',
    //         'barang_merk' => 'required|string|max:255',
    //         'volume' => 'required|integer|min:1',
    //         'satuan' => 'required|string|max:50',
    //         'harga_satuan' => 'required|numeric|min:0',
    //         'jumlah_harga' => 'required|numeric|min:0',
    //         'keterangan' => 'nullable|string|max:1000',
    //         'link_siplah' => 'nullable|url|max:255',
    //     ]);

    //     $alat_barangs = AlatBarang::findOrFail($id);
    //     $alat_barangs->update([
    //         'jenis' => $request->jenis,
    //         'barang_merk' => $request->barang_merk,
    //         'volume' => $request->volume,
    //         'satuan' => $request->satuan,
    //         'harga_satuan' => $request->harga_satuan,
    //         'jumlah_harga' => $request->jumlah_harga,
    //         'keterangan' => $request->keterangan,
    //         'link_siplah' => $request->link_siplah,
    //     ]);

    //     return redirect()->route('admin.alat-barang.index')->with('success', 'Alat atau Barang berhasil diperbarui.');
    // }

    public function destroy($id)
    {
        $alat_barang = AlatBarang::findOrFail($id);
        $alat_barang->delete();

        return response()->json(['success' => 'Alat atau Barang berhasil di hapus']);
    }
}
