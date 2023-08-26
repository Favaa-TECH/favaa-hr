 <!-- Modal -->
 <div wire:ignore.self class="modal fade" id="confirmDeleteSpecialHoliday" tabindex="-1" aria-labelledby="confirmDeleteSpecialHolidayLabel"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="confirmDeleteSpecialHolidayLabel">Data akan dihapus. Apakah kamu yakin?</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                 <button wire:click.prevent="deleteSpecialHoliday()" type="button" class="btn btn-sm btn-danger"
                     data-bs-dismiss="modal">Hapus</button>
             </div>
         </div>
     </div>
 </div>
