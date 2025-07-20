@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Karyawan</h3>
    <a href="{{ route('employee.create') }}" class="btn btn-primary">+ Tambah Karyawan</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $emp)
        <tr>
             <td>{{ $emp->employee_id }}</td> {{-- atau $emp->id jika tidak ada employee_id --}}
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->department->department_name ?? '-' }}</td>
            <td>{{ $emp->address }}</td>
            <td>
                <a href="{{ route('employee.edit', $emp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('employee.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
