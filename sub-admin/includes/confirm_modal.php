<div class="modal fade response_modal" id="confirm_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="responsemodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <form class="modal-content" method='post' id='delete_modal_form'>
        <div class="modal-header">
          <h5 class="modal-title" id="responsemodalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <span id='icon' style="font-size:70px">&#9432;</span>
            <h5 id='message'></h5>
        </div>
        <div class="modal-footer d-flex w-100 align-items-center flex-nowrap ">
          <button type='submit' id='btn_value' class="btn btn-danger w-50" name='delete_table'>Delete</button>
          <button type="button"  class="btn btn-secondary w-50 " data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
    </div>
</div>