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
        'jumlah' => 'required|integer|min:1',
        'tgl_rencana_kembali' => 'required|date|after_or_equal:today',
    ]);

    $alat = Alat::findOrFail($request->id_alat);

    if ($alat->stok < $request->jumlah) {
        return back()->with('error', 'Stok tidak mencukupi!');
    }

    DB::beginTransaction();

    try {

        // Buat peminjaman dengan status pending
        Peminjaman::create([
            'id_user' => auth()->id(),
            'id_alat' => $request->id_alat,
            'jumlah' => $request->jumlah,
            'tgl_pinjam' => now(),
            'tgl_rencana_kembali' => $request->tgl_rencana_kembali,
            'status' => 'pending',
        ]);

        DB::commit();

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
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
        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

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
