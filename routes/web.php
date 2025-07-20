<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\controllers\AttendanceHistoryController;


Route::get('/', function () {
    return view('dashboard');
});
Route::resource('employee', App\Http\Controllers\EmployeeController::class);
Route::resource('employee', EmployeeController::class);
Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');

Route::resource('department', App\Http\Controllers\DepartmentController::class);
Route::resource('department', DepartmentController::class);
Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');

Route::resource('attendance', App\Http\Controllers\AttendanceController::class);
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/attendance/tambah', [AttendanceController::class, 'create'])->name('attendance.create');
Route::post('/attendance/{id}/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockin');
Route::post('/attendance/{id}/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockout');

Route::resource('attendance_history', App\Http\Controllers\AttendanceHistoryController::class)->only(['index', 'store']);