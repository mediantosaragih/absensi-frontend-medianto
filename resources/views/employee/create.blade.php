@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Karyawan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('employee.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" name="employee_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Departemen</label>
                <select name="department_id" class="form-select" required>
                    <option value="">-- Pilih Departemen --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
