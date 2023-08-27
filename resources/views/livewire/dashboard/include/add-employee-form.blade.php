<form enctype="multipart/form-data">
    <div class="row mt-4">
        <div class="col-md-4 d-flex justify-content-center align-items-center mb-3">
            @if ($photo)
                <img id="preview-image" src="{{ $photo->temporaryUrl() }}" alt="profile image"
                    class="img-fluid rounded-circle shadow" style="width: 150px;height: 150px">
            @elseif($photo == null)
                @if ($oldPhoto != null)
                    <img id="preview-image" src="storage/{{ $oldPhoto }}" alt="profile image"
                        class="img-fluid rounded-circle shadow" style="width: 150px;height: 150px">
                @else
                    <img id="preview-image" src="https://via.placeholder.com/150" alt="profile image"
                        class="img-fluid rounded-circle shadow" style="width: 150px;height: 150px">
                @endif
            @endif
        </div>

        <div class="col-md-8 ">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="form-group mb-0">
                        <label for="photo-input">Foto Karyawan</label>
                        <input wire:loading.attr="disabled" wire:model.blur="photo" type="file"
                            class="form-control  @error('photo')
                        is-invalid
                @enderror"
                            id="photo-input" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event)">
                    </div>
                    @error('photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12 ">

                    <div class="form-group mb-0">
                        <label for="name">Nama Lengkap</label>
                        <input wire:model.blur="name" type="text" name="name"
                            class="form-control @error('name')
                    is-invalid
            @enderror"
                            id="name" placeholder="Nama lengkap">
                    </div>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="email">Email</label>
                <input wire:model.blur="email" type="email"
                    class="form-control @error('email')
            is-invalid
    @enderror" id="email"
                    placeholder="Email">
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="telephone">Nomor Telepon</label>
                <input wire:model.blur="phone" type="text"
                    class="form-control @error('phone')
            is-invalid
    @enderror" id="telephone"
                    placeholder="telepon">
            </div>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="gender">Jenis Kelamin</label>
                <select class="form-control @error('gender')
            is-invalid
    @enderror"
                    wire:model.blur="gender">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            @error('gender')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="dob">Tanggal Lahir</label>
                <input wire:model.blur="date_of_birth" type="date"
                    class="form-control @error('date_of_birth')
            is-invalid
    @enderror" id="dob">
            </div>
            @error('date_of_birth')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row">


        <div class="col-md-6">

            <div class="form-group mb-0">
                <label for="telephone">Jabatan</label>
                <select class="form-control @error('position_id')
            is-invalid
    @enderror"
                    wire:model.blur="position_id">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($dataPosition as $position)
                        <option value="{{ $position->id }}" class="text-normal">
                            {{ $position->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('position_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="gender">Lokasi Outlet</label>
            <select class="form-control @error('outlet_id')
        is-invalid
@enderror" wire:model.blur="outlet_id">
                <option value="">Pilih Outlet</option>
                @foreach ($dataOutlet as $outlet)
                    <option value="{{ $outlet->id }}" class="text-normal">
                        {{ $outlet->nama_ot }}</option>
                @endforeach
            </select>
            @error('outlet_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-3">

        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="account_number">Nomor Rekening</label>
                <input type="text" wire:model.blur="account_number"
                    class="form-control @error('account_number')
            is-invalid
    @enderror"
                    id="account_number" rows="3" placeholder="Masukan Nomor Rekening"></input>
            </div>
            @error('account_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="dob">Alamat</label>
                <textarea wire:model.blur="address" class="form-control @error('address')
            is-invalid
    @enderror"
                    id="address" rows="3" placeholder="Masukan Alamat"></textarea>
            </div>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    @if ($editMode == true)
        <button wire:click.prevent="update" type="submit"
            class="btn btn-sm bg-gradient-primary text-white text-md font-weight-normal px-5 float-end ">Update
        </button>
    @else
        <button wire:click.prevent="store" type="submit"
            class="btn btn-sm bg-gradient-primary text-white text-md font-weight-normal px-5 float-end ">Simpan
        </button>
    @endif

    <button wire:click.prevent="closeFormEmployee"
        class="btn btn-sm bg-gradient-secondary text-white text-md font-weight-normal px-5 float-end me-3">Cancel
    </button>

</form>
