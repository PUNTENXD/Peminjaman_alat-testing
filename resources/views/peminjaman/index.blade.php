@extends('Layouts.admin')

@section('content')

<h1>Data Peminjaman</h1>

{{-- ================= SUCCESS ALERT ================= --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- ================= FILTER ================= --}}
<div class="filter-wrapper">
    <a href="{{ route('peminjaman.index') }}" class="btn-edit">Semua</a>
    <a href="{{ route('peminjaman.index',['filter'=>'terlambat']) }}" class="btn-kembali">Terlambat</a>
</div>

{{-- ================= DENDA SESSION ================= --}}
@if(session('denda') && session('denda') > 0)
    <div class="alert-danger">
        Total Denda: Rp {{ number_format(session('denda'),0,',','.') }}
    </div>
@endif

<table class="table-peminjaman">
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Rencana</th>
            <th>Kembali</th>
            <th>Status</th>
            <th>Durasi</th>
            <th>Keterangan</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    @forelse($data as $item)

        @php
            $now = now();

            $tglPinjam  = $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->startOfDay() : null;
            $tglRencana = $item->tgl_rencana_kembali ? \Carbon\Carbon::parse($item->tgl_rencana_kembali)->startOfDay() : null;
            $tglKembali = $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->startOfDay() : null;

            // ================= DURASI =================
            $durasi = 0;
            if ($tglPinjam) {
                $durasi = $tglPinjam->diffInDays($tglKembali ?? $now);
            }

            // ================= TERLAMBAT =================
            $hariTerlambat = 0;

            if ($tglRencana) {
                if ($item->status === 'pinjam' && $now->gt($tglRencana)) {
                    $hariTerlambat = $tglRencana->diffInDays($now);
                }

                if ($item->status === 'kembali' && $tglKembali && $tglKembali->gt($tglRencana)) {
                    $hariTerlambat = $tglRencana->diffInDays($tglKembali);
                }
            }

            $terlambat  = $hariTerlambat > 0;
            $totalDenda = $hariTerlambat * 2000;
        @endphp

        <tr class="{{ $terlambat ? 'row-terlambat' : '' }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->username ?? '-' }}</td>
            <td>{{ $item->alat->nama_alat ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>

            <td>{{ $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y H:i') : '-' }}</td>
            <td>{{ $item->tgl_rencana_kembali ? \Carbon\Carbon::parse($item->tgl_rencana_kembali)->format('d-m-Y') : '-' }}</td>
            <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y H:i') : '-' }}</td>

            <td>
                <span class="status-badge {{ $item->status }}">
                    {{ strtoupper($item->status) }}
                </span>
            </td>

            <td>{{ $durasi }} hari</td>

            <td>
                @if($item->status === 'kembali')
                    <span class="badge-selesai">SELESAI</span>
                @elseif($terlambat)
                    <span class="badge-terlambat">TERLAMBAT</span>
                @else
                    -
                @endif
            </td>

            <td>
                @if($totalDenda > 0)
                    Rp {{ number_format($totalDenda,0,',','.') }}
                @else
                    -
                @endif
            </td>

            <td>
                @if(in_array(auth()->user()->role,['admin','petugas']) && $item->status === 'pending')
                    <a href="{{ route('peminjaman.edit',$item->id_peminjaman) }}" class="btn-edit">Edit</a>
                @endif

                @if(auth()->user()->role === 'petugas' && $item->status === 'pending')
                    <form action="{{ route('peminjaman.acc',$item->id_peminjaman) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-acc">ACC</button>
                    </form>
                @endif

                @if(auth()->user()->role === 'petugas' && $item->status === 'pinjam')
                    <form action="{{ route('peminjaman.kembali',$item->id_peminjaman) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin alat dikembalikan?')" class="btn-kembali">
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
            <td colspan="12">Tidak ada data</td>
        </tr>
    @endforelse
    </tbody>
</table>




@push('styles')
<style>

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

.badge-terlambat {
    background: #dc2626;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.badge-selesai {
    background: #16a34a;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}


.row-terlambat {
    background-color: #fee2e2;
}


.alert-danger {
    margin-bottom: 15px;
    padding: 10px;
    background: #fee2e2;
    color: #991b1b;
    border-radius: 6px;
}


</style>




</style>
@endpush





@endsection
