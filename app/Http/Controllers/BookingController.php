<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Alat;

class BookingController extends Controller
{
    // Riwayat peminjaman user
    public function index()
    {
        $penyewaan = Booking::with(['detail.alat.kategori', 'pengembalian'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('booking.index', compact('penyewaan'));
    }

    // Form peminjaman satu alat (dari detail alat)
    public function create($id)
    {
        $alat = Alat::with('kategori')
            ->where('jumlah', '>', 0)
            ->findOrFail($id);

        return view('booking.create', compact('alat'));
    }

    // Simpan pengajuan: 1 booking + 1 baris detail
    public function store(Request $request)
    {
        $request->validate([
            'alat_id'         => 'required|exists:alat,id',
            'jumlah'          => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->jumlah < $request->jumlah) {
            return back()
                ->withInput()
                ->with('error', 'Stok ' . $alat->nama_alat . ' hanya tersisa ' . $alat->jumlah . ' unit.');
        }

        DB::transaction(function () use ($request, $alat) {
            $booking = Booking::create([
                'user_id'         => auth()->id(),
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status'          => 'pending',
            ]);

            $booking->detail()->create([
                'alat_id' => $alat->id,
                'jumlah'  => $request->jumlah,
            ]);
        });

        return redirect()
            ->route('booking.index')
            ->with('success', 'Pengajuan peminjaman alat berhasil dikirim.');
    }
}