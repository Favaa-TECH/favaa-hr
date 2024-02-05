<?php

namespace App\Http\Controllers\AuthAPI;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'BAD_REQUEST',
                'code' => 400,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'status' => 'UNAUTHORIZED',
                'code' => 401,
                'message' => 'Email atau Password salah!'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        $employee = Employee::where('id', $user->employee_id)->first();
        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'message' => 'Login Success!',
            'token' => $token,
            'data' => [
                'id' => $user->id,
                'employee_id' => $user->employee_id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'position' => $employee->position->name,
                'photo' => $employee->photo,
            ]
        ],200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'message' => 'Logout Success!',
        ],200);
    }
}
