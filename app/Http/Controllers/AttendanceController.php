<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\AttendanceHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $today = \Carbon\Carbon::today()->toDateString();

    $employees = \App\Models\Employee::all(); // pastikan ini ada
    //$attendances = \App\Models\Attendance::whereDate('clock_in', $today)->get();
    $attendances = Attendance::whereDate('clock_in', today())->get();
    return view('attendance.index', compact('employees', 'attendances'));

    //return view('attendance.index', compact('employees', 'attendances'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    

    public function clockIn($employee_id)
    {
        $employee = Employee::where('employee_id', $employee_id)->firstOrFail();
        $already = Attendance::where('employee_id', $employee_id)
                            ->whereDate('clock_in', today())
                            ->first();
        if ($already) {
            return back()->with('warning', 'Karyawan ini sudah clock in hari ini.');
        }
        $attendanceId = Str::uuid(); // BUAT SEKALI

        $attendance = Attendance::create([
            'employee_id'   => $employee->employee_id,
            'attendance_id' => $attendanceId, // ⬅️ pakai yang sama
            'clock_in'      => now()
        ]);

        AttendanceHistory::create([
            'employee_id'       => $employee->employee_id,
            'attendance_id'     => $attendanceId, // ⬅️ pakai yang sama
            'date_attendance'   => now(),
            'attendance_type'   => 1, // 1 = Clock In
            'description'       => 'Clock In'
        ]);

        return back()->with('success', 'Clock In recorded.');
    }
    public function clockOut($employee_id)
    {
        // Cari data absensi hari ini
        $attendance = Attendance::where('employee_id', $employee_id)
                                ->whereDate('clock_in', today())
                                ->first();

        // Jika tidak ditemukan, berarti belum clock in
        if (!$attendance) {
            return back()->with('error', 'Karyawan ini belum melakukan clock in hari ini.');
        }

        // Jika sudah clock out, tidak perlu lanjut
        if ($attendance->clock_out) {
            return back()->with('warning', 'Karyawan ini sudah clock out hari ini.');
        }

        // Update clock_out
        $attendance->update([
            'clock_out' => now()
        ]);

        // Tambahkan ke attendance_histories
        AttendanceHistory::create([
            'employee_id'       => $employee_id,
            'attendance_id'     => $attendance->attendance_id, // Ambil dari attendance yang tadi
            'date_attendance'   => today(),
            'attendance_type'   => 2, // 2 = Clock Out
            'description'       => 'Clock Out'
        ]);

        return back()->with('success', 'Clock Out berhasil.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        Attendance::destroy($id);
        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil dihapus.');

    }
}
