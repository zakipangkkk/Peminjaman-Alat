<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
        public function index()
    {
        $kategori = Kategori::latest()->get();

        return view('admin.kategori.index', compact('kategori'));
    }
        public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:155',
        ]);

        User::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'data berhasil ditambahkan.');
    }
    public function edit($id)
{
    $kategori = Kategori::findOrFail($id);

    return view('admin.kategori.edit', compact('kategori'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:user,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
        'no_telfon' => 'required|string|max:20',
        'role' => 'required|in:user,admin,petugas',
    ]);

    $user->username = $request->username;
    $user->email = $request->email;
    $user->no_telfon = $request->no_telfon;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()
        ->route('admin.user.index')
        ->with('success', 'Data user berhasil diperbarui.');
}
public function destroy($id)
{
    $user = User::findOrFail($id);

    $user->delete();

    return redirect()
        ->route('admin.user.index')
        ->with('success', 'User berhasil dihapus.');
}
}
