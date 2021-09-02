<!DOCTYPE html>
<html lang="id" style="overflow: hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Cuhat Rekan dan Rekanita ini digunakan untuk menyalurkan aspirasi, kritik, saran dan pesan dari Pelajar Watulimo kepada PAC IPNU - IPPNU Watulimo.">
    <meta name="author" content="{{ config('app.author') }}">
    <link rel="shortcut icon" href="{{ asset('/') }}favicon.ico" type="image/x-icon">
    <title>Selamat Datang | {{ config('app.name') }}</title>
    <link href="{{ asset('/') }}assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/sb-admin-2.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/landing-page.css">
    <script src="{{ asset('/') }}assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}assets/js/sb-admin-2.min.js"></script>
    <script src="{{ asset('/') }}assets/js/landing-page.js"></script>
    <script src="{{ asset('/') }}assets/vendor/particles/particles.js"></script>
    <meta name="theme-color" content="#1cc88a">
    <meta name="msapplication-navbutton-color" content="#1cc88a">
    <meta name="apple-mobile-web-app-status-bar-style" content="#1cc88a">
    <style>
      #partical {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
      }
    </style>
</head>
<body class="text-dark">
  <div id="loading" style="width: 100vw; height: 100vh; position: fixed; display: flex; z-index: 10000; background: #1cc88a">
    <img src="{{ asset('/') }}assets/img/load.svg" alt="Animasi Loading" style="margin: auto">
  </div>
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4 fixed-top bg-max-lg-dark">
      <div class="container px-lg-5">
        <a class="navbar-brand font-weight-bold text-center text-lg-left" href="{{ asset('/') }}">
          <img src="{{ asset('/') }}assets/img/ipnu-ippnu.png" height="40" alt="Logo IPNU IPPNU" class="mr-lg-3">
          <h1 class="d-block d-lg-inline h4">{{ config('app.name') }}</h1>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link text-white px-lg-4 go-section" href="#beranda">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white px-lg-4" href="https://github.com/pelajarwatulimo/ipnuippnu-curhat">GitHub</a>
            </li>
            <li class="nav-item pl-lg-4 pr-lg-3">
              <a class="nav-link btn bg-white text-dark px-3 font-weight-bolder" href="{{ asset('/') }}login">Masuk<i class="fas fa-arrow-right ml-2"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <section id="beranda" class="bg-gradient-success d-flex text-white">
        <div id="partical"></div>
        <div class="container-lg px-5 px-lg-5 my-auto">
          <div class="row">

            <div class="col-lg-5 text-center col-12 order-lg-2">
              <h1 class="mb-3 font-weight-bold d-block d-lg-none mt-3">Selamat Datang</h1>
              <img src="{{ asset('/') }}assets/img/ketua.png" alt="Gambar Ketua" style="width: 100%; height: auto">
              <span class="font-weight-bold d-block h6 mb-0">( Rekan Imron & Rekanita Mega )</span>
              <span style="color: #fff8" class="small font-weight-bold d-block">Ketua {{ config('app.author') }}</span>

            </div>

            <div class="col-lg-7 my-lg-auto col-12 order-lg-1 text-center text-lg-left mt-4 mt-lg-0">
              <h1 class="mb-3 font-weight-bold d-none d-lg-block">Selamat Datang</h1>
              <p style="font-weight: lighter; line-height: 1.5;" class="h5">
                Selamat Belajar, Berjuang & Bertaqwa.
                Laman {{ config('app.name') }} ini dikembangkan oleh {{ config('app.author') }}.
                Silahkan masuk untuk memberikan kritik / masukan kepada kami.</p>
              <div class="d-flex mt-5 justify-content-center justify-content-lg-left">
                <a href="{{ asset('/') }}signup" class="btn btn-warning btn-lg px-4 font-weight-bolder" style="color: #2d2d2d !important">Mendaftar</a>
                <a href="{{ asset('/') }}login" class="text-white my-auto mx-5 font-weight-bolder">Masuk</a>
              </div>
            </div>

          </div>
        </div>

        <div class="rounded-bottom text-white d-none d-md-block">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
        </div>
    </section>

    <footer class="text-dark text-center small py-4 m-0">
      <i class="fab fa-creative-commons"></i>
      <span>{!! config('app.license') !!}</span>
    </footer>

    <script>
      $(document).ready(function(){
        particlesJS('partical', {
            "particles": {
          "number": {
            "value": 80,
            "density": {
            "enable": true,
            "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle",
            "stroke": {
            "width": 0,
            "color": "#000000"
            },
            "polygon": {
            "nb_sides": 5
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
            }
          },
          "size": {
            "value": 5,
            "random": true,
            "anim": {
            "enable": false,
            "speed": 40,
            "size_min": 0.1,
            "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 200,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1.5
          },
          "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY": 1200
            }
          }
          },
          "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
            "enable": false,
            "mode": "repulse"
            },
            "onclick": {
            "enable": false,
            "mode": "push"
            },
            "resize": true
          },
          "modes": {
            "grab": {
            "distance": 400,
            "line_linked": {
              "opacity": 1
            }
            },
            "bubble": {
            "distance": 400,
            "size": 40,
            "duration": 2,
            "opacity": 8,
            "speed": 3
            },
            "repulse": {
            "distance": 200,
            "duration": 0.4
            },
            "push": {
            "particles_nb": 4
            },
            "remove": {
            "particles_nb": 2
            }
          }
          },
          "retina_detect": true
        });
      });
    </script>

</body>
</html>
