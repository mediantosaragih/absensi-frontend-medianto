@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Absensi Hari Ini ({{ \Carbon\Carbon::now()->format('d M Y') }})</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped shadow-sm bg-white rounded-3">
        <thead class="table-primary">
            <tr>
                <th>Nama Karyawan</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($employees as $employee)
                @php
                    $attendance = $attendances->firstWhere('employee_id', $employee->employee_id);
                @endphp
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $attendance?->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}</td>
                    <td>{{ $attendance?->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}</td>
                    <td>
                        @if (!$attendance)
                            <form action="{{ route('attendance.clockin', $employee->employee_id) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Clock In</button>
                            </form>
                        @elseif (!$attendance->clock_out)
                            <form action="{{ route('attendance.clockout', $employee->employee_id) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Clock Out</button>
                            </form>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
