@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Karyawan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('employee.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id', $employee->employee_id) }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Departemen</label>
                <select name="department_id" class="form-select" required>
                    <option value="">-- Pilih Departemen --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                            {{ $dept->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $employee->address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
