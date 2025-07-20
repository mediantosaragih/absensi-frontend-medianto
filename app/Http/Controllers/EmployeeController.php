<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->get();
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $departments = Department::all();
            return view('employee.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:employees,employee_id',
            'name' => 'required',
            'department_id' => 'required|exists:departments,id',
            'address' => 'nullable|string',
        ]);

        Employee::create($request->only([
            'employee_id',
            'name',
            'department_id',
            'address',
        ]));

        return redirect()->route('employee.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
       // $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('employee.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_id' => 'required|unique:employees,employee_id,' . $employee->id,
            'name' => 'required',
            'department_id' => 'required|exists:departments,id',
            'address' => 'nullable',
        ]);

        $employee->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'address' => $request->address,
        ]);

        return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employee.index')->with('success', 'Karyawan berhasil dihapus.');

        }
}
