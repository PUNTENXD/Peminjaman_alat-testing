@extends('Layouts.admin')

@section('content')
<h1>Data Alat</h1>

@if(session('success'))
<div style="color:green;margin-bottom:10px;">
    {{ session('success') }}
</div>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="text-align:center;">
    <tr>
        <th>No</th>
        <th>Nama Alat</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Kondisi</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_alat }}</td>
        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
        <td>{{ $item->stok }}</td>
        <td>{{ $item->kondisi }}</td>
        <td>
            <a href="{{ route('alat.edit',$item->id_alat) }}"
               style="color:#2563eb;font-weight:bold;">
                Edit
            </a>

            <form action="{{ route('alat.destroy',$item->id_alat) }}"
                  method="POST"
                  style="display:inline;margin-left:20px;">
                @csrf
                <button onclick="return confirm('Hapus alat ini?')"
                    style="background:#dc2626;color:white;border:none;padding:5px 10px;border-radius:4px;cursor:pointer;">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<br>
<a href="{{ route('alat.create') }}"
   style="display:inline-block;margin-top:15px;padding:8px 15px;
          background:#2563eb;color:white;text-decoration:none;
          border-radius:5px;">
    + Tambah Alat
</a>

@endsection
