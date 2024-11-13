<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\User;
use App\Models\RequestPerbaikanBarang;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use Yajra\DataTables\Facades\DataTables;

class RequestPerbaikanBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requestPerbaikanBarang = RequestPerbaikanBarang::with(['user', 'barang'])->select(['id','barang_id', 'user_id', 'tanggal_request', 'status', 'deskripsi_kerusakan']);
            return DataTables::of($requestPerbaikanBarang)
                ->addIndexColumn()
                ->addColumn('barang', function ($requestPerbaikanBarang) {
                    return $requestPerbaikanBarang->barang->nama_barang ?? '-';
                })
                ->addColumn('user', function ($requestPerbaikanBarang) {
                    return $requestPerbaikanBarang->user->name ?? '-';
                })
                ->addColumn('actions', function ($requestPerbaikanBarang) {

                    $editBtn = '<a href="#" class="bi bi-card-checklist btn mx-1 btn-info edit-button" 
                                data-id="' . $requestPerbaikanBarang->id . '" 
                                data-barang-id="' . $requestPerbaikanBarang->barang_id . '"
                                data-user-id="' . $requestPerbaikanBarang->user_id . '"
                                data-tanggal-request="' . $requestPerbaikanBarang->tanggal_request . '"
                                data-deskripsi-kerusakan="' . $requestPerbaikanBarang->deskripsi_kerusakan . '"
                                data-bs-toggle="modal" 
                                data-bs-target="#editRequestPerbaikanBarangModal">
                        </a>';
                    $deleteBtn = '<a class="bi bi-trash btn btn-danger" data-id="' . $requestPerbaikanBarang->id . '" onclick="deleteRequestPerbaikanBarang(' . $requestPerbaikanBarang->id . ')"></a>';


                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $barangs = Barang::all();
        $users = User::all();
        $isModal = false;

        return view('pages.user.request-perbaikan-barang.index', compact('barangs','users','isModal'));
    }


    public function create()
    {   
        $barangs = Barang::all();
        $users = User::all();
        return view('pages.user.request-perbaikan-barang.create', compact('barangs','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'tanggal_request' => 'required|date',
            'deskripsi_kerusakan' => 'required',
        ]);
    
        RequestPerbaikanBarang::create($request->all());
    
        return redirect()->route('user.request-perbaikan-barang.index')
                         ->with('success', 'Request perbaikan sudah berhasil dikirim!');
    }

    public function edit($id)
    {
        $requestPerbaikanBarang = RequestPerbaikanBarang::find($id);
        $barangs = Barang::all();
        $users = User::all();

        return view('pages.user.request-perbaikan-barang.edit', compact('requestPerbaikanBarang', 'barangs', 'users'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'nullable',
            'user_id' => 'nullable|exists:users,id',
            'tanggal_request' => 'nullable|date',
            'deskripsi_kerusakan' => 'nullable',
        ]);
    
        $requestPerbaikanBarang = RequestPerbaikanBarang::findOrFail($id);
        $requestPerbaikanBarang->update($request->only('barang_id', 'user_id', 'tanggal_request', 'deskripsi_kerusakan'));
    
        return redirect()->route('user.request-perbaikan-barang.index')
                         ->with('success', 'Permintaan berhasil diubah!');
    }
    
    public function destroy($id)
    {
        $requestPerbaikanBarang = RequestPerbaikanBarang::findOrFail($id);
        $requestPerbaikanBarang->delete();
    
        return response()->json(['success' => 'Permintaan berhasil dihapus!']);
    }
    
}
