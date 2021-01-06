<?php echo form_open(base_url() . 'admin/meeting/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<!-- modal header -->
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Create new meeting</h5>  
  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<!-- modal body -->
<div class="modal-body">  
  <div class="form-group">
    <label class="control-label">Meeting Title</label>
    <input type="text" name="meeting_title" class="form-control" required placeholder="Enter meeting title" />
  </div>
  <div class="form-group">
    <label class="control-label">Meeting ID</label>
    <input type="text" name="meeting_code" class="form-control" required placeholder="Enter Meeting ID" />
  </div>
<!-- modal footer -->
<div class="modal-footer">
  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-primary btn-icon-split">
    <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
    <span class="text">Create</span>
  </button>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();

  });
</script>

        