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
                            <h6>Shift</h6>
                            <div class="p-0">
                                <button type="button" class="btn btn-block btn-sm bg-primary mb-3 px-3 text-sm text-white"
                                    data-bs-toggle="modal" data-bs-target="#modal-shift">Add Shift
                                </button>
                            </div>
                            <div class="modal fade" id="modal-shift" tabindex="-1" role="dialog"
                                aria-labelledby="modal-shift" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <h4 class="font-weight-bolder text-primary">Add Shift</h4>
                                                </div>
                                                <div class="card-body">
                                                    <form class="form text-left" method="POST"
                                                        action="{{ route('shift.store') }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6">
                                                                <label>Nama Shift</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="Nama Shift">
                                                            </div>
                                                             <div class="col-sm-12 col-md-6">
                                                                <label>Shift Type</label>
                                                                <select name="choosen_day" id=""
                                                                    class="form-control">
                                                                    <option value="">
                                                                        <i>-- Pilih Type Shift --</i>
                                                                    </option>
                                                                    <option value="senin">
                                                                        Normal Shift
                                                                    </option>
                                                                    <option value="selasa">
                                                                        Night Shift
                                                                    </option>
                                                                    <option value="rabu">
                                                                        Morning Shift
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <label>Start Time</label>
                                                                <input type="time" name="start_time" class="form-control"
                                                                    placeholder="Start Time">
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <label>End Time</label>
                                                                <input type="time" name="end_time" class="form-control"
                                                                    placeholder="End Time">
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
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                                No
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Name
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Shift Type
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Start Time
                                            </th>
                                            <th
                                                class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                End Time
                                            </th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @if (count($dataShift) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary">No Data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataShift as $shift)
                                                <tr>
                                                    <td class="p-4">{{ $index++ }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $shift->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $shift->shift_type }}
                                                        </p>
                                                    </td>
                                                    <td class="p-0">

                                                        <form action="{{ route('holiday.delete', $shift->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="badge badge-sm bg-gradient-danger text-white border-0"
                                                                style="color: inherit"
                                                                onclick="return confirm('Data akan dihapus.. apakah anda yakin?')">
                                                                <i class="fa-solid fa-trash"></i></button>
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
        @if (session('success'))
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

        @if (session('error'))
            {{-- Toastify.error('{{ session('error') }}').showToast(); --}}
        @endif
    </script>
@endpush
