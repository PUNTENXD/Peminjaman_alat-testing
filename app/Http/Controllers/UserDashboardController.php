<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class UserDashboardController extends Controller
{
    public function index()
    {
        $alat = Alat::with('kategori')->get();

        $peminjaman = Peminjaman::with('alat')
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.user', compact('alat', 'peminjaman'));
    }


public function pinjam(Request $request)
{
    $request->validate([
        'id_alat' => 'required|exists:alat,id_alat',
        'jumlah'  => 'required|integer|min:1',
    ]);

    $alat = Alat::findOrFail($request->id_alat);

    if ($request->jumlah > $alat->stok) {
        return back()->with('error', 'Jumlah melebihi stok tersedia')->withInput();
    }

    DB::beginTransaction();
    try {
        // Buat peminjaman
        Peminjaman::create([
            'id_user' => auth()->user()->id_user,
            'id_alat' => $alat->id_alat,
            'jumlah'  => $request->jumlah,
            'status'  => 'pending',
            'tgl_pinjam' => now(),
            'tgl_rencana_kembali' => now()->addDays(7), // contoh default 7 hari
        ]);


        DB::commit();
        return back()->with('success','Berhasil meminjam alat!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error','Terjadi kesalahan, coba lagi.');
    }
}



    public function kembali($id)
{
    DB::beginTransaction();

    try {

        $peminjaman = Peminjaman::with('alat')
            ->where('id_peminjaman', $id)
            ->where('status', 'pinjam')
            ->firstOrFail();

        // Tambah stok kembali
        //$peminjaman->alat->increment('stok', $peminjaman->jumlah);

        // Update status + tanggal kembali
        $peminjaman->update([
            'status' => 'kembali',
            'tgl_kembali' => now(),
        ]);

        DB::commit();

        return back()->with('success', 'Alat berhasil dikembalikan.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan.');
    }
}



    public function batal($id)
{
    $peminjaman = Peminjaman::where('id_peminjaman', $id)
        ->where('id_user', Auth::id())
        ->where('status', 'pending')
        ->firstOrFail();

    $peminjaman->delete();

    return back()->with('success', 'Peminjaman berhasil dibatalkan.');
}

}
