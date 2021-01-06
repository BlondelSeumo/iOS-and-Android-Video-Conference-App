<?php 
  $app_name       = get_app_config("app_name");
  $app_mode       = get_app_config("app_mode");
  $meeting_code   = $this->common_model->generate_meeting_code();
  $addthis_enable = get_app_config("addthis_enable");
  $addthis_pubid  = get_app_config("addthis_pubid"); 
  $backdrop_image = base_url('uploads/'.get_app_config('backdrop_image')); 
  $og_image       = base_url('uploads/'.get_app_config('og_image'));
  $check_availability_to_host_meeting   = $this->common_model->check_availability_to_host_meeting(); 
  $check_availability_to_join_meeting   = $this->common_model->check_availability_to_join_meeting(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="<?php echo base_url('uploads/system_logo/'.get_app_config("favicon")); ?>">

  <!-- open-graph -->
  <meta property="og:locale" content="en_US" />
  <meta name="twitter:card" content="summary">
  <meta name="twitter:description" content="Join and host a meeting by - <?php echo $app_name; ?>" />
  <meta name="twitter:title" content="<?php echo $app_name; ?> - Join Meeting" />
  <meta name="twitter:image" content="<?php echo $og_image; ?>">
  <meta name="twitter:site" content="@<?php echo $app_name; ?>">

  <meta property="og:title" content="<?php echo $app_name; ?> - Join Meeting" />
  <meta property="og:url" content="<?php echo base_url(); ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:description" content="Join and host a meeting by - <?php echo $app_name; ?>" />
  <meta property="og:image" content="<?php echo $og_image; ?>" />
  <meta property="og:image:alt" content="<?php echo $app_name; ?> - Preview">

  <title><?php echo $app_name; ?> - Join Meeting</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <style type="text/css">
    .bg-login-image{
      background: url("<?php echo $backdrop_image; ?>");
      background-size: cover !important;
      background-position: center !important;
    }
    .nav{
      display: flex;
      background-color: #eaecf4;
      border-radius: 0.25rem;
    }
    .nav-item{
      width: 50%;
    }
    .nav-pills .nav-link {
      text-align: center;
      border-radius: .25rem;
    }
    .nav-pills .nav-link.link-left {
      border-top-left-radius: 0.25rem;
      border-top-right-radius: 0rem;
      border-bottom-right-radius: 0rem;
      border-bottom-left-radius: 0.25rem;
    }
    .nav-pills .nav-link.link-right {
      border-top-left-radius: 0rem;
      border-top-right-radius: 0.25rem;
      border-bottom-right-radius: 0.25rem;
      border-bottom-left-radius: 0rem;
    }
  </style>
  <?php if($addthis_enable == "true"): ?>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addthis_pubid; ?>"></script>
  <?php endif; ?>


</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <a href="<?php echo base_url(); ?>">
                      <img src="<?php echo base_url('uploads/system_logo/'.get_app_config("logo")); ?>"></a><br>
                    <a href="<?php echo base_url(); ?>"><h1 class="h4 text-gray-900 mb-4"><?php echo get_app_config("app_name") ?> - Login</h1></a>
                  </div>
                  <!-- error/success message -->
                  <?php if($this->session->flashdata('success') !='') : ?>
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        ×
                      </button>
                      <?php echo $this->session->flashdata('success'); ?>
                    </div>
                  <?php endif; ?>
                  <?php if($this->session->flashdata('error') !='') : ?>
                    <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        ×
                      </button>
                      <?php echo $this->session->flashdata('error'); ?>
                    </div>
                  <?php endif; ?>
                  <!-- error/success message End-->
                  <?php if($check_availability_to_host_meeting && $check_availability_to_join_meeting): ?>
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link link-left active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Join Meeting</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link link-right" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Host Meeting</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form class="user" action="<?php echo base_url('room/join'); ?>" method="post">
                          <div class="form-group">
                            <input type="text" name="meeting_code" class="form-control form-control-user" id="" aria-describedby="" placeholder="Enter Meeting ID">                   
                          </div>
                          <button type="submit" class="btn btn-primary btn-user btn-block">Join Now</button>
                        </form>
                      </div>
                      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                          <form class="user" action="<?php echo base_url('room/create-and-join'); ?>" method="post">
                            <div class="form-group">
                              <input type="text" name="meeting_title" value="" class="form-control form-control-user" id="" aria-describedby="" placeholder="Enter Meeting Title(optional)">
                            </div>
                            <div class="form-group">
                              <input type="text" name="meeting_code" value="<?php echo $meeting_code; ?>" required class="form-control form-control-user" id="" aria-describedby="" placeholder="Enter Meeting ID">
                              <div class="my-2"></div>
                              <?php if($addthis_enable == "true"): ?>
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                <div class="addthis_inline_share_toolbox_f6vn"></div>
                              <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Create &amp; Join Now</button>
                          </form>                     
                      </div>
                    </div>
                  <?php elseif($check_availability_to_join_meeting): ?>
                    <form class="user" action="<?php echo base_url('room/join'); ?>" method="post">
                      <div class="form-group">
                        <input type="text" name="meeting_code" class="form-control form-control-user" id="" aria-describedby="" placeholder="Enter Meeting ID">                   
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">Join Now</button>
                    </form>
                    <?php else: ?>
                      <div class="text-center">
                        <div class="alert alert-warning">Please Login to Explore.</div>                    
                          <a class="small" href="<?php echo base_url('login'); ?>">Login</a> |
                          <a class="small" href="<?php echo base_url('signup'); ?>">Signup</a>
                      </div>
                  <?php endif; ?>
                  <?php if($this->session->userdata('login_status') !='1'): ?>
                    <hr>
                    <div class="text-center">                    
                      <a class="small" href="<?php echo base_url('login'); ?>">Login</a> |
                      <a class="small" href="<?php echo base_url('signup'); ?>">Signup</a>
                    </div>
                  <?php if($this->session->userdata('login_type') == "admin"):?>
                    <hr>
                    <div class="text-center">                    
                      <a class="small" href="<?php echo base_url('admin/dashboard'); ?>">Back to Dashboard</a>
                    </div>
                  <?php endif; endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
  <?php if($addthis_enable == "true"): ?>
    <script type="text/javascript">
      var addthis_share = {
         url: "<?php echo base_url("room/".$meeting_code); ?>",
         title: "Create and join a meeting - <?php echo $app_name; ?>",
         description: "THE DESCRIPTION",
         media: "<?php echo $og_image; ?>"
      }
    </script>
  <?php endif; ?>

</body>

</html>