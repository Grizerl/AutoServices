<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') | Auto Service Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- AdminLTE theme + plugins -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/circle.png') }}">

  @vite('resources/scss/admin.scss')
  @inject('adminPanel', 'App\Services\AdminPanel')
  @php($notifications = $adminPanel->show())
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="Admin" height="60" width="60">
  </div>

  <!-- Top navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-inline-block"><a href="{{ route('admin-home') }}" class="nav-link">Dashboard</a></li>
      <li class="nav-item d-none d-md-inline-block"><a href="{{ route('post.index') }}" class="nav-link">Blog</a></li>
      <li class="nav-item d-none d-md-inline-block"><a href="{{ route('client.index') }}" class="nav-link">Reviews</a></li>
      <li class="nav-item d-none d-lg-inline-block"><a href="{{ route('members.index') }}" class="nav-link">Team</a></li>
      <li class="nav-item d-none d-lg-inline-block"><a href="{{ route('contact.index') }}" class="nav-link">Questions</a></li>
      <li class="nav-item d-none d-lg-inline-block"><a href="{{ route('repair.index') }}" class="nav-link">Repair requests</a></li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="{{ route('home_auto') }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt mr-1"></i> View site</a>
      </li>
      <!-- Notifications -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-label="Notifications">
          <i class="far fa-bell"></i>
          @if ($notifications['amount'] > 0)
            <span class="badge badge-warning navbar-badge">{{ $notifications['amount'] }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ $notifications['amount'] }} to review</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('repair.index') }}" class="dropdown-item">
            <i class="fas fa-car-burst mr-2"></i> {{ $notifications['pending'] }} pending repair requests
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('contact.index') }}" class="dropdown-item">
            <i class="fas fa-question-circle mr-2"></i> {{ $notifications['questions'] }} questions
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" aria-label="Fullscreen"><i class="fas fa-expand-arrows-alt"></i></a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin-home') }}" class="brand-link" style="padding: 20px;">
      <i class="fa-solid fa-user-secret" style="font-size: 2.2rem; margin: 0 10px;"></i>
      <span class="brand-text font-weight-light" style="font-size: 1.3rem;">Admin Panel</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <span class="d-block ml-2 text-white">Welcome, {{ $adminPanel->index()['users'] }}</span>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin-home') }}" class="nav-link {{ request()->routeIs('admin-home') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-gauge"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item {{ request()->routeIs('post.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('post.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-newspaper"></i>
              <p>Blog <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('post.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All posts</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('post.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add post</p></a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ request()->routeIs('client.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('client.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-comments"></i>
              <p>Reviews <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('client.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All reviews</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('client.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add review</p></a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ request()->routeIs('members.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>Team <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('members.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All members</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('members.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add member</p></a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
              <i class="nav-icon fa-regular fa-circle-question"></i>
              <p>Questions</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('repair.index') }}" class="nav-link {{ request()->routeIs('repair.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
              <p>Repair requests</p>
            </a>
          </li>

          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-link btn btn-link text-left w-100" style="background: none; border: 0;">
                <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                <p>Log out</p>
              </button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content -->
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        @include('partials.admin-alerts')
      </div>
    </section>
    @yield('content')
  </div>
</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
<script>
  // Prevent double submits and confirm destructive actions
  $(function () {
    $('form').on('submit', function (e) {
      var message = $(this).data('confirm');
      if (message && !window.confirm(message)) {
        e.preventDefault();
        return;
      }
      var $btn = $(this).find('button[type=submit]');
      setTimeout(function () { $btn.prop('disabled', true); }, 0);
    });
  });
</script>
@stack('scripts')
</body>
</html>
