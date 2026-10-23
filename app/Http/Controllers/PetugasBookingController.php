<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Alat;
use App\Models\Pengembalian;

class PetugasBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $bookings = Booking::with(['user', 'detail.alat.kategori', 'pengembalian'])
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->orderByRaw("status = 'pending' desc")
            ->orderBy('id', 'desc')
            ->simplePaginate(15)
            ->withQueryString();

        $jumlah = [
            'semua'     => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'approved'  => Booking::where('status', 'approved')->count(),
            'rejected'  => Booking::where('status', 'rejected')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];

        return view('petugas.booking.index', compact('bookings', 'jumlah', 'status'));
    }

    // Setujui: stok SEMUA alat di pengajuan ini berkurang sesuai jumlahnya
    public function setujui($id)
    {
        $error = DB::transaction(function () use ($id) {
            $booking = Booking::with('detail')->lockForUpdate()->findOrFail($id);

            if ($booking->status !== 'pending') {
                return 'Pengajuan ini sudah diproses sebelumnya.';
            }

            // Kunci & cek stok semua alat dulu, baru kurangi
            $alats = Alat::whereIn('id', $booking->detail->pluck('alat_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($booking->detail as $d) {
                $alat = $alats[$d->alat_id] ?? null;

                if (!$alat || $alat->jumlah < $d->jumlah) {
                    return 'Stok ' . ($alat->nama_alat ?? 'alat') . ' tidak cukup (butuh ' . $d->jumlah
                        . ', tersisa ' . ($alat->jumlah ?? 0) . '). Pengajuan tidak bisa disetujui.';
                }
            }

            foreach ($booking->detail as $d) {
                $alats[$d->alat_id]->decrement('jumlah', $d->jumlah);
            }

            $booking->update(['status' => 'approved', 'catatan' => null]);

            return null;
        });

        return $error
            ? back()->with('error', $error)
            : back()->with('success', 'Pengajuan disetujui.');
    }

    // Tolak: stok tidak berubah, alasan disimpan di kolom catatan
    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan' => 'nullable|string|max:255']);

        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $booking->update([
            'status'  => 'rejected',
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }

    // Alat dikembalikan: catat di tabel pengembalian, stok bertambah, status completed
    public function kembali(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'denda'           => 'nullable|numeric|min:0',
            'keterangan'      => 'nullable|string|max:255',
        ]);

        $error = DB::transaction(function () use ($request, $id) {
            $booking = Booking::with('detail')->lockForUpdate()->findOrFail($id);

            if ($booking->status !== 'approved') {
                return 'Hanya peminjaman yang disetujui yang bisa ditandai dikembalikan.';
            }

            foreach ($booking->detail as $d) {
                Alat::where('id', $d->alat_id)->increment('jumlah', $d->jumlah);
            }

            $terlambat = $request->tanggal_kembali > $booking->tanggal_selesai->format('Y-m-d');

            Pengembalian::create([
                'booking_id'      => $booking->id,
                'tanggal_kembali' => $request->tanggal_kembali,
                'denda'           => $request->denda ?? 0,
                'keterangan'      => $request->keterangan ?: '-',
                'status'          => $terlambat ? 'terlambat' : 'tepat waktu',
            ]);

            $booking->update(['status' => 'completed']);

            return null;
        });

        return $error
            ? back()->with('error', $error)
            : back()->with('success', 'Pengembalian dicatat dan stok dipulihkan.');
    }
}