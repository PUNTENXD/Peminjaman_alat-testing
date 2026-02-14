<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // tampilkan semua kategori
public function index()
{
    $kategori = \App\Models\Kategori::orderBy('id_kategori','desc')->get();
    return view('kategori.index', compact('kategori'));
}


    // simpan kategori baru
    public function store(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required'
    ]);

    \App\Models\Kategori::create([
        'nama_kategori' => $request->nama_kategori
    ]);

    return redirect()->back()->with('success','Kategori berhasil ditambahkan');

}


// form edit
public function edit($id)
{
    $kategori = Kategori::findOrFail($id);
    return view('kategori.edit', compact('kategori'));
}

// update kategori
public function update(Request $request, $id)
{
    $request->validate([
        'nama_kategori' => 'required'
    ]);

    $kategori = Kategori::findOrFail($id);
    $kategori->update([
        'nama_kategori' => $request->nama_kategori
    ]);

    return redirect()->route('admin.kategori.index')
        ->with('success', 'Kategori berhasil diupdate');
}

// hapus kategori
public function destroy($id)
{
    try {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data alat');
    }
}


}
