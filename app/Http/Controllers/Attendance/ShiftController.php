<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $dataShift = Shift::all();
        return view('dashboard.shift', compact('dataShift'));
    }
    public function store(Request $request ){
        $validatedData = $request->validate([
            'shift_name' => 'required',
            'start_time' => 'required',
            'shift_type' => 'required',
            'shift_duration' => 'required',
        ]);

        if ($validatedData) {
            Shift::create($validatedData);
            return redirect()->route('shift.index')->with('success', 'Shift has been added');
        }
    }
}
