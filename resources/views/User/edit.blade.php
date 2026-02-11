@extends('layouts.admin')

@section('content')

<h2 style="text-align:center;">Edit User</h2>

{{-- NOTIFIKASI SUCCESS --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="form-wrapper">

    <form method="POST" action="/user/{{ $user->id_user }}">
        @csrf

        <div class="form-group">
            <label>Username</label>
            <input type="text"
                   name="username"
                   value="{{ $user->username }}"
                   required>
        </div>

        <div class="form-group">
            <label>Password Baru (Opsional)</label>
            <input type="password"
                   name="password"
                   placeholder="Kosongkan jika tidak diubah">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>Petugas</option>
                <option value="peminjam" {{ $user->role=='peminjam'?'selected':'' }}>Peminjam</option>
            </select>
        </div>

        <button type="submit" class="btn-update">
            Update User
        </button>

    </form>
</div>


<style>

/* ===== WRAPPER CENTER ===== */

.form-wrapper {
    max-width: 400px;
    margin: 30px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* ===== FORM GROUP ===== */

.form-group {
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 6px;
    font-weight: 600;
}

.form-group input,
.form-group select {
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #2563eb;
}

/* ===== BUTTON ===== */

.btn-update {
    width: 100%;
    padding: 10px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-update:hover {
    background: #1d4ed8;
}

/* ===== SUCCESS ALERT ===== */

.alert-success {
    max-width: 400px;
    margin: 0 auto 15px auto;
    padding: 10px;
    background: #dcfce7;
    color: #166534;
    border-radius: 6px;
    text-align: center;
}

/* ===== RESPONSIVE ===== */

@media (max-width: 500px) {
    .form-wrapper {
        margin: 20px;
        padding: 20px;
    }
}

</style>

@endsection
