@extends('Layouts.admin')

@section('content')

<h2 style="text-align:center;">Tambah User</h2>

{{-- NOTIFIKASI SUCCESS --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="form-wrapper">

   <form action="{{ route('admin.user.store') }}" method="POST">
    @csrf


        <div class="form-group">
            <label>Username</label>
            <input type="text"
                   name="username"
                   placeholder="Masukkan username"
                   required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password"
                   name="password"
                   placeholder="Masukkan password"
                   required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="peminjam">Peminjam</option>
            </select>
        </div>

        <button type="submit" class="btn-save">
            Simpan User
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
    border-color: #16a34a;
}

/* ===== BUTTON ===== */

.btn-save {
    width: 100%;
    padding: 10px;
    background: #16a34a;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-save:hover {
    background: #15803d;
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
