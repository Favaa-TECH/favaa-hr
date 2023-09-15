<?php

namespace App\Http\Controllers\Api\Permission;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'permission_type' => 'required|string',
                'permission_reason' => 'required|string',
                'proof' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
            ]);
            $employee = Employee::findOrFail($request->employee_id);
            $permission = new Permission([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'permission_type' => $request->permission_type,
                'permission_reason' => $request->permission_reason,
            ]);
            if ($request->hasFile('proof')) {
                $proof = $request->file('proof');
                $proofPath = $proof->store('permission_proofs', 'public');
                $permission->proof = $proofPath;
            }
            $employee->permissions()->save($permission);
            return response()->json([
                'code' => '200',
                'status' => 'OK',
                'message' => 'Permission created successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
