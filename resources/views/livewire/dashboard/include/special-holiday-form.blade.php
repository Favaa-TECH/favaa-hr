<div class="card ">
    <div class="card-header pb-0 text-left">
        @if ($editModeSpecialHoliday)
            <h4 class="font-weight-bolder text-primary text-md">Edit</h4>
        @else
            <h4 class="font-weight-bolder text-primary text-md">Add</h4>
        @endif

    </div>
    <div class="card-body">

        <form class="form text-left">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <label class="w-100">Nama </label>
                    <input wire:model='special_holiday_name' type="text" class="form-control">
                    @error('name_special_holiday')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-12">
                    <label>Start Time</label>
                    <input wire:model='start_date' type="date" class="form-control">
                    @error('start_date')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-12">
                    <label>End Time</label>
                    <input wire:model='end_date' type="date" class="form-control">
                    @error('end_date')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

            </div>


            <div class="text-end">
                @if ($editModeSpecialHoliday)
                    <button wire:click.prevent='updateSpecialHoliday' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                        Update
                    </button>
                @else
                    <button wire:click.prevent='storeSpecialHoliday' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                        Save
                    </button>
                @endif
                <button wire:click.prevent="closeFormSpecialHoliday"
                    class="btn btn-sm bg-gradient-secondary text-white text-md font-weight-normal px-5 float-end ms-3 mt-4">Cancel
                </button>

            </div>
        </form>
    </div>

</div>
