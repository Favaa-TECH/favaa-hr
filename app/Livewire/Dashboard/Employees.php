<?php

namespace App\Livewire\Dashboard;

use App\Models\Outlet;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Position;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Employees extends Component
{

    use WithFileUploads;
    use WithPagination;

    #[Rule('required|min:5|max:255')]
    public $name;
    #[Rule('required|unique:employees|email')]
    public $email;
    #[Rule('required|min:10')]
    public $address;
    #[Rule('required|min:5|max:30')]
    public $account_number;
    #[Rule('required|min:10|numeric')]
    public $phone;
    #[Rule('required|numeric')]
    public $position_id;
    #[Rule('required')]
    public $outlet_id;
    #[Rule('required')]
    public $date_of_birth;
    #[Rule('required')]
    public $gender;
    #[Rule('image|mimes:jpeg,png,jpg,gif|max:2048|nullable')]
    public  $photo;

    public $employee_id;
    public $oldPhoto;

    public $showForm = false;


    public function showFormEmployee()
    {
        $this->showForm = true;
    }

    public $editMode = false;
    public function showFormEditEmployee($id)
    {
        $dataEmployee = Employee::with('position', 'outlet')->find($id);
        $this->employee_id = $id;
        $this->name = $dataEmployee->name;
        $this->email = $dataEmployee->email;
        $this->address = $dataEmployee->address;
        $this->account_number = $dataEmployee->account_number;
        $this->phone = $dataEmployee->phone;
        $this->position_id = $dataEmployee->position_id;
        $this->outlet_id = $dataEmployee->outlet_id;
        $this->date_of_birth = $dataEmployee->date_of_birth;
        $this->gender = $dataEmployee->gender;
        $this->oldPhoto = $dataEmployee->photo;
        $this->showForm = true;
        $this->editMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|unique:employees,email,' . $this->employee_id,
            'address' => 'required|min:10',
            'account_number' => 'required|min:5|max:30',
            'phone' => 'required|min:10',
            'position_id' => 'required',
            'outlet_id' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048|nullable'
        ]);
        $employee = Employee::find($this->employee_id);
        if ($this->photo != null) {
            $photo = $this->photo->store('photos', 'public');
            if ($employee->photo != 'photos/default-employee-photo.jpeg') {
                Storage::delete('public/' . $employee->photo);
            }
            $employee = Employee::where('id', $this->employee_id)->update([
                'name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
                'account_number' => $this->account_number,
                'phone' => $this->phone,
                'position_id' => $this->position_id,
                'outlet_id' => $this->outlet_id,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'photo' => $photo,
            ]);
        } else {
            $employee->name = $this->name;
            $employee->email = $this->email;
            $employee->address = $this->address;
            $employee->account_number = $this->account_number;
            $employee->phone = $this->phone;
            $employee->position_id = $this->position_id;
            $employee->outlet_id = $this->outlet_id;
            $employee->date_of_birth = $this->date_of_birth;
            $employee->gender = $this->gender;
            $employee->photo = $this->oldPhoto;
            $employee->save();
        }

        if ($employee) {
            $this->dispatch('success',[
                'message' => 'Data ' . $this->name . ' berhasil diubah'
            ]);
            $this->reset();
            $this->showForm = false;
        }
    }

    public function closeFormEmployee()
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public $search;
    public function render()
    {
        $dataPosition = Position::all();
        $dataOutlet = Outlet::all();
        $dataEmployee = Employee::with('position', 'outlet')->latest()->where('name', 'like', "%{$this->search}%")->paginate(10);
        return view('livewire.dashboard.employees', compact('dataEmployee', 'dataPosition', 'dataOutlet'));
    }

    public function store()
    {
        $this->validate();
        if ($this->photo == null) {
            $photo = 'photos/default-employee-photo.jpeg';
        } else {
            $photo = $this->photo->store('photos', 'public');
        }

        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'account_number' => $this->account_number,
            'phone' => $this->phone,
            'position_id' => $this->position_id,
            'outlet_id' => $this->outlet_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'photo' => $photo,
        ]);

        $this->dispatch('success',[
            'message' => 'Data ' . $this->name . ' berhasil disimpan'
        ]);
        $this->reset();
    }

    public $deleteId;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }


    public $showDataId, $sName, $sEmail, $sAddress, $sAccountNumber, $sPhone, $sPosition, $sOutlet, $sDateOfBirth, $sGender, $sPhoto;

    public function showModalEmployee($id)
    {
        $this->showDataId = $id;
        $employee = Employee::with('position', 'outlet')->find($id);
        $position = Position::find($employee->position_id);
        $outlet = Outlet::find($employee->outlet_id);
        $this->sName = $employee->name;
        $this->sEmail = $employee->email;
        $this->sAddress = $employee->address;
        $this->sAccountNumber = $employee->account_number;
        $this->sPhone = $employee->phone;
        $this->sPosition = $position->name;
        $this->sOutlet = $outlet->nama_ot;
        $this->sDateOfBirth = $employee->date_of_birth;
        $this->sGender = $employee->gender;
        $this->sPhoto = $employee->photo;
    }

    public function delete()
{
    try {
        $employee =  Employee::find($this->deleteId);

        if (!$employee) {
            throw new \Exception("Employee not found");
        }

        if ($employee->photo != 'photos/default-employee-photo.jpeg') {
            Storage::delete('public/' . $employee->photo);
        }

        $employee->delete();

        $this->dispatch('success', [
            'message' => 'Data ' . $employee->name . ' berhasil dihapus'
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $this->dispatch('error', [
            'message' =>  $e->getMessage()
        ]);
    } catch (\Exception $e) {
        $this->dispatch('error', [
            'message' => "Employee tidak bisa di hapus karena ada keterkaitan data lain"
        ]);
    }
}

}
