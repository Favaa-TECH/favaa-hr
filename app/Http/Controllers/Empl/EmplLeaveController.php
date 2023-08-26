<?php

namespace App\Http\Controllers\Empl;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmplLeaveController extends Controller
{
    public function index()
    {
        $leaveData = Leave::where('employee_id', auth()->user()->employee_id)->latest()->simplePaginate(5);
        return view('employee.leave',[
            'leaveData' => $leaveData
        ]);
    }

    public function submit(){
        return view('employee.leave-submit');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|string',
            'leave_reason' => 'required|string',
            'leave_attachment' => 'nullable:max:2048',
        ]);

        $employee = Employee::findOrFail(auth()->user()->employee_id);
        $days_requested = Carbon::parse($request->start_date)->diffInDays($request->end_date);
        if ($validatedData) {
            $leave = Leave::create([
                'employee_id' => $employee->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'leave_type' => $request->leave_type,
                'leave_reason' => $request->leave_reason,
                'leave_attachment' => $request->leave_attachment,
            ]);
            $employee->leave_quota -= $days_requested;
            $employee->save();

            if ($request->hasFile('leave_attachment')) {
                $attachment = $request->file('leave_attachment');
                $attachmentPath = $attachment->store('leave_attachments', 'public');
                $leave->leave_attachment = $attachmentPath;
            }

            $leave->save();
        }


        $request->session()->flash('success', 'Pengajuan cuti berhasil disimpan!');
        return redirect()->route('empl-leave.index');


    }
}
