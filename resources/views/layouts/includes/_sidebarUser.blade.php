<aside class="main-sidebar sidebar-light-primary elevation-3" style="min-height: calc(100% + 3.5rem);">
  <!-- Brand Logo -->
  <div class="brand-link elevation-2">
    <img src="{{ asset('/data/users_img') . '/' . ( auth()->user()->avatar ?: 'default.jpg' ) }}" class="brand-image elevation-2" alt="User Image">
    <span class="brand-text ml-2 text-md font-weight-light">{{ auth()->user()->panggilan() }}</span>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('user.beranda') }}" class="nav-link{{ in_array(Route::currentRouteName(), ['user.beranda', 'user.pesan.view']) ? ' active' : '' }}">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              Kotak Curhat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../gallery.html" class="nav-link disabled text-secondary">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Agenda Bulan Ini
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link disabled text-secondary">
            <i class="nav-icon far fa-address-card"></i>
            <p>
              Pengajuan KTA
            </p>
          </a>
        </li>
        <li class="nav-header">LAINNYA</li>
        <li class="nav-item">
          <a href="{{ route('user.info') }}" class="nav-link{{ Route::currentRouteName() == 'user.info' ? ' active' : '' }}">
            <i class="nav-icon far fa-question-circle"></i>
            <p>
              Tentang Kami
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>