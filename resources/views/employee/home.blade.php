<x-app-employee>
    @push('additional-css')
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
    @endpush

    @if ($dataSchedule == null)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="nothingSchedule()"><i
                class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
    @elseif($cekAlreadyPresent > 0)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="alreadyPresent()"><i
                class="fa-regular fa-fingerprint text-white fa-2x"></i></button>
    @elseif($passWorkTimeCheck)
        <button type="button" class="rounded-circle fab bg-gradient-danger border-white border-2"
            style="width: 75px;height: 75px" onclick="passWorkTime()"><i
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
                        echo \Carbon\Carbon::now()
                            ->locale('id')
                            ->isoFormat('dddd, DD MMMM YYYY');
                    @endphp
                </h6>
                <h6 class="text-primary">
                    {{ date_format($shiftStartTime, 'H:i') }} - {{ date_format($shiftEndTime, 'H:i') }}
                </h6>
            </div>

        </div>
        <div class="row mb-4">

            <div class="col-sm-12 d-flex ">
                <img src="{{ asset('storage/' . $userEmployee->photo) }}" alt=""
                    class=" me-2 rounded-circle border-2 border-white" width="45" height="45">
                <div class="d-flex flex-column justify-content-center">

                    <h6 class="mb-0">
                        {{ $userEmployee->name }}
                    </h6>

                    <p class="mb-0"> {{ $userEmployee->position->name }}</p>
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
                <a href="{{ route('empl-leave.index') }}"
                    class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-power-off text-danger fa-2x mb-1"></i>
                    <span class="font-weight-normal">Cuti</span>
                </a>
                <a href="{{ route('empl-permission.index') }}"
                    class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-note-sticky text-primary text-warning fa-2x mb-1"></i>
                    <span class="font-weight-normal">Izin</span>
                </a>
                <a href="{{ route('empl-history.index') }}" class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-calendar-week text-info fa-2x mb-1"></i>
                    <span class="font-weight-normal">History</span>
                </a>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-credit-card text-warning fa-2x mb-1"></i>
                    <span class="font-weight-normal">Payroll</span>
                </div>
            </div>
        </div>

        <h6>Attendance history - 5 days ago</h6>
        <div class="row mt-3">
            @foreach ($attendanceHistory as $history)
                <div class="col-sm-12 d-flex justify-content-center mb-3">
                    <div class="card shadow-none border-0 bg-primary-2 w-100">
                        <div
                            class="card-header py-1 px-3 {{ $history->status == 'Present' ? 'bg-gradient-success' : ($history->status == 'Late' ? 'bg-gradient-danger' : ($history->status == 'Holiday' ? 'bg-gradient-info' : 'bg-gradient-secondary')) }}
                            d-flex justify-content-between align-items-center">
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
                                    @if($history->status == 'Holiday' || $history->status == 'Permission' || $history->status = 'Leave')
                                    <h4 class="mb-0 text-white text-center">
                                        {{ $history->check_in_date }}</h4>
                                    <h1 class="text-white">|</h1>
                                    <h4 class="mb-0 text-white text-center">
                                        {{ $history->check_out_date }}</h4>
                                    @else

                                    <h4 class="mb-0 text-white text-center">Check In <br>
                                        {{ $history->check_in_time }}</h4>
                                    <h1 class="text-white">|</h1>
                                    <h4 class="mb-0 text-white text-center">Check Out <br>
                                        {{ $history->check_out_time }}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        @push('additional-js')
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
                function passWorkTime() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam kerja sudah lewat',
                        text: 'Anda tidak melakukan absen pada jam kerja',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            </script>
        @endpush
</x-app-employee>
