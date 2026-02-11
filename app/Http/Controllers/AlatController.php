<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

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
            'nama_alat' => 'required|max:100',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|max:50'
        ]);

        Alat::create($request->all());

        return redirect()->route('alat.index')
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

        return redirect()->route('alat.index')
            ->with('success','Data alat berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success','Data alat berhasil dihapus');
    }
}
