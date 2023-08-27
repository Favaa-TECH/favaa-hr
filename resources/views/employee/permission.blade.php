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
                    Permission
                </h4>
            </a>

        </div>
    </nav>

    <div class="container mt-3 content">
        <a href="{{ route('empl-permission.submit-permission') }}" class="btn bg-primary mb-3 px-3 py-2 text-white">Ajukan
            Ijin</a>
        <div class="row">
            <h4 class="mb-3">History Ijin</h4>
            @foreach ($permissionData as $index => $permission)
                <div class="col-md-12 mb-3">
                    <div class="card card-frame">
                        <div
                            class="card-header px-4 py-2 text-capitalize {{ $permission->status == 'pending' ? 'bg-gradient-secondary' : ($permission->status == 'approved' ? 'bg-gradient-success' : ($permission->status == 'rejected' ? 'bg-gradient-danger' : ($permission->status == 'cancelled' ? 'bg-gradient-primary' : ''))) }}  text-white d-flex justify-content-between border">
                            <div class="">

                                {{ $permission->status }}
                            </div>
                            <div class="" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Left popover"></div>
                        </div>
                        <div class="card-body bg-white p-3 border">
                            <h6>Tanggal Ijin</h6>
                            <p> {{ $permission->start_date }} - {{ $permission->end_date }}</p>
                            <h6>Tipe Ijin</h6>
                            <p>{{ $permission->permission_type }}</p>
                            <h6>Alasan Ijin</h6>
                            <p>{{ $permission->permission_reason }}</p>
                            @if ($permission->status == 'rejected')
                                <h6>Alasan Penolakan</h6>
                                <p>{{ $permission->rejected_reason }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $permissionData->links() }}
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
