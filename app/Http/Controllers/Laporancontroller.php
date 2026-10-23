<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pengembalian;

class LaporanController extends Controller
{
    // Halaman laporan di layar (ada filter)
    public function index(Request $request)
    {
        return view('petugas.laporan.index', $this->susun($request));
    }

    // Halaman cetak (tanpa navbar, langsung membuka dialog print)
    public function cetak(Request $request)
    {
        return view('petugas.laporan.cetak', $this->susun($request));
    }

    private function susun(Request $request): array
    {
        $request->validate([
            'jenis'  => 'nullable|in:peminjaman,pengembalian',
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
            'status' => 'nullable|in:pending,approved,rejected,completed',
        ]);

        $jenis  = $request->query('jenis') ?: 'peminjaman';
        $dari   = $request->query('dari') ?: now()->startOfMonth()->toDateString();
        $sampai = $request->query('sampai') ?: now()->toDateString();
        $status = $request->query('status');

        if ($jenis === 'pengembalian') {
            $status = null;

            $data = Pengembalian::with(['booking.user', 'booking.detail.alat'])
                ->whereBetween('tanggal_kembali', [$dari, $sampai])
                ->orderBy('tanggal_kembali')
                ->orderBy('id')
                ->get();

            $ringkasan = [
                ['Total pengembalian', $data->count()],
                ['Tepat waktu', $data->where('status', 'tepat waktu')->count()],
                ['Terlambat', $data->where('status', 'terlambat')->count()],
                ['Total denda', 'Rp ' . number_format($data->sum('denda'), 0, ',', '.')],
            ];
        } else {
            $data = Booking::with(['user', 'detail.alat', 'pengembalian'])
                ->whereBetween('tanggal_mulai', [$dari, $sampai])
                ->when($status, fn ($q, $s) => $q->where('status', $s))
                ->orderBy('tanggal_mulai')
                ->orderBy('id')
                ->get();

            $ringkasan = [
                ['Total pengajuan', $data->count()],
                ['Disetujui / selesai', $data->whereIn('status', ['approved', 'completed'])->count()],
                ['Ditolak', $data->where('status', 'rejected')->count()],
                ['Menunggu', $data->where('status', 'pending')->count()],
                ['Total unit alat (disetujui)', $data->whereIn('status', ['approved', 'completed'])
                    ->sum(fn ($b) => $b->detail->sum('jumlah'))],
            ];
        }

        return compact('jenis', 'dari', 'sampai', 'status', 'data', 'ringkasan');
    }
}