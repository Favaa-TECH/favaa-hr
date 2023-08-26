@extends('layouts.app')
@push('additional-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
            max-height: 500px !important;

        }

        .table-sticky th:first-child,
        .table-sticky td:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            /* Atur warna latar belakang yang sesuai */
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Presence</p>
                                        <h5 class="font-weight-bolder">
                                            100
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Absent</p>
                                        <h5 class="font-weight-bolder">
                                            10
                                        </h5>

                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-danger text-center rounded-circle">
                                        <i class="fa-solid fa-circle-check fa-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Holiday</p>
                                        <h5 class="font-weight-bolder">
                                            4
                                        </h5>

                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-warning text-center rounded-circle">
                                        <i class="fa-solid fa-clock fa-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Leave</p>
                                        <h5 class="font-weight-bolder">
                                            2
                                        </h5>

                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow-warning text-center rounded-circle">
                                        <i class="fa-solid fa-plane-circle-check fa-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between mb-3 align-items-center">
                            <div class="title-table">
                                <h5>Absensi</h5>
                                <span>Periode Juni 2023</span>
                            </div>
                            <div class="mx-4 my-3 d-flex justify-content-start  ">
                                <h6 class="me-3">  <i class="fa-sharp fa-solid fa-circle-check text-success"></i> Present</h6>
                                <h6 class="me-3"> <i class="fa-solid fa-clock" style="color: #FFD015;"></i> Late </h6>
                                <h6 class="me-3">  <i class="fa-solid fa-circle-xmark text-danger"></i> Absent</h6>
                                <h6 class="me-3">  <i class="fa-solid fa-right-from-bracket text-info"></i> Leave</h6>
                                <h6 class="me-3">  <i class="fa-solid fa-house-chimney"></i> Holiday</h6>
                            </div>
                            <div class="input-date-search d-flex align-items-end">
                                <input type="text" class="form-control me-2" placeholder="Cari karyawan"
                                    name="search-employee" id="search-employee" style="height: 40px">
                                <input type="month" class="form-control " name="month" id="month"
                                    style="height: 40px">
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 table-sticky" id="attendance-table">
                                    <thead>
                                        <tr class="sticky-top">
                                            <th>
                                                Employee Name
                                            </th>

                                            @for ($i = 0; $i < 30; $i++)
                                                <th class="bg-white">
                                                    {{ $i + 1 }}
                                                </th>
                                            @endfor

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center">
                                                    <i class="fa-sharp fa-solid fa-circle-check text-success"></i>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center">
                                                    <i class="fa-solid fa-clock" style="color: #FFD015;"></i>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center">
                                                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center">
                                                    <i class="fa-solid fa-right-from-bracket text-info"></i>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center">
                                                    <i class="fa-solid fa-house-chimney"></i>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="p-4">
                                                <span class="">Muhammad Ali Faatikh Riziq</span>
                                            </td>
                                            @for ($i = 0; $i < 30; $i++)
                                                <td class="text-center font-weight-bold">
                                                    -
                                                </td>
                                            @endfor
                                        </tr>

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
        @if (session('success'))
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

        @if (session('error'))
            {{-- Toastify.error('{{ session('error') }}').showToast(); --}}
        @endif

        window.addEventListener('DOMContentLoaded', function() {
            var table = document.getElementById('attendance-table');
            var firstCells = table.querySelectorAll('td:first-child');

            table.addEventListener('scroll', function() {
                var scrollTop = this.scrollTop;
                for (var i = 0; i < firstCells.length; i++) {
                    firstCells[i].style.transform = 'translateY(' + scrollTop + 'px)';
                }
            });
        });

    </script>
@endpush
