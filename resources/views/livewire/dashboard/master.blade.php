@push('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Outlet</h6>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Outlet
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Lokasi Map
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Alamat
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kontak Outlet
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (empty($dataOutlet))

                                        <tr>
                                            <td colspan="5" class="text-center text-primary">Tidak ada data</td>
                                        </tr>
                                    @else
                                        @foreach ($dataOutlet as $outlet)
                                            <tr>
                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $outlet->nama_ot }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ni ni-map-big text-success text-md me-3"></i>
                                                        <div class="text-md link-success cursor-pointer">
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $outlet->latitude }}</p>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $outlet->longitude }}</p>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $outlet->alamat_ot }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">

                                                    <p class="text-primary">{{ $outlet->kontak_ot }}</p>

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
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6> Jabatan</h6>

                            <div class="p-0">
                                @if ($showCreatedPositionForm == false)
                                    <button wire:click="showForm" class="btn btn-block btn-sm bg-gradient-info mb-3"><i
                                            class="fa-solid fa-user-doctor fa-2x me-1"></i><i
                                            class="fa-regular fa-plus"></i>
                                    </button>
                                @endif


                            </div>


                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if ($showCreatedPositionForm)
                                <div class="container-fluid mt-3">

                                    <form class="form text-left w-50">

                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label>Nama Jabatan</label>
                                                <div class="input-group ">
                                                    <input type="text"
                                                           class="form-control @error('position_name')
                                                    is-invalid
                                                @enderror"
                                                           placeholder="Nama Jabatan" wire:model="position_name">
                                                </div>
                                                @error('position_name')
                                                <small class="text-danger mb-3">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label>Deskripsi</label>
                                                <div class="input-group ">
                                                    <textarea
                                                        class="form-control @error('position_name')
                                                is-invalid
                                            @enderror"
                                                        placeholder="Deskripsi" aria-label="Deskripsi"
                                                        wire:model="position_description"></textarea>
                                                </div>
                                                @error('position_description')
                                                <small class="text-danger mb-3">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>


                                        <div class="text-end">
                                            @if ($editMode == true)
                                                <button wire:click.prevent="updatePosition" type="submit"
                                                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                                                    Update
                                                </button>
                                            @else
                                                <button wire:click.prevent="createPosition" type="submit"
                                                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                                                    Save
                                                </button>
                                            @endif
                                            <button wire:click.prevent="closeForm" type="submit"
                                                    class="btn btn-sm  bg-gradient-secondary btn-lg  mt-4 mb-0">
                                                Cancel
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="table-responsive p-0">
                                <table class="table table-hover justify-content-center mb-0">
                                    <thead>
                                    <tr>

                                        <th
                                            class="w-75 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Position Name
                                        </th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    @if (count($dataPosition) == 0)

                                        <tr>
                                            <td colspan="2" class="text-center text-primary text-sm">Tidak ada
                                                data
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataPosition as $position)
                                            <tr>

                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $position->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center d-flex justify-content-center">

                                                    <button wire:click="deletePosition({{ $position->id }})"
                                                            class="badge badge-sm bg-gradient-danger text-white border-0 me-2"
                                                            style="color: inherit">
                                                        <i class="fa-solid fa-trash"></i></button>


                                                    <button wire:click="editPosition({{ $position->id }})"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit"><i
                                                            class="fa-sharp fa-solid fa-pen-to-square"></i></button>

                                                </td>

                                            </tr>
                                        @endforeach

                                    @endif


                                    </tbody>
                                </table>
                                <div class="mt-3 ps-3">

                                    {{ $dataPosition->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.layouts.partials.footer')
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
        Livewire.on('error', data => {
            toastr.error(data[0].message)
        });
    </script>
@endpush
