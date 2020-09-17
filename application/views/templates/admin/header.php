<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $title= array("Dashboard"); if($menuHalaman){$title = explode('(',$menuHalaman->sub_judul_menu); }?>
  <?php echo asset_icon('AdminLTELogo.png')?>
  <title>e-KTA DPD PKS | <?php echo $title[0] ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php echo asset_plugin_css('fontawesome-free/css/all.min.css') ?>
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <?php echo asset_plugin_css('daterangepicker/daterangepicker.css') ?>
  <?php echo asset_plugin_css('icheck-bootstrap/icheck-bootstrap.min.css') ?>
  <?php echo asset_plugin_css('bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') ?>
  <?php echo asset_plugin_css('tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>
  <?php echo asset_plugin_css('datatables-bs4/css/dataTables.bootstrap4.min.css')?>
  <?php echo asset_plugin_css('datatables-rowgroup/css/rowGroup.bootstrap4.min.css')?>
  <?php echo asset_plugin_css('select2/css/select2.min.css') ?>
  <?php echo asset_plugin_css('select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>
  <?php echo asset_plugin_css('bootstrap4-duallistbox/bootstrap-duallistbox.min.css') ?>
  <?php echo asset_css('adminlte.min.css') ?>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <?php echo asset_plugin_css('sweetalert2/sweetalert2.min.css')?>
  <?php echo asset_plugin_css('icheck/skins/all.css')?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo base_url() ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
        </ul> -->

        <!-- SEARCH FORM -->
        <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>
        </form> -->

        <!-- Right navbar links -->
        <!-- <ul class="navbar-nav ml-auto"> -->
        <!-- Messages Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item"> -->
                <!-- Message Start -->
                <!-- <div class="media">
                <?php echo asset_image_chat('user1-128x128.jpg')?>
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
                </div> -->
                <!-- Message End -->
            <!-- </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"> -->
                <!-- Message Start -->
                <!-- <div class="media">
                <?php echo asset_image_chat('user8-128x128.jpg')?>
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">I got your message bro</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
                </div> -->
                <!-- Message End -->
            <!-- </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"> -->
                <!-- Message Start -->
                <!-- <div class="media">
                <?php echo asset_image_chat('user3-128x128.jpg')?>
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">The subject goes here</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
                </div> -->
                <!-- Message End -->
            <!-- </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li> -->
        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 news reports
                <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
            <i class="fas fa-th-large"></i>
            </a>
        </li> -->
        </ul>
    </nav>
    <!-- /.navbar -->
