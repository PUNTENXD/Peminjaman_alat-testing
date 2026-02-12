@extends('Layouts.admin')

@section('content')

<h1>Data Pengembalian</h1>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table-peminjaman" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Rencana</th>
            <th>Kembali</th>
            <th>Keterangan</th>
        </tr>
    </thead>

    <tbody>
    @forelse($data as $item)

        @php
            $rencana = \Carbon\Carbon::parse($item->tgl_rencana_kembali);
            $kembali = \Carbon\Carbon::parse($item->tgl_kembali);
            $terlambat = $kembali->gt($rencana);
        @endphp

        <tr class="{{ $terlambat ? 'row-terlambat' : '' }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->username ?? '-' }}</td>
            <td>{{ $item->alat->nama_alat ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y H:i') }}</td>
            <td>{{ $rencana->format('d-m-Y') }}</td>
            <td>{{ $kembali->format('d-m-Y H:i') }}</td>
            <td>
                @if($terlambat)
                    <span class="badge-terlambat">TERLAMBAT</span>
                @else
                    <span class="badge-selesai">SELESAI</span>
                @endif
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="8">Belum ada data pengembalian</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection
