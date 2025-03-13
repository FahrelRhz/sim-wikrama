<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\User;
use App\Models\RequestPerbaikanBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RequestPerbaikanBarangsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requestPerbaikanBarang = RequestPerbaikanBarang::with(['user', 'barang'])
                ->select(['id', 'barang_id', 'user_id', 'tanggal_request', 'status', 'deskripsi_kerusakan']);
            return DataTables::of($requestPerbaikanBarang)
                ->addIndexColumn()
                ->addColumn('barang_id', function ($requestPerbaikanBarang) {
                    return optional($requestPerbaikanBarang->barang)->nama_barang
                        ? $requestPerbaikanBarang->barang->nama_barang . ' - ' . $requestPerbaikanBarang->barang->kode_barang
                        : '-';
                })
                ->addColumn('user', function ($requestPerbaikanBarang) {
                    return $requestPerbaikanBarang->user->name ?? '-';
                })
                ->addColumn('actions', function ($requestPerbaikanBarang) {

                    $editBtn = '<a href="#" class="bi bi-card-checklist btn mx-1 btn-info edit-button" 
                                data-id="' . $requestPerbaikanBarang->id . '" 
                                data-status="' . $requestPerbaikanBarang->status . '"
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

        return view('pages.admin.request-perbaikan-barang.index', compact('barangs', 'users', 'isModal'));
    }


    public function edit($id)
    {
        $requestPerbaikanBarang = RequestPerbaikanBarang::find($id);

        return view('pages.admin.request-perbaikan-barang.edit', compact('requestPerbaikanBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $requestPerbaikanBarang = RequestPerbaikanBarang::findOrFail($id);
        $requestPerbaikanBarang->update([
            'status' => $request->input('status')
        ]);

        return redirect()->route('admin.request-perbaikan-barang.index')
            ->with('success', 'Status perbaikan berhasil diubah!');
    }

    public function destroy($id)
    {
        $requestPerbaikanBarang = RequestPerbaikanBarang::findOrFail($id);
        $requestPerbaikanBarang->delete();

        return response()->json(['success' => 'Perbaikan berhasil dihapus!']);
    }
}
