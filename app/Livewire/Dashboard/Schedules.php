<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Shift;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class Schedules extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        $dataEmployee = Employee::all();
        $dataShift = Shift::all();
        $scheduleQuery = Schedule::query();

        if ($this->search) {
            // Melakukan query pencarian berdasarkan nama karyawan atau atribut lain yang sesuai dengan input search
            $scheduleQuery->whereHas('employee', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }
        $dataSchedule = Schedule::latest()->paginate(10);

        return view('livewire.dashboard.schedules', compact('dataShift', 'dataEmployee', 'dataSchedule'));
    }

    public $showForm = false;
    public $editMode = false;

    public function showFormSchedule()
    {
        $this->showForm = true;
        $this->dispatch('show-form-schedule');
    }

    public function closeFormSchedule()
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->reset();
    }

    #[Rule('required')]
    public $shift_id;
    #[Rule('required|unique:schedules,employee_id')]
    public $employee_id;
    #[Rule('required')]
    public $start_date;
    #[Rule('required')]
    public $end_date;

    public function store()
    {

        $this->validate();
        Schedule::create([
            'shift_id' => $this->shift_id,
            'employee_id' => $this->employee_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('success', [
            'message' => 'Schdule berhasil dibuat'
        ]);
        $this->reset();
    }
    public $schedule_id;
    public function showFormEditSchedule($id)
    {
        $this->editMode = true;
        $this->showForm = true;
        $dataSchedule = Schedule::find($id);
        $this->shift_id = $dataSchedule->shift_id;
        $this->employee_id = $dataSchedule->employee_id;
        $this->start_date = $dataSchedule->start_date;
        $this->end_date = $dataSchedule->end_date;
        $this->schedule_id = $dataSchedule->id;
        $this->dispatch('show-form-schedule');

    }

    public function update()
    {
        $this->validate([
            'shift_id' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        Schedule::where('id', $this->schedule_id)->update([
            'shift_id' => $this->shift_id,
            'employee_id' => $this->employee_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
        $this->dispatch('success', [
            'message' => 'Schdule berhasil diupdate'
        ]);
        $this->reset();
    }
    public $deleteId;
    public function confirmDelete($id)
    {
       $this->deleteId = $id;
    }

    public function delete()
    {
        Schedule::where('id', $this->deleteId)->delete();
        $this->dispatch('success', [
            'message' => 'Schdule berhasil dihapus'
        ]);
        $this->reset();
    }

}
