<?php

namespace App\Http\Controllers\AuthAPI;

use App\Models\User;
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
                'error' => true,
                'message' => $validator->errors()->first()
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'error' => true,
                'message' => 'Email atau Password salah!'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json([
            'message' => 'Login Berhasil',
            'token' => $token,
            'user' => $user->name,
            'role' => $user->role,
            'employee_id' => $user->employee_id,
            'photo' => $user->photo,
        ],200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
