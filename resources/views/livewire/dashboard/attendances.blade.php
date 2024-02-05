@push('additional-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"
        xmlns:wire="http://www.w3.org/1999/xhtml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
<div>
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
                                    <div
                                        class="icon icon-shape bg-gradient-info shadow-warning text-center rounded-circle">
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
                                <h4>Absensi</h4>
                                <span>Periode {{ date('F') }} {{ date('Y') }}</span>
                            </div>
                            <div class="mx-4 my-3 d-flex justify-content-start">
                                <h6 class="me-3"><i class="fa-sharp fa-solid fa-circle-check text-success"></i>
                                    Present</h6>
                                <h6 class="me-3"><i class="fa-solid fa-clock" style="color: #FFD015;"></i> Late </h6>
                                <h6 class="me-3"><i class="fa-solid fa-circle-xmark text-danger"></i> Absent</h6>
                                <h6 class="me-3"><i class="fa-solid fa-right-from-bracket text-info"></i> Leave</h6>
                                <h6 class="me-3"><i class="fa-solid fa-house-chimney"></i> Holiday</h6>
                            </div>
                            <div class="input-date-search d-flex justify-content-center align-items-center ">
                                <input wire:model.live.debounce.500ms='search' type="text" class="form-control me-2"
                                    placeholder="Cari karyawan" name="search-employee" id="search-employee"
                                    style="height: 40px">
                                <input type="month" class="form-control me-2" name="month" id="month"
                                    style="height: 40px">
                            </div>

                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <button class=" btn btn-sm  bg-primary ms-4" data-bs-toggle="modal"
                                data-bs-target="#settingAttendance"><i class="fa-solid fa-gear text-white"></i>
                            </button>
                            @include('livewire.dashboard.include.setting-attendance-rules')

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 table-sticky" id="attendance-table">
                                    <thead>
                                        <tr class="sticky-top">
                                            <th>
                                                Employee Name
                                            </th>

                                            @php
                                                $dt = \Carbon\Carbon::now();
                                                $daysInMonth = \Carbon\Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                                            @endphp



                                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                                <th class="bg-white">
                                                    {{ $i }}
                                                </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendance as $key => $data)
                                            <tr>
                                                <td class="p-4">
                                                    <span class="">{{ $data->name }}</span>
                                                </td>
                                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                                    {{-- Mulai dari 1 karena tanggal dimulai dari 1 --}}
                                                    <td class="text-center">
                                                        @php
                                                            $attendanceStatus = '-'; // Default status
                                                            foreach ($data->attendance as $attendanceData) {
                                                                $attendanceDate = date('d', strtotime($attendanceData->check_in_date));
                                                                if ($attendanceDate == $i) {
                                                                    $attendanceStatus = $attendanceData->status;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($attendanceStatus == 'Present')
                                                            <i wire:click="showModalDataAttendance({{ $attendanceData->id }})"
                                                                class="fa-sharp fa-solid fa-circle-check text-success cursor-pointer"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showDataAttendanceModal"></i>
                                                        @elseif ($attendanceStatus == 'Absent')
                                                            <i wire:click="showModalDataAttendance({{ $attendanceData->id }})"
                                                                class="fa-sharp fa-solid fa-circle-xmark text-danger cursor-pointer"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showDataAttendanceModal"></i>
                                                        @elseif ($attendanceStatus == 'Leave')
                                                            <i wire:click="showModalDataAttendance({{ $attendanceData->id }})"
                                                                class="fa-sharp fa-solid fa-right-from-bracket text-info cursor-pointer"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showDataAttendanceModal"></i>
                                                        @elseif ($attendanceStatus == 'Holiday')
                                                            <i wire:click="showModalDataAttendance({{ $attendanceData->id }})"
                                                                class="fa-sharp fa-solid fa-house-chimney cursor-pointer"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showDataAttendanceModal"></i>
                                                        @elseif ($attendanceStatus == 'Late')
                                                            <i wire:click="showModalDataAttendance({{ $attendanceData->id }})"
                                                                class="fa-solid fa-clock cursor-pointer"
                                                                style="color: #FFD015;" data-bs-toggle="modal"
                                                                data-bs-target="#showDataAttendanceModal"></i>
                                                        @else
                                                            {{ $attendanceStatus }} {{-- Tampilkan "-" atau status lain jika ada --}}
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
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
    @include('livewire.dashboard.include.show-data-attendance-modal')
</div>
@push('additional-js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
            console.log("toast executed");
            toastr.success(data[0].message)
        });

        window.addEventListener('success', event => {
            console.log("Modal hide code executed");
            $('.modal').modal('hide');
        });



        // window.addEventListener('DOMContentLoaded', function() {
        //     var table = document.getElementById('attendance-table');
        //     var firstCells = table.querySelectorAll('td:first-child');

        //     table.addEventListener('scroll', function() {
        //         var scrollTop = this.scrollTop;
        //         for (var i = 0; i < firstCells.length; i++) {
        //             firstCells[i].style.transform = 'translateY(' + scrollTop + 'px)';
        //         }
        //     });
        // });
    </script>
@endpush
