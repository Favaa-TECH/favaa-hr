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
                <a href="{{ route('empl-leave.index') }}"><i class="fa-solid fa-chevron-left text-primary"
                        style="font-size: 27px;"></i></a>
            </h4>
            <a class=" d-flex justify-content-center align-items-center" href="#">

                <h4 class="text-primary">
                    Submit Cuti
                </h4>
            </a>

        </div>
    </nav>

    <div class="container mt-3 content">

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('empl-leave.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" id="start_date" name="start_date">
                        @error('start_date')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control  @error('end_date') is-invalid @enderror" value="{{ old('end_date')}} " id="end_date" name="end_date">
                        @error('end_date')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="leave_type" class="form-label">Tipe Cuti</label>
                        <select name="leave_type" class="form-select  @error('leave_type') is-invalid @enderror" value="{{ old('leave_type')}}" aria-label="Default select example">
                            <option disabled selected> <i>--- Pilih Tipe Cuti ---</i></option>
                            <option value="Cuti Tahunan">Cuti Tahunan</option>
                            <option value="Cuti Sakit">Cuti Sakit</option>
                            <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                            <option value="Cuti Karena Alasan Penting">Cuti Karena Alasan Penting</option>
                            <option value="Cuti Diluar Tanggungan Perusahaan">Cuti Diluar Tanggungan Perusahaan</option>
                        </select>
                        @error('leave_type')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="leave_attachment" class="form-label ">Bukti Pendukung <span class="text-primary">
                                (Opsional)</span><br><small
                                class="text-danger text-xs font-weight-light">pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max
                                2mb</small></label>

                        <input class="form-control  @error('leave_attachment') is-invalid  @enderror " value="{{ old('leave_attachment') }}" type="file" name="leave_attachment" id="leave_attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                        @error('leave_attachment')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="leave_reason" class="form-label">Alasan Cuti</label>
                        <textarea class="form-control  @error('leave_reason') is-invalid @enderror " value="{{ old('leave_reason') }}" name="leave_reason" id="" cols="30" rows="5"></textarea>
                        @error('leave_reason')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>



    @push('additional-js')
    @endpush

</x-app-employee>
