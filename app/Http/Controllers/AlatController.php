<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // =========================
    // USER
    // =========================

    public function index(Request $request)
    {
        $kategori = Kategori::all();

        $alats = Alat::with('kategori')
            ->where('jumlah', '>', 0)
            ->when($request->kategori, function ($query, $kategori) {
                $query->whereHas('kategori', function ($q) use ($kategori) {
                    $q->where('nama_kategori', $kategori);
                });
            })
            ->get();

        return view('alat.index', compact('alats', 'kategori'));
    }


    // =========================
    // USER DETAIL
    // =========================

    public function detail($id)
    {
        $alat = Alat::with('kategori')->findOrFail($id);

        return view('alat.detail', compact('alat'));
    }


    // =========================
    // ADMIN
    // =========================

    public function adminIndex()
    {
        $alat = Alat::with('kategori')->get();

        return view('admin.alat.index', compact('alat'));
    }


    // =========================
    // FORM TAMBAH
    // =========================

    public function create()
    {
        $kategori = Kategori::all();

        return view('admin.alat.create', compact('kategori'));
    }


    // =========================
    // SIMPAN ALAT
    // =========================

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'jumlah' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('alat', 'public');
        }

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'jumlah' => $request->jumlah,
            'foto' => $foto,
        ]);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil ditambahkan.');
    }


    // =========================
    // FORM EDIT
    // =========================

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);

        $kategori = Kategori::all();

        return view('admin.alat.edit', compact('alat', 'kategori'));
    }


    // =========================
    // UPDATE ALAT
    // =========================

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'jumlah' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $alat->nama_alat = $request->nama_alat;
        $alat->kategori_id = $request->kategori_id;
        $alat->jumlah = $request->jumlah;

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if (
                $alat->foto &&
                file_exists(storage_path('app/public/' . $alat->foto))
            ) {
                unlink(storage_path('app/public/' . $alat->foto));
            }

            // Simpan foto baru
            $alat->foto = $request->file('foto')->store('alat', 'public');
        }

        $alat->save();

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil diperbarui.');
    }


    // =========================
    // HAPUS ALAT
    // =========================

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // Hapus foto jika ada
        if (
            $alat->foto &&
            file_exists(storage_path('app/public/' . $alat->foto))
        ) {
            unlink(storage_path('app/public/' . $alat->foto));
        }

        // Hapus data alat
        $alat->delete();

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil dihapus.');
    }
}
