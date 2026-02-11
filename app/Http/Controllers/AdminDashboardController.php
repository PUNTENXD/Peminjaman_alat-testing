<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\LogAktivitas;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [

            // Statistik utama
            'totalUser'     => User::count(),
            'totalAlat'     => Alat::count(),
            'totalKategori' => \App\Models\Kategori::count(),

            // Status peminjaman
            'pending'  => Peminjaman::where('status','pending')->count(),
            'dipinjam' => Peminjaman::where('status','pinjam')->count(),
            'kembali'  => Peminjaman::where('status','kembali')->count(),

            // 5 peminjaman terbaru
            'latestPeminjaman' => Peminjaman::with(['user','alat'])
                ->orderBy('id_peminjaman','desc')
                ->limit(5)
                ->get(),

            // 5 log terbaru (ingat tabel kamu namanya log)
            'logs' => LogAktivitas::orderBy('id_log','desc')
                ->limit(5)
                ->get(),
        ]);
    }
}
