<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




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

    $totalDenda = $data->sum(function($item){
        return $item->denda;
    });

    return view('petugas.peminjaman', compact('data','totalDenda'));
}


    public function pengembalian()
{
    $data = Peminjaman::with(['user','alat'])
        ->where('status', 'kembali')
        ->orderBy('id_peminjaman','desc')
        ->get();

    return view('petugas.pengembalian', compact('data'));
}




public function laporan()
{
    $data = Peminjaman::with(['user','alat'])
        ->where('status','kembali')
        ->orderBy('id_peminjaman','desc')
        ->get();

    $totalDenda = $data->sum(function($item){
        return $item->denda;
    });

    return view('petugas.laporan', compact('data','totalDenda'));
}




public function acc($id)
{
    DB::beginTransaction();

    try {

      $peminjaman = Peminjaman::with('alat')
    ->lockForUpdate()
    ->where('id_peminjaman', $id)
    ->where('status', 'pending')
    ->firstOrFail();


        if ($peminjaman->alat->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // // Kurangi stok
         $peminjaman->alat->decrement('stok', $peminjaman->jumlah);

        // Ubah status
        $peminjaman->update([
            'status' => 'pinjam'
        ]);

        DB::commit();

        return back()->with('success', 'Peminjaman disetujui.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan.');
    }
}


public function kembalikan($id)
{
    DB::beginTransaction();

    try {

       $peminjaman = Peminjaman::with('alat')
    ->where('id_peminjaman', $id)
    ->first();

    if (!$peminjaman) {
    return back()->with('error','Data tidak ditemukan');
}

if ($peminjaman->status !== 'pending') {
    return back()->with('error','Status bukan pending');
}



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






}
