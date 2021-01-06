<?php echo form_open(base_url() . 'admin/manage_user/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<!-- modal header -->
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Add new user</h5>  
  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<!-- modal body -->
<div class="modal-body">  
  <div class="form-group">
    <label class="control-label">Full Name</label>
    <input type="text" name="name" class="form-control" placeholder="Enter user full name" />
  </div>
  <div class="form-group">
    <label class="control-label">Email</label>
    <input type="text" name="email" class="form-control" placeholder="Enter email" />
  </div>

  <div class="form-group">
    <label class="control-label">Login Password</label>
    <input type="password" name="password" class="form-control" placeholder="Enter login password" />
  </div>


  <div class="form-group">
    <label class="control-label">User Role</label>
    <select class="form-control" name="role" required>
      <option value="admin">admin</option>
      <option value="subscriber">subscriber</option>
      <?php if(get_app_config("app_mode") == "academic"): ?>
        <option value="teacher">Teacher</option>
      <?php endif; ?>
    </select>
  </div>
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

        