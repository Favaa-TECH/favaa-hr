<div wire:ignore.self class="modal fade" id="showPermissionModal" tabindex="-1" aria-labelledby="showPermissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showPermissionModalLabel">Detail Cuti</h5>
                <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>Nama Karyawan</h6>
                            <p>{{ $employeeName }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Status</h6>
                            <p
                                class="badge badge-sm @if ($permissionStatus == 'approved') bg-gradient-success @elseif ($permissionStatus == 'rejected') bg-gradient-danger @elseif ($permissionStatus == 'cancelled') bg-gradient-primary @else bg-gradient-secondary @endif  p-2 text-uppercase">
                                {{ $permissionStatus }}</p>

                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Tanggal Mulai</h6>
                            <p>{{ $permissionStartDate
                            }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Tanggal Berakhir</h6>
                            <p>{{ $permissionEndDate }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6>Tipe Cuti</h6>
                            <p>{{ $permissionType }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Alasan Cuti</h6>
                            <p>{{ $permissionReason }}</p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <button wire:click='downloadProof' class="btn btn-sm bg-gradient-primary">

                                Download Attachment
                            </button>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button wire:click='approvePermission' class="btn btn-sm bg-gradient-success">Approve</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
