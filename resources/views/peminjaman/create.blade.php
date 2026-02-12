<h1>Tambah Peminjaman</h1>

<div class="form-box">
<form method="POST" action="/peminjaman">
    @csrf

    <label>Peminjam</label>
    <select name="id_user">
        @foreach($users as $u)
            <option value="{{ $u->id_user }}">
                {{ $u->username }}
            </option>
        @endforeach
    </select>

    <label>Alat</label>
    <select name="id_alat">
        @foreach($alat as $a)
            <option value="{{ $a->id_alat }}">
                {{ $a->nama_alat }} (stok {{ $a->stok }})
            </option>
        @endforeach
    </select>

    <label>Jumlah</label>
    <input type="number" name="jumlah" min="1" required>


    <br><br>
    <button class="btn btn-add">Simpan</button>
</form>
</div>
