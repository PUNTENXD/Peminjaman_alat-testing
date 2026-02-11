@extends('layouts.admin')

@section('content')
<h1>Data Pengembalian</h1>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>No</th>
        <th>Peminjam</th>
        <th>Alat</th>
        <th>Jumlah</th>
        <th>Tgl Pinjam</th>
        <th>Rencana Kembali</th>
        <th>Tgl Kembali</th>
    </tr>

    @forelse($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->user->username ?? '-' }}</td>
        <td>{{ $item->alat->nama_alat ?? '-' }}</td>
        <td>{{ $item->jumlah }}</td>
        <td>{{ $item->tgl_pinjam }}</td>
        <td>{{ $item->tgl_rencana_kembali }}</td>
        <td>{{ $item->updated_at }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="7">Belum ada data pengembalian</td>
    </tr>
    @endforelse
</table>

@endsection
