<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function index()
    {
        $users = User::all();
        return view('dashboard.user', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'password' => 'required|confirmed|max:50|min:8',
            'role' => 'required|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData) {
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create($validatedData);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = strtolower(str_replace(' ', '_', $user->id . '_' . $user->name)) . '.' . $extension;
            $file->storeAs('photos', $fileName, 'public');
            $user->photo = $fileName;
            $user->save();

            $request->session()->flash('success', 'Data User berhasil disimpan!');
            return redirect()->route('user.index');
        } else {
            // Tindakan yang diambil ketika validasi gagal
            return redirect()->back()->withErrors('Terjadi kesalahan validasi')->withInput();
        }
    }
}
