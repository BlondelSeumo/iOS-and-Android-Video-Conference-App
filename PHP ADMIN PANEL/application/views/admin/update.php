<?php echo form_open(base_url() . 'admin/process_update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">
    <div class="row"> 
      <!-- panel  -->
      <div class="col-md-12"> 
        <div class="form-group row">
          <label class="control-label col-sm-3">Current Version</label>
          <div class="col-sm-3">
            <strong><?php echo $this->db->get_where('config' , array('title' =>'version'))->row()->value; ?></strong>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Update file</label>
          <div class="col-sm-3">
            <input type="file" name="zip_file" class="filestyle">
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-icon-split">
          <span class="icon text-white-50"><i class="fa fa-upload"></i></span>
          <span class="text">Process Update</span>
        </button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- file select--> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select-->