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
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'id_alat' => 'required|exists:alat,id_alat',
            'jumlah' => 'required|integer|min:1',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali' => 'required|date|after:tgl_pinjam'
        ]);

        DB::transaction(function () use ($request, $peminjaman) {

            $alatLama = Alat::findOrFail($peminjaman->id_alat);
            $alatBaru = Alat::findOrFail($request->id_alat);

            $jumlahLama = $peminjaman->jumlah;
            $jumlahBaru = $request->jumlah;

            if ($alatLama->id_alat == $alatBaru->id_alat) {

                $selisih = $jumlahBaru - $jumlahLama;

                if ($selisih > 0 && $alatBaru->stok < $selisih) {
                    abort(400,'Stok tidak mencukupi');
                }

                $alatBaru->stok -= $selisih;
                $alatBaru->save();
            } else {

                $alatLama->stok += $jumlahLama;
                $alatLama->save();

                if ($alatBaru->stok < $jumlahBaru) {
                    abort(400,'Stok alat baru tidak mencukupi');
                }

                $alatBaru->stok -= $jumlahBaru;
                $alatBaru->save();
            }

            $peminjaman->update([
                'id_alat' => $request->id_alat,
                'jumlah' => $jumlahBaru,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_rencana_kembali' => $request->tgl_rencana_kembali
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
