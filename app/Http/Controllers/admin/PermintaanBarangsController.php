<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use Yajra\DataTables\Facades\DataTables;

class PermintaanBarangsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permintaans = Permintaan::with(['user'])->select(['id', 'barang', 'user_id', 'tanggal_permintaan', 'alasan_permintaan', 'status']);
            return DataTables::of($permintaans)
                ->addIndexColumn()
                ->addColumn('user', function ($permintaans) {
                    return $permintaans->user->name ?? '-';
                })
                ->addColumn('actions', function ($permintaans) {
                    $editBtn = '<a href="#" class="bi bi-card-checklist btn mx-1 btn-info edit-button" 
                    data-id="' . $permintaans->id . '" 
                    data-status="' . $permintaans->status . '"
                    data-bs-toggle="modal" 
                    data-bs-target="#editPermintaanBarangModal">
                    </a>';
                    $deleteBtn = '<a class="bi bi-trash btn btn-danger" data-id="' . $permintaans->id . '" onclick="deletePermintaan(' . $permintaans->id . ')"></a>';


                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $users = User::all();
        $isModal = false;

        return view('pages.admin.permintaan-barang.index', compact('users', 'isModal'));
    }

    public function edit($id)
    {
        $permintaanBarang = Permintaan::find($id);

        return view('pages.admin.permintaan-barang.edit', compact('permintaanBarang'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required',
    ]);

    $permintaanBarang = Permintaan::findOrFail($id);

    $permintaanBarang->status = $request->input('status');
    $permintaanBarang->save();

    return redirect()->route('admin.permintaan-barang.index')
        ->with('success', 'Status permintaan berhasil diubah!');
}




    public function destroy($id)
    {
        $permintaans = Permintaan::findOrFail($id);
        $permintaans->delete();

        return response()->json(['success' => 'Permintaan berhasil dihapus!']);
    }
}
