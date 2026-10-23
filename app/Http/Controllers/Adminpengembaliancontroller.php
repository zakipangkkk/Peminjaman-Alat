<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alat;
use App\Models\Booking;
use App\Models\Pengembalian;

// CRUD data pengembalian untuk ADMIN.
class AdminPengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with(['booking.user', 'booking.detail.alat'])
            ->orderBy('tanggal_kembali', 'desc')
            ->orderBy('id', 'desc')
            ->simplePaginate(15);

        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        // Hanya peminjaman yang sudah disetujui petugas dan belum dikembalikan
        $bookings = Booking::with(['user', 'detail.alat'])
            ->where('status', 'approved')
            ->doesntHave('pengembalian')
            ->orderBy('tanggal_selesai')
            ->get();

        return view('admin.pengembalian.create', compact('bookings'));
    }

    // Sama seperti pencatatan oleh petugas: stok pulih, status booking jadi completed
    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id'      => 'required|exists:booking,id',
            'tanggal_kembali' => 'required|date',
            'denda'           => 'nullable|numeric|min:0',
            'keterangan'      => 'nullable|string|max:255',
        ]);

        $error = DB::transaction(function () use ($data) {
            $booking = Booking::with('detail')->lockForUpdate()->findOrFail($data['booking_id']);

            if ($booking->status !== 'approved' || $booking->pengembalian()->exists()) {
                return 'Peminjaman ini tidak bisa dicatat pengembaliannya (belum disetujui atau sudah dikembalikan).';
            }

            foreach ($booking->detail as $d) {
                Alat::where('id', $d->alat_id)->increment('jumlah', $d->jumlah);
            }

            Pengembalian::create([
                'booking_id'      => $booking->id,
                'tanggal_kembali' => $data['tanggal_kembali'],
                'denda'           => $data['denda'] ?? 0,
                'keterangan'      => $data['keterangan'] ?: '-',
                'status'          => $this->statusKembali($data['tanggal_kembali'], $booking),
            ]);

            $booking->update(['status' => 'completed']);

            return null;
        });

        if ($error) {
            return back()->withInput()->with('error', $error);
        }

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian ditambahkan.');
    }

    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load(['booking.user', 'booking.detail.alat']);

        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    // Yang bisa diubah: tanggal kembali, denda, keterangan (status dihitung ulang)
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $data = $request->validate([
            'tanggal_kembali' => 'required|date',
            'denda'           => 'nullable|numeric|min:0',
            'keterangan'      => 'nullable|string|max:255',
        ]);

        $pengembalian->update([
            'tanggal_kembali' => $data['tanggal_kembali'],
            'denda'           => $data['denda'] ?? 0,
            'keterangan'      => $data['keterangan'] ?: '-',
            'status'          => $this->statusKembali($data['tanggal_kembali'], $pengembalian->booking),
        ]);

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian diperbarui.');
    }

    // Hapus pengembalian = alat dianggap belum kembali: booking jadi approved lagi, stok dikurangi lagi
    public function destroy(Pengembalian $pengembalian)
    {
        $error = DB::transaction(function () use ($pengembalian) {
            $booking = Booking::with('detail.alat')->lockForUpdate()->find($pengembalian->booking_id);

            if ($booking) {
                foreach ($booking->detail as $d) {
                    if (!$d->alat || $d->alat->jumlah < $d->jumlah) {
                        return 'Stok ' . optional($d->alat)->nama_alat . ' tidak cukup untuk membatalkan pengembalian ini.';
                    }
                }

                foreach ($booking->detail as $d) {
                    $d->alat->decrement('jumlah', $d->jumlah);
                }

                if ($booking->status === 'completed') {
                    $booking->update(['status' => 'approved']);
                }
            }

            $pengembalian->delete();

            return null;
        });

        return $error
            ? back()->with('error', $error)
            : back()->with('success', 'Data pengembalian dihapus. Peminjaman kembali berstatus disetujui.');
    }

    private function statusKembali(string $tanggalKembali, Booking $booking): string
    {
        return $tanggalKembali > $booking->tanggal_selesai->format('Y-m-d') ? 'terlambat' : 'tepat waktu';
    }
}
