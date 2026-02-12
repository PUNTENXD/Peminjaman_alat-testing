@extends('Layouts.admin')

@section('content')

<div class="form-wrapper">

    <div class="form-card">

        <h2>Edit Peminjaman</h2>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Alat</label>
                <select name="id_alat" required>
                    @foreach($alat as $a)
                        <option value="{{ $a->id_alat }}"
                            @selected($peminjaman->id_alat == $a->id_alat)>
                            {{ $a->nama_alat }} (stok {{ $a->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number"
       name="jumlah"
       min="1"
       value="{{ $peminjaman->jumlah }}"
       required>

            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date"
       name="tgl_pinjam"
       min="{{ date('Y-m-d') }}"
       value="{{ $peminjaman->tgl_pinjam }}"
       required>

            </div>

            <div class="form-group">
                <label>Rencana Kembali</label>
                <input type="date"
       name="tgl_rencana_kembali"
       min="{{ date('Y-m-d') }}"
       value="{{ $peminjaman->tgl_rencana_kembali }}"
       required>

            </div>

            <button type="submit" class="btn-submit">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>


<style>

/* WRAPPER CENTER */
.form-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

/* CARD */
.form-card {
    background: white;
    width: 100%;
    max-width: 500px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* TITLE */
.form-card h2 {
    text-align: center;
    margin-bottom: 25px;
}

/* GROUP */
.form-group {
    margin-bottom: 18px;
}

/* LABEL */
.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

/* INPUT & SELECT */
.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

/* FOCUS EFFECT */
.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #2563eb;
}

/* BUTTON */
.btn-submit {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 6px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.btn-submit:hover {
    background: #1e40af;
    transform: translateY(-2px);
}

/* ALERT */
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
}

/* RESPONSIVE */
@media (max-width: 500px) {
    .form-card {
        padding: 20px;
    }
}

</style>

@endsection
