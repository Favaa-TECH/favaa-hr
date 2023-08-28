<div wire:ignore.self class="modal fade" id="showDataAttendanceModal" tabindex="-1" aria-labelledby="showDataAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showDataAttendanceModalLabel">Detail Absensi</h5>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <h6>Nama</h6>
                        <p>{{ $employeeName }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Check In Time</h6>
                        <p>{{ $check_in_time }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Check Out Time</h6>
                        <p>{{ $check_out_time }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Status</h6>
                        <p>{{ $status }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6>Check In Date</h6>
                        <p>{{ $check_in_date }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Check Out Date</h6>
                        <p>{{ $check_out_date }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Photo In</h6>
                        @if($photo_in == null)
                        <p>-</p>
                        @else
                        <img src="{{ asset('storage/attendance/photos/'.$photo_in) }}" alt="" srcset="" height="300px" width="100%">
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Photo Out</h6>
                        @if($photo_out == null)
                        <p>-</p>
                        @else
                        <img src="{{ asset('storage/attendance/photos/'.$photo_out) }}" alt="" srcset="" height="300px" width="100%">
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Location lng Lat Check In</h6>
                        <p>{{ $check_in_latitude }} {{ $check_in_longitude }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Location lng Lat Check Out</h6>
                        <p>{{ $check_out_latitude }} {{ $check_out_longitude }}</p>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
