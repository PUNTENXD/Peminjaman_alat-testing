@extends('layouts.admin')

@section('content')

<h1>Data Peminjaman</h1>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table-peminjaman" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Rencana Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    @forelse($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->user->username ?? '-' }}</td>
        <td>{{ $item->alat->nama_alat ?? '-' }}</td>
        <td>{{ $item->jumlah }}</td>
        <td>{{ $item->tgl_pinjam }}</td>
        <td>{{ $item->tgl_rencana_kembali }}</td>

        <td>
            <span class="status-badge
                {{ $item->status }}">
                {{ strtoupper($item->status) }}
            </span>
        </td>

        <td>

            {{-- EDIT --}}
            @if(in_array(auth()->user()->role, ['admin','petugas']) 
                && $item->status === 'pending')
                
                <a href="{{ route('peminjaman.edit', $item->id_peminjaman) }}"
                   class="btn-edit">
                    Edit
                </a>
            @endif

            {{-- ACC --}}
            @if(auth()->user()->role === 'petugas' 
                && $item->status === 'pending')
                
                <form action="{{ route('peminjaman.acc', $item->id_peminjaman) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    <button type="submit" class="btn-acc">
                        ACC
                    </button>
                </form>
            @endif

            {{-- KEMBALIKAN --}}
            @if(auth()->user()->role === 'petugas' 
                && $item->status === 'pinjam')
                
                <form action="{{ route('peminjaman.kembali', $item->id_peminjaman) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Yakin alat dikembalikan?')"
                            class="btn-kembali">
                        Kembalikan
                    </button>
                </form>
            @endif

            @if($item->status === 'kembali')
                -
            @endif

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8">Tidak ada data</td>
    </tr>
    @endforelse
    </tbody>
</table>


<style>

/* ALERT */
.alert-success {
    margin-bottom: 15px;
    padding: 10px;
    background: #dcfce7;
    color: #166534;
    border-radius: 6px;
}

/* TABLE */
.table-peminjaman {
    border-collapse: collapse;
    background: white;
}

.table-peminjaman th,
.table-peminjaman td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center; /* ← SEMUA DATA CENTER */
}

.table-peminjaman th {
    background: #f3f4f6;
}

/* STATUS BADGE */
.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    color: white;
    font-size: 12px;
}

.status-badge.pending {
    background: #f59e0b;
}

.status-badge.pinjam {
    background: #2563eb;
}

.status-badge.kembali {
    background: #16a34a;
}

/* EDIT BUTTON */
.btn-edit {
    color: #2563eb; /* biru */
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s ease;
}

.btn-edit:hover {
    text-decoration: underline;
    opacity: 0.7;
}

/* ACC */
.btn-acc {
    border: none;
    background: transparent;
    color: #16a34a;
    font-weight: 600;
    cursor: pointer;
    margin-left: 10px;
    transition: 0.3s;
}

.btn-acc:hover {
    opacity: 0.7;
}

/* KEMBALIKAN */
.btn-kembali {
    border: none;
    background: transparent;
    color: #dc2626;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-kembali:hover {
    opacity: 0.7;
}

</style>

@endsection
