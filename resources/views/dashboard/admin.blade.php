@extends('Layouts.admin')

@section('content')

<h1>Dashboard Admin</h1>

<p>Selamat datang, <strong>{{ auth()->user()->username }}</strong></p>

{{-- ============================= --}}
{{-- STATISTIK --}}
{{-- ============================= --}}

<div class="stats-grid">

    <div class="stat-card blue">
        <h3>Total User</h3>
        <h2>{{ $totalUser }}</h2>
    </div>

    <div class="stat-card green">
        <h3>Total Alat</h3>
        <h2>{{ $totalAlat }}</h2>
    </div>

    <div class="stat-card purple">
        <h3>Total Kategori</h3>
        <h2>{{ $totalKategori }}</h2>
    </div>

    <div class="stat-card orange">
        <h3>Pending</h3>
        <h2>{{ $pending }}</h2>
    </div>

    <div class="stat-card darkblue">
        <h3>Sedang Dipinjam</h3>
        <h2>{{ $dipinjam }}</h2>
    </div>

    <div class="stat-card darkgreen">
        <h3>Sudah Kembali</h3>
        <h2>{{ $kembali }}</h2>
    </div>

</div>

<hr style="margin:40px 0;">

{{-- ============================= --}}
{{-- PEMINJAMAN TERBARU --}}
{{-- ============================= --}}

<h2>Peminjaman Terbaru</h2>

<table class="table-dashboard">
    <tr>
        <th>Peminjam</th>
        <th>Alat</th>
        <th>Jumlah</th>
        <th>Status</th>
    </tr>

    @forelse($latestPeminjaman as $item)
    <tr>
        <td>{{ $item->user->username ?? '-' }}</td>
        <td>{{ $item->alat->nama_alat ?? '-' }}</td>
        <td>{{ $item->jumlah }}</td>
        <td>
            <span class="badge {{ $item->status }}">
                {{ strtoupper($item->status) }}
            </span>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4">Belum ada data</td>
    </tr>
    @endforelse
</table>

<hr style="margin:40px 0;">

{{-- ============================= --}}
{{-- LOG TERBARU --}}
{{-- ============================= --}}

<h2>Aktivitas Terbaru</h2>

<table class="table-dashboard">
    <tr>
        <th>User</th>
        <th>Aktivitas</th>
        <th>Waktu</th>
    </tr>

    @forelse($logs as $log)
    <tr>
        <td>{{ $log->id_user }}</td>
        <td>{{ $log->aktivitas }}</td>
        <td>{{ $log->create_at }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3">Belum ada aktivitas</td>
    </tr>
    @endforelse
</table>

@endsection
