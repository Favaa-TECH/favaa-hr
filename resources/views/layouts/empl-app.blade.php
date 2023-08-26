<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/logo.png') }}">
    <title>
        FAvaa Human Resource Management System
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/solid.min.css') }}">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        .fab {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
        }

        .bg-primary-2 {
            background-color: #0047D3 !important;
        }

        /* Contoh gaya untuk elemen di bawah navbar */
        .content {
            margin-top: 75px !important;
            /* Atur margin atas sesuai dengan tinggi navbar */
            /* Ganti 60px dengan tinggi navbar Anda */
            /* Anda juga dapat menyesuaikan gaya lainnya sesuai kebutuhan */
        }

        .check-in {

            height: 75px;
        }

        .check-out {

            height: 75px;
        }
    </style>
    @stack('additional-css')

</head>

<body>

    @if ($dataSchedule == null)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="nothingSchedule()"><i
                class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
    @elseif($cekAlreadyPresent > 0)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="alreadyPresent()"><i
                class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
    @elseif(!$canPresenceCheck)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="canNotPresent()"><i
                class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
    @else
        @if ($cekAlreadyCheckIn > 0)
            @if (!$canCheckOutCheck)
                <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
                    style="width: 75px;height: 75px" onclick="canNotCheckOut()"><i
                        class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
            @else
                <a href="{{ route('presence') }}"><button type="button"
                        class="rounded-circle fab bg-primary border-white border-2" style="width: 75px;height: 75px"><i
                            class="fa-regular fa-fingerprint text-white fa-2x"></i></button></a>
            @endif
        @else
            <a href="{{ route('presence') }}"><button type="button"
                    class="rounded-circle fab bg-primary border-white border-2" style="width: 75px;height: 75px"><i
                        class="fa-regular fa-fingerprint text-white fa-2x"></i></button></a>
        @endif
    @endif


    <nav class="navbar bg-body-tertiary shadow-none py-3 fixed-top bg-white">
        <div class="container-fluid px-2">
            <a class=" d-flex justify-content-center align-items-center" href="#">
                <img src="{{ asset('assets/img/logos/logo.png') }}" alt="Logo" width="30" height="30"
                    class="d-inline-block align-text-top me-2 ">
                <h4 class="mb-0">

                    FAvaa HR
                </h4>
            </a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="bg-transparent border-0 p-0">
                    <h4><i class="fa-solid fa-right-from-bracket text-primary"></i></h4>
                </button>
            </form>
        </div>
    </nav>
    <div class="container mt-3 content">
        <div class="row mb-2">
            <div class="col-sm-12 d-flex justify-content-between ">
                <h6 class="text-primary">
                    @php
                        echo date('l, d F Y');
                    @endphp
                </h6>
                <h6 class="text-primary">
                    08:00 - 17:00
                </h6>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-sm-12 d-flex ">
                <img src="https://www.mecgale.com/wp-content/uploads/2017/08/dummy-profile.png" alt=""
                    class=" me-2 rounded-circle border-2 border-white" width="45" height="45">
                <div class="d-flex flex-column justify-content-center">

                    <h6 class="mb-0">
                        {{ $userEmployee->name }}
                    </h6>
                    <p class="mb-0">Fullstack Developer</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mb-3">
            <div class="w-100">
                <h6 class="text-primary">Check In Today</h6>
                <div
                    class="check-in bg-gradient-success w-100 rounded d-flex justify-content-center align-items-center">
                    @if ($dataCheckInToday != null)
                        <i class="fa-solid fa-camera fa-2x text-white me-2"></i>
                        <h4 class="text-white mb-0">
                            {{ $dataCheckInToday->check_in_time }}
                        </h4>
                    @else
                        <h5 class="text-white mb-0">
                            Belum absen
                        </h5>
                    @endif

                </div>
            </div>
            <div class="w-100">
                <h6 class="text-primary">Check Out Today</h6>
                <div
                    class="check-out bg-gradient-danger w-100 rounded d-flex justify-content-center align-items-center">
                    @if ($dataCheckOutToday != null)
                        <i class="fa-solid fa-camera fa-2x text-white me-2"></i>
                        <h5 class="text-white mb-0">
                            {{ $dataCheckOutToday->check_out_time }}
                        </h5>
                    @else
                        <h5 class="text-white mb-0">
                            Belum pulang
                        </h5>
                    @endif

                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-card border-1">
            <div class="card-body d-flex justify-content-between">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-power-off text-danger fa-2x mb-1"></i>
                    <span class="font-weight-normal">Cuti</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-calendar-week text-info fa-2x mb-1"></i>
                    <span class="font-weight-normal">History</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-credit-card text-warning fa-2x mb-1"></i>
                    <span class="font-weight-normal">Payroll</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-user text-primary fa-2x mb-1"></i>
                    <span class="font-weight-normal">Profile</span>
                </div>
            </div>
        </div>

        <h6>Attendance history - 5 days ago</h6>
        <div class="row mt-3">
            @foreach ($attendanceHistory as $history)
                <div class="col-sm-12 d-flex justify-content-center mb-3">
                    <div class="card shadow-none border-0 bg-primary-2 w-100">
                        <div
                            class="card-header py-1 px-3 @if ($history->status == 'Present') {{ 'bg-gradient-success' }}
                        @elseif($history->status == 'Late') {{ 'bg-gradient-danger' }} @endif  d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-white">
                                {{ \Carbon\Carbon::parse($history->check_in_date)->format('d, F Y') }}</h6>
                            <h6 class="mb-0 text-white">{{ $history->status }}@if ($history->status == 'Present')
                                    <i class="fa-solid fa-circle-check ms-2"></i>
                                @elseif($history->status == 'Late')
                                    <i class="fa-solid fa-clock-rotate-left ms-2"></i>
                                @endif
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-between">

                                    <h4 class="mb-0 text-white text-center">Check In <br>
                                        {{ $history->check_in_time }}</h4>
                                    <h1 class="text-white">|</h1>
                                    <h4 class="mb-0 text-white text-center">Check Out <br>
                                        {{ $history->check_out_time }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



            {{-- <div class="col-sm-12 d-flex justify-content-center mb-3">

                <div class="card shadow-none border-0 bg-primary-2 w-100">
                    <div
                        class="card-header py-1 px-3 bg-gradient-danger  d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white">23, Desember 2023</h6>
                        <h6 class="mb-0 text-white">Late<i class="fa-solid fa-clock-rotate-left ms-2"></i></h6>
                    </div>
                    <div class="card-body  p-3">
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-between">

                                <h4 class="mb-0 text-white text-center">Check In <br> 08:00</h4>
                                <h1 class="text-white">|</h1>
                                <h4 class="mb-0 text-white text-center">Check Out <br> 17:00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center mb-3">

                <div class="card shadow-none border-0 bg-primary-2 w-100">
                    <div
                        class="card-header py-1 px-3 bg-gradient-secondary  d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white">23, Desember 2023</h6>
                        <h6 class="mb-0 text-white">Absent<i class="fa-regular fa-person-through-window ms-2"></i>
                        </h6>
                    </div>
                    <div class="card-body  p-3">
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-between">

                                <h4 class="mb-0 text-white text-center">Check In <br> 08:00</h4>
                                <h1 class="text-white">|</h1>
                                <h4 class="mb-0 text-white text-center">Check Out <br> 17:00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center mb-3">

                <div class="card shadow-none border-0 bg-primary-2 w-100">
                    <div
                        class="card-header py-1 px-3 bg-gradient-secondary  d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white">23, Desember 2023</h6>
                        <h6 class="mb-0 text-white">Absent<i class="fa-regular fa-person-through-window ms-2"></i>
                        </h6>
                    </div>
                    <div class="card-body  p-3">
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-between">

                                <h4 class="mb-0 text-white text-center">Check In <br> 08:00</h4>
                                <h1 class="text-white">|</h1>
                                <h4 class="mb-0 text-white text-center">Check Out <br> 17:00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>


        <!--   Core JS Files   -->
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
        @stack('additional-js')
        <!-- GitHub buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }


            $(document).ready(function() {
                // Fungsi untuk mengatur margin pada elemen konten
                function setMarginTop() {
                    var navbarHeight = $('.navbar').outerHeight();
                    $('.content').css('margin-top', navbarHeight + 'px !important');
                }

                // Panggil fungsi setMarginTop saat halaman dimuat dan ketika jendela diubah ukurannya
                setMarginTop();
                $(window).resize(setMarginTop);
            });

            function alreadyPresent() {
                Swal.fire({
                    icon: 'error',
                    title: 'Anda Sudah Absen',
                    text: 'Anda Sudah Absen hari ini',
                    showConfirmButton: false,
                    timer: 1000
                })
            }

            function nothingSchedule() {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak ada Jadwal',
                    text: 'Hari ini tidak ada jadwal Kerja',
                    showConfirmButton: false,
                    timer: 1000
                })
            }

            function canNotPresent() {
                Swal.fire({
                    icon: 'error',
                    title: 'Belum masuk jam kerja',
                    text: 'Tunggu hingga jam kerja dimulai',
                    showConfirmButton: false,
                    timer: 1000
                })
            }

            function canNotCheckOut() {
                Swal.fire({
                    icon: 'error',
                    title: 'Belum masuk jam pulang',
                    text: 'Tunggu saat waktu jam pulang',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        </script>
</body>

</html>
