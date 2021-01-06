<?php 
  $app_mode                 =   get_app_config("app_mode");
  $app_mandatory_login      =   get_app_config("app_mandatory_login");
  $cron_key                 =   get_app_config("cron_key");
  $db_backup                =   get_app_config("db_backup");
 ?>

<?php echo form_open(base_url() . 'admin/system_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
    </div>
    <div class="card-body">
    <div class="row"> 
      <!-- panel  -->
      <div class="col-md-12">
        <div class="form-group row">
          <label class="col-sm-3 control-label">App Name</label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo get_app_config("app_name");?>" name="app_name" class="form-control" required  />
          </div>
        </div> 
        <div class="form-group row">
          <label class="col-sm-3 control-label">Purchase Code</label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo get_app_config("purchase_code");?>" name="purchase_code" class="form-control" required  />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label">Jitsi Server URL</label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo get_app_config("jitsi_server");?>" name="jitsi_server" class="form-control" required  />
            <p><small>Upstreaming server address.You can use your own server by self host software download from here:</small></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label"><strong>Privacy Policy URL FOR ANDROID</strong></label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo base_url('privacy-policy/') ?>" readonly class="form-control" required data-parsley-length="[14, 128]" />
            <p><small>Copy &amp; paste this URL to app source code.</small></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-md-3">App Mode</label>
          <div class="col-sm-3">
              <select class="form-control m-bot15" id="app_mode" name="app_mode">
                <option value="free" <?php if($app_mode == 'free'){echo 'selected';}?> >Free</option>
                <option value="academic" <?php if($app_mode == 'academic'){echo 'selected';}?> >Academic</option>
              </select>
              <p><small>Example: Free mode any user can join and host meeting but academic mode student can join a meeting only.</small></p>
          </div>
        </div>            

        <div class="form-group row">
          <label class="control-label col-md-3">Mandatory Login</label>
          <div class="col-sm-3">
              <select class="form-control m-bot15" id="app_mandatory_login" name="app_mandatory_login">
                <option value="true" <?php if($app_mandatory_login == 'true'){echo 'selected';}?> >Enable</option>
                <option value="false" <?php if($app_mandatory_login == 'false'){echo 'selected';}?> >Disable</option>
              </select>
              <p><small>All user to join a meeting with/without login.</small></p>
          </div>
        </div>

        
        <div class="form-group row">
          <label class="control-label col-md-3">Allow Unauthorized Meeting ID</label>
          <div class="col-sm-3">
              <select class="form-control m-bot15" id="allow_unauthorized_meeting_code" name="allow_unauthorized_meeting_code">
                <option value="true" <?php if(get_app_config("allow_unauthorized_meeting_code") == 'true'){echo 'selected';}?> >Yes</option>
                <option value="false" <?php if(get_app_config("allow_unauthorized_meeting_code") == 'false'){echo 'selected';}?> >No</option>
              </select>
              <p><small>Allow user to join a meeting room which is not created by <?php echo get_app_config("app_name"); ?>.</small></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label">Meeting ID Prefix</label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo get_app_config("meeting_prefix");?>" name="meeting_prefix" class="form-control" required  />
          </div>
        </div>      

        <div class="form-group row">
          <label class="col-sm-3 control-label">Address</label>
          <div class="col-sm-9">
            <textarea rows="5" name="business_address" class="form-control"><?php echo get_app_config("business_address");?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 control-label">Phone</label>
          <div class="col-sm-9">
            <input type="number"  value="<?php echo get_app_config("business_phone");?>" name="business_phone" class="form-control" data-parsley-length="[10, 14]"  />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 control-label">System Email</label>
          <div class="col-sm-9">
            <input type="email"  value="<?php echo get_app_config("system_email");?>" name="system_email" class="form-control"   />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label">Contact Email</label>
          <div class="col-sm-9">
            <input type="email"  value="<?php echo get_app_config("contact_email");?>" name="contact_email" class="form-control"   />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label">Privacy &amp; Policy</label>
          <div class="col-sm-9">
            <textarea name="privacy_policy_text" id="privacy_policy_text" rows="10" class="form-control"><?php echo get_app_config("privacy_policy_text");?></textarea>
            <p><small>HTML is allowed</small></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-md-3">Addthis Share</label>
          <div class="col-sm-3">
              <select class="form-control m-bot15" id="addthis_enable" name="addthis_enable">
                <option value="true" <?php if(get_app_config("addthis_enable") == 'true'){echo 'selected';}?> >Enable</option>
                <option value="false" <?php if(get_app_config("addthis_enable") == 'false'){echo 'selected';}?> >Disable</option>
              </select>
              <p><small>Share meeting URL with friends by addthis(Web Only).</small></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label">Addthis Public ID</label>
          <div class="col-sm-9">
            <input type="text"  value="<?php echo get_app_config("addthis_pubid");?>" name="addthis_pubid" class="form-control" required  />
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
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#privacy_policy_text').summernote({
        height: 200, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });
    $('form').parsley();
  });
</script>

