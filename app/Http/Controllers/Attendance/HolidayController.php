<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $dataHoliday = Holiday::all();
        return view('dashboard.holiday',compact('employees','dataHoliday'));
    }

    public function store(Request $request)
    {
        $ValidatedData = $request->validate([
            'employee_id' => 'required',
            'choosen_day' => 'required',
        ]);
        if ($ValidatedData) {
            Holiday::create($ValidatedData);
            return redirect()->route('holiday.index')->with('success', 'Holiday has been added');
        }

    }

    public function delete($id){
        $holiday = Holiday::find($id);
        $holiday->delete();
        return redirect()->route('holiday.index')->with('success', 'Holiday has been deleted');
    }


}
