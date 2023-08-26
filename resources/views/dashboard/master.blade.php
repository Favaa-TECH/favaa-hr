@extends('layouts.app')
@push('additional-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')
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
                                    @if(empty($dataOutlet))

                                        <tr>
                                            <td colspan="5" class="text-center text-primary">Tidak ada data</td>
                                        </tr>
                                    @else
                                        @foreach($dataOutlet as $outlet)
                                            <tr>
                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$outlet->nama_ot}}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ni ni-map-big text-success text-md me-3"></i>
                                                            <div class="text-md link-success cursor-pointer">
                                                                <p class="text-xs font-weight-bold mb-0">{{$outlet->latitude}}</p>
                                                                <p class="text-xs font-weight-bold mb-0">{{$outlet->longitude}}</p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                </td>
                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$outlet->alamat_ot}}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">

                                                    <p class="text-primary">{{$outlet->kontak_ot}}</p>

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
                                {{--Modal Button--}}
                                <button type="button" class="btn btn-block btn-sm bg-gradient-info mb-3"
                                        data-bs-toggle="modal" data-bs-target="#modal-positionoutlet"><i
                                        class="fa-solid fa-user-doctor fa-2x me-1"></i><i
                                        class="fa-regular fa-plus"></i>
                                </button>
                                {{--Modal Body--}}
                                <div class="modal fade" id="modal-positionoutlet" tabindex="-1" role="dialog"
                                     aria-labelledby="modal-positionoutlet" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="card card-plain">
                                                    <div class="card-header pb-0 text-left">
                                                        <h4 class="font-weight-bolder text-primary">Add Data</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <form class="form text-left" method="POST"
                                                              action="{{route('position.store')}}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Nama Jabatan</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                               placeholder="Nama Jabatan" name="name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-12">
                                                                    <label>Deskripsi</label>
                                                                    <div class="input-group mb-3">
                                                                        <textarea class="form-control"
                                                                                  placeholder="Deskripsi"
                                                                                  aria-label="Deskripsi"
                                                                                  name="description"></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class="text-end">
                                                                <button type="submit"
                                                                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--End Modal Body--}}
                            </div>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
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


                                    @if(count($dataPosition) == 0)

                                        <tr>
                                            <td colspan="2" class="text-center text-primary">No Data</td>
                                        </tr>
                                    @else
                                        @foreach($dataPosition as $position)
                                            <tr>

                                                <td>
                                                    <div class="align-middle ms-3">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$position->name}}</h6>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center d-flex justify-content-center">
                                                    <form action="{{route('position.delete',$position->id)}}"
                                                          method="POST" class="me-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="badge badge-sm bg-gradient-danger text-white border-0"
                                                                style="color: inherit"
                                                                onclick="return confirm('Data akan dihapus.. apakah anda yakin?')">
                                                            <i
                                                                class="fa-solid fa-trash"></i></button>
                                                    </form>

                                                    <a href="" class="badge badge-sm bg-gradient-success text-white"
                                                       style="color: inherit"><i
                                                            class="fa-sharp fa-solid fa-pen-to-square"></i></a>

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

@endsection
@push('additional-js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }


        @if(session('success'))
        Toastify({
            text: "{{ session('success') }}",
            duration: 2000,
            close: true,
            gravity: "bottom",
            position: "right",
            style: {
                background: "linear-gradient(to right, #003399, #1185EF)",
                color: "#fff",
                fontSize: "14px",
            }
        }).showToast();
        @endif
        @if(session('success-add-outlet'))
        Toastify({
            text: "{{ session('success-add-outlet') }}",
            duration: 2000,
            close: true,
            gravity: "bottom",
            position: "right",
            style: {
                background: "linear-gradient(to right, #003399, #1185EF)",
                color: "#fff",
                fontSize: "14px",
            }
        }).showToast();
        @endif
        @if(session('success-delete-outlet'))
        Toastify({
            text: "{{ session('success-delete-outlet') }}",
            duration: 2000,
            close: true,
            gravity: "bottom",
            position: "right",
            style: {
                background: "linear-gradient(to right, #003399, #1185EF)",
                color: "#fff",
                fontSize: "14px",
            }
        }).showToast();
        @endif

        @if(session('error'))
            {{--Toastify.error('{{ session('error') }}').showToast();--}}
        @endif


    </script>
@endpush
