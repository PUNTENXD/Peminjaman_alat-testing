<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
{
    $data = LogAktivitas::with('user')
        ->orderBy('create_at','desc')
        ->get();

    return view('log.index', compact('data'));
}

}
