<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alat;
use App\Models\Booking;

class KeranjangController extends Controller
{
    // Session 'keranjang' berbentuk [alat_id => jumlah], contoh: [3 => 2, 7 => 1]

    public function index()
    {
        $cart = session('keranjang', []);

        $items = Alat::with('kategori')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->each(fn ($alat) => $alat->qty = $cart[$alat->id]);

        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $request, $id)
    {
        $jumlah = max(1, (int) $request->input('jumlah', 1));

        $alat = Alat::where('jumlah', '>', 0)->findOrFail($id);

        $cart = session('keranjang', []);
        $total = ($cart[$alat->id] ?? 0) + $jumlah;

        if ($total > $alat->jumlah) {
            return back()->with('error', 'Jumlah ' . $alat->nama_alat . ' melebihi stok (' . $alat->jumlah . ' unit).');
        }

        $cart[$alat->id] = $total;
        session(['keranjang' => $cart]);

        return back()->with('success', $alat->nama_alat . ' ditambahkan ke keranjang.');
    }

    public function ubah(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $alat = Alat::findOrFail($id);

        if ($request->jumlah > $alat->jumlah) {
            return back()->with('error', 'Stok ' . $alat->nama_alat . ' hanya ' . $alat->jumlah . ' unit.');
        }

        $cart = session('keranjang', []);

        if (isset($cart[$alat->id])) {
            $cart[$alat->id] = (int) $request->jumlah;
            session(['keranjang' => $cart]);
        }

        return back()->with('success', 'Jumlah diperbarui.');
    }

    public function hapus($id)
    {
        $cart = session('keranjang', []);
        unset($cart[(int) $id]);
        session(['keranjang' => $cart]);

        return back()->with('success', 'Alat dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $cart = session('keranjang', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $alats = Alat::whereIn('id', array_keys($cart))->get();

        // Cek stok semua alat sebelum disimpan
        $kurang = $alats->filter(fn ($a) => $a->jumlah < $cart[$a->id]);

        if ($kurang->isNotEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Stok tidak cukup: ' . $kurang->pluck('nama_alat')->implode(', '));
        }

        // Satu pengajuan, banyak baris detail
        DB::transaction(function () use ($request, $alats, $cart) {
            $booking = Booking::create([
                'user_id'         => auth()->id(),
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status'          => 'pending',
            ]);

            foreach ($alats as $alat) {
                $booking->detail()->create([
                    'alat_id' => $alat->id,
                    'jumlah'  => $cart[$alat->id],
                ]);
            }
        });

        session()->forget('keranjang');

        return redirect()
            ->route('booking.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}