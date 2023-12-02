@push('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if ($showForm)
                        <div class="card mb-4">
                            <div class="card-header pb-0 d-flex w-100  justify-content-between">
                                @if ($editMode)
                                    <h6>Edit Karyawan</h6>
                                @else
                                    <h6>Tambah Karyawan</h6>
                                @endif
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="container-fluid">

                                    @include('livewire.dashboard.include.add-employee-form')
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Data Karyawan</h6>
                            <div class="p-0">
                                <button wire:click="showFormEmployee"
                                    class="btn btn-block btn-sm bg-gradient-primary mb-3"><i
                                        class="fa-sharp fa-solid fa-user-plus fa-2x"></i></button>
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
                                                    <input class="form-control" placeholder="Cari Karyawan"
                                                        type="search" wire:model.live.debounce.500ms="search">
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Nama
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Jabatan
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Telepon
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Tanggal Lahir
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Timestamp
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($dataEmployee) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary text-sm">Tidak ada
                                                    data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataEmployee as $index => $employee)
                                                <tr>
                                                    <td class="p-4">{{ $dataEmployee->firstItem() + $index }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div>
                                                                <img src="{{ asset('storage/' . $employee->photo) }}"
                                                                    class="avatar avatar-sm me-3" alt="user1">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $employee->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $employee->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $employee->position->name }}</p>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $employee->outlet->nama_ot }}</p>
                                                    </td>
                                                    <td class="p-1 align-middle  text-sm">
                                                        <span
                                                            class="badge badge-sm bg-primary">{{ $employee->phone }}</span>
                                                    </td>
                                                    <td class="p-1 align-middle ">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ date_format(date_create($employee->date_of_birth), 'd F Y') }}</span>
                                                    </td>
                                                    <td class="p-1 align-middle ">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ date_format(date_create($employee->date_of_birth), 'd/m/y H:i') }}</span>
                                                    </td>
                                                    <td class=" p-1 align-middle">
                                                        <button wire:click="confirmDelete({{ $employee->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                        <button wire:click="showFormEditEmployee({{ $employee->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#editModal">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <button wire:click="showModalEmployee({{ $employee->id }})"
                                                            type="button"
                                                            class="badge badge-sm bg-gradient-info text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#showEmployeeModal">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="mt-3 ps-3">

                                    {{ $dataEmployee->links() }}
                                </div>
                                {{-- Modal Confirm Delete --}}
                                @include('livewire.dashboard.include.confirm-delete-modal')
                                {{-- Modal Data Employee --}}
                                @include('livewire.dashboard.include.show-data-employee-modal')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.partials.footer')
        </div>
    </main>
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
        Livewire.on('error', data => {
            toastr.error(data[0].message)
        });

    </script>
@endpush
