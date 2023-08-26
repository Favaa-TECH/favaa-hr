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
                            <h6> User</h6>
                            <div class="p-0">
                                {{--Modal Button--}}
                                <button type="button" class="btn btn-block btn-sm bg-gradient-info mb-3"
                                        data-bs-toggle="modal" data-bs-target="#modal-positionoutlet"><i
                                        class="fa-solid fa-user-doctor fa-2x me-1"></i><i
                                        class="fa-regular fa-plus"></i>
                                </button>
                                {{--Modal Body--}}
                                <div class="modal fade" id="modal-positionoutlet" tabindex="-1" role="dialog"
                                     aria-labelledby="modal-positionoutlet" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="card card-plain">
                                                    <div class="card-header pb-0 text-left">
                                                        <h4 class="font-weight-bolder text-primary">Add User</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <form class="form text-left" method="POST"
                                                              action="{{route('user.store')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div
                                                                        class="col-md-4 d-flex justify-content-center align-items-center mb-3">
                                                                        <img id="preview-image"
                                                                             src="https://via.placeholder.com/150"
                                                                             alt="profile image"
                                                                             class="img-fluid rounded-circle shadow"
                                                                             style="width: 150px;height: 150px">
                                                                    </div>

                                                                    <div class="col-md-8 ">
                                                                        <div class="row">
                                                                            <div class="col-md-12 ">
                                                                                <div class="form-group">
                                                                                    <label for="photo-input">Foto
                                                                                        Karyawan</label>
                                                                                    <input type="file" name="photo"
                                                                                           class="form-control"
                                                                                           id="photo-input"
                                                                                           accept="image/jpeg, image/png, image/jpg"
                                                                                           onchange="previewImage(event)">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 ">

                                                                                <div class="form-group">
                                                                                    <label for="name">Nama
                                                                                    </label>
                                                                                    <input type="text" name="name"
                                                                                           class="form-control"
                                                                                           id="name"
                                                                                           placeholder="Nama">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Email</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="email" class="form-control"
                                                                               placeholder="Email" name="email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Role</label>
                                                                    <select class="form-control" name="role">

                                                                        <option value="Administrator"
                                                                                class="text-normal">Administrator
                                                                        </option>
                                                                        <option value="HR Manager"
                                                                                class="text-normal">HR Manager
                                                                        </option>
                                                                        <option value="Payroll Manager"
                                                                                class="text-normal">Payroll Manager
                                                                        </option>
                                                                        <option value="Employee"
                                                                                class="text-normal">Employee
                                                                        </option>


                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Password</label>
                                                                    <input type="password" id="password"
                                                                           class="form-control @error('password') is-invalid @enderror"
                                                                           name="password" placeholder="Password"/>
                                                                    @error('password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Konfirmasi Password</label>
                                                                    <input type="password" id="password"
                                                                           class="form-control @error('password') is-invalid @enderror"
                                                                           name="password_confirmation"
                                                                           placeholder="Konfirmasi Password"/>
                                                                    @error('password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>


                                                            </div>


                                                            <div class="text-end">
                                                                <button type="submit"
                                                                        class="btn btn-sm  bg-gradient-primary btn-lg  mt-4 mb-0">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--End Modal Body--}}
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Role
                                        </th>
                                        <th class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                            Aksi
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @if(count($users) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center text-primary">No Data</td>
                                        </tr>
                                    @else
                                        @foreach($users as $user )
                                            <tr>
                                                <td class="p-4">{{ $index++ }}</td>
                                                <td class="p-1">
                                                    <div class="d-flex px-0 py-1">
                                                        <div>
                                                            <img src="/storage/photos/{{$user->photo}}"
                                                                 class="avatar avatar-sm me-3"
                                                                 alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="p-1 align-middle  text-sm">
                                                    <span class="badge badge-sm bg-primary">{{$user->role}}</span>
                                                </td>
                                                <td class=" p-1 align-middle">
                                                    <form action="{{route('user.delete',$user->id)}}"
                                                          method="POST" class="me-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="badge badge-sm bg-gradient-danger text-white border-0"
                                                                style="color: inherit"
                                                                onclick="return confirm('Data akan dihapus.. apakah anda yakin?')">
                                                            <i
                                                                class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }


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
        @if(session('success-add-outlet'))
        Toastify({
            text: "{{ session('success-add-outlet') }}",
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
        @if(session('success-delete-outlet'))
        Toastify({
            text: "{{ session('success-delete-outlet') }}",
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
