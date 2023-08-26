<div wire:ignore class="modal fade" id="settingAttendance" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="settingAttendanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="specialHolidayLabel">Pengaturan Absensi
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="lateTolerance" class="form-label">
                                    <h6>Late Tolerance Attendance (In Minute)</h6>
                                </label>

                                <input wire:model='lateTolerance' type="number" name="lateTolerance" id=""
                                    class="form-control" placeholder="In Minute">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="lateTolerance" class="form-label">
                                    <h6>Clock In Tolerance Attendance (In Minute)</h6>
                                </label>

                                <input wire:model='clockInTolerance' type="number" name="lateTolerance" id=""
                                    class="form-control" placeholder="In Minute">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click='resetForm' type="button" class="btn btn-sm btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
                <button wire:click='updateLateAndClockInTolerance' type="button"
                    class="btn btn-sm btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>
