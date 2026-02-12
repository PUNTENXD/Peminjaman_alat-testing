<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KembaliController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user','alat'])
            ->where('status','kembali')
            ->orderBy('tgl_kembali','desc');

        if ($request->filter === 'terlambat') {
            $query->whereColumn('tgl_kembali','>','tgl_rencana_kembali');
        }

        $data = $query->get();

        return view('kembali.index', compact('data'));
    }
}
