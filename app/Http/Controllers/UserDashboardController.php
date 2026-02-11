<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

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
            'id_alat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tgl_rencana_kembali' => 'required|date'
        ]);

        $alat = Alat::findOrFail($request->id_alat);

        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        Peminjaman::create([
            'id_user' => Auth::id(),
            'id_alat' => $request->id_alat,
            'jumlah' => $request->jumlah,
            'tgl_pinjam' => now(),
            'tgl_rencana_kembali' => $request->tgl_rencana_kembali,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil!');
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        if ($peminjaman->status != 'pinjam') {
            return back()->with('error', 'Tidak bisa mengembalikan!');
        }

        $alat = Alat::find($peminjaman->id_alat);
        $alat->stok += $peminjaman->jumlah;
        $alat->save();

        $peminjaman->update([
            'tgl_kembali' => now(),
            'status' => 'kembali'
        ]);

        return back()->with('success', 'Alat berhasil dikembalikan!');
    }
}
