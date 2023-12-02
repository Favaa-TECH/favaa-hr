@push('additional-js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Permission</h6>
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
                                                Nama Karyawan
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
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Status
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataPermission) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataPermission as $index => $permission)
                                                <tr>
                                                    <td class="p-4">{{ $dataPermission->firstItem() + $index }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $permission->employee->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $permission->start_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $permission->end_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1 align-middle">
                                                        <h6
                                                            class="badge badge-sm @if ($permission->status == 'approved') bg-gradient-success @elseif ($permission->status == 'rejected') bg-gradient-danger @elseif ($permission->status == 'cancelled') bg-gradient-primary @else bg-gradient-secondary @endif  p-2 text-uppercase">
                                                            {{ $permission->status }}</h6>
                                                    </td>
                                                    <td class="p-0">
                                                        <button wire:click='confirmDelete({{ $permission->id }})'
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i></button>

                                                        <button wire:click="showModalPermission({{ $permission->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-info text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#showPermissionModal">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                        <button wire:click="showModalReject({{ $permission->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#rejectPermissionModal">
                                                            <i class="fa-solid fa-ban"></i>
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
            </div>

            @include('layouts.partials.footer')
        </div>
    </main>
    @include('livewire.dashboard.include.confirm-delete-modal')
    @include('livewire.dashboard.include.reject-permission-form-modal')
    @include('livewire.dashboard.include.show-data-permission-modal')
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
        window.addEventListener('success', event => {
            $('.modal').modal('hide');
        });
    </script>
@endpush
