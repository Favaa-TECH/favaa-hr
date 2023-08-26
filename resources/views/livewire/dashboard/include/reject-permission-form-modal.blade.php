<div wire:ignore class="modal fade" id="rejectPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="rejectPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="rejectPermissionModalLabel">Reject Leave
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form text-left">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label class="w-100">Alasan Penolakan Ijin</label>
                            <textarea wire:model='rejectedReason' class="form-control" name="" id="" cols="30" rows="5"></textarea>
                        </div>
                        @error('rejectedReason')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror


                    </div>


                    <div class="text-end">
                        <button wire:click.prevent='rejectPermission' type="submit"
                            class="btn btn-sm  bg-gradient-danger  mt-4 me-2">
                            Reject
                        </button>

                        <button wire:click='resetForm' type="button" class="btn btn-sm btn-secondary mt-4"
                        data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


