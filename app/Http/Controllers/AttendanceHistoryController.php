<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceHistory;
use App\Models\Department;
use Carbon\Carbon; // ✅ Tambahkan ini
use App\Models\Employee;


class AttendanceHistoryController extends Controller
{
   public function index(Request $request)
    {
        $date = $request->input('date'); // format: yyyy-mm-dd (dari input type="date")
        $departmentId = $request->input('department_id');

        $query = AttendanceHistory::with(['employee.department']);

        // Filter berdasarkan tanggal jika diisi
        if ($date) {
            try {
                $parsedDate = Carbon::parse($date)->toDateString(); // pastikan format valid
                $query->whereDate('date_attendance', $parsedDate);
            } catch (\Exception $e) {
                // Jika error parsing tanggal, abaikan filter tanggal
            }
        }

        // Filter berdasarkan departemen jika diisi
        if ($departmentId) {
            $query->whereHas('employee.department', function ($q) use ($departmentId) {
                $q->where('id', $departmentId);
            });
        }

        $rawHistories = $query->get();

        $groupedHistories = $rawHistories->groupBy(function ($item) {
            return $item->employee_id . '_' . \Carbon\Carbon::parse($item->date_attendance)->toDateString();
        });
       // $groupedHistories = $rawHistories->groupBy(function ($item) {
   //         return $item->employee_id . '_' . Carbon::parse($item->date_attendance)->toDateString();
   //     });

        $histories = $groupedHistories->map(function ($logs, $key) {
            $employee = $logs->first()->employee;
            $department = $employee->department;

            $clockIn = $logs->firstWhere('description', 'Clock In');
            $clockOut = $logs->firstWhere('description', 'Clock Out');

            $clockInTime = $clockIn ? Carbon::parse($clockIn->created_at) : null;
            $clockOutTime = $clockOut ? Carbon::parse($clockOut->created_at) : null;

            $statusIn = '-';
            $statusOut = '-';

            if ($clockInTime && $department) {
                $maxIn = Carbon::parse($clockInTime->format('Y-m-d') . ' ' . $department->max_clock_in_time);
                $statusIn = $clockInTime <= $maxIn ? 'Tepat Waktu' : 'Terlambat';
            }

            if ($clockOutTime && $department) {
                $maxOut = Carbon::parse($clockOutTime->format('Y-m-d') . ' ' . $department->max_clock_out_time);
                $statusOut = $clockOutTime >= $maxOut ? 'Tepat Waktu' : 'Pulang Cepat';
            }

            return [
                'employee' => $employee,
                'department' => $department,
                'clock_in_time' => $clockInTime ? $clockInTime->format('H:i') : '-',
                'clock_out_time' => $clockOutTime ? $clockOutTime->format('H:i') : '-',
                'status_in' => $statusIn,
                'status_out' => $statusOut,
                'date' => $logs->first()->date_attendance,
            ];
        });

        // Kirim juga data departemen untuk dropdown
        $departments = \App\Models\Department::all();

        return view('attendance_history.index', compact('histories', 'departments', 'date', 'departmentId'));
    }


 public function indexs(Request $request)
{
    $query = AttendanceHistory::with(['employee.department']);

    // Filter berdasarkan tanggal (jika diisi)
    if ($request->filled('date')) {
        $query->whereDate('date_attendance', $request->date);
    }

    // Filter berdasarkan departemen (jika diisi)
    if ($request->filled('department_id')) {
        $query->whereHas('employee', function ($q) use ($request) {
            $q->where('department_id', $request->department_id);
        });
    }

    $histories = $query->get()->groupBy('employee_id');
    $departments = Department::all();

    return view('attendance_history.index', compact('histories', 'departments'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'status_after' => 'required|in:present,absent,leave',
            'keterangan' => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($request->attendance_id);

        AttendanceHistory::create([
            'attendance_id' => $attendance->id,
            'status_before' => $attendance->status,
            'status_after' => $request->status_after,
            'changed_at' => Carbon::now(),
            'changed_by' => auth()->id(), // pastikan pakai auth
            'keterangan' => $request->keterangan,
        ]);

        // Update juga data utama di tabel attendance
        $attendance->status = $request->status_after;
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Status absensi diperbarui dan dicatat di log.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
