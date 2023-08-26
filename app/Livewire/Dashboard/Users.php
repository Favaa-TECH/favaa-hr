<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Users extends Component
{
    use WithFileUploads;
    use WithPagination;
    #[Rule('required|max:50')]
    public $name;
    #[Rule('required|max:50|unique:users,email|email')]
    public $email;
    #[Rule('required|max:50|min:8')]
    public $password;
    #[Rule('required|same:password')]
    public $password_confirmation;
    #[Rule('required|max:50')]
    public $role;
    #[Rule('image|mimes:jpeg,png,jpg,gif|max:2048|nullable')]
    public $photo;

    public $oldPhoto;
    public $showForm = false;


    public $search;
    public function render()
    {
        $dataUsers = User::latest()->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->paginate(5);
        return view('livewire.dashboard.users', compact('dataUsers'));
    }


    public function showFormUser()
    {
        $this->showForm = true;
    }

    public function closeFormUser()
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function store()
    {

        $this->validate();
        if ($this->photo == null) {
            $photo = 'photos/default-employee-photo.jpeg';
        } else {
            $photo = $this->photo->store('photos', 'public');
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'photo' => $photo,
            'password' => bcrypt($this->password),
        ]);


        $this->dispatch('success', ['message' => 'Data User ' . $this->name . ' berhasil disimpan!']);
        $this->reset();
    }
    public $editMode = false;
    public $userId;
    public $oldPassword;
    public function showUpdateForm($id)
    {
        $this->editMode = true;
        $this->showForm = true;
        $user = User::find($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->oldPhoto = $user->photo;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $this->userId,
            'role' => 'required|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'password' => 'max:50|min:8|nullable',
            'password_confirmation' => 'same:password'

        ]);

        $user = User::find($this->userId);
        if ($this->password !== null) {
            // Validasi password lama sebelum pembaruan
            if (!Hash::check($this->oldPassword, $user->password)) {
                $this->addError('oldPassword', 'Password lama tidak cocok');
                return;
            }

            // Pembaruan password baru
            $hashedPassword = bcrypt($this->password);
            $user->password = $hashedPassword;
        }

        if ($this->photo != null) {

            if ($user->photo != 'photos/default-employee-photo.jpeg') {
                Storage::delete('public/' . $user->photo);
            }
            // Menyimpan foto baru
            $photoPath = $this->photo->store('photos', 'public');
            $user->photo = $photoPath;
        }
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->save();

        $this->dispatch('success', [
            'message' => 'Data ' . $this->name . ' berhasil diperbarui'
        ]);

        $this->reset();  // Reset properti setelah pembaruan
    }

    public $deleteId;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $user =  User::find($this->deleteId);
        if ($user->photo != 'photos/default-employee-photo.jpeg') {
            Storage::delete('public/' . $user->photo);
        }
        $this->dispatch('success', [
            'message' => 'Data ' . $user->name . ' berhasil dihapus'
        ]);
        $user->delete();
    }
}
