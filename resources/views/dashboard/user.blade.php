@extends('layouts.peminjam')


@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Dashboard Peminjam</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    {{-- ===================== DAFTAR ALAT ===================== --}}
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            Daftar Alat
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alat as $a)
                    <tr>
                        <td>{{ $a->nama_alat }}</td>
                        <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $a->stok }}</td>
                        <td>{{ $a->kondisi }}</td>
                        <td>
                            @if($a->stok > 0)
                            <form action="{{ route('user.pinjam') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_alat" value="{{ $a->id_alat }}">

                                <input type="number" name="jumlah" min="1"
                                    max="{{ $a->stok }}" class="form-control mb-2"
                                    placeholder="Jumlah" required>

                                <input type="date" name="tgl_rencana_kembali"
                                    class="form-control mb-2" required>

                                <button class="btn btn-success btn-sm w-100">
                                    Pinjam
                                </button>
                            </form>
                            @else
                                <span class="text-danger">Stok Habis</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- ===================== RIWAYAT ===================== --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            Riwayat Peminjaman Saya
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr>
                        <td>{{ $p->alat->nama_alat }}</td>
                        <td>{{ $p->jumlah }}</td>
                        <td>{{ $p->tgl_pinjam }}</td>
                        <td>{{ $p->tgl_rencana_kembali }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            @if($p->status == 'pinjam')
                            <form action="{{ route('user.kembali', $p->id_peminjaman) }}"
                                  method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm">
                                    Kembalikan
                                </button>
                            </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
