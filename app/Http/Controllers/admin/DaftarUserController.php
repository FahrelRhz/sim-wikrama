<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class DaftarUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'jurusan']);
            return DataTables::of($users)
                ->addIndexColumn()
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
        return view('pages.admin.daftar-user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
           'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'jurusan' => 'required|string|max:255',
        ]);

        $user = User::create($request->only('name', 'email', 'jurusan', 'password'));

        return redirect()->route('admin.daftar-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); 
        return view('pages.admin.daftar-user.edit', compact('user')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id); 
        $user->update($request->only('name', 'email', 'jurusan'));

        return redirect()->route('admin.daftar-user.index')->with('success', 'Pengguna berhasil diperbarui.'); // Mengarahkan kembali ke daftar pengguna dengan pesan sukses
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); 
        $user->delete(); 

        return response()->json(['success' => 'Pengguna berhasil dihapus.']); // Mengembalikan respons JSON
    }
}
