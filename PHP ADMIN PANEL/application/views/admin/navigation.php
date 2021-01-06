<?php $active_menu=$this->session->userdata('active_menu');
?>

  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>">
      <div class="sidebar-brand-icon">
        <img src="<?php echo base_url('uploads/system_logo/'.get_app_config("logo")); ?>">
      </div>
      <div class="sidebar-brand-text mx-3">MeetAir <sup><?php echo get_app_config("version"); ?></sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php if($active_menu==1) {echo "active"; } ?>"><a class="nav-link" href="<?php echo base_url()."admin/dashboard";?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a> </li>    
    <li class="nav-item <?php if($active_menu==2) {echo "active"; } ?>"><a class="nav-link" href="<?php echo base_url().'admin/manage_user'?>"><i class="fas fa-fw fa-users"></i><span>Users</span></a></li>
    <li class="nav-item <?php if($active_menu==3 || $active_menu==4): echo "active"; endif; ?>">
      <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseMeeting" aria-expanded="true" aria-controls="collapseMeeting">
        <i class="fas fa-fw fa-video" aria-hidden="true"></i><span>Meeting</span>
      </a>
      <div id="collapseMeeting" class="collapse <?php if($active_menu==3 || $active_menu==4): echo "show"; endif; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?php if($active_menu==3) {echo "active"; } ?>" href="<?php echo base_url().'admin/meeting/'?>">All Meeting</span></a>
          <a class="collapse-item <?php if($active_menu==4) {echo "active"; } ?>" href="<?php echo base_url().'admin/meeting_history/'?>">Meeting History</span></a>
        </div>
      </div>
    </li>

    <li class="nav-item <?php if($active_menu==5 || $active_menu==6 || $active_menu==7 || $active_menu==8 || $active_menu==9 || $active_menu==10): echo "active"; endif; ?>">
      <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
        <i class="fas fa-fw fa-cog" aria-hidden="true"></i><span>Setting</span>
      </a>
      <div id="collapseSetting" class="collapse <?php if($active_menu==5 || $active_menu==6 || $active_menu==7 || $active_menu==8 || $active_menu==9 || $active_menu==10): echo "show"; endif; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?php if($active_menu==5) {echo "active"; } ?>" href="<?php echo base_url().'admin/system_setting/'?>">System Setting</span></a>
          <a class="collapse-item <?php if($active_menu==6) {echo "active"; } ?>" href="<?php echo base_url().'admin/api_setting/'?>">API Setting</span></a>
          <a class="collapse-item <?php if($active_menu==7) {echo "active"; } ?>" href="<?php echo base_url().'admin/email_setting/'?>">Email Setting</span></a>
          <a class="collapse-item <?php if($active_menu==8) {echo "active"; } ?>" href="<?php echo base_url().'admin/mobile_ads_setting/'?>">Ads Setting</span></a>
          <a class="collapse-item <?php if($active_menu==9) {echo "active"; } ?>" href="<?php echo base_url().'admin/logo_and_image/'?>">Logo & Image</span></a>
          <a class="collapse-item <?php if($active_menu==10) {echo "active"; } ?>" href="<?php echo base_url().'admin/update/'?>">Update</span></a>
        </div>
      </div>
    </li>
    <li class="nav-item <?php if($active_menu == 11 || $active_menu==12): echo "active"; endif; ?>">
      <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseNotificationSetting" aria-expanded="true" aria-controls="collapseNotificationSetting">
        <i class="fas fa-fw fa-bell" aria-hidden="true"></i><span>Notification</span>
      </a>
      <div id="collapseNotificationSetting" class="collapse <?php if($active_menu == 11 || $active_menu == 12): echo "show"; endif; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?php if($active_menu==11) {echo "active"; } ?>" href="<?php echo base_url().'admin/send_notification/'?>">Send Notification</span> </a>
          <a class="collapse-item <?php if($active_menu==12) {echo "active"; } ?>" href="<?php echo base_url().'admin/push_notification_setting/'?>">Setting</span> </a>
        </div>
      </div>
    </li>
    <li class="nav-item <?php if($active_menu==13) {echo "active"; } ?>"><a class="nav-link" href="<?php echo base_url().'admin/backup_restore'?>"><i class="fas fa-fw fa-database"></i><span>Backup</span></a></li>
   <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>
        