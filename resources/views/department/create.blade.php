@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">Tambah Departemen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('department.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="department_name" class="form-label">Nama Departemen</label>
                            <input type="text" name="department_name" id="department_name" class="form-control @error('department_name') is-invalid @enderror" placeholder="Masukkan nama departemen" value="{{ old('department_name') }}">
                            @error('department_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="max_clock_in_time" class="form-label">Jam Maks. Masuk</label>
                                <input type="time" name="max_clock_in_time" id="max_clock_in_time" class="form-control @error('max_clock_in_time') is-invalid @enderror" value="{{ old('max_clock_in_time') }}">
                                @error('max_clock_in_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="max_clock_out_time" class="form-label">Jam Maks. Pulang</label>
                                <input type="time" name="max_clock_out_time" id="max_clock_out_time" class="form-control @error('max_clock_out_time') is-invalid @enderror" value="{{ old('max_clock_out_time') }}">
                                @error('max_clock_out_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('department.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
