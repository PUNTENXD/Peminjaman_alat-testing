@extends('Layouts.admin')

@section('content')

<h2 style="text-align:center;">Data Kategori</h2>

{{-- NOTIFIKASI --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="wrapper">

    {{-- FORM TAMBAH --}}
    <div class="card-form">
       <form action="{{ route('admin.kategori.store') }}" method="POST">
    @csrf


            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text"
                       name="nama_kategori"
                       placeholder="Masukkan nama kategori"
                       required>
            </div>

            <button type="submit" class="btn-save">
                Tambah Kategori
            </button>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="card-table">
        <table width="100%">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kategori }}</td>

                     <td>
    <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}"
       class="btn btn-warning btn-sm">Edit</a>

    <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
            Hapus
        </button>
    </form>
</td>




                </tr>
                @empty
                <tr>
                    <td colspan="2">Belum ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


<style>

/* WRAPPER */
.wrapper {
    max-width: 700px;
    margin: 20px auto;
}

/* CARD FORM */
.card-form {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

/* FORM GROUP */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
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

/* BUTTON */
.btn-save {
    padding: 9px 14px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-save:hover {
    background: #1e40af;
}

/* TABLE */
.card-table {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

table {
    border-collapse: collapse;
}

table th {
    background: #f3f4f6;
    padding: 10px;
    text-align: center;
}

table td {
    padding: 10px;
    text-align: center;
    border-top: 1px solid #eee;
}

/* ALERT */
.alert-success {
    max-width: 700px;
    margin: 0 auto 15px auto;
    padding: 10px;
    background: #dcfce7;
    color: #166534;
    border-radius: 6px;
    text-align: center;
}

/* RESPONSIVE */
@media (max-width: 600px) {
    .wrapper {
        margin: 10px;
    }
}

</style>

@endsection
