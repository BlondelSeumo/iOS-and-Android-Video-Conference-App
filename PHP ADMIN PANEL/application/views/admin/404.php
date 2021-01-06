<?php 
  $app_name       = get_app_config("app_name"); 
  $og_image       = base_url('uploads/'.get_app_config('og_image')); 
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

  <title><?php echo get_app_config("app_name") ?> - Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <style type="text/css">
    .bg-login-image{
      background: url("<?php echo base_url('uploads/'.get_app_config('backdrop_image')); ?>");
    }
  </style>

</head>

<body>

  <!-- Begin Page Content -->
	<div class="container-fluid">

	  <!-- 404 Error Text -->
	  <div class="text-center">
	    <div class="error mx-auto" data-text="404">404</div>
	    <p class="lead text-gray-800 mb-5">Page Not Found</p>
	    <p class="text-gray-500 mb-0">It looks like you found a glitch in the page...</p>
	    <a href="<?php echo base_url() ?>">&larr; Back to Home</a>
	  </div>

	</div>
	<!-- /.container-fluid -->

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

</body>

</html>