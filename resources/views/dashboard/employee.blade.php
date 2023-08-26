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
                            <h6>Table Karyawan</h6>
                            <div class="p-0">
                                <a href="{{route('employee.add')}}"
                                   class="btn btn-block btn-sm bg-gradient-primary mb-3"><i
                                        class="fa-sharp fa-solid fa-user-plus fa-2x"></i></a>
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
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Jabatan
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Telepon
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Tanggal Lahir
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                            Timestamp
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
                                    @if(count($dataEmployee) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center text-primary">No Data</td>
                                        </tr>
                                    @else
                                        @foreach($dataEmployee as $employee )
                                            <tr>
                                                <td class="p-4">{{ $index++ }}</td>
                                                <td class="p-1">
                                                    <div class="d-flex px-0 py-1">

                                                        <div>
                                                            <img src="{{ asset('/storage/public/photos/'.$employee->photo) }}"
                                                                 class="avatar avatar-sm me-3"
                                                                 alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$employee->name}}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{$employee->email}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-1">
                                                    <p class="text-xs font-weight-bold mb-0">{{$employee->position->name}}</p>
                                                    <p class="text-xs text-secondary mb-0">{{$employee->outlet->nama_ot}}</p>
                                                </td>
                                                <td class="p-1 align-middle  text-sm">
                                                    <span class="badge badge-sm bg-primary">{{$employee->phone}}</span>
                                                </td>
                                                <td class="p-1 align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ date_format(date_create($employee->date_of_birth), 'd F Y')}}</span>
                                                </td>
                                                <td class="p-1 align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ date_format(date_create($employee->date_of_birth), 'd/m/y H:i') }}</span>
                                                </td>
                                                <td class=" p-1 align-middle">
                                                    <form action="{{route('employee.delete',$employee->id)}}"
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

        @if(session('error'))
            {{--Toastify.error('{{ session('error') }}').showToast();--}}
        @endif


    </script>
@endpush
