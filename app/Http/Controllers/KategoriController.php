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

}
