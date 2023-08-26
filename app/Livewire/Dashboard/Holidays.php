<?php

namespace App\Livewire\Dashboard;

use App\Models\Holiday;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\SpecialHoliday;

class Holidays extends Component
{
    use WithPagination;
    public $searchHoliday;
    public $searchSpecialHoliday;
    public $searchEmployee;
    public function render()
    {
        $employees = Employee::with('specialHolidays')->latest()->where('name', 'like', "%{$this->searchEmployee}%")->paginate(10);
        $holidaysQuery = Holiday::query();

        if ($this->searchHoliday) {
            // Melakukan query pencarian berdasarkan nama karyawan atau atribut lain yang sesuai dengan
            $holidaysQuery->whereHas('employee', function ($query) {
                $query->where('name', 'like', '%' . $this->searchHoliday . '%');
            });
        }
        $dataHoliday = $holidaysQuery->latest()->paginate(10);
        $dataSpecialHoliday = SpecialHoliday::latest()->where('name', 'like', "%{$this->searchSpecialHoliday}%")->paginate(10);
        return view('livewire.dashboard.holidays', compact('employees', 'dataHoliday', 'dataSpecialHoliday'));
    }

    public $showForm = false;
    public function showFormHoliday()
    {
        $this->showForm = true;
        $this->dispatch('show-form-holiday');
    }
    public function closeFormHoliday()
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public $employee_id;
    public $choosen_day;

    public function store()
    {
        $this->validate([
            'employee_id' => 'required|unique:holidays,employee_id',
            'choosen_day' => 'required',
        ]);
        Holiday::create([
            'employee_id' => $this->employee_id,
            'choosen_day' => $this->choosen_day,
        ]);
        $this->dispatch('success', [
            'message' => 'berhasil ditambahkan'
        ]);
        $this->reset();
    }

    public $editMode = false;
    public $holiday_id;
    public function showFormEditEmployee($id)
    {
        $this->editMode = true;
        $this->showForm = true;
        $this->holiday_id = $id;
        $holiday = Holiday::find($id);
        $this->employee_id = $holiday->employee_id;
        $this->choosen_day = $holiday->choosen_day;
    }
    public function update()
    {
        $this->validate([
            'employee_id' => 'required',
            'choosen_day' => 'required',
        ]);
        $holiday = Holiday::find($this->holiday_id);
        $holiday->where('id', $this->holiday_id)->update([
            'employee_id' => $this->employee_id,
            'choosen_day' => $this->choosen_day,
        ]);
        $this->dispatch('success', [
            'message' => 'berhasil diubah'
        ]);
        $this->reset();
        $this->showForm = false;
    }

    public $deleteId;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $holiday =  Holiday::find($this->deleteId);
        $this->dispatch('success', [
            'message' => 'Data ' . $holiday->name . ' berhasil dihapus'
        ]);
        $holiday->delete();
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
    }

    #[Rule('required|max:100|min:5')]
    public $specialHolidayName;
    #[Rule('required|date|before_or_equal:specialHolidayEndDate')]
    public $specialHolidayStartDate;
    #[Rule('required|date|after_or_equal:specialHolidayStartDate')]
    public $specialHolidayEndDate;

    public $editModeSpecialHoliday = false;
    public $specialHolidayId;


    public function storeSpecialHoliday()
    {
        $this->validate();
        $saveData = SpecialHoliday::create([
            'name' => $this->specialHolidayName,
            'start_date' => $this->specialHolidayStartDate,
            'end_date' => $this->specialHolidayEndDate,
        ]);

        if ($saveData) {
            $this->dispatch('success', [
                'message' => 'berhasil ditambahkan'
            ]);
            $this->reset();
            return redirect()->route('holiday.index');
        }
    }

    public function showFormEditSpecialHoliday($id)
    {
        $this->editModeSpecialHoliday = true;
        $this->specialHolidayId = $id;
        $specialHoliday = SpecialHoliday::find($id);
        $this->specialHolidayName = $specialHoliday->name;
        $this->specialHolidayStartDate = $specialHoliday->start_date;
        $this->specialHolidayEndDate = $specialHoliday->end_date;
    }

    public function updateSpecialHoliday()
    {
        $this->validate();
        $saveData = SpecialHoliday::where('id', $this->specialHolidayId)->update([
            'name' => $this->specialHolidayName,
            'start_date' => $this->specialHolidayStartDate,
            'end_date' => $this->specialHolidayEndDate,
        ]);

        if ($saveData) {
            $this->dispatch('success', [
                'message' => 'berhasil diubah'
            ]);
            $this->reset();
        }
    }

    public function confirmDeleteSpecialHoliday($id)
    {
        $this->specialHolidayId = $id;
    }

    public function deleteSpecialHoliday()
    {
        $specialHoliday = SpecialHoliday::find($this->specialHolidayId);
        $specialHoliday->delete();
        $this->dispatch('success', [
            'message' => 'Data ' . $specialHoliday->name . ' berhasil dihapus'
        ]);
    }

    public $attachEmployeeId;
    public $specialHolidayIdEmployee;
    public $notesAttachSH;
    public $editModeAttachSH = false;

    public function attachSpecialHoliday()
    {
        $this->validate([
            'attachEmployeeId' => 'required',
            'specialHolidayIdEmployee' => 'required',
            'notesAttachSH' => 'max:50|nullable',
        ]);

        $employee = Employee::find($this->attachEmployeeId);
        $employee->specialHolidays()->syncWithoutDetaching($this->specialHolidayIdEmployee, ['notes' => $this->notesAttachSH]);
        if ($employee->specialHolidays->contains($this->specialHolidayIdEmployee)) {
            $this->dispatch('success', [
                'message' => $employee->name . ' sudah terdaftar'
            ]);
        } else {
            $this->dispatch('success', [
                'message' => 'berhasil ditambahkan'
            ]);
        }
        $this->reset();
    }


    public function showModalAttachSH($id)
    {
        $this->editModeAttachSH = true;
        $this->attachEmployeeId = $id;
        $employee = Employee::with('specialHolidays')->find($id);
        $this->specialHolidayIdEmployee = $employee->specialHolidays->pluck('id');
    }

    public function updateAttachSpecialHoliday()
    {
        $this->validate([
            'attachEmployeeId' => 'required',
            'specialHolidayIdEmployee' => 'required',
            'notesAttachSH' => 'max:50|nullable',
        ]);

        $employee = Employee::find($this->attachEmployeeId);
        $employee->specialHolidays()->sync($this->specialHolidayIdEmployee, ['notes' => $this->notesAttachSH]);

        $this->dispatch('success', [
            'message' => 'berhasil ditambahkan'
        ]);

        $this->reset();
    }

    public function confirmDeleteAttachSH($id)
    {
        $this->attachEmployeeId = $id;
    }

    public function deleteAttachSH()
    {
        $employee = Employee::find($this->attachEmployeeId);
        $employee->specialHolidays()->detach($this->specialHolidayIdEmployee);
        $this->dispatch('success', [
            'message' => 'berhasil dihapus'
        ]);
    }
}
