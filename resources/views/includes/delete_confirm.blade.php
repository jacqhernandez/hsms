<?php echo '<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about you want to delete this?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" id="confirm">Yes</button>
      </div>
    </div>
  </div>' ?>

<script>
  $('#confirm').on('click', function(){
    document.getElementById('delete').submit();
  });
</script>