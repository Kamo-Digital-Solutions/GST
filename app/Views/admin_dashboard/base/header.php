<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/fontawesome-free/css/all.min.css");?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css");?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css");?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/jqvmap/jqvmap.min.css");?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/adminlte.min.css");?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css");?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.css");?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/summernote/summernote-bs4.min.css");?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url("admin/dashboard/games"); ?>" class="brand-link">
      <img src="<?php echo base_url("assets/dist/img/AdminLTELogo.png");?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">GameShowTime </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-header">GAMES</li>

          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/games"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Games
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/add_jeopardy"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Add Jeopardy
              </p>
            </a>
          </li>

          <li class="nav-header">Categories</li>
          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/categories"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Categories
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/add_category"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Add category
              </p>
            </a>
          </li>

          <li class="nav-header">Questions</li>
          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/questions"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Questions
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url("admin/dashboard/add_question"); ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Add question
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>