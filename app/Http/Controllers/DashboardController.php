<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Alat tersedia
        $alatTersedia = Alat::where('jumlah', '>', 0)->count();

        // Total seluruh alat
        $totalAlat = Alat::count();

        // Total user
        $totalUser = User::count();

        return view('admin.index', compact(
            'alatTersedia',
            'totalAlat',
            'totalUser'
        ));
    }
}