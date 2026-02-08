<h2>Data Kategori</h2>

<form action="/kategori" method="POST">
    @csrf
    <input type="text" name="nama_kategori">
    <button type="submit">Tambah</button>
</form>

<ul>
@foreach ($kategori as $k)
    <li>{{ $k->nama_kategori }}</li>
@endforeach
</ul>
