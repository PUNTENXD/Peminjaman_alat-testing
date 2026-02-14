<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AlatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = Alat::with('kategori')
            ->orderBy('id_alat','desc')
            ->get();

        return view('alat.index', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $kategori = Kategori::all();
        return view('alat.create', compact('kategori'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
{
    $request->validate([
        'id_kategori' => 'required',
        'nama_alat'   => 'required|max:100',
        'stok'        => 'required|integer',
        'kondisi'     => 'required|max:50'
    ]);

    // NORMALISASI STOK
    $stok = (int) $request->stok;

    if ($stok <= 1) {
        $stok = 1;
    }

    Alat::create([
        'id_kategori' => $request->id_kategori,
        'nama_alat'   => $request->nama_alat,
        'stok'        => $stok,
        'kondisi'     => $request->kondisi,
    ]);

    return redirect()->route('admin.alat.index')
        ->with('success','Data alat berhasil ditambahkan');
}


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategori = Kategori::all();

        return view('alat.edit', compact('alat','kategori'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required',
            'nama_alat' => 'required|max:100',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|max:50'
        ]);

        $alat->update($request->all());

        return redirect()->route('admin.alat.index')
            ->with('success','Data alat berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
{
    $dipakai = DB::table('peminjaman')
                ->where('id_alat', $id)
                ->exists();

    if ($dipakai) {
        return redirect()->back()
            ->with('error', 'Alat tidak bisa dihapus karena masih memiliki data peminjaman.');
    }

    DB::table('alat')->where('id_alat', $id)->delete();

    return redirect()->back()
        ->with('success', 'Alat berhasil dihapus.');
}
}
