<x-app-employee>
    @push('additional-css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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

            #map {
                height: 180px;
                border-radius: 15px;
            }

            .webcam-capture,
            .webcam-capture video {
                display: inline-block;
                width: 100% !important;
                margin: auto;
                height: auto !important;
                border-radius: 15px;
            }

            .card-header {
                border-radius: 8px 8px 0 0 !important;
            }

            .card-body {
                border-radius: 0 0 8px 8px !important;

            }
        </style>
    @endpush

    <nav class="navbar bg-body-tertiary shadow-none py-3 fixed-top bg-white  shadow-sm">
        <div class="container-fluid px-2 d-flex justify-content-start align-items-center">
            <h4 class="me-4 mb-0">
                <a href="{{ route('empl-presence') }}"><i class="fa-solid fa-chevron-left text-primary"
                        style="font-size: 27px;"></i></a>
            </h4>
            <a class=" d-flex justify-content-center align-items-center" href="#">

                <h4 class="text-primary">
                    History
                </h4>
            </a>

        </div>
    </nav>

    <div class="container mt-3 content">

        <div class="row">
            <h4 class="mb-3">History Absensi</h4>
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
        {{ $attendanceHistory->links() }}
    </div>




    @push('additional-js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}', // Berikan nilai dalam tanda kutip
                    showConfirmButton: false,
                    timer: 1000
                });
            @endif
        </script>
    @endpush

</x-app-employee>
