<div class="card mb-5">
    <div class="card-header pb-0 text-left">
        @if ($editMode)
            <h5 class="font-weight-bolder text-primary">Edit Schedule</h5>
        @else
            <h5 class="font-weight-bolder text-primary">Generate Schedule</h5>
        @endif
    </div>
    <div class="card-body">
        <form class="form text-left">
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-3">
                    <label class="w-100">Nama Karyawan</label>
                    <div wire:ignore>
                        <select wire:model.blur='employee_id'   id="single-employee" wire:ignore {{ $editMode == true ? 'disabled' : '' }}>
                            <option value="">Pilih karyawan</option>
                            @foreach ($dataEmployee as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('employee_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label class="w-100">Shift</label>
                    <div wire:ignore>
                        <select wire:model.blur='shift_id' id="single-shift" wire:ignore>
                            <option value="">Pilih Shift</option>
                            @foreach ($dataShift as $shift)
                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('shift_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label>Start Date</label>
                    <input wire:model.blur='start_date' type="date" class="form-control" placeholder="Start Time"
                        min="{{ date('Y-m-d') }}">
                    @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label>End Date</label>
                    <input wire:model.blur='end_date' type="date" class="form-control" placeholder="End Time"
                        min="{{ date('Y-m-d') }}">
                    @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>


            <div class="text-end">
                @if ($editMode)
                    <button wire:click.prevent='update' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0 me-3">
                        Update
                    </button>
                @else
                    <button wire:click.prevent='store' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0 me-3">
                        Save
                    </button>
                @endif
                <button wire:click.prevent='closeFormSchedule' type="submit"
                    class="btn btn-sm  bg-gradient-secondary btn-lg  mt-4 mb-0">
                    Cancel
                </button>

            </div>
        </form>
    </div>

</div>
