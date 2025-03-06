<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use Yajra\DataTables\Facades\DataTables;

class PermintaanBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userJurusanId = Auth::user()->jurusan_id;

            $permintaans = Permintaan::with(['user'])
                ->whereHas('user', function ($query) use ($userJurusanId) {
                    $query->where('jurusan_id', $userJurusanId);
                })
                ->select(['id', 'barang', 'user_id', 'tanggal_permintaan', 'alasan_permintaan', 'status']);

            return DataTables::of($permintaans)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="#" class="bi bi-card-checklist btn mx-1 btn-info edit-button" 
                        data-id="' . $row->id . '" 
                        data-barang="' . $row->barang . '"
                        data-user-id="' . $row->user_id . '"
                        data-tanggal-permintaan="' . $row->tanggal_permintaan . '"
                        data-alasan-permintaan="' . $row->alasan_permintaan . '"
                        data-status="' . $row->status . '"
                        data-bs-toggle="modal" 
                        data-bs-target="#editPermintaanModal">
                </a>';
                    $deleteBtn = '<a class="bi bi-trash btn btn-danger" data-id="' . $row->id . '" onclick="deletePermintaan(' . $row->id . ')"></a>';

                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }

        $users = User::all();
        $isModal = false;

        return view('pages.user.permintaan-barang.index', compact('users', 'isModal'));
    }



    public function create()
    {
        // $userJurusanId = Auth::user()->jurusan_id;
        // $users = User::where('jurusan_id', $userJurusanId)->get();
        return view('pages.user.permintaan-barang.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'barang' => 'required',
            // 'user_id' => 'required|exists:users,id',
            'tanggal_permintaan' => 'required|date',
            'alasan_permintaan' => 'required',
        ]);

        // Simpan permintaan
        Permintaan::create([
            'barang' => $request->barang,
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'alasan_permintaan' => $request->alasan_permintaan,
        ]);

        return redirect()->route('user.permintaan-barang.index')
            ->with('success', 'Permintaan sudah berhasil dikirim!');
    }


    public function edit($id)
    {
        $permintaan = Permintaan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.user.permintaan-barang.edit', compact('permintaan'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'barang' => 'required',
            'tanggal_permintaan' => 'required|date',
            'alasan_permintaan' => 'required',
        ]);

        $permintaan = Permintaan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $permintaan->update([
            'barang' => $request->barang,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'alasan_permintaan' => $request->alasan_permintaan,
        ]);

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
