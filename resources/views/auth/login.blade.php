@extends('layouts.auth')
@push('additional-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" action="{{route('login.authenticate')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg" placeholder="Email"
                                                   aria-label="Email" name="email" value="{{old('email')}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg  @error('foto')
                                                is-invalid
                                        @enderror"
                                                   placeholder="Password" aria-label="Password" name="password"
                                                   value="{{old('password')}}" required>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('foto')
                                                is-invalid
                                        @enderror" type="checkbox" id="rememberMe">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                                Sign in
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('./assets/img/favaa-picture.jpg'); background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h2 class="mt-5 text-white font-weight-bolder position-relative ">FAVAA HUMAN RESOURCE
                                    MANAGEMENT SYSTEM</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

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


        @if (Session::has('login-fail'))
        Toastify({
            text: "{{ Session::get('login-fail') }}",
            duration: 5000,
            close: true,
            gravity: "top",
            position: "left",
            backgroundColor: "#EF4747",
        }).showToast();
        @endif

        @if (session('success'))
        Toastify({
            text: "{{ session('success') }}",
            duration: 2000,
            close: true,
            gravity: "top",
            position: "left",
            style: {
                background: "linear-gradient(to right, #003399, #1185EF)",
                color: "#fff",
                fontSize: "14px",
            }
        }).showToast();
        @endif
    </script>
@endpush
