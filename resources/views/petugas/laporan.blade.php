<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f8;
}

/* Sidebar */
.sidebar{
    width:220px;
    height:100vh;
    background:#1f2937;
    color:white;
    position:fixed;
}

.sidebar h2{
    text-align:center;
    padding:16px;
    margin:0;
    background:#111827;
}

.sidebar a{
    display:block;
    padding:12px 16px;
    color:white;
    text-decoration:none;
}

.sidebar a:hover,
.sidebar a.active{
    background:#374151;
}

/* Content */
.content{
    margin-left:220px;
    padding:25px;
}

/* Filter Box */
.filter-box{
    background:white;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.filter-box label{
    font-weight:bold;
    margin-right:5px;
}

.filter-box input,
.filter-box select{
    padding:6px 8px;
    border:1px solid #ccc;
    border-radius:5px;
    margin-right:10px;
}

/* Tombol */
.btn{
    padding:6px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.btn-filter{
    background:#2563eb;
    color:white;
}

.btn-reset{
    background:#9ca3af;
    color:white;
}

.btn-cetak{
    background:#16a34a;
    color:white;
    padding:20px;
    margin-bottom:15px;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

th{
    background:#f3f4f6;
}

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>PETUGAS</h2>
    <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
    <a href="{{ route('petugas.peminjaman') }}">Pantau Peminjaman</a>
    <a href="{{ route('petugas.laporan') }}" class="active">Laporan</a>

    <div style="position:absolute;bottom:0;width:100%;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button style="width:100%;padding:12px;border:none;background:#dc2626;color:white;">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

<h1>Laporan Pengembalian</h1>

<!-- FILTER -->
<form method="GET" class="filter-box">

    <label>Tanggal Awal</label>
    <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}">

    <label>Tanggal Akhir</label>
    <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}">

    <label>Alat</label>
    <select name="alat">
        <option value="">Semua Alat</option>
        @foreach($alatList as $alat)
            <option value="{{ $alat->id_alat }}"
                {{ request('alat') == $alat->id_alat ? 'selected' : '' }}>
                {{ $alat->nama_alat }}
            </option>
        @endforeach
    </select>

    <label>Cari Peminjam</label>
    <input type="text" name="user" value="{{ request('user') }}">

    <button type="submit" class="btn btn-filter">Filter</button>

    <a href="{{ route('petugas.laporan') }}" class="btn btn-reset">Reset</a>

</form>

<!-- CETAK -->
<button class="btn btn-cetak" onclick="window.print()">Cetak</button>

<!-- TABLE -->
<table>
<tr>
    <th>No</th>
    <th>Peminjam</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tgl Pinjam</th>
    <th>Tgl Rencana Kembali</th>
    <th>Tgl Kembali</th>
</tr>

@forelse($data as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->user->username }}</td>
    <td>{{ $item->alat->nama_alat }}</td>
    <td>{{ $item->jumlah }}</td>
    <td>{{ $item->tgl_pinjam }}</td>
    <td>{{ $item->tgl_rencana_kembali }}</td>
    <td>{{ $item->tgl_kembali }}</td>
</tr>
@empty
<tr>
    <td colspan="7">Tidak ada data</td>
</tr>
@endforelse

</table>

</div>
</body>
</html>

