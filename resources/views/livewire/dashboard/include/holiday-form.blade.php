<div class="card ">
    <div class="card-header pb-0 text-left">
        @if ($editMode)
            <h4 class="font-weight-bolder text-primary text-md">Edit Holiday</h4>
        @else
            <h4 class="font-weight-bolder text-primary text-md">Add Holiday</h4>
        @endif

    </div>
    <div class="card-body">

        <form class="form text-left">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <label class="w-100">Nama Karyawan</label>
                    <div wire:ignore class="">
                        <select @if ($editMode) disabled @endif wire:model='employee_id'
                            name="employee_id" id="js-example-basic-single"
                            class=" form-control js-example-basic-single" style="width: 100%">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('employee_id')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-12">
                    <label>Hari</label>
                    <select wire:model='choosen_day' name="choosen_day" id="" class="form-control">
                        <option value="">
                            <i>-- Pilih Hari --</i>
                        </option>
                        <option value="Senin">
                            Senin
                        </option>
                        <option value="Selasa">
                            Selasa
                        </option>
                        <option value="Rabu">
                            Rabu
                        </option>
                        <option value="Kamis">
                            Kamis
                        </option>
                        <option value="Jumat">
                            Jumat
                        </option>
                        <option value="Sabtu">
                            Sabtu
                        </option>
                        <option value="Minggu">
                            Minggu
                        </option>
                    </select>
                    @error('choosen_day')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

            </div>


            <div class="text-end">
                @if ($editMode)
                    <button wire:click.prevent='update' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                        Update
                    </button>
                @else
                    <button wire:click.prevent='store' type="submit"
                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                        Save
                    </button>
                @endif
                <button wire:click.prevent="closeFormHoliday"
                    class="btn btn-sm bg-gradient-secondary text-white text-md font-weight-normal px-5 float-end ms-3 mt-4">Cancel
                </button>

            </div>
        </form>
    </div>

</div>
