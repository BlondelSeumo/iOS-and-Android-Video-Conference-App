<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php echo form_open(base_url() . 'admin/push_notification_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
          <div class="alert alert-warning">If you don't have <a href="https://onesignal.com/" target="_blank">OneSignal</a> account yet.Signup <a href="https://onesignal.com/" target="_blank">here</a> to get AppID And Key.</div>
          <div class="form-group row">
            <label class=" col-sm-4 control-label">OneSignal AppID</label>
            <div class="col-sm-9">
              <input type="text" name="onesignal_appid" class="form-control" value="<?php echo get_app_config("onesignal_appid");?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-sm-4 control-label">Onesignal Api Keys</label>
            <div class="col-sm-9">
              <input type="text" name="onesignal_api_keys" class="form-control" value="<?php echo get_app_config("onesignal_api_keys");?>" required>
            </div>
          </div>          
          <button type="submit" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50"><i class="fa fa-check"></i></span>
            <span class="text">Save Changes</span>
          </button>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>




