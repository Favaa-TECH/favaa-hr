<div wire:ignore.self class="modal fade" id="showEmployeeModal" tabindex="-1" aria-labelledby="showEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showEmployeeModalLabel">Detail Karyawan</h5>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-5 text-center">
                        <img id="preview-image" src="storage/{{ $sPhoto }}" alt="profile image"
                        class="img-fluid rounded-circle shadow" style="width: 165px;height: 165px">
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Nama</h6>
                        <p>{{ $sName }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Email</h6>
                        <p>{{ $sEmail }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Telepon</h6>
                        <p>{{ $sPhone }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Jenis Kelamin</h6>
                        <p>{{ $sGender }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Tanggal Lahir</h6>
                        <p>{{ $sDateOfBirth }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Jabatan</h6>
                        <p>{{ $sPosition }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Outlet / Departement</h6>
                        <p>{{ $sOutlet }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Alamat</h6>
                        <p>{{ $sAddress }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>No Rekening</h6>
                        <p>{{ $sAccountNumber }}</p>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
