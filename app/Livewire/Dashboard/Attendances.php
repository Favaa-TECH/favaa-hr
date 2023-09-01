<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use App\Models\LateTolerance;
use App\Models\ClockInTolerance;

class Attendances extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year; // Mengambil tahun
        $currentMonth = $currentDate->month;

        $employeeAttendance = Employee::with('attendance')->get();
        $attendance = Employee::with(['attendance' => function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('check_in_date', $currentMonth)->whereYear('check_in_date', $currentYear);
        }])->where('name', 'like', '%' . $this->search . '%')->get();


        return view('livewire.dashboard.attendances', [
            'employeeAttendance' => $employeeAttendance,
            'attendance' => $attendance,

        ]);
    }

    public $lateTolerance;
    public $clockInTolerance;

    public function mount()
    {
        $lateTolerance = LateTolerance::first();
        $clockInTolerance = ClockInTolerance::first();

        if ($lateTolerance) {
            $this->lateTolerance = $lateTolerance->late_tolerance_time;
        } else {
            // In case the record is not found, set a default value or handle it accordingly
            $this->lateTolerance = 0; // Default value
        }

        if ($clockInTolerance) {
            $this->clockInTolerance = $clockInTolerance->clock_in_tolerance_time;
        } else {
            // In case the record is not found, set a default value or handle it accordingly
            $this->clockInTolerance = 0; // Default value
        }
    }

    public function updateLateAndClockInTolerance()
    {
        $this->validate([
            'lateTolerance' => 'numeric',
            'clockInTolerance' => 'numeric',
        ]);

        LateTolerance::updateOrCreate(
            [], // Kriteria pencarian, dalam hal ini kosong agar selalu diperbarui atau dibuat baru
            ['late_tolerance_time' => $this->lateTolerance]
        );

        ClockInTolerance::updateOrCreate(
            [], // Kriteria pencarian, dalam hal ini kosong agar selalu diperbarui atau dibuat baru
            ['clock_in_tolerance_time' => $this->clockInTolerance]
        );


        $this->dispatch('success', [
            'message' => 'Berhasil memperbarui toleransi keterlambatan dan toleransi jam masuk.'
        ]);
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function resetForm()
    {
        $this->resetValidation();
    }

    public $employeeName,
        $check_in_time,
        $check_in_date,
        $check_out_time,
        $check_out_date,
        $status,
        $photo_in,
        $photo_out,
        $employee_id,
        $check_in_latitude,
        $check_in_longitude,
        $check_out_latitude,
        $check_out_longitude;

    public function showModalDataAttendance($id)
    {
        $this->employee_id = $id;
        $attendanceData = Attendance::with('employee')->where('id', $id)->first();
        $this->employeeName = $attendanceData->employee->name;
        $this->check_in_time = $attendanceData->check_in_time;
        $this->check_in_date = $attendanceData->check_in_date;
        $this->check_out_time = $attendanceData->check_out_time;
        $this->check_out_date = $attendanceData->check_out_date;
        $this->status = $attendanceData->status;
        $this->photo_in = $attendanceData->photo_in;
        $this->photo_out = $attendanceData->photo_out;
        $this->check_in_latitude = $attendanceData->check_in_latitude;
        $this->check_in_longitude = $attendanceData->check_in_longitude;
        $this->check_out_latitude = $attendanceData->check_out_latitude;
        $this->check_out_longitude = $attendanceData->check_out_longitude;
    }
}
