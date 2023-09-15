<?php

namespace App\Http\Controllers\Api\Attendance;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\ApiKey;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\LateTolerance;
use App\Models\ClockInTolerance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AttendanceController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
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

        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

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

        $imageNameIn = $id . '_' . 'In' . '_' . 'image_' . time() . '.' . 'jpg';
        $imageNameOut = $id . '_' . 'Out' . '_' . 'image_' . time() . '.' . 'jpg';
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
            return response()->json(['status' => 'error', 'message' => 'Out of radius'], 400);
        } else {
            if ($cekAlreadyPresent > 0) {
                return response()->json(['status' => 'error', 'message' => 'Already present'], 400);
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
                    return response()->json(['status' => 'success', 'message' => 'Check out successful']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to update attendance'], 500);
                }
            } else if ($cek == 0) {
                $saveAttendance = DB::table('attendance')->insert($data);

                if ($saveAttendance) {
                    $image = $request->file('image');
                    $image->storeAs('attendance/photos', $imageNameIn, 'public');
                    return response()->json(['status' => 'success', 'message' => 'Check in successful']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to save attendance'], 500);
                }
            }
        }
    }


    public function getHistory($id)
    {
        try {
            $attendance = Attendance::where('employee_id', $id)->get();
            if($attendance->count() > 0){
                return response()->json([
                    'status' => 'success',
                    'data' => $attendance
                ], 200);
            }else if($attendance->count() == 0){
                return response()->json([
                    'status' => 'error',
                    'message' => 'data history tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function getAttendanceHistory(Request $request)
    {
        try {
            $dataUserEmployeeID = $request->input('employee_id');

            $startDate = Carbon::now()->subDays(5)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');

            $attendanceHistory = DB::table('attendance')
                ->where('employee_id', $dataUserEmployeeID)
                ->whereDate('check_out_date', '>=', $startDate)
                ->whereDate('check_out_date', '<=', $endDate)
                ->orderBy('check_in_date', 'desc')
                ->get();

            if ($attendanceHistory->count() > 0) {
                return response()->json(['status' => 'success', 'data' => $attendanceHistory], 200);
            } else if ($attendanceHistory->count() == 0) {
                return response()->json(['status' => 'error', 'data' => null], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function getCheckInToday(Request $request)
    {
        try {
            $dataUserEmployeeID = $request->input('employee_id');
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckInToday = DB::table('attendance')
                ->where('check_in_date', $date)
                ->where('employee_id', $dataUserEmployeeID)
                ->get();

            if ($dataCheckInToday->count() > 0) {
                return response()->json(['status' => 'success', 'data' => $dataCheckInToday], 200);
            } else if ($dataCheckInToday->count() == 0) {
                return response()->json(['status' => 'error', 'data' => null], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e], 500);
        }
    }

    public function getCheckOutToday(Request $request)
    {
        try {
            $dataUserEmployeeID = $request->input('employee_id');
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckOutToday = DB::table('attendance')
                ->where('check_out_date', $date)
                ->where('employee_id', $dataUserEmployeeID)
                ->get();

            if ($dataCheckOutToday->count() > 0) {
                return response()->json(['status' => 'success', 'data' => $dataCheckOutToday], 200);
            } else if ($dataCheckOutToday->count() == 0) {
                return response()->json(['status' => 'error', 'data' => null], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e], 500);
        }
    }


    public function getHistoryPA(Request $request){
        try {
            $apiInput = $request->input('api_key');
            $validApiKey = ApiKey::where('key', $apiInput)->first();
            if ($validApiKey){
                $attendance = DB::table('attendance')->get();
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'data' => $attendance
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
