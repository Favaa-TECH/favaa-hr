@push('additional-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-6 mb-4">
                    @if ($showForm)
                        @include('livewire.dashboard.include.holiday-form')
                    @endif
                </div>
                <div class="col-md-12">

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Holiday Off</h6>
                            <div class="p-0">
                                <button wire:click='showFormHoliday' type="button"
                                    class="btn btn-block btn-sm bg-primary mb-3 px-3 text-sm text-white"
                                    data-bs-toggle="modal" data-bs-target="#modal-holiday"> <i
                                        class="fa-solid fa-plus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-zoom-split-in"></i></span>
                                                    <input class="form-control" placeholder="Search" type="search"
                                                        wire:model.live.debounce.500ms="searchHoliday">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                                No
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Employee
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Day
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($dataHoliday) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataHoliday as $index => $holiday)
                                                <tr>
                                                    <td class="p-4">{{ $dataHoliday->firstItem() + $index }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $holiday->employee->name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <p class="text-sm font-weight-bold mb-0 text-uppercase">
                                                            {{ $holiday->choosen_day }}</p>
                                                    </td>
                                                    <td class="p-0">
                                                        <button wire:click='confirmDelete({{ $holiday->id }})'
                                                            type="submit"
                                                            class="badge badge-sm bg-gradient-danger text-white border-0 me-1"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i></button>
                                                        <button wire:click="showFormEditEmployee({{ $holiday->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#editModal">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Special Holiday</h6>
                            <div class="p-0">
                                <!-- Button trigger modal -->
                                <button type="button"
                                    class="btn btn-block btn-sm bg-primary mb-3 px-3 text-sm text-white"
                                    data-bs-toggle="modal" data-bs-target="#specialHoliday">
                                    <i class="fa-solid fa-plus"></i>
                                </button>

                                <!-- Modal -->
                                <div wire:ignore.self class="modal modal-lg fade" id="specialHoliday"
                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="specialHolidayLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                @if ($editModeSpecialHoliday)
                                                    <h5 class="modal-title" id="specialHolidayLabel">Edit Special
                                                        Holiday
                                                    </h5>
                                                @else
                                                    <h5 class="modal-title" id="specialHolidayLabel">Add Special Holiday
                                                    </h5>
                                                @endif
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form text-left">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <label>Nama Hari Libur</label>
                                                            <input wire:model.blur='specialHolidayName' type="text"
                                                                class="form-control {{ $errors->has('specialHolidayName') ? 'is-invalid' : '' }}"
                                                                placeholder="Nama Hari Libur">
                                                            @error('specialHolidayName')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-sm-12 col-md-6">
                                                            <label>Start Date</label>
                                                            <input wire:model.blur='specialHolidayStartDate'
                                                                type="date" class="form-control "
                                                                placeholder="Start Time">
                                                            @error('specialHolidayStartDate')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <label>End Date</label>
                                                            <input wire:model.blur='specialHolidayEndDate'
                                                                type="date" class="form-control "
                                                                placeholder="End Time">
                                                            @error('specialHolidayEndDate')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button wire:click='resetForm' type="button"
                                                    class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                @if ($editModeSpecialHoliday)
                                                    <button wire:click='updateSpecialHoliday' type="button"
                                                        class="btn btn-sm btn-primary">Save</button>
                                                @else
                                                    <button wire:click='storeSpecialHoliday' type="button"
                                                        class="btn btn-sm btn-primary">Save</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-zoom-split-in"></i></span>
                                                    <input class="form-control" placeholder="Search" type="search"
                                                        wire:model.live.debounce.500ms="searchSpecialHoliday">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                                No
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Name
                                            </th>

                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Start Date
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                End Date
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($dataSpecialHoliday) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataSpecialHoliday as $index => $specialHoliday)
                                                <tr>
                                                    <td class="p-1 ps-4">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    {{ $dataSpecialHoliday->firstItem() + $index }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $specialHoliday->name }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $specialHoliday->start_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $specialHoliday->end_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-0">
                                                        <button
                                                            wire:click='confirmDeleteSpecialHoliday({{ $specialHoliday->id }})'
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#confirmDeleteSpecialHoliday">
                                                            <i class="fa-solid fa-trash"></i></button>

                                                        <button
                                                            wire:click="showFormEditSpecialHoliday({{ $specialHoliday->id }})"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#specialHoliday">
                                                            <i class="fa-solid fa-pen-to-square"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{ $dataSpecialHoliday->links() }}
                                @include('livewire.dashboard.include.confirm-delete-special-holiday-modal')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Attach Special Holiday</h6>
                            <div class="p-0">
                                <!-- Button trigger modal -->
                                <button type="button"
                                    class="btn btn-block btn-sm bg-primary mb-3 px-3 text-sm text-white"
                                    data-bs-toggle="modal" data-bs-target="#attachSH">
                                    <i class="fa-solid fa-plus"></i>
                                </button>

                                <!-- Modal -->
                                <div wire:ignore.self class="modal  fade" id="attachSH" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="attachSHLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                @if ($editModeAttachSH)
                                                    <h5 class="modal-title" id="specialHolidayLabel">Edit Attach
                                                    </h5>
                                                @else
                                                    <h5 class="modal-title" id="specialHolidayLabel">Add Attach
                                                    </h5>
                                                @endif
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form text-left">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 mb-3">
                                                            <label>Nama Karyawan</label>
                                                            <div wire:ignore class="">
                                                                <select
                                                                    @if ($editModeAttachSH) disabled @endif
                                                                    wire:model='attachEmployeeId'
                                                                    name="attachEmployeeId" id="select2-employee"
                                                                    class=" form-control select2-employee"
                                                                    style="width: 100%">
                                                                    <option value="">-- Pilih Karyawan --
                                                                    </option>
                                                                    @foreach ($employees as $employee)
                                                                        <option value="{{ $employee->id }}">
                                                                            {{ $employee->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('attachEmployeeId')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 mb-3">
                                                            <label>Special Holiday</label>
                                                            <div wire:ignore class="">
                                                                <select wire:model='specialHolidayIdEmployee'
                                                                    name="specialHolidayIdEmployee"
                                                                    id="select2-special-holiday"
                                                                    class=" form-control select2-special-holiday"
                                                                    style="width: 100%">
                                                                    <option value="">-- Pilih hari libur --
                                                                    </option>
                                                                    @foreach ($dataSpecialHoliday as $specialHoliday)
                                                                        <option value="{{ $specialHoliday->id }}">
                                                                            {{ $specialHoliday->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('specialHolidayIdEmployee')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <label>Catatan</label>
                                                            <textarea wire:model='notesAttachSH' class="form-control" id="" cols="30" rows="5"></textarea>

                                                            @error('notesAttachSH')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button wire:click='resetForm' type="button"
                                                    class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                @if ($editModeAttachSH)
                                                    <button wire:click='updateAttachSpecialHoliday' type="button"
                                                        class="btn btn-sm btn-primary">Update</button>
                                                @else
                                                    <button wire:click='attachSpecialHoliday' type="button"
                                                        class="btn btn-sm btn-primary">Save</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-zoom-split-in"></i></span>
                                                    <input class="form-control" placeholder="Search" type="search"
                                                        wire:model.live.debounce.500ms="searchEmployee">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                                No
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Name
                                            </th>

                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Special Holiday
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Start Date
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                End Date
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($employees) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($employees as $index => $employee)
                                                <tr>
                                                    <td class="p-1 ps-4">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    {{ $employees->firstItem() + $index }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $employee->name }}
                                                        </h6>
                                                    </td>
                                                    @if ($employee->specialHolidays->count() > 0)
                                                        @foreach ($employee->specialHolidays as $specialHoliday)
                                                            <td class="p-1">
                                                                <h6 class=" font-weight-bold mb-0">
                                                                    {{ $specialHoliday->name }}
                                                                </h6>
                                                            </td>
                                                            <td class="p-1">
                                                                <h6 class=" font-weight-bold mb-0">
                                                                    {{ $specialHoliday->end_date }}
                                                                </h6>
                                                            </td>
                                                            <td class="p-1">
                                                                <h6 class=" font-weight-bold mb-0">
                                                                    {{ $specialHoliday->end_date }}
                                                                </h6>
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td class="p-1">
                                                            <h6 class=" font-weight-bold mb-0">
                                                                -
                                                            </h6>
                                                        </td>
                                                        <td class="p-1">
                                                            <h6 class=" font-weight-bold mb-0">
                                                                -
                                                            </h6>
                                                        </td>
                                                        <td class="p-1">
                                                            <h6 class=" font-weight-bold mb-0">
                                                                -
                                                            </h6>
                                                        </td>
                                                    @endif
                                                    <td class="p-0">
                                                        <button
                                                            {{ $employee->specialHolidays->count() == 0 ? 'disabled' : '' }}
                                                            wire:click='confirmDeleteAttachSH({{ $employee->id }})'
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteAttachSHModal">
                                                            <i class="fa-solid fa-trash"></i></button>
                                                        @if ($employee->specialHolidays->count() > 0)
                                                            <button
                                                                wire:click="showModalAttachSH({{ $employee->id }})"
                                                                class="badge badge-sm bg-gradient-success text-white border-0"
                                                                style="color: inherit" data-bs-toggle="modal"
                                                                data-bs-target="#attachSH">
                                                                <i class="fa-solid fa-pen-to-square"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{ $employees->links() }}
                                @include('livewire.dashboard.include.confirm-delete-attach-special-holiday-modal')
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @include('layouts.partials.footer')

        </div>
    </main>
    @include('livewire.dashboard.include.confirm-delete-modal')
</div>
@push('additional-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        Livewire.on('show-form-holiday', () => {
            $(document).ready(function() {
                // Initialize Select2
                var select2Element = $('#js-example-basic-single').select2();
                // Attach Livewire event handler to Select2 change
                select2Element.on('change', function(e) {
                    var data = select2Element.val();
                    @this.set('employee_id', data);
                });
                // Disable the standard select change event
                $('#js-example-basic-single').on('change', function(e) {
                    e.preventDefault();
                });
            });
        });

        $(document).ready(function() {
            // Initialize Select2
            var select2Element = $('#select2-employee').select2();
            // Attach Livewire event handler to Select2 change
            select2Element.on('change', function(e) {
                var data = select2Element.val();
                @this.set('attachEmployeeId', data);
            });
            // Disable the standard select change event
            $('#select2-employee').on('change', function(e) {
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            // Initialize Select2
            var select2Element = $('#select2-special-holiday').select2();
            // Attach Livewire event handler to Select2 change
            select2Element.on('change', function(e) {
                var data = select2Element.val();
                @this.set('specialHolidayIdEmployee', data);
            });
            // Disable the standard select change event
            $('#select2-special-holiday').on('change', function(e) {
                e.preventDefault();
            });
        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        Livewire.on('success', data => {
            toastr.success(data[0].message)
        });

        Livewire.on('refreshData', () => {
            location.reload();
        });

        window.addEventListener('success', event => {
            $('.modal').modal('hide');
        });
    </script>
@endpush
