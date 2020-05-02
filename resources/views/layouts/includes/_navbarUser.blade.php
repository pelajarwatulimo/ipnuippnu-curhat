<nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="{{ route('user.beranda') }}" class="nav-link">{{ config('app.name') }}</a>
      </li>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge">1</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="overflow: hidden">
          <span class="dropdown-item dropdown-header">Pesan Siaran</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="{{ asset('/data/users_img/admin.png') }}" alt="Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Pengelola
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Selamat Datang di curhat...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Saat ini</p>
              </div>
            </div>
          </a>
        </div>
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