<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="index, follow" />
  <meta name="description" content="Laman yang digunakan untuk menyalurkan aspirasi, kritik, saran dan pesan kepada {{ config('app.author') }}">
  <link rel="shortcut icon" href="{{ asset('/') }}favicon.ico" type="image/x-icon">
  <meta name="author" content="{{ config('app.author') }}">
  <title>@yield('title') | {{ config('app.name') }}</title>
  <meta name="theme-color" content="#1cc88a">
  <meta name="msapplication-navbutton-color" content="#1cc88a">
  <meta name="apple-mobile-web-app-status-bar-style" content="#1cc88a">
  <link href="{{ asset('/') }}assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link href="{{ asset('/') }}assets/css/sb-admin-2.css" rel="stylesheet">
  <script src="{{ asset('/') }}assets/vendor/jquery/jquery.min.js"></script>
  <script src="{{ asset('/') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('/') }}assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="{{ asset('/') }}assets/js/sb-admin-2.min.js"></script>
  <script>
    $(document).ready(function(){
        $('a.go-section').click(function(e){
            e.preventDefault();
        });
        $('#loading').fadeOut('slow',function(){
            $('html').removeAttr('style');
        });
    });
  </script>
  @yield('prepare', '')
</head>
<body class="d-flex text-dark bg-login p-2">
  <div id="loading" style="width: 100vw; height: 100vh; position: fixed; display: flex; z-index: 10000; background: #1cc88a">
    <img src="{{ asset('/') }}assets/img/load.svg" alt="Animasi Loading" style="margin: auto">
  </div>
  <div class="container-md m-auto">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9 p-3">
            @if( !in_array(Route::currentRouteName(), ['reset_pass.go']) )
            <a href="{{ route('beranda') }}" class="btn-back btn bg-dark py-2 px-3 text-white mb-2 shadow-sm"><i class="fas fa-chevron-left pr-2"></i>Kembali ke Beranda</a>
            @endif
            <div class="card o-hidden border-0 shadow-lg mb-3">
              <div class="card-body p-0">
                  <div class="row">
                    <div class="col">
                      @if (session()->has('informasi'))
                      <div class="alert alert-{{ session()->get('informasi')['type'] }} m-2" style="margin-bottom: -10px !important">{!! session()->get('informasi')['value'] !!}</div>  
                      @endif
                        
                      <div class="px-lg-5 py-lg-4 p-4">
                          @yield('content')
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      </div>
  </div>
</body>
</html>