@extends('layouts.admin')

@section('content')

<h2>Manajemen User</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table class="user-table">
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->username }}</td>
        <td>{{ ucfirst($u->role) }}</td>
        <td>

            <a href="/user/{{ $u->id_user }}/edit"
               class="btn-edit">
                Edit
            </a>

            @if($u->role !== 'admin')
            <form action="/user/{{ $u->id_user }}/delete"
                  method="POST"
                  style="display:inline;">
                @csrf
                <button type="submit"
                        class="btn-delete"
                        onclick="return confirm('Hapus user?')">
                    Hapus
                </button>
            </form>
            @endif

        </td>
    </tr>
    @endforeach
</table>

{{-- Tombol tambah user pindah ke bawah --}}
<div class="tambah-wrapper">
    <a href="/user/create" class="btn-tambah">
        + Tambah User
    </a>
</div>

<style>

/* ===== TABLE ===== */

.user-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.user-table th,
.user-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center; /* RATA TENGAH */
}

.user-table th {
    background: #f3f4f6;
}

/* ===== BUTTON TAMBAH ===== */

.tambah-wrapper {
    margin-top: 15px; /* jarak 10-15px dari tabel */
}

.btn-tambah {
    background: #2563eb;
    color: white;
    padding: 8px 14px;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}

.btn-tambah:hover {
    background: #1d4ed8;
}

/* ===== BUTTON EDIT ===== */

.btn-edit {
    background: #10b981;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
    margin-right: 20px; /* jarak 20px ke hapus */
}

.btn-edit:hover {
    background: #059669;
}

/* ===== BUTTON DELETE ===== */

.btn-delete {
    background: #dc2626;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-delete:hover {
    background: #b91c1c;
}

</style>

@endsection
