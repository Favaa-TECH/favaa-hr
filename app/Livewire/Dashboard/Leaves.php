<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class Leaves extends Component
{
    use WithPagination;
    public function render()
    {
        $dataLeave = Leave::with('employee')->latest()->paginate(10);
        return view('livewire.dashboard.leaves',compact('dataLeave'));
    }


    public $leaveId;
    public $leaveStatus;
    public $leaveReason;
    public $leaveStartDate;
    public $leaveEndDate;
    public $leavetype;
    public $EmployeeName;
    public $leaveAttachment;

    public function showModalLeave($id){
        $this->leaveId = $id;
        $leave = Leave::with('employee')->find($id);
        $this->leaveStatus = $leave->status;
        $this->leaveReason = $leave->leave_reason;
        $this->leaveStartDate = $leave->start_date;
        $this->leaveEndDate = $leave->end_date;
        $this->leavetype = $leave->leave_type;
        $this->EmployeeName = $leave->employee->name;
        $this->leaveAttachment = $leave->leave_attachment;
    }

    public function approveLeave(){
        Leave::where('id',$this->leaveId)->update([
            'status' => 'approved'
        ]);
        $this->dispatch('success',[
            'message' => 'Pengajuan cuti berhasil disetujui'
        ]);
    }
    #[Rule('required')]
    public $rejectedReason;

    public function showModalReject($id){
        $this->leaveId = $id;
    }

    public function rejectLeave(){
        $this->validate();

        Leave::where('id',$this->leaveId)->update([
            'status' => 'rejected',
            'rejected_reason' => $this->rejectedReason
        ]);

        $this->dispatch('success',[
            'message' => 'Pengajuan cuti berhasil ditolak'
        ]);
    }

    public function resetForm(){
        $this->resetValidation();
        $this->reset();
    }

    public function confirmDelete($id){
        $this->leaveId = $id;
        $leave = Leave::find($id);
        $this->leaveStartDate = $leave->start_date;
        $this->leaveEndDate = $leave->end_date;
    }

    public function delete(){
        $days_requested = Carbon::parse($this->leaveStartDate)->diffInDays($this->leaveEndDate);

        $employee = Leave::find($this->leaveId)->employee;
        $employee->leave_quota += $days_requested;
        $employee->save();

        Leave::find($this->leaveId)->delete();
        $this->dispatch('success',[
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function downloadAttachment(){
        $leave = Leave::find($this->leaveId);
        return response()->download(storage_path('app/public/' . $leave->leave_attachment));
    }
}
