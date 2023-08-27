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
    public function render()
    {
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year; // Mengambil tahun
        $currentMonth = $currentDate->month;

        $employeeAttendance = Employee::with('attendance')->get();
        $attendance = Employee::with('attendance')->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();


        return view('livewire.dashboard.attendances',[
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

    public function closeModal(){
        $this->dispatch('closeModal');
    }

    public function resetForm()
    {
        $this->resetValidation();
    }
}
