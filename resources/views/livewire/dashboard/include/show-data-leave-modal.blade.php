<div wire:ignore.self class="modal fade" id="showLeaveModal" tabindex="-1" aria-labelledby="showLeaveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLeaveModalLabel">Detail Cuti</h5>
                <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>Nama Karyawan</h6>
                            <p>{{ $EmployeeName }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Status</h6>
                            <p
                                class="badge badge-sm @if ($leaveStatus == 'approved') bg-gradient-success @elseif ($leaveStatus == 'rejected') bg-gradient-danger @elseif ($leaveStatus == 'cancelled') bg-gradient-primary @else bg-gradient-secondary @endif  p-2 text-uppercase">
                                {{ $leaveStatus }}</p>

                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Tanggal Mulai</h6>
                            <p>{{ $leaveStartDate }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Tanggal Berakhir</h6>
                            <p>{{ $leaveEndDate }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6>Tipe Cuti</h6>
                            <p>{{ $leavetype }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Alasan Cuti</h6>
                            <p>{{ $leaveReason }}</p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            @if ($leaveAttachment == null)
                                <h6>No Attachment</h6>
                            @else
                                <button wire:click='downloadAttachment' class="btn  bg-gradient-primary">
                                    Download Attachment
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button wire:click='approveLeave' class="btn btn-sm bg-gradient-success">Approve</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
