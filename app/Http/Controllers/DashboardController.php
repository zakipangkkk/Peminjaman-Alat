<?php
namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Total stok alat yang tersedia
        $alatTersedia = Alat::sum('jumlah');

        // Total jenis alat
        $totalAlat = Alat::count();

        // Total pengguna
        $totalUser = User::count();

        // Total peminjaman yang sedang berlangsung
        $alatDipinjam = Booking::where('status', 'dipinjam')->count();

        // Lima peminjaman terbaru beserta pengguna dan detail alat
        $peminjamanTerbaru = Booking::with([
            'user',
            'detail.alat'
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'alatTersedia',
            'alatDipinjam',
            'totalAlat',
            'totalUser',
            'peminjamanTerbaru'
        ));
    }
}