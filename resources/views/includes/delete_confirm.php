<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
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
        <button type="button" class="btn btn-danger" id="confirm">Yes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
      document.getElementById('delete').submit();
  });
</script>