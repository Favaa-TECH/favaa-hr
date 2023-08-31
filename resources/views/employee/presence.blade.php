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
                    Absen
                </h4>
            </a>

        </div>
    </nav>

    <div class="container mt-3 content">

        <div class="row mb-4">
            <div class="col-sm-12 d-flex ">
                <img src="{{ asset('storage/'.$dataEmployee->photo) }}" alt=""
                    class=" me-2 rounded-circle border-2 border-white" width="45" height="45">
                <div class="d-flex flex-column justify-content-center">

                    <h6 class="mb-0">
                        {{ $dataEmployee->name }}
                    </h6>
                    <p class="mb-0">{{ $dataEmployee->email }}</p>
                </div>
            </div>
        </div>
        <div class="row px-2 mb-3">

            <h6 id="status-location">Status Lokasi</h6>

            <input type="hidden" class="form-control" name="lat" id="lat">
            <input type="hidden" class="form-control" name="long" id="long">
            <div id="map"></div>
        </div>
        <div class="row mb-3">
            <h6>Kamera</h6>
            <div class="col-sm-12 d-flex ">
                <div class="webcam-capture"></div>
            </div>
        </div>

        @if ($cek > 0)
            <button class="btn btn-danger btn-block fs-5 fw-bold w-100" id="take-presence"> Absen Pulang</button>
        @else
            <button class="btn btn-primary btn-block fs-5 fw-bold w-100" id="take-presence"> Absen Masuk</button>
        @endif

    </div>

    <audio id="notif-in">
        <source src="{{ asset('assets/sound/absen-sound.mp3') }}" type="audio/mp3">
    </audio>
    <audio id="notif-out">
        <source src="{{ asset('assets/sound/pulang-sound.mp3') }}" type="audio/mp3">
    </audio>
    <audio id="out-radius">
        <source src="{{ asset('assets/sound/out-of-radius.mp3') }}" type="audio/mp3">
    </audio>

    @push('additional-js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            var notif_in = document.getElementById("notif-in");
            var notif_out = document.getElementById("notif-out");
            var out_radius = document.getElementById("out-radius");
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


            var lat = document.getElementById("lat");
            var long = document.getElementById("long");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                    enableHighAccuracy: true
                });
            }

            function successCallback(position) {
                lat.value = position.coords.latitude;
                long.value = position.coords.longitude;
                var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);
                var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                var circle = L.circle([{{ $outlet_lat }}, {{ $outlet_long }}], {
                    color: '#0047D3',
                    fillColor: '#0047D3',
                    fillOpacity: 0.5,
                    radius: 15
                }).addTo(map);
            }

            function errorCallback(error) {
                console.log(error);
            }

            Webcam.set({
                width: 480,
                height: 640,
                image_format: 'jpeg',
                jpeg_quality: 80
            });

            Webcam.attach('.webcam-capture');

            $('#take-presence').click(function(e) {
                Webcam.snap(function(uri) {
                    var image = uri;
                    var lat = $('#lat').val();
                    var long = $('#long').val();

                    var formData = new FormData();
                    formData.append('image', dataURItoBlob(image));
                    formData.append('lat', lat);
                    formData.append('long', long);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('presence.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 'success-check-in') {
                                notif_in.play();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Absen Masuk',
                                    text: 'Selamat pagi!, Selamat bekerja ya! Semangat!',
                                    showConfirmButton: false,
                                    timer: 4000
                                }).then(function() {
                                    window.location.href = "{{ route('empl-presence') }}";
                                });
                                return;
                            } else if (response.status == 'success-check-out') {
                                notif_out.play();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Absen Pulang',
                                    text: 'Wah udah waktunya pulang nih, hati-hati dijalan!',
                                    showConfirmButton: false,
                                    timer: 4000
                                }).then(function() {
                                    window.location.href = "{{ route('empl-presence') }}";
                                });
                            } else if (response.status == 'error-out-of-radius') {
                                out_radius.play();
                                var status_location = document.getElementById("status-location");
                                status_location.innerHTML =
                                    'Status Lokasi <span class="badge badge-sm bg-danger">Out Of Radius <i class="fa-solid fa-right-from-bracket"></i></span>';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Diluar Radius',
                                    text: 'Maaf anda berada diluar radius kantor',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else if (response.status == 'error-already-present') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Anda Sudah Absen',
                                    text: 'Kan sudah absen, ngapain absen lagi?',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                });
            });

            function dataURItoBlob(dataURI) {
                var byteString = atob(dataURI.split(',')[1]);
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                var blob = new Blob([ab], {
                    type: mimeString
                });
                return blob;
            }
        </script>
    @endpush
</x-app-employee>
