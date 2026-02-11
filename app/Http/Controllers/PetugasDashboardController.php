<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;


class PetugasDashboardController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with(['user','alat'])
            ->where('status', 'pinjam')
            ->orderBy('id_peminjaman','desc')
            ->get();

        return view('dashboard.petugas', compact('data'));
    }

    public function peminjaman()
    {
        $data = Peminjaman::with(['user','alat'])
            ->whereIn('status', ['pending','pinjam'])
            ->orderBy('id_peminjaman','desc')
            ->get();

        return view('petugas.peminjaman', compact('data'));
    }

    public function pengembalian()
{
    $data = Peminjaman::with(['user','alat'])
        ->where('status', 'kembali')
        ->orderBy('id_peminjaman','desc')
        ->get();

    return view('petugas.pengembalian', compact('data'));
}




}
