<?php

namespace App\Http\Controllers\Api\Leave;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|string',
            'leave_reason' => 'required|string',
            'leave_attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $days_requested = Carbon::parse($request->start_date)->diffInDays($request->end_date);

        if ($days_requested > $employee->leave_quota) {
            return response()->json(['message' => 'Kuota cuti tidak mencukupi'], 400);
        }

        $leave = new Leave([
            'employee_id' => $employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'leave_type' => $request->leave_type,
            'leave_reason' => $request->leave_reason,
        ]);

        if ($request->hasFile('leave_attachment')) {
            $attachment = $request->file('leave_attachment');
            $attachmentPath = $attachment->store('leave_attachments', 'public');
            $leave->leave_attachment = $attachmentPath;
        }

        $leave->save();

        $employee->leave_quota -= $days_requested;
        $employee->save();

        return response()->json(['message' => 'Pengajuan cuti berhasil'], 200);
    }
}
