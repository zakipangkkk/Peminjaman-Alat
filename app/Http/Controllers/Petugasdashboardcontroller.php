<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Booking;
use App\Models\Pengembalian;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $hariIni = today();

        $statistik = [
            // pengajuan yang menunggu keputusan petugas
            'menunggu'  => Booking::where('status', 'pending')->count(),
            // alat yang sedang dipinjam
            'dipinjam'  => Booking::where('status', 'approved')->count(),
            // sedang dipinjam tapi sudah lewat tanggal selesai
            'lewat'     => Booking::where('status', 'approved')->whereDate('tanggal_selesai', '<', $hariIni)->count(),
            // pengembalian yang dicatat bulan ini
            'kembali'   => Pengembalian::whereBetween('tanggal_kembali', [
                                now()->startOfMonth()->toDateString(),
                                now()->endOfMonth()->toDateString(),
                           ])->count(),
        ];

        // 5 pengajuan tertua yang belum diproses
        $perluDiverifikasi = Booking::with(['user', 'detail.alat'])
            ->where('status', 'pending')
            ->orderBy('created_at')
            ->limit(5)
            ->get();

        // 5 peminjaman paling lama lewat tempo
        $lewatTempo = Booking::with(['user', 'detail.alat'])
            ->where('status', 'approved')
            ->whereDate('tanggal_selesai', '<', $hariIni)
            ->orderBy('tanggal_selesai')
            ->limit(5)
            ->get();

        // alat dengan stok hampir habis
        $stokMenipis = Alat::where('jumlah', '<=', 2)
            ->orderBy('jumlah')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'statistik', 'perluDiverifikasi', 'lewatTempo', 'stokMenipis'
        ));
    }
}