@extends('Layouts.admin')

@section('content')
<h1>Log Aktivitas</h1>

<table>
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Aktivitas</th>
        <th>Tabel</th>
        <th>Waktu</th>
    </tr>

    @foreach($data as $log)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $log->user->username ?? '-' }}</td>
        <td>{{ $log->aktivitas }}</td>
        <td>{{ $log->target_tabel }}</td>
        <td>{{ $log->create_at }}</td>
    </tr>
    @endforeach
</table>
@endsection
