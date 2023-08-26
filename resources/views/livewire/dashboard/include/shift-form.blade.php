<div class="card mb-5">
    <div class="card-header pb-0 text-left">
        @if ($editMode)
            <h5 class="font-weight-bolder text-primary">Edit Shift</h5>
        @else
            <h5 class="font-weight-bolder text-primary">Add Shift</h5>
        @endif
    </div>
    <div class="card-body">
        <form class="form text-left">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label>Nama Shift</label>
                    <input wire:model='name' type="text" class="form-control" placeholder="Nama Shift">
                </div>
                <div class="col-sm-12 col-md-6">
                    <label>Shift Type</label>
                    <select wire:model='shift_type' id="" class="form-control">
                        <option value="">
                            <i>-- Pilih Type Shift --</i>
                        </option>
                        <option value="Normal Shift">
                            Normal Shift
                        </option>
                        <option value="Night Shift">
                            Night Shift
                        </option>
                        <option value="Morning Shift">
                            Morning Shift
                        </option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label>Start Time</label>
                    <input wire:model='start_time' type="time" class="form-control" placeholder="Start Time">
                </div>
                <div class="col-sm-12 col-md-6">
                    <label>End Time</label>
                    <input wire:model='end_time' type="time" class="form-control" placeholder="End Time">
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
                <button wire:click.prevent='closeFormShift' type="submit"
                    class="btn btn-sm  bg-gradient-secondary btn-lg  mt-4 mb-0">
                    Cancel
                </button>

            </div>
        </form>
    </div>

</div>
