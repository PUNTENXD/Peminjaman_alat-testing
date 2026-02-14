@extends('Layouts.admin')

@section('content')

<!-- ================= NAVBAR ================= -->
<div class="dashboard-navbar">
    <h2>Dashboard</h2>
    <div class="user-info">
        {{ auth()->user()->username }}
    </div>
</div>

<!-- ================= TOP SECTION ================= -->
<div class="dashboard-top">

    <!-- LEFT BIG BOX (KOSONG) -->
    <div class="left-box">
        <!-- Kosong sesuai permintaan -->
    </div>

    <!-- RIGHT MONITORING BOX -->
    <div class="right-stats">

        <div class="stat-card blue">
            <h4>Total User</h4>
            <h2>{{ $totalUser }}</h2>
        </div>

        <div class="stat-card green">
            <h4>Total Alat</h4>
            <h2>{{ $totalAlat }}</h2>
        </div>

        <div class="stat-card purple">
            <h4>Total Kategori</h4>
            <h2>{{ $totalKategori }}</h2>
        </div>

        <div class="stat-card orange">
            <h4>Pending</h4>
            <h2>{{ $pending }}</h2>
        </div>

        <div class="stat-card darkblue">
            <h4>Sedang Dipinjam</h4>
            <h2>{{ $dipinjam }}</h2>
        </div>

        <div class="stat-card darkgreen">
            <h4>Sudah Kembali</h4>
            <h2>{{ $kembali }}</h2>
        </div>

    </div>

</div>

<!-- ================= TABEL ================= -->

<div class="dashboard-table">

    <h3>Peminjaman Terbaru</h3>
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

</div>

<div class="dashboard-table">

    <h3>Aktivitas Terbaru</h3>
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

</div>

@endsection
