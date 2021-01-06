<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">
    <div class="row"> 
      <!-- panel  -->
      <div class="col-md-12">        
        <?php echo form_open(base_url() . 'admin/email_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data','id'=>'mail'));?> 
        <!-- panel  -->     
        <h4>Contact Email</h4>
        <hr>
        <div class="form-group row">
          <label class="col-sm-3 control-label">Contact Email</label>
          <div class="col-sm-9">
            <input type="email"  value="<?php echo get_app_config("contact_email");?>" name="contact_email" class="form-control"   />
            <p>All contact mail will send to this email..</p>
          </div>
        </div>
        <h4>Outgoing Server Configuration</h4>
        <hr>          
        <div class="form-group row">
          <label class="control-label col-md-3">Mail Type</label>
          <div class="col-sm-3">
              <select class="form-control m-bot15" id="protocol" name="protocol">
                <option value="mail" <?php if(get_app_config("protocol")=='mail'){echo 'selected';}?> >Mail</option>                  
                <option value="smtp" <?php if(get_app_config("protocol")=='smtp'){echo 'selected';}?> >SMTP (Recommanded)</option>
                <option value="sendmail" <?php if(get_app_config("protocol")=='sendmail'){echo 'selected';}?> >Sednmail</option>
              </select>
          </div>
        </div>
        <div id="smtp">
          <div class="form-group row">
            <label class="col-sm-3 control-label">SMTP Server Address</label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo get_app_config("smtp_host");?>" name="smtp_host" class="form-control"   placeholder="ex: smtp.gmail.com"/>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label">SMTP Username</label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo get_app_config("smtp_user");?>" name="smtp_user" class="form-control"   placeholder="ex: example@gmail.com"/>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label">SMTP Password</label>
            <div class="col-sm-9">
              <input type="password"  value="*************" name="smtp_pass" class="form-control"   placeholder="ex: ******"/>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label">SMTP Port</label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo get_app_config("smtp_port");?>" name="smtp_port" class="form-control"   placeholder="ex: 465"/>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">SMTP Crypto</label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="slider_type" name="smtp_crypto">
                  <option value="ssl" <?php if(get_app_config("smtp_crypto")=='ssl'){echo 'selected';}?> >SSL</option>
                  <option value="tls" <?php if(get_app_config("smtp_crypto")=='tls'){echo 'selected';}?> >TLS</option>
                </select>
            </div>
          </div>
        </div>
        <div id="sendmail">
          <div class="form-group row">
            <label class="col-sm-3 control-label">Mail Path</label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo get_app_config("mailpath");?>" name="mailpath" class="form-control"   placeholder="ex: /usr/bin/sendmail"/>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-icon-split">
          <span class="icon text-white-50"><i class="fa fa-check"></i></span>
          <span class="text">Save Changes</span>
        </button>
      <?php echo form_close(); ?> 
    </div>
  </div>
        
    <?php echo form_open(base_url() . 'admin/test_mail' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data','id'=>'test-mail'));?>
          <div class="col-md-6 offset-md-3">
            <div class="panel panel-border panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Test Configuration</h3>
              </div>
              <div class="panel-body">
                <div class="form-group row m-b-0">
                                    
                      <div class="input-group">
                        <input type="email" class="form-control" name='email' value="<?php echo get_app_config("contact_email");?>" placeholder="Enter your email" required>
                        <span class="input-group-btn">
                        <button type="submit" id="import_btn" class="btn btn-primary w-sm waves-effect waves-light"> Test </button>
                        
                        </span> </div>
                        <div id="result"></div>
                    <?php echo form_close(); ?>        
                </div>
              </div>
            </div>
          </div>
      </div>
    </div></div>
</div>
<script>
    $(document).ready(function() {
        <?php $protocol=get_app_config("protocol");
        if ($protocol=='smtp'):?>
        $("#sendmail").fadeOut();
        <?php endif; if ($protocol=='sendmail'):?>
        $("#smtp").fadeOut();
        <?php endif;?>
        <?php if($protocol=='mail'):?>
        $("#sendmail").fadeOut();
        $("#smtp").fadeOut();
      <?php endif; ?>
        
    });
    $("#protocol").change(function() {
        var protocol = $("#protocol option:selected").val();
        if (protocol == 'smtp') {
            $("#smtp").fadeIn();
            $("#sendmail").fadeOut();
        } else if (protocol == 'sendmail') {
            $("#smtp").fadeOut();
            $("#sendmail").fadeIn();
        }
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
      $(document).ready(function() {
        $('#mail').parsley();
        $('#test-mail').parsley();
      });
    </script> 

<!-- file select--> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select--> 

