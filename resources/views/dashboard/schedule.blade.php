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
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h6>Table Karyawan</h6>
                            <div class="p-0">
                                <a href=""
                                   class="btn btn-block btn-sm bg-gradient-primary mb-3"><i
                                        class="fa-sharp fa-solid fa-user-plus fa-2x"></i></a>
                            </div>

                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                            No
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Nama
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Jabatan
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Telepon
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Tanggal Lahir
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Timestamp
                                        </th>
                                        <th class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                            Aksi
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

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

        @if(session('error'))
            {{--Toastify.error('{{ session('error') }}').showToast();--}}
        @endif


    </script>
@endpush
