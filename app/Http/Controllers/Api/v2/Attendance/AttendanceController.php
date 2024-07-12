<?php

namespace App\Http\Controllers\Api\v2\Attendance;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\LateTolerance;
use App\Models\ClockInTolerance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function getAttendanceHistory(Request $request, $countDay)
    {
        try {
            $dataUserEmployeeID = $request->input('employee_id');

            $startDate = Carbon::now()->subDays($countDay)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');

            $attendanceHistory = DB::table('attendance')
                ->where('employee_id', $dataUserEmployeeID)
                ->whereDate('check_out_date', '>=', $startDate)
                ->whereDate('check_out_date', '<=', $endDate)
                ->orderBy('check_in_date', 'desc')
                ->get();

            if ($attendanceHistory->count() > 0) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Success get attendance history',
                    'data' => $attendanceHistory
                ], 200);
            } else if ($attendanceHistory->count() == 0) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum ada Riwayat Absensi',
                    'data' => []
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Internal Server Error',
            ], 500);
        }
    }


    public function getCheckInToday()
    {
        try {
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckInToday = DB::table('attendance')
                ->where('check_in_date', $date)
                ->where('employee_id', auth()->user()->employee_id)
                ->first();

            if ($dataCheckInToday) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Success get check in today',
                    'data' => [
                        'check_in_time' => $dataCheckInToday->check_in_time,
                        'check_out_time' => $dataCheckInToday->check_out_time,
                    ],
                ], 200);
            } else if (!$dataCheckInToday) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum ada Check In Hari Ini',
                    'data' => null
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
    }

    public function getCheckOutToday()
    {
        try {
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckOutToday = DB::table('attendance')
                ->where('check_out_date', $date)
                ->where('employee_id', auth()->user()->employee_id)
                ->first();

            if ($dataCheckOutToday) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Success get check out today',
                    'data' => [
                        'check_in_time' => $dataCheckOutToday->check_in_time,
                        'check_out_time' => $dataCheckOutToday->check_out_time,
                    ],
                ], 200);
            } else if (!$dataCheckOutToday) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum ada Check Out Hari Ini',
                    'data' => null
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
    }


    public function getDataOutlet()
    {
        try {
            $employee = DB::table('employees')->where('id', auth()->user()->employee_id)->first();
            $dataOutlet = DB::table('outlets')->where('id', $employee->outlet_id)->first();
            if ($dataOutlet) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Success get data outlet',
                    'data' => [
                        'name' => $dataOutlet->nama_ot,
                        'address' => $dataOutlet->alamat_ot,
                        'latitude' => $dataOutlet->latitude,
                        'longitude' => $dataOutlet->longitude,
                    ]
                ], 200);
            } else if (!$dataOutlet) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Data Outlet Kosong',
                    'data' => null
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
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
            return response()->json([
                'code' => '400',
                'status' => 'BAD_REQUEST',
                'message' => 'Anda tidak memiliki jadwal hari ini',
            ], 400);
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
            return response()->json([
                'code' => '400',
                'status' => 'BAD_REQUEST',
                'message' => 'Anda berada di luar radius',
            ], 400);
        } else {
            if ($cekAlreadyPresent > 0) {
                return response()->json([
                    'code' => '400',
                    'status' => 'BAD_REQUEST',
                    'message' => 'Anda sudah melakukan Absensi Hari Ini',
                ], 400);
            } else if ($cek > 0) {
                $data = [
                    'employee_id' => $dataUserEmployeeID,
                    'check_out_time' => $presence_time,
                    'check_out_date' => $presence_date,
                    'check_out_latitude' => $lat,
                    'check_out_longitude' => $long,
                    'photo_out' => $imageNameOut,
                    'status' => $presence_status,
                ];

                $update = DB::table('attendance')->where('check_in_date', $presence_date)->where('employee_id', $dataUserEmployeeID)->update($data);
                if ($update) {
                    $image = $request->file('image');
                    $image->storeAs('attendance/photos', $imageNameOut, 'public');
                    return response()->json([
                        'code' => '200',
                        'status' => 'OK',
                        'message' => 'Success check out',
                        'data' => $data
                    ], 200);

                } else {
                    return response()->json([
                        'code' => '400',
                        'status' => 'BAD_REQUEST',
                        'message' => 'Gagal melakukan Absensi',
                    ], 400);
                }
            } else if ($cek == 0) {
                $saveAttendance = DB::table('attendance')->insert($data);
                if ($saveAttendance) {
                    $image = $request->file('image');
                    $image->storeAs('attendance/photos', $imageNameIn, 'public');
                    return response()->json([
                        'code' => '200',
                        'status' => 'OK',
                        'message' => 'Success check in',
                        'data' => $data
                    ], 200);

                } else {
                    return response()->json([
                        'code' => '400',
                        'status' => 'BAD_REQUEST',
                        'message' => 'Gagal melakukan Absensi',
                    ], 400);

                }
            }
        }
    }


    public function isAlreadyCheckIn()
    {
        try {
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckIn = DB::table('attendance')
                ->where('check_in_date', $date)
                ->where('check_out_date', null)
                ->where('employee_id', auth()->user()->employee_id)
                ->first();

            if ($dataCheckIn) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Anda sudah Check In',
                    'data' => true,
                ], 200);
            } else if (!$dataCheckIn) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Anda belum Check In',
                    'data' => false
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
    }


    public function isAlreadyPresent()
    {
        try {
            $date = Carbon::now()->format('Y-m-d');

            $dataCheckIn = DB::table('attendance')
                ->where('check_in_date', $date)
                ->where('check_out_date', $date)
                ->where('employee_id', auth()->user()->employee_id)
                ->first();

            if ($dataCheckIn) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Anda sudah Absensi Hari Ini',
                    'data' => true,
                ], 200);
            } else if (!$dataCheckIn) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum ada Absensi Hari Ini',
                    'data' => false,
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
    }

    public function checkSchedule()
    {
        try {
            $date = Carbon::now()->format('Y-m-d');
            $userEmployee = Employee::with('position')->find(Auth::user()->employee_id);
            $dataUserEmployeeID = $userEmployee->id;
            $dataSchedule = Schedule::where('employee_id', $dataUserEmployeeID)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
            if ($dataSchedule) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Success get schedule',
                    'data' => true
                ], 200);
            } else if (!$dataSchedule) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum ada Jadwal Hari Ini',
                    'data' => false
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
    }





    public function canCheckOutCheck()
    {
        try {
            $now = Carbon::now();
            $date = Carbon::now()->format('Y-m-d');
            $userEmployee = Employee::with('position')->find(Auth::user()->employee_id);
            $dataUserEmployeeID = $userEmployee->id;
            $dataSchedule = Schedule::where('employee_id', $dataUserEmployeeID)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
            $shiftEndTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->end_time);
            $canCheckOut = $shiftEndTime->copy();
            $canCheckOutCheck = $now >= $canCheckOut;

            if ($canCheckOutCheck) {
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'message' => 'Can Check Out',
                    'data' => true
                ], 200);
            } else if (!$canCheckOutCheck) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Belum bisa Check Out Hari Ini',
                    'data' => false
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }
        // $shiftEndTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->end_time);
        // $canCheckOut = $shiftEndTime->copy();
        // $canCheckOutCheck = $now >= $canCheckOut;

        // if ($canCheckOutCheck) {
        //     return response()->json([
        //         'code' => '200',
        //         'status' => 'OK',
        //         'message' => 'Can Check Out',
        //         'data' => true
        //     ], 200);
        // } else if (!$canCheckOutCheck) {
        //     return response()->json([
        //     'code' => '404',
        //     'status' => 'NOT_FOUND',
        //     'message' => 'Belum bisa Check Out Hari Ini',
        //     'data' => false
        // ], 404);
        // }
    }

    public function canCheckInCheck()
    {
        try {
            $now = Carbon::now();
            $date = Carbon::now()->format('Y-m-d');
            $userEmployee = Employee::with('position')->find(Auth::user()->employee_id);
            $dataUserEmployeeID = $userEmployee->id;
            $dataSchedule = Schedule::where('employee_id', $dataUserEmployeeID)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
            $shiftStartTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->start_time);
            $canCheckIn = $shiftStartTime->copy()->subMinutes(15);
            $canPresenceCheck = $now >= $canCheckIn;
            $shiftEndTime = Carbon::createFromFormat('H:i:s', $dataSchedule->shift->end_time);
            $canCheckOut = $shiftEndTime->copy();
            $canCheckOutCheck = $now >= $canCheckOut;
            $isAlreadyCheckIn = DB::table('attendance')->where('check_in_date', $date)->where('check_out_date', null)->where('employee_id', $dataUserEmployeeID)->first() != null;

            if ($canPresenceCheck) {
                if(!$isAlreadyCheckIn ){
                    return response()->json([
                        'code' => '200',
                        'status' => 'OK',
                        'message' => 'Can Check In',
                        'data' => true
                    ], 200);
                } else {
                    if($canCheckOutCheck && $isAlreadyCheckIn){
                        return response()->json([
                            'code' => '200',
                            'status' => 'OK',
                            'message' => 'Can Check Out',
                            'data' => true
                        ], 200);
                    } else {
                        return response()->json([
                            'code' => '404',
                            'status' => 'NOT_FOUND',
                            'message' => 'Belum Masuk Jam Pulang',
                            'data' => false
                        ], 404);
                    }
                }
            } else if (!$canPresenceCheck || $isAlreadyCheckIn) {
                if(!$canCheckOutCheck && $isAlreadyCheckIn){
                    return response()->json([
                        'code' => '404',
                        'status' => 'NOT_FOUND',
                        'message' => 'Belum Masuk Jam Pulang',
                        'data' => false
                    ], 404);
                }else{
                    return response()->json([
                        'code' => '404',
                        'status' => 'NOT_FOUND',
                        'message' => 'Belum Masuk Jam Kerja',
                        'data' => false
                    ], 404);
                }
            } else {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Anda sudah Check In',
                    'data' => false
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'message' => $e
            ], 500);
        }

    }










}
