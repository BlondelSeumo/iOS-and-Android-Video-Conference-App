<?php
    $business_address         =   get_app_config("business_address");
    $system_email             =   get_app_config("system_email");
    $business_phone           =   get_app_config("business_phone");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Abdul Mannan">
    <meta name="copyright" content="Copyright (c) 2014 - 2018 SpaGreen">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <link rel="shortcut icon" href="<?php echo base_url('uploads/system_logo/'.get_app_config("favicon")); ?>">
    <!-- CSS-->

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/summernote/dist/summernote.css" rel="stylesheet" />
    <script src="<?php echo base_url("assets/"); ?>vendor/jquery/jquery.min.js"></script>
    <title><?php echo $page_title.' - '.get_app_config("app_name");?></title>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php  include'navigation.php';?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

              <!-- Sidebar Toggle (Topbar) -->
              <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
              </button>

              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('name'); ?></span>
                    <img class="img-profile rounded-circle" src="<?php echo $this->common_model->get_img('user', $this->session->userdata('user_id')).'?'.time();?>">
                  </a>
                  <!-- Dropdown - User Information -->
                  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo base_url();?>admin/manage_profile">
                      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                      Profile
                    </a>
                    <a class="dropdown-item" href="<?php echo base_url();?>admin/manage_profile">
                      <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                      Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url();?>login/logout">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Logout
                    </a>
                  </div>
                </li>

              </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
              <!-- Page Heading -->
              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo $page_title; ?></h1>
              </div>
              <?php  include $page_name.'.php';?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Developed by: <a href="http://www.spagreen.net">SpaGreen Creative</a></span>
                </div>
            </div>
        </footer>
      <!-- End of Footer -->
      </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
   <!-- ajax modal  -->
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url(); ?>assets/images/preloader.gif" /> </div>
        <!-- content will be load here -->
        <div id="dynamic-content"></div>        
      </div>
    </div>
  </div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#menu', function(e) {
            e.preventDefault();
            var url = $(this).data('id'); // it will get action url
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show(); // load ajax loader
            $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'html'
                })
            .done(function(data) {
                console.log(data);
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response 
                $('#modal-loader').hide(); // hide ajax loader 
            })
            .fail(function() {
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
        });
    });
</script>
<!-- END Ajax modal  -->

<!-- Ajax Delete -->
<script type="text/javascript">
    function delete_row2(table_name, row_id) {
        var table_row = '#row_' + row_id
        var base_url = '<?php echo base_url();?>'
        url = base_url + 'admin/delete_record/'
        swal({
            title: "Are you sure?",
            text: "It will delete permanently",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3CB371',
            cancelButtonText: "Cancel",
            confirmButtonText: "Yes, Delete it.",
            showLoaderOnConfirm: true,
            closeOnConfirm: false,
            closeOnCancel: false
        },function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                        url: url,
                        type: 'POST',
                        data: 'row_id=' + row_id + '&table_name=' + table_name,
                        dataType: 'json'
                    })
                    .done(function(response) {
                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        swal("Deleted", response.message, response.status);
                        $(table_row).fadeOut(2000);
                    })
                    .fail(function() {
                        swal('Oops...', response.message, response.status);
                    });
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    }
</script>
<script type="text/javascript">
    function delete_row(table_name, row_id) {
        var table_row = '#row_' + row_id
        var base_url = '<?php echo base_url();?>'
        url = base_url + 'admin/delete_record/'        
        swal({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            icon: "warning",
            buttons: true,
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
            closeOnClickOutside: false
            })           
        .then(function(confirmed){
            if (confirmed){                
                 $.ajax({
                    url: url,
                    type: 'POST',
                    data: 'row_id=' + row_id + '&table_name=' + table_name,
                    dataType: 'json'
                 })
                 .done(function(response){
                    swal.stopLoading();
                    swal("Deleted!", response.message, response.status);
                    $(table_row).fadeOut(2000);
                 })
                 .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                 })
            }
        })      
    }
</script>
<!-- END Ajax Delete -->
<!-- Bootstrap core JavaScript-->

<script src="<?php echo base_url("assets/"); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url("assets/"); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

<!--sweet alert2 JS -->
<script src="<?php echo base_url(); ?>assets/js/plugins/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        var success_message = '<?php echo $this->session->flashdata('success'); ?>';
        var error_message = '<?php echo $this->session->flashdata('error'); ?>';
        if (success_message != '') {
            swal('Success!',success_message,'success');
        }
        if (error_message != '') {
            swal('Error!',error_message,'error');
        }
    });
</script>

</body>
</html>