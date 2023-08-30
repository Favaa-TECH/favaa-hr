@push('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
            max-height: 500px !important;

        }

        .table-sticky th:first-child,
        .table-sticky td:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            /* Atur warna latar belakang yang sesuai */
            z-index: 1;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.6.0/slimselect.min.js"
        integrity="sha512-0E8oaoA2v32h26IycsmRDShtQ8kMgD91zWVBxdIvUCjU3xBw81PV61QBsBqNQpWkp/zYJZip8Ag3ifmzz1wCKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.6.0/slimselect.css"
        integrity="sha512-ijXMfMV6D0xH0UfHpPnqrwbw9cjd4AbjtWbdfVd204tXEtJtvL3TTNztvqqr9AbLcCiuNTvqHL5c9v2hOjdjpA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
<div>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($showForm)
                                @include('livewire.dashboard.include.schedule-form')
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex w-100  justify-content-between">
                            <h5 class="text-primary">Schedules</h5>
                            <div class="p-0">
                                <button wire:click='showFormSchedule' href=""
                                    class="btn btn-block btn-sm bg-gradient-primary mb-3 px-3 py-2"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>

                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 table-sticky" id="attendance-table">
                                    <thead>
                                        <tr class="sticky-top">
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ps-4">
                                                No
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1">
                                                Employee Name
                                            </th>

                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Shift Type</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                Start Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-1 ">
                                                End Date</th>
                                            <th
                                                class="text-uppercase text-xxs font-weight-bolder text-secondary opacity-7 p-1">
                                                Aksi
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataSchedule) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center text-primary text-sm">Tidak ada
                                                    data</td>
                                            </tr>
                                        @else
                                            @foreach ($dataSchedule as $schedule)
                                                <tr>
                                                    <td class="p-4">{{ $loop->iteration }}</td>
                                                    <td class="p-1">
                                                        <div class="d-flex px-0 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $schedule->employee->name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-1 align-middle">
                                                        <h6
                                                            class="badge badge-sm  @if($schedule->shift->shift_type == 'Normal Shift') bg-gradient-primary @elseif ($schedule->shift->shift_type == 'Night Shift') bg-gradient-secondary @elseif ($schedule->shift->shift_type == 'Morning Shift') bg-gradient-warning @endif   p-2 text-uppercase">
                                                            {{ $schedule->shift->shift_type }}</h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $schedule->start_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-1">
                                                        <h6 class=" font-weight-bold mb-0">
                                                            {{ $schedule->end_date }}
                                                        </h6>
                                                    </td>
                                                    <td class="p-0">
                                                        <button wire:click='confirmDelete({{ $schedule->id }})'
                                                            class="badge badge-sm bg-gradient-danger text-white border-0"
                                                            style="color: inherit" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            <i class="fa-solid fa-trash"></i></button>

                                                        <button wire:click="showFormEditSchedule({{ $schedule->id }})"
                                                            class="badge badge-sm bg-gradient-success text-white border-0"
                                                            style="color: inherit">
                                                            <i class="fa-solid fa-pen-to-square"></i></button>
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
    @include('livewire.dashboard.include.confirm-delete-modal')
</div>

@push('additional-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        Livewire.on('show-form-schedule', () => {
            $(document).ready(function() {
                new SlimSelect({
                    select: '#single-employee'
                })
                new SlimSelect({
                    select: '#single-shift'
                })
            });
        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        Livewire.on('success', data => {
            toastr.success(data[0].message)
        });
    </script>
@endpush
