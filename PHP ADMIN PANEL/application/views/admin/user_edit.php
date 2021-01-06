<?php 
    $users    = $this->db->get_where('user', array('user_id' => $param2))->result_array();
    foreach ($users as $row) :
    echo form_open(base_url() . 'admin/manage_user/update/'.$param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));
?>
<!-- modal header -->
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<!-- modal body -->
<div class="modal-body">  
  <div class="form-group">
    <label class="control-label">Full Name</label>
    <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control" placeholder="Enter user full name" />
  </div>
  <div class="form-group">
    <label class="control-label">Email</label>
    <input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter email" />
  </div>

  <div class="form-group">
    <label class="control-label">Login Password</label>
    <input type="password" name="password" class="form-control" placeholder="Enter login password" />
  </div>


  <div class="form-group">
    <label class="control-label">User Role</label>
    <select class="form-control" name="role" required>
      <option value="admin" <?php if($row['role'] == "admin"): echo "selected"; endif; ?>>admin</option>
      <option value="subscriber" <?php if($row['role'] == "subscriber"): echo "selected"; endif; ?>>subscriber</option>
      <?php if(get_app_config("app_mode") == "academic"): ?>
        <option value="teacher" <?php if($row['role'] == "teacher"): echo "selected"; endif; ?>>Teacher</option>
      <?php endif; ?>
    </select>
  </div>
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

