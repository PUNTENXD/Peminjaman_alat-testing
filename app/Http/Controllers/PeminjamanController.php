<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
{
    $query = Peminjaman::with(['user','alat'])
        ->whereIn('status', ['pending','pinjam'])
        ->orderBy('id_peminjaman','desc');

    if ($request->filter === 'terlambat') {
        $query->where('status','pinjam')
              ->whereDate('tgl_rencana_kembali','<', now());
    }

    $data = $query->get();

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
            abort(403);
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
    $request->validate([
        'jumlah' => 'required|integer|min:1'
    ]);

    $peminjaman = Peminjaman::findOrFail($id);

    $alatLama = Alat::findOrFail($peminjaman->id_alat);
    $alatBaru = Alat::findOrFail($request->id_alat);

    // Jika alat tidak diganti
    if ($alatLama->id_alat == $alatBaru->id_alat) {

        $stokTersedia = $alatLama->stok + $peminjaman->jumlah;

        if ($request->jumlah > $stokTersedia) {
            return back()->with('error','Jumlah melebihi stok tersedia')->withInput();
        }

        // Hitung selisih
        $selisih = $request->jumlah - $peminjaman->jumlah;

        $alatLama->stok -= $selisih;
        $alatLama->save();

    } else {

        // Kembalikan stok alat lama
        $alatLama->stok += $peminjaman->jumlah;
        $alatLama->save();

        if ($request->jumlah > $alatBaru->stok) {
            return back()->with('error','Stok alat baru tidak mencukupi')->withInput();
        }

        $alatBaru->stok -= $request->jumlah;
        $alatBaru->save();
    }

    $peminjaman->update([
        'id_alat' => $request->id_alat,
        'jumlah' => $request->jumlah,
        'tgl_pinjam' => $request->tgl_pinjam,
        'tgl_rencana_kembali' => $request->tgl_rencana_kembali
    ]);

    return redirect()->route('peminjaman.index')
        ->with('success','Data peminjaman berhasil diperbarui');
}



    /*
    |--------------------------------------------------------------------------
    | ACC
    |--------------------------------------------------------------------------
    */
    public function acc($id)
    {
        DB::transaction(function () use ($id) {

            $p = Peminjaman::findOrFail($id);

            if ($p->status !== 'pending') {
                abort(403);
            }

            $alat = Alat::findOrFail($p->id_alat);

            if ($alat->stok < $p->jumlah) {
                abort(400,'Stok tidak cukup');
            }

            $alat->stok -= $p->jumlah;
            $alat->save();

            $p->status = 'pinjam';
            $p->tgl_pinjam = now();
            $p->save();
        });

        return back()->with('success','Peminjaman disetujui');
    }

    /*
    |--------------------------------------------------------------------------
    | KEMBALI
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

        $alat->stok += $p->jumlah;
        $alat->save();

        $p->status = 'kembali';
        $p->tgl_kembali = now(); // simpan datetime asli
        $p->save();
    });

    return redirect()->route('kembali.index')
        ->with('success','Alat berhasil dikembalikan');
}

}
