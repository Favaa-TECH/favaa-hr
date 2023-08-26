@extends('layouts.app')

@section('content')
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 py-4  px-5">
                        <form action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-4">
                                <div class="col-md-4 d-flex justify-content-center align-items-center mb-3">
                                    <img id="preview-image" src="https://via.placeholder.com/150" alt="profile image"
                                         class="img-fluid rounded-circle shadow" style="width: 150px;height: 150px" >
                                </div>

                                <div class="col-md-8 ">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                                <label for="photo-input">Foto Karyawan</label>
                                                <input type="file" name="photo" class="form-control" id="photo-input"
                                                       accept="image/jpeg, image/png, image/jpg"  onchange="previewImage(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">

                                            <div class="form-group">
                                                <label for="name">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                       placeholder="Nama lengkap">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telephone">Nomor Telepon</label>
                                        <input type="text" name="phone" class="form-control" id="telephone"
                                               placeholder="telepon">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Jenis Kelamin</label>
                                        <select class="form-control" name="gender">
                                            <option value="Laki-laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Tanggal Lahir</label>
                                        <input type="date" name="date_of_birth" class="form-control" id="dob"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="telephone">Jabatan</label>
                                        <select class="form-control" name="position_id">
                                            @foreach($dataPosition as $position)
                                                <option value="{{$position->id}}"
                                                        class="text-normal">{{$position->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="gender">Lokasi Outlet</label>
                                    <select class="form-control" name="outlet_id">
                                        @foreach($dataOutlet as $outlet)
                                            <option value="{{$outlet->id}}"
                                                    class="text-normal">{{$outlet->nama_ot}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dob">Alamat</label>
                                        <textarea name="address" class="form-control" id="address" rows="3"
                                                  placeholder="Masukan Alamat"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn bg-primary text-white text-md font-weight-normal px-5 float-end ">Simpan
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.partials.footer')
        </div>
    </main>

@endsection
@push('additional-js')
    <script>
        function previewImage(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

