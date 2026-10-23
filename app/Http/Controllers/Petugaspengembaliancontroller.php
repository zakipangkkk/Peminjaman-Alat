<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pengembalian;

class PetugasPengembalianController extends Controller
{
    // Pemantauan pengembalian (khusus petugas)
    public function index(Request $request)
    {
        $filter = $request->query('status', 'semua');   // semua | tepat_waktu | terlambat
        $q = trim((string) $request->query('q', ''));

        $statusDb = [
            'tepat_waktu' => 'tepat waktu',
            'terlambat'   => 'terlambat',
        ];

        $pengembalian = Pengembalian::with(['booking.user', 'booking.detail.alat'])
            ->when(isset($statusDb[$filter]), fn ($query) => $query->where('status', $statusDb[$filter]))
            ->when($q !== '', function ($query) use ($q) {
                // dibungkus satu grup supaya OR tidak merusak filter status
                $query->where(function ($w) use ($q) {
                    $w->whereHas('booking.user', fn ($u) => $u->where('username', 'like', "%{$q}%"))
                      ->orWhereHas('booking.detail.alat', fn ($a) => $a->where('nama_alat', 'like', "%{$q}%"));
                });
            })
            ->orderBy('tanggal_kembali', 'desc')
            ->orderBy('id', 'desc')
            ->simplePaginate(15)
            ->withQueryString();

        $ringkasan = [
            'total'       => Pengembalian::count(),
            'tepat_waktu' => Pengembalian::where('status', 'tepat waktu')->count(),
            'terlambat'   => Pengembalian::where('status', 'terlambat')->count(),
            'denda'       => Pengembalian::sum('denda'),
        ];

        // Peminjaman yang sudah disetujui tapi alatnya belum kembali
        $belumKembali = Booking::with(['user', 'detail.alat'])
            ->where('status', 'approved')
            ->orderBy('tanggal_selesai')
            ->get();

        $ringkasan['belum_kembali'] = $belumKembali->count();
        $ringkasan['jatuh_tempo']   = $belumKembali->filter(fn ($b) => $b->tanggal_selesai->lt(today()))->count();

        return view('petugas.pengembalian.index', compact('pengembalian', 'ringkasan', 'filter', 'q', 'belumKembali'));
    }
}