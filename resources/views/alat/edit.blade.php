@extends('layouts.admin')

@section('content')

<div style="max-width:700px;margin:auto;">

    <div style="background:white;padding:30px;border-radius:10px;
                box-shadow:0 5px 15px rgba(0,0,0,0.08);">

        <h2 style="margin-bottom:25px;">Edit Data Alat</h2>

        <form action="{{ route('alat.update',$alat->id_alat) }}" method="POST">
            @csrf

            {{-- Kategori --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;">Kategori</label>
                <select name="id_kategori" required
                    style="width:100%;padding:10px;margin-top:5px;
                           border:1px solid #ddd;border-radius:6px;">
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}"
                            {{ $alat->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Alat --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;">Nama Alat</label>
                <input type="text" name="nama_alat"
                       value="{{ $alat->nama_alat }}" required
                       style="width:100%;padding:10px;margin-top:5px;
                              border:1px solid #ddd;border-radius:6px;">
            </div>

            {{-- Stok --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;">Stok</label>
                <input type="number" name="stok"
                       value="{{ $alat->stok }}" required
                       style="width:100%;padding:10px;margin-top:5px;
                              border:1px solid #ddd;border-radius:6px;">
            </div>

            {{-- Kondisi --}}
            <div style="margin-bottom:25px;">
                <label style="font-weight:600;">Kondisi</label>
                <input type="text" name="kondisi"
                       value="{{ $alat->kondisi }}" required
                       style="width:100%;padding:10px;margin-top:5px;
                              border:1px solid #ddd;border-radius:6px;">
            </div>

            {{-- Button --}}
            <div style="display:flex;justify-content:space-between;">

                <a href="{{ route('alat.index') }}"
                   style="text-decoration:none;padding:10px 18px;
                          background:#6b7280;color:white;
                          border-radius:6px;">
                    ← Kembali
                </a>

                <button type="submit"
                    style="background:#2563eb;color:white;border:none;
                           padding:10px 20px;border-radius:6px;
                           cursor:pointer;font-weight:600;">
                    Update Data
                </button>

            </div>

        </form>
    </div>

</div>

@endsection
