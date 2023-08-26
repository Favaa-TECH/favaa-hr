<form class="form text-left" enctype="multipart/form-data">

    <div class="row">
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
                        <div class="form-group">
                            <label for="photo-input">Foto
                                User</label>
                            <input wire:model.blur='photo' type="file"
                                class="form-control @error('photo') is-invalid @enderror" id="photo-input"
                                accept="image/jpeg, image/png, image/jpg">
                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 ">

                        <div class="form-group">
                            <label for="name">Nama
                            </label>
                            <input wire:model.blur='name' type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Nama">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <label>Email</label>
            <div class="input-group mb-3">
                <input wire:model.blur='email' type="email"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <label>Role</label>
            <select wire:model.blur='role' class="form-control @error('role') is-invalid @enderror">
                <option value="">Pilih Role</option>
                <option value="Administrator" class="text-normal">Administrator
                </option>
                <option value="HR Manager" class="text-normal">HR Manager
                </option>
                <option value="Payroll Manager" class="text-normal">Payroll Manager
                </option>
                <option value="Employee" class="text-normal">Employee
                </option>
            </select>
            @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if($editMode == true)
        <div class="row">

            <div class="col-md-6 form-group">
                <label>Password Lama</label>
                <input wire:model.blur='oldPassword' type="password" id="password"
                    class="form-control @error('oldPassword') is-invalid @enderror" name="password" placeholder="Password" />
                @error('oldPassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        @endif
        <div class="col-md-6 form-group">
            <label>Password Baru</label>
            <input wire:model.blur='password' type="password" id="password"
                class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" />
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 form-group">
            <label>Konfirmasi Password</label>
            <input wire:model.live='password_confirmation' type="password" id="password"
                class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                placeholder="Konfirmasi Password" />
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


    </div>


    <div class="text-end">

        @if ($editMode)
            <button wire:click.prevent='update' type="submit" class="btn btn-sm  bg-gradient-primary btn-lg  me-3 mb-0">
                Update
            </button>
        @else
            <button wire:click.prevent='store' type="submit" class="btn btn-sm  bg-gradient-primary btn-lg   me-3 mb-0">
                Save
            </button>
        @endif
        <button wire:click.prevent="closeFormUser"
            class="btn btn-sm bg-gradient-secondary text-white text-md font-weight-normal px-5 float-end me-3">Cancel
        </button>
    </div>

</form>
