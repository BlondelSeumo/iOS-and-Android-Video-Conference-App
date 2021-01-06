<?php 
    $meetings    = $this->db->get_where('meeting', array('meeting_id' => $param2))->result_array();
    foreach ($meetings as $row) :
    echo form_open(base_url() . 'admin/meeting/update/'.$param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));
?>
<!-- modal header -->
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Edit Meeting</h5>
  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<!-- modal body -->
<div class="modal-body">  
  <div class="form-group">
    <label class="control-label">Meeting Title</label>
    <input type="text" name="meeting_title" value="<?php echo $row['meeting_title']; ?>" class="form-control" required placeholder="Enter meeting title" />
  </div>
<!-- modal footer -->
<div class="modal-footer">
  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-primary btn-icon-split">
    <span class="icon text-white-50"><i class="fa fa-check"></i></span>
    <span class="text">Save</span>
  </button>
</div>
</form>
<?php endforeach; ?>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();

  });
</script>

