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
    <meta name="twitter:description" content="Join a meeting from web: <?php echo base_url('room/'.$meeting_code); ?> Or Use meeting ID for mobile app.Meeting ID: <?php echo $meeting_code; ?>" />
    <meta name="twitter:title" content="Join a Meeting.Meeting ID: <?php echo $meeting_code; ?> - <?php echo $app_name; ?>" />
    <meta property="og:title" content="Join a Meeting.Meeting ID: <?php echo $meeting_code; ?> - <?php echo $app_name; ?>" />
    <meta name="twitter:image" content="<?php echo $og_image; ?>">
    <meta name="twitter:site" content="@<?php echo $app_name; ?>">

    <meta property="og:url" content="<?php echo base_url('room/'.$meeting_code); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Join a meeting from web: <?php echo base_url('room/'.$meeting_code); ?> Or Use meeting ID for mobile app.Meeting ID: <?php echo $meeting_code; ?>" />
    <meta property="og:image:alt" content="<?php echo $app_name; ?> - Preview">
    <meta property="og:image" content="<?php echo $og_image; ?>" />

    <title><?php echo get_app_config("app_name") ?> - Meeting Room</title>
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <script src='https://meet.jit.si/external_api.js' type="text/javascript"></script>
  </head>
  <body>
    <div id="meeting"></div>
      <script type="text/javascript">
          const domain = '<?php echo $this->common_model->get_jitsi_server_domain(); ?>';
          const options = {
            roomName: '<?php echo $meeting_code; ?>',
            width: "100%",
            height: 920,
            parentNode: document.querySelector('#meeting'),
            onload: function(){
            }
          };
          const api = new JitsiMeetExternalAPI(domain, options);
      </script>
  </body>
</html>