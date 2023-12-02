@push('additional-js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($showForm)
                                @include('livewire.dashboard.include.shift-form')
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Shift</h6>
                            <div class="p-0">
                                <button wire:click='showFormShift' type="button"
                                    class="btn btn-block btn-sm bg-primary mb-3 px-3 text-sm text-white">Add Shift
                                </button>
                            </div>
                            <div class="modal fade" id="modal-shift" tabindex="-1" role="dialog"
                                aria-labelledby="modal-shift" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">

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
                                                    <input class="form-control" placeholder="Cari shift" type="search"
                                                        wire:model.live.debounce.500ms="search">
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
                                                Shift Type
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Start Time
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                End Time
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($dataShift) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataShift as $index => $shift)
                                                <tr>
                                                    <td class="p-4">{{ $dataShift->firstItem() + $index }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $shift->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1 align-middle">
                                                        <h6
                                                            class="badge badge-sm @if($shift->shift_type == 'Normal Shift') bg-gradient-primary @elseif ($shift->shift_type == 'Night Shift') bg-gradient-secondary @elseif ($shift->shift_type == 'Morning Shift') bg-gradient-warning @endif  p-2 text-uppercase">
                                                            {{ $shift->shift_type }}</h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $shift->start_time }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $shift->end_time }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-0">
                                                        <button wire:click='confirmDelete({{ $shift->id }})'
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i></button>

                                                        <button wire:click="showFormEditShift({{ $shift->id }})"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit">
                                                            <i class="fa-solid fa-pen-to-square"></i></button>
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
            </div>

            @include('layouts.partials.footer')
        </div>
    </main>
    @include('livewire.dashboard.include.confirm-delete-modal')
</div>
@push('additional-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
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
    </script>
@endpush
