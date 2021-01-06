<?php echo form_open(base_url() . 'admin/logo_and_image/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">
    <div class="row"> 
      <!-- panel  -->
      <div class="col-md-12">          
        <div class="form-group row">
          <label class="control-label col-sm-3"></label>
          <div class="col-sm-9">
             <img id="website_logo" src="<?php echo base_url().'uploads/system_logo/'.get_app_config('logo'); ?>"  alt="logo" >
          </div>
        </div>              

        <div class="form-group row">
          <label class="control-label col-sm-3">Website Logo</label>
          <div class="col-sm-9">
            <input type="file" onchange="showImg(this,'website_logo');" name="logo" class="filestyle" accept="image/*">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3"></label>
          <div class="col-sm-9">
             <img id="website_favicon" src="<?php echo base_url().'uploads/system_logo/'.get_app_config('favicon'); ?>"  alt="favicon" >
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Favicon</label>
          <div class="col-sm-9">
            <input type="file" onchange="showImg(this,'website_favicon');" name="favicon" class="filestyle" accept="image/*">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3"></label>
          <div class="col-sm-9">
             <img id="backdrop_image" src="<?php echo base_url().'uploads/'.get_app_config('backdrop_image'); ?>"  alt="backdrop_image" style="max-width: 440px" >
          </div>
        </div>              

        <div class="form-group row">
          <label class="control-label col-sm-3">Backdrop Image</label>
          <div class="col-sm-9">
            <input type="file" onchange="showImg(this,'backdrop_image');" name="backdrop_image" class="filestyle" accept="image/*">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3"></label>
          <div class="col-sm-9">
             <img id="og_image" src="<?php echo base_url().'uploads/'.get_app_config('og_image'); ?>"  alt="og_image" style="max-width: 440px" >
          </div>
        </div>              

        <div class="form-group row">
          <label class="control-label col-sm-3">OpenGraph Image</label>
          <div class="col-sm-9">
            <input type="file" onchange="showImg(this,'og_image');" name="og_image" class="filestyle" accept="image/*">
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


<!-- file select--> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select--> 



<!--instant image dispaly-->
<script type="text/javascript">
    function showImg(input,id) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#'+id).attr('src', e.target.result)
          };
          reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!--end instant image dispaly-->



