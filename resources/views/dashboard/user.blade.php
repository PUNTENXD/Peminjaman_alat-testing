@extends('Layouts.peminjam')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4 fw-bold">Dashboard Peminjam</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- ===================== DAFTAR ALAT ===================== --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white fw-semibold">
            Daftar Alat Tersedia
        </div>
        <div class="card-body">

            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alat as $a)
                    <tr>
                        <td class="fw-semibold">{{ $a->nama_alat }}</td>
                        <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>

                        <td>
                            @if($a->stok > 0)
                                <span class="badge bg-success">{{ $a->stok }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>

                        <td>{{ $a->kondisi }}</td>

                        <td>
                            @if($a->stok > 0)
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#pinjamModal"
                                    data-id="{{ $a->id_alat }}"
                                    data-nama="{{ $a->nama_alat }}"
                                    data-stok="{{ $a->stok }}"
                                >
                                    Pinjam
                                </button>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    {{-- ===================== RIWAYAT ===================== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            Riwayat Peminjaman Saya
        </div>
        <div class="card-body">

            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Rencana Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr>
                        <td class="fw-semibold">{{ $p->alat->nama_alat }}</td>
                        <td>{{ $p->jumlah }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d-m-Y H:i') }}
                        </td>

                        <td>
                            <span class="text-primary fw-semibold">
                                {{ \Carbon\Carbon::parse($p->tgl_rencana_kembali)->format('d-m-Y') }}
                            </span>
                        </td>

                        <td>
                            @if($p->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @elseif($p->status == 'pinjam')
                                <span class="badge bg-info text-dark">Sedang Dipinjam</span>
                            @elseif($p->status == 'kembali')
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>

                        <td>
                            @if($p->status == 'pinjam')
                                <form action="{{ route('user.kembali', $p->id_peminjaman) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-warning btn-sm">
                                        Kembalikan
                                    </button>
                                </form>
                            @elseif($p->status == 'pending')
                                <form action="{{ route('user.batal', $p->id_peminjaman ?? 0) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        Batalkan
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


{{-- ===================== MODAL PINJAM ===================== --}}
<div class="modal fade" id="pinjamModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('user.pinjam') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Form Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id_alat" id="modal_id_alat">

                <div class="mb-3">
                    <label class="form-label">Nama Alat</label>
                    <input type="text" id="modal_nama_alat" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Pinjam</label>
                    <input type="number" name="jumlah" id="modal_stok"
                           class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Rencana Kembali</label>
                    <input type="date"
       name="tgl_rencana_kembali"
       class="form-control"
       min="{{ date('Y-m-d') }}"
       required>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">
                    Ajukan Peminjaman
                </button>
            </div>
        </div>
    </form>
  </div>
</div>


{{-- SCRIPT UNTUK ISI MODAL --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('pinjamModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const stok = button.getAttribute('data-stok');

        document.getElementById('modal_id_alat').value = id;
        document.getElementById('modal_nama_alat').value = nama;
        document.getElementById('modal_stok').max = stok;
    });
});
</script>

@endsection
