@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selamat datang di Sistem Absensi!</h1>
    <a href="{{ route('employee.create') }}" class="btn btn-primary mt-3">Tambah Karyawan</a>
</div>
@endsection