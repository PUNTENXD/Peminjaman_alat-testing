<!DOCTYPE html>
<html>
<head>
    <title>Data Pengembalian</title>
    <style>
        body { margin:0;font-family:Arial;background:#f4f6f8; }
        .sidebar { width:220px;height:100vh;background:#1f2937;color:white;position:fixed; }
        .sidebar h2 { text-align:center;padding:16px;margin:0;background:#111827; }
        .sidebar a { display:block;padding:12px 16px;color:white;text-decoration:none; }
        .sidebar a:hover,.sidebar a.active { background:#374151; }
        .content { margin-left:220px;padding:20px; }

        table { width:100%;border-collapse:collapse;background:white; }
        th,td { padding:10px;border:1px solid #ddd;text-align:center; }
        th { background:#f3f4f6; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PETUGAS</h2>
    <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
    <a href="{{ route('petugas.peminjaman') }}">Pantau Peminjaman</a>
    <a href="{{ route('petugas.pengembalian') }}" class="active">Data Pengembalian</a>

    <div style="position:absolute;bottom:0;width:100%;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button style="width:100%;padding:12px;border:none;background:#dc2626;color:white;">
                Logout
            </button>
        </form>
    </div>
</div>

<div class="content">
<h1>Data Pengembalian</h1>

<table>
<tr>
    <th>No</th>
    <th>Peminjam</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tgl Pinjam</th>
    <th>Tgl Kembali</th>
</tr>

@forelse($data as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->user->username }}</td>
    <td>{{ $item->alat->nama_alat }}</td>
    <td>{{ $item->jumlah }}</td>
    <td>{{ $item->tgl_pinjam }}</td>
    <td>{{ $item->tgl_kembali }}</td>
</tr>
@empty
<tr><td colspan="6">Belum ada pengembalian</td></tr>
@endforelse

</table>
</div>
</body>
</html>
