<aside class="main-sidebar sidebar-dark-danger elevation-3" style="min-height: calc(100% + 3.5rem + 1px);">
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
          <a href="{{ route('admin.broadcast') }}" class="nav-link {{ Route::currentRouteName() == 'admin.broadcast' ? 'active font-weight-bold' : 'text-danger' }}">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
              Pesan Siaran
            </p>
          </a>
        </li>
        <li class="nav-header pt-3">UMUM</li>
        <li class="nav-item">
          <a href="{{ route('admin.beranda') }}" class="nav-link{{ in_array(Route::currentRouteName(), ['admin.beranda', 'admin.pesan.view']) ? ' active' : '' }}">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              Kotak Curhat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.ranting') }}" class="nav-link{{ Route::currentRouteName() == 'admin.ranting' ? ' active' : '' }}">
            <i class="nav-icon fas fa-code-branch"></i>
            <p>
              Ranting
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.users') }}" class="nav-link{{ Route::currentRouteName() == 'admin.users' ? ' active' : '' }}">
            <i class="nav-icon far fa-address-card"></i>
            <p>
              Daftar Akun
            </p>
          </a>
        </li>
        <li class="nav-header">LAINNYA</li>
        <li class="nav-item">
          <a href="{{ route('admin.setting') }}" class="nav-link{{ Route::currentRouteName() == 'admin.setting' ? ' active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Pengaturan Aplikasi
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.sysinfo') }}" class="nav-link{{ Route::currentRouteName() == 'admin.sysinfo' ? ' active' : '' }}">
            <i class="nav-icon fab fa-php"></i>
            <p>
              Informasi Sistem
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>