<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    // Data semua alat yang sudah dikembalikan (khusus admin)
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
                    $w->whereHas('booking.user', fn ($u) => $u->where('name', 'like', "%{$q}%"))
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

        return view('admin.pengembalian.index', compact('pengembalian', 'ringkasan', 'filter', 'q'));
    }
}