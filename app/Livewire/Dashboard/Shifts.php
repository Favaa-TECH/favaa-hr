<?php

namespace App\Livewire\Dashboard;

use App\Models\Shift;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class Shifts extends Component
{
    use WithPagination;

    public $search;
    public function render()
    {
        $dataShift = Shift::latest()->where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.dashboard.shifts', compact('dataShift'));
    }
    #[Rule('required|max:50')]
    public $name;
    #[Rule('required')]
    public $start_time;
    #[Rule('required')]
    public $end_time;
    #[Rule('required')]
    public $shift_type;

    public function store()
    {
        $this->validate();
        Shift::create([
            'name' => $this->name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'shift_type' => $this->shift_type,
        ]);
        $this->dispatch('success', [
            'message' => 'Shift '. $this->name.' berhasil ditambahkan'
        ]);
        $this->reset();
    }

    public $showForm = false;
    public function showFormShift()
    {
        $this->showForm = true;
    }
    public function closeFormShift()
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public $editMode;
    public $shift_id;
    public function showFormEditShift($id)
    {
        $this->editMode = true;
        $this->showForm = true;
        $this->shift_id = $id;
        $shift = Shift::find($id);
        $this->name = $shift->name;
        $this->start_time = $shift->start_time;
        $this->end_time = $shift->end_time;
        $this->shift_type = $shift->shift_type;
    }
    public function update()
    {
        $this->validate();
        Shift::where('id', $this->shift_id)->update([
            'name' => $this->name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'shift_type' => $this->shift_type,
        ]);
        $this->dispatch('success', [
            'message' => 'Shift '. $this->name.' berhasil diupdate'
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
        $shift = Shift::find($this->deleteId);
        $shift->delete();
        $this->dispatch('success', [
            'message' => 'Shift '. $shift->name.' berhasil dihapus'
        ]);
    }
}
