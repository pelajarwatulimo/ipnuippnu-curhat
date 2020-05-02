<nav class="main-header navbar navbar-expand navbar-danger navbar-dark border-secondary  elevation-3">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.beranda') }}" class="nav-link">Admin {{ config('app.name') }}</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#logout" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
</nav>