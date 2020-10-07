<?php
include '../includes/functions.php';

if (staffConfirmLogin() == false) {
    $_SESSION['showError'] = "<script>function showError() {
     iziToast.warning({
         title: 'Action Required!',
         message: 'Unauthorized! You need to be logged in.',
         position: 'bottomRight'  });
     } showError(); </script>";

     redirect('/admin-cp/login');
     exit();
 }

 if (isset($_SESSION['admin_login_status'])  && $_SESSION['admin_login_status'] === true) {

  $token = $_SESSION['admin_token'];

  $sql = "SELECT * FROM ng_admin WHERE email_address = ?";

  $astmt = $db->prepare($sql);
  $email_address = $_SESSION['admin_email'];
  $astmt->bind_param("s", $email_address);
  $astmt->execute();

  $res = $astmt->get_result();
  $arow = $res->fetch_assoc();


}

if ($res->num_rows === 0) {
 $_SESSION['showError'] = "<script>function showError() {
   iziToast.warning({
         title: 'Action Required!',
         message: 'Unauthorized! You need to be logged in.',
         position: 'bottomRight'  });
 } showError(); </script>";

 redirect('/admin-cp/login');
 exit();  
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   <?=$page?> - Naam Global Administration
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/iziToast.min.css">
  
  <link href="/assets/css/naam-dashboard.css?v=2.1.2" rel="stylesheet" />

</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="danger" data-background-color="black" data-image="/assets/images/sidebar.jpg">
     
      <div class="logo"><a href="/admin-cp/dashboard" class="simple-text logo-mini">
          NG
        </a>
        <a href="/admin-cp/dashboard" class="simple-text logo-normal">
          Naam Global
        </a></div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="/assets/images/avatar/<?=$arow['avatar']?>" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#profile" class="username">
              <span>
               <?=htmlspecialchars_decode(html_entity_decode($arow['first_name']." ".$arow['other_names'],ENT_QUOTES)) ?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="profile">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="/admin-cp/profile">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                </li>
              
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item <?php if($page == 'Dashboard') : echo "active"; endif;?> ">
            <a class="nav-link" href="/admin-cp/dashboard">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          <li class="nav-item <?php if($page == 'Students') : echo "active"; endif;?> ">
            <a class="nav-link" data-toggle="collapse" href="#students">
              <i class="material-icons">people</i>
              <p> students
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="students">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'smanage') : echo "active"; endif;?> ">
                  <a class="nav-link" href="/admin-cp/students/manage">
                    <span class="sidebar-mini"> MS</span>
                    <span class="sidebar-normal"> Manage users </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'sapply') : echo "active"; endif;?> ">
                  <a class="nav-link" href="/admin-cp/students/application">
                    <span class="sidebar-mini"> MA </span>
                    <span class="sidebar-normal"> Manage applications </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item  <?php if($page == 'Tours') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#tours">
              <i class="material-icons">tour</i>
              <p> Tours
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="tours">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'tmanage') : echo "active"; endif;?> ">
                  <a class="nav-link" href="/admin-cp/tours/manage">
                    <span class="sidebar-mini"> MT </span>
                    <span class="sidebar-normal"> Manage tours </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'tbooking') : echo "active"; endif;?> ">
                  <a class="nav-link" href="/admin-cp/tours/booking">
                    <span class="sidebar-mini"> MB </span>
                    <span class="sidebar-normal"> Manage bookings </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($page == 'Visa') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#visa">
              <i class="material-icons">credit_card</i>
              <p> Visas
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="visa">
              <ul class="nav">
                <li class="nav-item  <?php if($subpage == 'mvisa') : echo "active"; endif;?> ">
                  <a class="nav-link" href="/admin-cp/visa/manage">
                    <span class="sidebar-mini"> MV </span>
                    <span class="sidebar-normal"> Manage Visas </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'mvisapp') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/visa/applications">
                    <span class="sidebar-mini"> MA </span>
                    <span class="sidebar-normal"> Manage Applications </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($page == 'School') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#schools">
              <i class="material-icons">school</i>
              <p> Schools
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="schools">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'scmanage') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/school/manage">
                    <span class="sidebar-mini"> MS </span>
                    <span class="sidebar-normal"> Manage Schools </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'courses') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/school/courses">
                    <span class="sidebar-mini"> MC </span>
                    <span class="sidebar-normal"> Manage Courses </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'reviews') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/school/reviews">
                    <span class="sidebar-mini"> MR </span>
                    <span class="sidebar-normal"> Manage Reviews </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($page == 'Services') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#services">
              <i class="material-icons">home_repair_service</i>
              <p> Services
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="services">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'serm') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/services/manage">
                    <span class="sidebar-mini"> MS </span>
                    <span class="sidebar-normal"> Manage Services </span>
                  </a>
                </li>
                 <li class="nav-item <?php if($subpage == 'serc') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/services/categories">
                    <span class="sidebar-mini"> MC </span>
                    <span class="sidebar-normal"> Manage Categories </span>
                  </a>
                </li>
                <li class="nav-item  <?php if($subpage == 'serb') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/services/bookings">
                    <span class="sidebar-mini"> MB </span>
                    <span class="sidebar-normal"> Manage Bookings </span>
                  </a>
                </li>
              
              </ul>
            </div>
          </li>
           <li class="nav-item <?php if($page == 'Blog') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#blog">
              <i class="material-icons">rss_feed</i>
              <p> Blog
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="blog">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'badd') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/blog/add">
                    <span class="sidebar-mini"> AP </span>
                    <span class="sidebar-normal"> Add Post </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'bman') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/blog/manage">
                    <span class="sidebar-mini"> MB </span>
                    <span class="sidebar-normal"> Manage Posts </span>
                  </a>
                </li>
              
              </ul>
            </div>
          </li>
          <?php if($arow['role'] == 'admin') : ?>
           <li class="nav-item <?php if($page == 'Staff') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#staff">
              <i class="material-icons">admin_panel_settings</i>
              <p> staff
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="staff">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'sadd') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/staff/add">
                    <span class="sidebar-mini"> AS</span>
                    <span class="sidebar-normal"> Add staff </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'sman') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/staff/manage">
                    <span class="sidebar-mini"> MS </span>
                    <span class="sidebar-normal"> Manage staff </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        <?php endif;?>
          <li class="nav-item <?php if($page == 'Testimony') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#testimonies">
              <i class="material-icons">speaker_notes</i>
              <p> Testimonies
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="testimonies">
              <ul class="nav">
                <li class="nav-item <?php if($subpage == 'tadd') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/testimony/add">
                    <span class="sidebar-mini"> AT </span>
                    <span class="sidebar-normal"> Add Testimony </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'tman') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/testimony/manage">
                    <span class="sidebar-mini"> MT </span>
                    <span class="sidebar-normal"> Manage Testimony </span>
                  </a>
                </li>
              
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($page == 'Mail') : echo "active"; endif;?>">
            <a class="nav-link" data-toggle="collapse" href="#mail">
              <i class="material-icons">mail</i>
              <p> Mail
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="mail">
              <ul class="nav">
              <li class="nav-item <?php if($subpage == 'subscribers') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/subscribers">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Subscribers </span>
                  </a>
                </li>
              <li class="nav-item <?php if($subpage == 'contacts') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/contacts">
                    <span class="sidebar-mini"> CM </span>
                    <span class="sidebar-normal"> Contact Messages </span>
                  </a>
                </li>
                <li class="nav-item <?php if($subpage == 'compose') : echo "active"; endif;?>">
                  <a class="nav-link" href="/admin-cp/compose">
                    <span class="sidebar-mini"> SM </span>
                    <span class="sidebar-normal"> Send Mail </span>
                  </a>
                </li>
              
              </ul>
            </div>
          </li>
           
          <li class="nav-item <?php if($page == 'Settings') : echo "active"; endif;?>">
            <a class="nav-link" href="/admin-cp/settings">
              <i class="material-icons">settings</i>
              <p> Settings </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-secondary" href="/admin-cp/logout/<?=$token?>">
              <i class="material-icons">login</i>
              <p> Logout </p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"><?=$page?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#!" id="notificationDrawer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <?php $notifCount = countAllNotifs(); if($notifCount != '0'): ?>
                  <span class="notification"><?=$notifCount ?></span> <?php endif; ?>
                  <p class="d-lg-none d-md-block">
                   Notifications
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDrawer">
                  <?php
                  $nql = "SELECT * FROM ng_notifications WHERE enabled = ? ORDER BY id DESC";
                  $enabled = 'yes';
                  $nstmt = $db->prepare($nql);
                  $nstmt->bind_param('s',$enabled);
                  $nstmt->execute();
                  $nres  = $nstmt->get_result();

                  while ($nrow = $nres->fetch_assoc()) :
                  ?>
                  <a class="dropdown-item notif-read" href="#!" data-id = "<?=encode($nrow['id'],'e')?>"> <?=htmlspecialchars_decode(html_entity_decode($nrow['notif_from']." ".$nrow['body'],ENT_QUOTES)) ?></a>
                 <?php endwhile; if ($nres->num_rows == 0) : ?>
                   <a class="dropdown-item" href="#!"> No new notifications</a>
               <?php endif; ?>
               <div class="d-flex justify-content-center mt-3">
               <button class="btn btn-danger btn-sm" onclick="location.href='notifications'">View all</button>
             </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="profileDrawer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDrawer">
                  <a class="dropdown-item" href="/admin-cp/profile">Profile</a>
                  <a class="dropdown-item" href="/admin-cp/settings">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/admin-cp/logout/<?=$token?>">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
   