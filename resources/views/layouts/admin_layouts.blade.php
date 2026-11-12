<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminPanel -@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
  <link href="/assets/dist/css/colorbox.css" rel="stylesheet">
  <link rel="website icon" href="/assets/images/circle.png">

  @vite('resources/scss/admin.scss')
  @inject('adminPanel', 'App\Services\AdminPanel')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin-home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('post.index')}}" class="nav-link">Blog</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('client.index')}}" class="nav-link">Client</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('members.index')}}" class="nav-link">Members</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('contact.index')}}" class="nav-link">Ask Questions</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('repair.index')}}" class="nav-link">Help with car</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{$adminPanel->show()['amount']}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{$adminPanel->show()['amount']}} Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="{{route('client.index')}}" class="dropdown-item">
          <i class="fa-solid fa-clipboard-user"></i>{{$adminPanel->show()['client']}} Client
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('members.index')}}" class="dropdown-item">
          <i class="fa-solid fa-briefcase"></i>{{$adminPanel->show()['members']}}Members
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('repair.index')}}" class="dropdown-item">
          <i class="fa-solid fa-car-burst"></i>{{$adminPanel->show()['repair']}} Car
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
      <a style="padding: 20px;" class="brand-link ">
      <i style="font-size: 2.2rem; margin: 0px 10px;" class="fa-solid fa-user-secret"></i>
      <span style="font-size: 1.3rem;" class="brand-text font-weight-light">Admin|Panel</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block ml-2">Welcome {{$adminPanel->index()['users']}}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{route('admin-home')}}" class="nav-link">
            <i class="fa-solid fa-car"></i>
            <p>
              Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-envelopes-bulk"></i>
              <p>
                Blog
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('post.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All news</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('post.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add news</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-mug-hot"></i>
              <p>
              Client Says
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('client.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All response</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('client.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add response</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-brands fa-ember"></i>
              <p>
              Members
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('members.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All members</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('members.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add members</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-regular fa-circle-question"></i>
              <p>
                Ask Questions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('contact.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All questions</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-screwdriver-wrench"></i>
              <p>
              Help with car repair 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('repair.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All auto</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">
            <i class="fa-solid fa-right-from-bracket"></i>
              <p>
              Log out
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/assets/plugins/moment/moment.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/assets/admin.js"></script>
<script type="text/javascript" src="/assets/dist/js/jquery.colorbox-min.js"></script>
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
<script src="/assets/dist/js/pages/dashboard.js"></script>
<script src="https://cdn.tiny.cloud/1/u3xget8b6g00f5okf2wfwg4jua3611mxzrrt0smpk6js3e98/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
<script src="/assets/js/admin.js"></script>
</body>
</html>
