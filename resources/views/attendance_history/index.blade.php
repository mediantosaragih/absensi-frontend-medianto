@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Log Absensi & Ketepatan Waktu</h2>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('attendance_history.index') }}" class="row g-2 mb-4 align-items-end">
        <div class="col-md-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-3">
            <label for="department_id" class="form-label">Departemen</label>
            <select name="department_id" id="department_id" class="form-select">
                <option value="">-- Semua Departemen --</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->department_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Tabel Absensi --}}
    <table class="table table-bordered">
        <thead>
    <tr>
        <th>Nama Karyawan</th>
        <th>Departemen</th>
        <th>Tanggal</th>
        <th>Clock In</th>
        <th>Status In</th>
        <th>Clock Out</th>
        <th>Status Out</th>
    </tr>
</thead>
<tbody>
    @forelse($histories as $log)
        <tr>
            <td>{{ $log['employee']->name }}</td>
            <td>{{ $log['department']->department_name ?? '-' }}</td>
            <td>{{ $log['date'] }}</td>
            <td>{{ $log['clock_in_time'] }}</td>
            <td>
                @if($log['status_in'] == 'Tepat Waktu')
                    <span class="badge bg-success">{{ $log['status_in'] }}</span>
                @elseif($log['status_in'] == 'Terlambat')
                    <span class="badge bg-danger">{{ $log['status_in'] }}</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </td>
            <td>{{ $log['clock_out_time'] }}</td>
            <td>
                @if($log['status_out'] == 'Tepat Waktu')
                    <span class="badge bg-success">{{ $log['status_out'] }}</span>
                @elseif($log['status_out'] == 'Pulang Cepat')
                    <span class="badge bg-danger">{{ $log['status_out'] }}</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data absensi.</td>
        </tr>
    @endforelse
</tbody>

    </table>
</div>
@endsection
