<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ $pesan->title }} | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendor/adminlte/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ auth()->check() ? route('login') : route('beranda') }}" class="navbar-brand mx-auto py-2">
        <img src="{{ asset('assets/img/ipnu-ippnu.png') }}" alt="Logo IPNU & IPPNU" class="brand-image"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Pesan Siaran</span>
      </a>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">{{ $pesan->title }}</h1>
            <small class="text-muted">
                <i class="fas fa-clock mr-1"></i>{{ $pesan->created_at->format('d M Y') }}
                <i class="fas fa-user mr-1 ml-2"></i>{{ $pesan->user->panggilan() }}
            </small>
          </div><!-- /.col -->
          <div class="col">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ auth()->check() ? route('login') : route('beranda') }}">Kembali</a></li>
              <li class="breadcrumb-item active">Pesan Siaran</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
          <div class="row">
              <div class="col">
                <div class="card">
                    <div class="card-body">
                       {!! $pesan->message !!}
                    </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <b>Versi </b>{{ config('app.version') }}
    </div>
    <!-- Default to the left -->
    <strong><i class="fab fa-creative-commons mr-2"></i></strong>{{ config('app.license') }}
  </footer>
</div>

<script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/adminlte/adminlte.min.js') }}"></script>
</body>
</html>