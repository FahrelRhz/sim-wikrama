<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use Yajra\DataTables\Facades\DataTables;

class PermintaanBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permintaans = Permintaan::with(['user'])->select(['id', 'barang', 'user_id', 'tanggal_permintaan', 'alasan_permintaan']);
            return DataTables::of($permintaans)
                ->addIndexColumn()
                ->addColumn('user', function ($user) {
                    return $user->user->name ?? '-';
                })
                ->addColumn('actions', function ($row) {

                    $editBtn = '<a href="#" class="bi bi-card-checklist btn mx-1 btn-info edit-button" 
                                data-id="' . $row->id . '" 
                                data-barang="' . $row->barang . '"
                                data-user-id="' . $row->user_id . '"
                                data-tanggal-permintaan="' . $row->tanggal_permintaan . '"
                                data-alasan-permintaan="' . $row->alasan_permintaan . '"
                                data-bs-toggle="modal" 
                                data-bs-target="#editPermintaanModal">
                        </a>';
                    $deleteBtn = '<a class="bi bi-trash btn btn-danger" data-id="' . $row->id . '" onclick="deletePermintaan(' . $row->id . ')"></a>';


                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $users = User::all();
        $isModal = false;

        return view('pages.user.permintaan-barang.index', compact('users', 'isModal'));
    }


    public function create()
    {
        $users = User::all();
        return view('pages.user.permintaan-barang.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang' => 'required',
            'user_id' => 'required|exists:users,id',
            'tanggal_permintaan' => 'required|date',
            'alasan_permintaan' => 'required',
        ]);
    
        Permintaan::create($request->all());
    
        return redirect()->route('user.permintaan-barang.index')
                         ->with('success', 'Permintaan sudah berhasil dikirim!');
    }

    public function edit($id)
    {
        $permintaan = Permintaan::find($id);
        $users = User::all();

        return view('pages.user.permintaan-barang.edit', compact('permintaan', 'users'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang' => 'nullable',
            'user_id' => 'nullable|exists:users,id',
            'tanggal_permintaan' => 'nullable|date',
            'alasan_permintaan' => 'nullable',
        ]);
    
        $permintaans = Permintaan::findOrFail($id);
        $permintaans->update($request->only('barang', 'user_id', 'tanggal_permintaan', 'alasan_permintaan'));
    
        return redirect()->route('user.permintaan-barang.index')
                         ->with('success', 'Permintaan berhasil diubah!');
    }
    
    public function destroy($id)
    {
        $permintaans = Permintaan::findOrFail($id);
        $permintaans->delete();
    
        return response()->json(['success' => 'Permintaan berhasil dihapus!']);
    }
    
}
