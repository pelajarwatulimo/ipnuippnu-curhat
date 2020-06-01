<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'o_o') | {{ auth()->user()->is_admin ? 'Admin ' : '' }}{{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendor/adminlte/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/assets/vendor/sweetalert2/sweetalert2.min.css') }}">
  <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/adminlte/adminlte.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>
  @yield('header')
  @yield('footer')

  <script>
    var OneSignal = window.OneSignal || [];
    var mySession = "";
    $(document).ready(function(){

      $('a[href="#development"]').click(function(e){
          e.preventDefault();
          Swal.fire(
              'Mohon Maaf!',
              "Fitur masih dalam pengembangan, akan tersedia dalam waktu dekat.",
              'info'
          );
      });

      // OneSignal setup
      OneSignal.push(function(){
        OneSignal.init({appId: "<?= config('app.onesignal_appID') ?>" });
        OneSignal.getNotificationPermission(function(data){
            if( data == 'default' && localStorage.getItem('os_pageViews') <= 3 ) {
                $('#perizinan').fadeIn('fast', function(){
                  $('#perizinan button').click(function(){
                      $(this).attr('disabled', 'disabled');
                      OneSignal.showNativePrompt();
                  });
                });
                $('#perizinan').click(function(e){
                  if(e.target != this) return false;
                  $(this).fadeOut('fast', function(){
                    $(this).remove();
                    localStorage.setItem('hasPrompt', 'true');
                  });
                });
            } else {
              $('#perizinan').remove();
            }
        });

        OneSignal.on('notificationPermissionChange', function(e){
          $("#perizinan").fadeOut('fast', function(){
            $(this).remove();
            localStorage.setItem('hasPrompt', 'true');
          });
        });

        OneSignal.getUserId(function(data){
          if( data != null ) {
            OneSignal.getTags(function(tags){

              if (
                tags.isAdmin !== "<?= auth()->user()->is_admin ? config('') : 'none' ?>" ||
                tags.userID !== "<?= auth()->user()->remember_token ?>"
              ) {
                OneSignal.sendTags({
                  isAdmin: "<?= auth()->user()->is_admin ? config('') : 'none' ?>" ,
                  userID: "<?= auth()->user()->remember_token ?>"
                });
              }

              mySession = data;

            });

          }
        });

      });

      // Jika ada informasi
      @if (session()->has('informasi'))
      @php $informasi = session()->get('informasi');  @endphp
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      Toast.fire({
        icon: '{{ $informasi['type']  }}',
        title: '{{ $informasi['value'] }}'
      })
      @endif

      // Jika admin belum punya jabatan
      @if (auth()->user()->is_admin == true && auth()->user()->jabatan == null)
      Swal.fire({
        icon: 'info',
        title: 'Anda telah menjadi Pengelola',
        allowOutsideClick: false,
        text: 'Silahkan masukkan posisi anda di {!! config('app.author') !!}'
      }).then(function()
      {
        Swal.fire({
          title: 'Masukkan Posisi Anda',
          confirmButtonText: 'Simpan',
          allowOutsideClick: false,
          showLoaderOnConfirm: true,
          html:
            '<div class="form-group text-left">' +
            '  <label for="jabatan-jenis">Jenis</label>' +
            '  <select class="form-control" id="jabatan-jenis">' +
            '    <option value="L">Lembaga</option>' +
            '    <option value="D">Departemen</option>' +
            '    <option value="B">Badan</option>' +
            '    <option value="O">Lainnya...</option>' +
            '  </select>' +
            '</div>'+
            '<div class="form-group text-left">' +
            '  <label for="jabatan-nama">Nama Posisi</label>' +
            '  <input type="text" class="form-control" id="jabatan-nama" placeholder="Ex: Ketua Umum, Corp Brigade Pembangunan, Sekretaris 1 etc.">' +
            '</div>',
          preConfirm: function () {
            var jabatan = $('#jabatan-jenis').val();
            var nama = $('#jabatan-nama').val();

            if( jabatan == "" || nama == "" )
              return false;

            return $.ajax({
                url: "{{ route('admin.jabatan') }}",
                type: "POST",
                data: {jabatan: jabatan, nama: nama},
                dataType: "html",
                success: function () {
                    Swal.fire("Berhasil!","Data berhasil diubah!","success");
                },
                fail: function() {
                    Swal.fire("Gagal!","Terjadi kesalahan pada sistem!","error");
                }
            });
          }
        });
      });
      @endif

      //Keluar
      $('a[href="#logout"]').click(function(e){
        e.preventDefault();
        swal.fire({
          title: 'Yakin ingin keluar?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Keluar',
          cancelButtonText: 'Batalkan',
          showLoaderOnConfirm: true,
          preConfirm: (result) => {
            return $.ajax({
              url: "{{ route('logout') }}",
              type: 'post',
              data: {userID: mySession},
              success: function(e)
              {
                location.href = "{{ route('login') }}";
              },
              fail: function(e){
                Swal.fire("Gagal!","Terjadi kesalahan pada sistem!","error");
              }
            })
          },

        });
      });

    })
  </script>
  
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="w-100 h-100 d-flex" style="left: 0; top: 0; position: fixed; background: #0000009e; z-index: 2000; padding: 4em; display: none !important;" id="perizinan">
    <div class="card m-auto" style="max-width: 560px">
        <div class="card-body text-center">
            <h5>
                Untuk mendapatkan notifikasi akun <b>{{ auth()->user()->name }}</b>, 
                silahkan setujui perizinan yang diminta.
                <button class="mt-3 btn btn-primary btn-block btn-lg">Baiklah</button>
            </h5>
        </div>
    </div>
</div>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  @include('layouts.includes._navbar' . ( auth()->user()->is_admin ? 'Admin' : 'User') )
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.includes._sidebar' . ( auth()->user()->is_admin ? 'Admin' : 'User') )

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"{!! request()->route()->getPrefix() == '/admin' ? ' style="background: #272c31"' : '' !!}>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  @if( !in_array(Route::currentRouteName(), ['user.pesan.view', 'admin.pesan']) )
  <footer class="main-footer{{ auth()->user()->is_admin ? ' bg-danger border-dark' : '' }}">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> {{ config('app.version') }}
    </div>
    <div class="d-inline"><strong><i class="fab fa-creative-commons mr-2"></i></strong>{{ config('app.license') }}</div>
  </footer>
  @endif

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>
</html>
