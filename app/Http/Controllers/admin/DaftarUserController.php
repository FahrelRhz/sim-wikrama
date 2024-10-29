<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class DaftarUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('jurusan')->select(['id', 'name', 'email', 'jurusan_id']);
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('jurusan', function ($user) {
                    return $user->jurusan->nama_jurusan ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = '<a href="' . route('admin.daftar-user.edit', $row->id) . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm mb-1" data-id="' . $row->id . '" onclick="deleteUser(' . $row->id . ')">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.admin.daftar-user.index');
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('pages.admin.daftar-user.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('admin.daftar-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('pages.admin.daftar-user.edit', compact('user', 'jurusans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('admin.daftar-user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'Pengguna berhasil dihapus.']);
    }
}
