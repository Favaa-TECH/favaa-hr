<?php

namespace App\Http\Controllers\Attendance;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\LateTolerance;
use App\Models\ClockInTolerance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        return view('dashboard.attendance');
    }

    public function indexEmployee()
    {

        $date = Carbon::now()->format('Y-m-d');
        $userEmployee = Employee::with('position')->find(Auth::user()->employee_id);
        $dataUserEmployeeID = $userEmployee->id;
        $cekAlreadyPresent = DB::table('attendance')->where('check_out_date', $date)->where('employee_id', $dataUserEmployeeID)->count();
        $cekAlreadyCheckIn = DB::table('attendance')->where('check_in_date', $date)->where('employee_id', $dataUserEmployeeID)->count();
        $dataCheckInToday = DB::table('attendance')->where('check_in_date', $date)->where('employee_id', $dataUserEmployeeID)->first();
        $dataCheckOutToday = DB::table('attendance')->where('check_out_date', $date)->where('employee_id', $dataUserEmployeeID)->first();

        $startDate = Carbon::now()->subDays(5)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $dataSchedule = Schedule::where('employee_id', $dataUserEmployeeID)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
        $shiftStartTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->start_time);
        $shiftEndTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->end_time);
        $canCheckIn = $shiftStartTime->copy()->subMinutes(15);
        $canPresenceCheck = $now >= $canCheckIn;



        $canCheckOut = $shiftEndTime->copy();
        $canCheckOutCheck = $now >= $canCheckOut;
        $attendanceHistory = DB::table('attendance')
            ->where('employee_id', $dataUserEmployeeID)
            ->whereNotNull('check_out_date')
            ->whereDate('check_in_date', '>=', $startDate)
            ->whereDate('check_in_date', '<=', $endDate)
            ->orderBy('check_in_date', 'desc')
            ->get();

        $passWorkTimeCheck = false;

        if ($cekAlreadyCheckIn <= 0 && $now >= $canCheckOut) {
            $passWorkTimeCheck = true;
        }

        return view('employee.home', compact('passWorkTimeCheck', 'shiftEndTime', 'shiftStartTime', 'cekAlreadyCheckIn', 'canCheckOutCheck', 'canPresenceCheck', 'cekAlreadyPresent', 'dataCheckInToday', 'dataCheckOutToday', 'userEmployee', 'attendanceHistory', 'dataSchedule'));
    }

    public function presence()
    {
        $date = date('Y-m-d');
        $userEmployee = User::find(Auth::user()->id);
        $dataUserEmployeeID = $userEmployee->employee_id;
        $dataEmployee = DB::table('employees')->where('id', $dataUserEmployeeID)->first();
        $dataOutlet = DB::table('outlets')->where('id', $dataEmployee->outlet_id)->first();
        $outlet_lat = $dataOutlet->latitude;
        $outlet_long = $dataOutlet->longitude;
        $cek = DB::table('attendance')->where('check_in_date', $date)->where('employee_id', $dataUserEmployeeID)->count();

        return view('employee.presence', compact('dataEmployee','cek', 'outlet_lat', 'outlet_long'));
    }

    //Menghitung Jarak Radius
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function store(Request $request)
    {

        $request->validate([
            'image' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        $userEmployee = User::find(Auth::user()->id);
        $dataUserEmployeeID = $userEmployee->employee_id;
        $dataEmployee = DB::table('employees')->where('id', $dataUserEmployeeID)->first();
        $dataOutlet = DB::table('outlets')->where('id', $dataEmployee->outlet_id)->first();
        $outlet_lat = $dataOutlet->latitude;
        $outlet_long = $dataOutlet->longitude;

        $distance = $this->distance($outlet_lat, $outlet_long, $request->lat, $request->long);
        $radius = round($distance['meters']);

        $lat = $request->lat;
        $long = $request->long;
        $id = Auth::user()->id;
        $presence_date = date('Y-m-d');
        $presence_time = date('H:i:s');
        $check_in_time = strtotime($presence_time);
        $check_in_time = strtotime($presence_time);


        $scheduleShift = Schedule::where('employee_id', $dataUserEmployeeID)->where('start_date', '<=', $presence_date)->where('end_date', '>=', $presence_date)->first();

        if (!$scheduleShift) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada jadwal kerja saat ini'], 400);
        }

        $shift = Shift::find($scheduleShift->shift_id);
        $shiftStartTime = strtotime($shift->start_time);


        $lateTolerance = LateTolerance::first();
        $lateToleranceTime = $lateTolerance->late_tolerance_time * 60;
        $clockInTolerance = ClockInTolerance::first();
        $clockInToleranceTime = $clockInTolerance->clock_in_tolerance_time * 60;

        $timeDifference = $check_in_time - $shiftStartTime;

        if ($timeDifference > $clockInToleranceTime) {
            $presence_status = 'Absent';
        } else if ($timeDifference > $lateToleranceTime) {
            $presence_status = 'Late';
        } else {
            $presence_status = 'Present';
        }

        $imageNameIn = $id . '_' . 'In' . '_' . 'image_' . time() . '.' . 'png';
        $imageNameOut = $id . '_' . 'Out' . '_' . 'image_' . time() . '.' . 'png';
        $data = [
            'employee_id' => $dataUserEmployeeID,
            'check_in_time' => $presence_time,
            'check_in_date' => $presence_date,
            'check_in_latitude' => $lat,
            'check_in_longitude' => $long,
            'photo_in' => $imageNameIn,
            'status' => $presence_status,
        ];


        $cek = DB::table('attendance')->where('check_in_date', $presence_date)->where('employee_id', $dataUserEmployeeID)->count();
        $cekAlreadyPresent = DB::table('attendance')->where('check_out_date', $presence_date)->where('employee_id', $dataUserEmployeeID)->count();
        if ($radius > 15) {
            return response()->json(['status' => 'error-out-of-radius']);
        } else {
            if ($cekAlreadyPresent > 0) {
                return response()->json(['status' => 'error-already-present']);
            } else if ($cek > 0) {
                $data = [
                    'employee_id' => $dataUserEmployeeID,
                    'check_out_time' => $presence_time,
                    'check_out_date' => $presence_date,
                    'check_out_latitude' => $lat,
                    'check_out_longitude' => $long,
                    'photo_out' => $imageNameOut,
                ];

                $update = DB::table('attendance')->where('check_in_date', $presence_date)->where('employee_id', $dataUserEmployeeID)->update($data);
                if ($update) {
                    $image = $request->file('image');
                    $image->storeAs('attendance/photos', $imageNameOut, 'public');
                    return response()->json(['status' => 'success-check-out']);
                } else {
                    return response()->json(['status' => 'error']);
                }
            } else if ($cek == 0) {
                $saveAttendance = DB::table('attendance')->insert($data);
                if ($saveAttendance) {
                    $image = $request->file('image');
                    $image->storeAs('attendance/photos', $imageNameIn, 'public');
                    return response()->json(['status' => 'success-check-in']);
                } else {
                    return response()->json(['status' => 'error']);
                }
            }
        }
    }
}
