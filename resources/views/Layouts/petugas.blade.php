<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}

/* SIDEBAR */
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
    transition: 0.2s;
}

.sidebar a:hover,
.sidebar a.active {
    background: #374151;
}

/* CONTENT */
.content {
    margin-left: 220px;
    padding: 20px;
}

/* TABLE */
.table-dashboard {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.table-dashboard th,
.table-dashboard td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

.table-dashboard th {
    background: #f3f4f6;
}

/* BUTTON */
.btn-success {
    background: #16a34a;
    border: none;
    padding: 6px 12px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-success:hover {
    background: #15803d;
}

/* LOGOUT */
.logout {
    position: absolute;
    bottom: 0;
    width: 100%;
}

.logout button {
    width: 100%;
    padding: 12px;
    border: none;
    background: #dc2626;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.logout button:hover {
    background: #b91c1c;
}
</style>

</head>
<body>

<div class="sidebar">
    <h2>PETUGAS</h2>

    <a href="{{ route('petugas.dashboard') }}"
       class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
       Dashboard
    </a>

    <a href="{{ route('petugas.peminjaman') }}"
       class="{{ request()->routeIs('petugas.peminjaman') ? 'active' : '' }}">
       Pantau Peminjaman
    </a>

    <a href="{{ route('petugas.pengembalian') }}"
       class="{{ request()->routeIs('petugas.pengembalian') ? 'active' : '' }}">
       Data Pengembalian
    </a>

    <a href="{{ route('petugas.laporan') }}"
       class="{{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">
       Laporan
    </a>

    <div class="logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Logout</button>
        </form>
    </div>
</div>


<div class="content">
    @yield('content')
</div>

</body>
</html>
