<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $userJurusanId = Auth::user()->jurusan_id;

            $requestPerbaikanBarang = RequestPerbaikanBarang::with(['user', 'barang'])
                ->whereHas('user', function ($query) use ($userJurusanId) {
                    $query->where('jurusan_id', $userJurusanId);
                })
                ->whereHas('barang', function ($query) use ($userJurusanId) {
                    $query->where('jurusan_id', $userJurusanId);
                })
                ->select(['id', 'barang_id', 'user_id', 'tanggal_request', 'status', 'deskripsi_kerusakan']);

            return DataTables::of($requestPerbaikanBarang)
                ->addIndexColumn()
                ->addColumn('barang', function ($requestPerbaikanBarang) {
                    return $requestPerbaikanBarang->barang
                        ? $requestPerbaikanBarang->barang->nama_barang . ' - ' . $requestPerbaikanBarang->barang->kode_barang
                        : '-';
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

        $barangs = Barang::where('jurusan_id', auth()->user()->jurusan_id)->get();
        $users = User::all();
        $isModal = false;

        return view('pages.user.request-perbaikan-barang.index', compact('barangs', 'users', 'isModal'));
    }




    public function create()
    {
        $userJurusanId = auth()->user()->jurusan_id;

        $barangs = Barang::where('jurusan_id', $userJurusanId)
            ->whereDoesntHave('request_perbaikan_barang', function ($query) {
                $query->whereIn('status', ['Pending', 'Dalam Perbaikan']);
            })->get();

        return view('pages.user.request-perbaikan-barang.create', compact('barangs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => [
                'required',
                'exists:barang,id',
                function ($attribute, $value, $fail) {
                    $barang = Barang::find($value);
                    if ($barang && $barang->requestPerbaikanBarang()->whereIn('status', ['Pending', 'Dalam Perbaikan'])->exists()) {
                        $fail('Barang ini sedang dalam proses perbaikan.');
                    }
                },
            ],
            'tanggal_request' => 'required|date',
            'deskripsi_kerusakan' => 'required',
        ]);

        try {
            RequestPerbaikanBarang::create([
                'barang_id' => $request->barang_id,
                'user_id' => auth()->id(),
                'tanggal_request' => $request->tanggal_request,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'status' => 'Pending',
            ]);

            return redirect()->route('user.request-perbaikan-barang.index')
                ->with('success', 'Request perbaikan sudah berhasil dikirim!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $requestPerbaikanBarang = RequestPerbaikanBarang::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $userJurusanId = auth()->user()->jurusan_id;
        $barangs = Barang::where('jurusan_id', $userJurusanId)->get();

        return view('pages.user.request-perbaikan-barang.edit', compact('requestPerbaikanBarang', 'barangs'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_request' => 'required|date',
            'deskripsi_kerusakan' => 'required',
        ]);

        $requestPerbaikanBarang = RequestPerbaikanBarang::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (in_array($requestPerbaikanBarang->status, ['Pending', 'Dalam Perbaikan'])) {
            return back()->withErrors(['status' => 'Barang ini sedang dalam proses perbaikan.']);
        }

        $requestPerbaikanBarang->update([
            'barang_id' => $request->barang_id,
            'tanggal_request' => $request->tanggal_request,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
        ]);

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
