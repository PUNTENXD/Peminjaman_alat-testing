<!DOCTYPE html>
<html>
<head>
    <title>Peminjam</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

    <style>
        body {
            margin: 0;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: #1e293b;
            color: white;
            padding-top: 20px;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #334155;
        }

        .logout {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #dc2626;
            text-align: center;
        }

        .logout:hover {
            background: #b91c1c;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>PEMINJAM</h4>

    <a href="{{ route('user.dashboard') }}"
       class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout text-white border-0 p-3">
            Logout
        </button>
    </form>
</div>

<div class="content">
    @yield('content')
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
