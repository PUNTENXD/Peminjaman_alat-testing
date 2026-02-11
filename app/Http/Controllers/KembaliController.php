<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KembaliController extends Controller
{

public function index()
{
    $data = \App\Models\Peminjaman::with(['user','alat'])
        ->where('status', 'kembali')
        ->orderBy('update_at','desc')
        ->get();

    return view('kembali.index', compact('data'));
}




    public function store($id_peminjaman)
    {
        DB::transaction(function () use ($id_peminjaman) {

            // 1️⃣ Ambil data peminjaman
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);

            // 2️⃣ Validasi status (UKK CLEAN)
            if ($peminjaman->status !== 'pinjam') {
                abort(403, 'Peminjaman tidak valid untuk dikembalikan');
            }

            // 3️⃣ Tambah stok alat
            $alat = Alat::findOrFail($peminjaman->id_alat);
            $alat->stok += $peminjaman->jumlah;
            $alat->save();

            // 4️⃣ Update status
            $peminjaman->status = 'kembali';
            $peminjaman->save();

            // 5️⃣ Log aktivitas
            LogAktivitas::create([
                'id_user' => Auth::id(),
                'aktivitas' => 'Mengembalikan alat',
                'target_tabel' => 'peminjaman',
                'id_target' => $peminjaman->id_peminjaman,
                'create_at' => now()
            ]);
        });

        return redirect()->back()->with('success', 'Pengembalian berhasil');
    }
}
