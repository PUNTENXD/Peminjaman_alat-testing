<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peminjam</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            margin: 0;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #e5e7eb;
        }
        .status {
            padding: 4px 8px;
            border-radius: 6px;
            color: white;
            font-size: 12px;
        }
        .pending { background: #f59e0b; }
        .pinjam { background: #2563eb; }
        .kembali { background: #16a34a; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>
<body>

<div class="container">
    <h1>Riwayat Peminjaman Saya</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Status</th>
        </tr>

        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->alat->nama_alat ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->tgl_pinjam }}</td>
            <td>
                <span class="status {{ $item->status }}">
                    {{ strtoupper($item->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>
