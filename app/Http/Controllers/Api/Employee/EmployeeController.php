<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function getEmployee(Request $request){
        try {
            $apiInput = $request->input('api_key');
            $validApiKey = ApiKey::where('key', $apiInput)->first();
            if ($validApiKey){

            $employee = Employee::with('position')->get();
            return response()->json([
                'code' => '200',
                'status' => 'OK',
                'data' => $employee
            ], 200);
            }else{
                return response()->json([
                    'code' => '401',
                    'status' => 'UNAUTHORIZED',
                    'data' => 'Unauthorized'
                ], 401);
            }
        }catch (\Exception $e){
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
