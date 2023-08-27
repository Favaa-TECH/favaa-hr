<?php

namespace App\Http\Controllers\Empl;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class EmplPermissionController extends Controller
{
    public function index()
    {
        $permissionData = Permission::where('employee_id', auth()->user()->employee_id)->latest()->simplePaginate(5);
        return view('employee.permission',[
            'permissionData' => $permissionData
        ]);
    }

    public function submit()
    {
        return view('employee.permission-submit');
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'permission_type' => 'required|string',
            'permission_reason' => 'required|string',
            'proof' => 'nullable:max:2048',
        ]);

        $employee = Employee::findOrFail(auth()->user()->employee_id);
        $days_requested = Carbon::parse($request->start_date)->diffInDays($request->end_date);
        if ($validatedData) {
            $leave = Permission::create([
                'employee_id' => $employee->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'permission_type' => $request->permission_type,
                'permission_reason' => $request->permission_reason,
                'proof' => $request->proof,
            ]);
            $employee->leave_quota -= $days_requested;
            $employee->save();

            if ($request->hasFile('proof')) {
                $proof = $request->file('proof');
                $proofPath = $proof->store('proofs', 'public');
                $leave->proof = $proofPath;
            }

            $leave->save();
        }


        $request->session()->flash('success', 'Pengajuan Ijin berhasil disimpan!');
        return redirect()->route('empl-permission.index');


    }
}
