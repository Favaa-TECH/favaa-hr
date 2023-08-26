@push('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if ($showForm)

                        <div class="card mb-4">
                            <div class="card-header pb-0 text-left">
                                @if ($editMode)
                                    <h6 class="font-weight-bolder text-primary">Edit User</h6>
                                @else
                                    <h6 class="font-weight-bolder text-primary">Tambah User</h6>
                                @endif
                            </div>
                            <div class="card-body">
                                @include('livewire.dashboard.include.user-form')
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6> User</h6>
                            <div class="p-0">

                                <button wire:click='showFormUser' type="button"
                                    class="btn btn-block btn-sm bg-gradient-info mb-3" data-bs-toggle="modal"
                                    data-bs-target="#modal-positionoutlet"><i
                                        class="fa-solid fa-user-doctor fa-2x me-1"></i><i
                                        class="fa-regular fa-plus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-zoom-split-in"></i></span>
                                                    <input class="form-control" placeholder="Cari user" type="search"
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Nama
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Role
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($dataUsers) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary text-sm">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataUsers as $index => $user)
                                                <tr>
                                                    <td class="p-4">{{ $dataUsers->firstItem() + $index }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div>
                                                                <img src="{{ asset('storage/' . $user->photo) }}"
                                                                    class="avatar avatar-sm me-3" alt="user1">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $user->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="p-1 align-middle  text-sm">
                                                        <span
                                                            class="badge badge-sm bg-primary">{{ $user->role }}</span>
                                                    </td>
                                                    <td class=" p-1 align-middle">

                                                        <button wire:click='confirmDelete({{ $user->id }})'
                                                            type="submit"
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i></button>
                                                        <button wire:click="showUpdateForm({{ $user->id }})"
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
                                <div class="mt-3 ps-3">
                                    {{ $dataUsers->links() }}
                                </div>

                                @include('livewire.dashboard.include.confirm-delete-modal')
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
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }


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
