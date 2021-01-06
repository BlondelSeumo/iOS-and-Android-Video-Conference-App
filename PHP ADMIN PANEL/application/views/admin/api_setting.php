<?php echo form_open(base_url('admin/api_setting/update/'.$key->id) , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-3 control-label"><strong>API SERVER URL FOR APP</strong></label>
      <div class="col-sm-9">
        <textarea rows="2" id="api_v100_url" name="business_address" onclick="copyToClipboard('api_v100_url')" class="form-control" readonly><?php echo base_url(); ?></textarea>
        <p><small>Copy &amp; paste this URL to App Source Code.</small></p>
      </div>
    </div>
    <div class="form-group row">      
      <label class="col-sm-3 control-label"><strong>API KEY FOR APP</strong></label>
      <div class="col-sm-6">
        <input type="text"  value="<?php echo $key->key; ?>" id="api_v100_key" onclick="copyToClipboard('api_v100_key')" name="key" class="form-control" required data-parsley-length="[14, 128]" />
      </div>
        <div class="col-sm-3">
          <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
            <span class="icon text-white-50"><i class="fa fa-check"></i></span>
            <span class="text">Save Changes</span>
          </button>
          <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/api_setting/update_key/'.$key->id); ?>">Create New Key</a>
        </div> 
        <?php echo form_close(); ?>       
    </div>    
  </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script> 
<script type="text/javascript">
  function copyToClipboard(element) {
    var copyText = document.getElementById(element);
    copyText.select();
  }
</script>

