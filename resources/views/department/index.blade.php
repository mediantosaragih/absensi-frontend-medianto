@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Department</h4>
    <a href="{{ route('department.create') }}" class="btn btn-primary mb-3">+ Tambah Department</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Department</th>
                <th>Max Clock In</th>
                <th>Max Clock Out</th>                                
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $dept)
            <tr>
                <td>{{ $dept->id }}</td>
                <td>{{ $dept->department_name }}</td>
                <td>{{ $dept->max_clock_in_time }}</td>
                <td>{{ $dept->max_clock_out_time }}</td>                
                <td>
                    <a href="{{ route('department.edit', $dept->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('department.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
