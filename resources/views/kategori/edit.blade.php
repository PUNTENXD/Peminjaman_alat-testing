@extends('Layouts.admin')

@section('content')

<h2 style="text-align:center;">Edit Kategori</h2>

{{-- NOTIFIKASI SUCCESS --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="form-wrapper">

    <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   value="{{ $kategori->nama_kategori }}"
                   required>
        </div>

        <button type="submit" class="btn-update">
            Update Kategori
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

.form-group input {
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: 0.3s;
}

.form-group input:focus {
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
