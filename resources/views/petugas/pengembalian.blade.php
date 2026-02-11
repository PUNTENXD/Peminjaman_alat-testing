<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>

    <style>
        body {
            margin:0;
            font-family:Arial;
            background:#f4f6f8;
        }

        .sidebar {
            width:220px;
            height:100vh;
            background:#1f2937;
            color:white;
            position:fixed;
        }

        .sidebar h2 {
            text-align:center;
            padding:16px;
            margin:0;
            background:#111827;
        }

        .sidebar a {
            display:block;
            padding:12px 16px;
            color:white;
            text-decoration:none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background:#374151;
        }

        .content {
            margin-left:220px;
            padding:20px;
        }

        table {
            width:100%;
            border-collapse:collapse;
            background:white;
        }

        th,td {
            padding:10px;
            border:1px solid #ddd;
            text-align:center;
        }

        th {
            background:#f3f4f6;
        }

        .btn-cetak {
            padding:20px;
            font-size:18px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            margin-bottom:20px;
        }

        .btn-cetak:hover {
            background:#1d4ed8;
        }

        /* PRINT MODE */
        @media print {
            .sidebar,
            .btn-cetak {
                display:none;
            }

            .content {
                margin-left:0;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PETUGAS</h2>

    <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
    <a href="{{ route('petugas.peminjaman') }}">Pantau Peminjaman</a>
    <a href="{{ route('petugas.pengembalian') }}" class="active">Laporan</a>

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

<h1>Laporan Pengembalian</h1>

<button onclick="window.print()"class="btn-cetak">
    Cetak Laporan
</button>

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
    <td colspan="7">Tidak ada data pengembalian</td>
</tr>
@endforelse

</table>

</div>
</body>
</html>
