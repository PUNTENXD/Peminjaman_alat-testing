<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (ADMIN & PETUGAS)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = Peminjaman::with(['user','alat'])
            ->orderBy('id_peminjaman','desc')
            ->get();

        return view('peminjaman.index', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $peminjaman = Peminjaman::with(['user','alat'])
            ->where('id_peminjaman', $id)
            ->firstOrFail();

        if ($peminjaman->status !== 'pending') {
            abort(403, 'Hanya data pending yang bisa diedit');
        }

        $alat = Alat::all();

        return view('peminjaman.edit', compact('peminjaman','alat'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
{
    $peminjaman = Peminjaman::where('id_peminjaman', $id)
        ->firstOrFail();

    if ($peminjaman->status !== 'pending') {
        abort(403, 'Data tidak bisa diedit');
    }

    $request->validate([
        'id_alat' => 'required|exists:alat,id_alat',
        'jumlah' => 'required|integer|min:1',
        'tgl_pinjam' => 'required|date',
        'tgl_rencana_kembali' => 'required|date|after_or_equal:tgl_pinjam'
    ]);

    DB::transaction(function () use ($request, $peminjaman) {

        $alatBaru = Alat::findOrFail($request->id_alat);

        // 🔥 CEK STOK
        if ($request->jumlah > $alatBaru->stok) {
            abort(400, 'Jumlah melebihi stok tersedia');
        }

        $peminjaman->update([
            'id_alat' => $request->id_alat,
            'jumlah' => $request->jumlah,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_rencana_kembali' => $request->tgl_rencana_kembali
        ]);

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aktivitas' => 'Edit data peminjaman',
            'target_tabel' => 'peminjaman',
            'id_target' => $peminjaman->id_peminjaman
        ]);
    });

    return redirect()->route('peminjaman.index')
        ->with('success','Data berhasil diperbarui');
}


    /*
    |--------------------------------------------------------------------------
    | ACC
    |--------------------------------------------------------------------------
    */
    public function acc($id)
    {
        DB::transaction(function () use ($id) {

            $p = Peminjaman::where('id_peminjaman', $id)->firstOrFail();

            if ($p->status !== 'pending') {
                abort(403);
            }

            $alat = Alat::findOrFail($p->id_alat);

            if ($alat->stok < $p->jumlah) {
                abort(400, 'Stok tidak cukup');
            }

            $alat->stok -= $p->jumlah;
            $alat->save();

            $p->status = 'pinjam';
            $p->save();
        });

        return back()->with('success','Peminjaman disetujui');
    }

    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN
    |--------------------------------------------------------------------------
    */
    public function kembali($id)
{
    DB::transaction(function () use ($id) {

        $p = Peminjaman::findOrFail($id);

        if ($p->status !== 'pinjam') {
            abort(403);
        }

        $alat = Alat::findOrFail($p->id_alat);

        // Kembalikan stok
        $alat->stok += $p->jumlah;
        $alat->save();

        // Update status + tanggal kembali
        $p->status = 'kembali';
        $p->tgl_kembali = now(); // 🔥 INI YANG PENTING
        $p->save();

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aktivitas' => 'Pengembalian alat',
            'target_tabel' => 'peminjaman',
            'id_target' => $p->id_peminjaman,
            'create_at' => now()
        ]);
    });

    return back()->with('success','Alat berhasil dikembalikan');
}

}
