<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
   <style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}

.sidebar {
    width: 220px;
    height: 100vh;
    background: #1f2937;
    color: white;
    position: fixed;
}

.sidebar h2 {
    text-align: center;
    padding: 16px;
    margin: 0;
    background: #111827;
}

.sidebar a {
    display: block;
    padding: 12px 16px;
    color: white;
    text-decoration: none;
}

.sidebar a:hover {
    background: #374151;
}

.content {
    margin-left: 220px;
    padding: 20px;
}

/* ===== DASHBOARD STYLE ===== */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    padding: 20px;
    border-radius: 10px;
    color: white;
}

.stat-card h3 {
    margin: 0;
    font-size: 16px;
}

.stat-card h2 {
    margin: 10px 0 0;
    font-size: 28px;
}

.blue { background: #3b82f6; }
.green { background: #10b981; }
.purple { background: #8b5cf6; }
.orange { background: #f59e0b; }
.darkblue { background: #2563eb; }
.darkgreen { background: #16a34a; }

.table-dashboard {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.table-dashboard th,
.table-dashboard td {
    padding: 10px;
    border: 1px solid #ddd;
}

.table-dashboard th {
    background: #f3f4f6;
    text-align: left;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    color: white;
    font-size: 12px;
}

.badge.pending { background: #f59e0b; }
.badge.pinjam { background: #2563eb; }
.badge.kembali { background: #16a34a; }

.logout {
    position: absolute;
    bottom: 0;
    width: 100%;
}
</style>

</head>
<body>

<div class="sidebar">
    <h2>ADMIN</h2>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="/user">User</a>
    <a href="/kategori">Kategori</a>
    <a href="{{ route('alat.index') }}">Alat</a>
    <a href="/peminjaman">Peminjaman</a>
    <a href="/kembali">Kembali</a>
    <a href="/log">Log Aktivitas</a>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button style="width:100%;padding:12px;border:none;background:#dc2626;color:white;">
                Logout
            </button>
        </form>
    </div>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
