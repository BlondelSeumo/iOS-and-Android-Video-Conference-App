<?php 
    $mobile_ads_enable                  =   get_app_config("mobile_ads_enable");
    $mobile_ads_network                 =   get_app_config("mobile_ads_network");
    $admob_publisher_id                 =   get_app_config("admob_publisher_id");
    $admob_app_id                       =   get_app_config("admob_app_id");
    $admob_banner_ads_id                =   get_app_config("admob_banner_ads_id");
    $admob_interstitial_ads_id          =   get_app_config("admob_interstitial_ads_id");
    $fan_native_ads_placement_id        =   get_app_config("fan_native_ads_placement_id");
    $fan_banner_ads_placement_id        =   get_app_config("fan_banner_ads_placement_id");
    $fan_interstitial_ads_placement_id  =   get_app_config("fan_interstitial_ads_placement_id");
    $startapp_app_id                    =   get_app_config("startapp_app_id");
 ?>
 <?php echo form_open(base_url() . 'admin/mobile_ads_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group row">
                    <label class="control-label col-sm-3 ">Ads Enable</label>
                    <div class="col-sm-6">
                      <div class="toggle">
                        <label>
                          <input type="checkbox" name="mobile_ads_enable" <?php if($mobile_ads_enable =='1'){ echo 'checked';} ?>><span class="button-indecator"></span>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 control-label">Ads Network</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="mobile_ads_network" required>
                      <option value="admob" <?php if($mobile_ads_network == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                    </select>
                  </div>
                </div>
                <strong>Admob</strong>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Publisher ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_publisher_id;?>" data-parsley-minlength="10" name="admob_publisher_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob APP ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_app_id;?>" data-parsley-minlength="10" name="admob_app_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Banner Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_banner_ads_id;?>" data-parsley-minlength="10" name="admob_banner_ads_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Interstitial Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_interstitial_ads_id;?>" data-parsley-minlength="10" name="admob_interstitial_ads_id" class="form-control" required  />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50"><i class="fa fa-check"></i></span>
                  <span class="text">Save Changes</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script> 