<?php

namespace App\Livewire\Dashboard;

use App\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {

        $dataPermission = Permission::with('employee')->latest()->paginate(10);
        return view('livewire.dashboard.permissions', compact('dataPermission'));
    }

    public $employeeName,
        $permissionStartDate,
        $permissionEndDate,
        $permissionReason,
        $permissionStatus,
        $permissionType,
        $permissionId;

        public function showModalPermission($id){
            $this->permissionId = $id;
            $permission = Permission::with('employee')->find($id);
            $this->employeeName = $permission->employee->name;
            $this->permissionStartDate = $permission->start_date;
            $this->permissionEndDate = $permission->end_date;
            $this->permissionReason = $permission->permission_reason;
            $this->permissionStatus = $permission->status;
            $this->permissionType = $permission->permission_type;
        }

        public function approvePermission(){
            $permission = Permission::find($this->permissionId);
            $permission->update([
                'status' => 'approved'
            ]);
            $this->dispatch('success', [
                'message' => 'Berhasil menyetujui izin.'
            ]);
        }

        public $rejectedReason;

        public function showModalReject($id){
            $this->permissionId = $id;
        }

        public function rejectPermission(){
            $this->validate([
                'rejectedReason' => 'required|max:255'
            ]);
            $permission = Permission::find($this->permissionId);
            $permission->update([
                'status' => 'rejected',
                'rejected_reason' => $this->rejectedReason
            ]);
            $this->dispatch('success', [
                'message' => 'Berhasil menolak izin.'
            ]);
        }

        public function resetForm(){
            $this->resetValidation();
            $this->reset();
        }


        public function confirmDelete($id){
            $this->permissionId = $id;

        }

        public function delete(){
            $permission = Permission::find($this->permissionId);
            Storage::delete('public/' . $permission->proof);
            $permission->delete();
            $this->dispatch('success', [
                'message' => 'Berhasil menghapus izin.'
            ]);
        }

        public function downloadProof(){
            $permission = Permission::find($this->permissionId);
            return response()->download(storage_path('app/public/' . $permission->proof));
        }
}
