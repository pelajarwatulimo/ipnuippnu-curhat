@extends('layouts.master')

@section('title', 'Curhat...')

@if (!empty($pesan))
@section('header')
<link rel="stylesheet" href="{{ asset('/assets/vendor/overlayScrollbars/css/OverlayScrollbars.css') }}">
<style>
.direct-chat-messages{
  height: calc(100vh - 230px);
  overflow-y: auto;
}
.direct-chat-msg{
  margin-bottom: 30px;
}
.direct-chat-msg p:last-child{
  margin-bottom: 3px;
}
#loading-chat{
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 1922;
  background: #000000ba;
  display:flex;
}
@media (min-width: 576px) {
  .direct-chat-msg.right{
    margin-left: auto;
  }
  .direct-chat-msg{
    width: 400px;
    margin-right: 5px;
  }
  .direct-chat-msg .direct-chat-text{
    width: calc(100% - 70px);
    display: inline-block;
    margin-left: 10px;
  }
  .direct-chat-msg.right .direct-chat-text{
    margin-left: 20px;
    margin-right: 0;
  }
  .direct-chat-msg .direct-chat-timestamp{
    margin-right: 20px;
    margin-left: 20px;
  }
}
</style>
@endsection

@section('footer')
    <script src="{{ asset('/assets/vendor/jquery-grab-bag/jquery.autogrow-textarea.js') }}"></script>
    <script src="{{ asset('/assets/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#loading-chat').fadeIn('fast');
        var aciap = $('.direct-chat-messages').overlayScrollbars({
          scrollbars : {
            autoHide: 'leave',
            autoHideDelay: 800
          }
        })
        aciap.overlayScrollbars().scroll({y : "100%" }, 100);

        $('#txtarea').autogrow();
        $(".direct-chat-messages").animate({ scrollTop: $(".direct-chat-messages").prop("scrollHeight")}, 1000);
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });

        function acak(length = 50) {
          var result           = '';
          var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
          var charactersLength = characters.length;
          for ( var i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
          }
          return result;
        }

        function stripHTML(dirtyString) {
          var container = document.createElement('div');
          var text = document.createTextNode(dirtyString);
          container.appendChild(text);
          return container.innerHTML; // innerHTML will be a xss safe string
        }

        function pesan(isi, kounci = null, dariku = true, dari = '{{ auth()->user()->name }}', waktu = "Mengirim...", avatar = "{{ auth()->user()->avatar() }}" ){
          if( !dariku )
          $('#kolom-chat').find('.os-content').append('<div class="direct-chat-msg" kunci="'+ kounci +'">' +
              '<div class="direct-chat-infos clearfix">' +
              '<span class="direct-chat-name float-left">'+ dari +'</span>' +
              '<span class="direct-chat-timestamp float-right">'+ waktu +'</span>' +
              '</div>' +
              '<img class="direct-chat-img" src="{{ asset('data/users_img/') }}/'+ avatar +'">' +
              '<div class="direct-chat-text">' +
              isi +
              '</div>' +
              '</div>');

          else
          $('#kolom-chat').find('.os-content').append('<div class="direct-chat-msg right" kunci="'+ kounci +'">' +
              '<div class="direct-chat-infos clearfix">' +
              '<span class="direct-chat-name float-right">'+ dari +'</span>' +
              '<span class="direct-chat-timestamp float-left">'+ waktu +'</span>' +
              '</div>' +
              '<img class="direct-chat-img" src="{{ asset('data/users_img/') }}/'+ avatar +'">' +
              '<div class="direct-chat-text">' +
              isi +
              '</div>' +
              '</div>');

          aciap.overlayScrollbars().scroll({y : "100%" }, 100);
          return kounci;
        }

        function kirim()
        {
          var kunci = acak();
          
          var data = stripHTML($('textarea').val());

          $('textarea').val('').css('height', 'unset');
          pesan(data,kunci);     

          $.ajax({
            method: "POST",
            url: '{{ route('admin.pesan', $pesan->id) }}',
            data: { balasan: data, client_id: kunci }
          }).done(function( msg ) {
            Toast.fire({
              icon: 'success',
              title: 'Pengiriman balasan berhasil'
            });
            $('.direct-chat-msg[kunci="'+msg.client_id+'"]').find('.float-left').html(msg.time);
          }).fail(function( msg ) {
            Toast.fire({
              icon: 'error',
              title: 'Pengiriman balasan gagal'
            });
            $('.direct-chat-msg[kunci="'+kunci+'"]').find('.float-left').html('<div class="text-danger">Gagal dikirim!</div>');
          });
        };

            // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('080be145d82e8f94682f', {
          cluster: 'ap1',
          forceTLS: true
        });

        var channel = pusher.subscribe('CurhatRekanRekanita');
        pusher.connection.bind('connected', function() {
        $('#loading-chat').fadeOut('slow');
        });
        channel.bind('TerimaBalasan-{{ $pesan->id }}', function(data) {
          
          if( $('.direct-chat-msg[kunci="'+data.message.kunci+'"]').length == 0 )
          {
            data = data.message;
            if( data.is_admin == 1 )
            {
              pesan(data.message, data.kunci, true, data.name, data.created_at, data.avatar );
            }
            else
            {
              pesan(data.message, data.kunci, false, data.name, data.created_at, data.avatar );
            }
          }

        });

        channel.bind('{{ auth()->user()->remember_token }}', function(e){
          if( e.action == 'refresh' )
          {
            location.href = "";
          }
        })

        $('#kirim').click(kirim);
        $('textarea').on('keypress',function(e) {
            if(e.which == 13)
            {
                kirim();
                return false;
            }
        });

      })
    </script>
@endsection
@endif

@section('content')
<!-- Main content -->
<section class="content pt-3">
@if (empty($pesan))
<div class="error-page">
  <h2 class="headline text-warning"> 404</h2>

  <div class="error-content">
    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Astaghfirullah.</h3>

    <p>
      Pesan tidak dapat ditemukan seperti do'i yang suka menghilang.
      Silahkan <a href="{{ route('admin.beranda') }}">Kembali ke Beranda.</a>
    </p>

  </div>
  <!-- /.error-content -->
</div>
@else
<div class="container-fluid">
    <div class="row">
    <div class="col-12">
        <!-- Default box -->
        <div class="card border-primary" style="overflow: hidden; position: relative">
              <div id="loading-chat" style="display: none">
                <h3 class="m-auto text-white pb-5 text-center">
                  <div class="display-3 mb-0"><i class="fas fa-circle-notch fa-spin"></i></div>
                  <small style="font-size: 14px">Sedang menghubungi doi, eh server ding...</small>
                </h3>
              </div>
              <div class="card-body bg-light">
                <div class="direct-chat-messages" id="kolom-chat">
                  
                  {{-- ============================  P E S A N ============================ --}}
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">{{ $pesan->user->name }}</span>
                      <span class="direct-chat-timestamp float-right">{{ $pesan->updated_at->format('d M h:i a') }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset('data/users_img/'.$pesan->user->avatar()) }}" alt="Message User Image">
                    <div class="direct-chat-text">
                      {!! $pesan->message !!}
                    </div>
                  </div>

                    @foreach ($pesan->message_answer as $balasan)
                      @if ($balasan->user->is_admin == null)
                      <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-left">{{ $balasan->user->name }}</span>
                          <span class="direct-chat-timestamp float-right">{{ $balasan->updated_at->format('d M h:i a') }}</span>
                        </div>
                        <img class="direct-chat-img" src="{{ asset('data/users_img/'.$balasan->user->avatar()) }}" alt="Message User Image">
                        <div class="direct-chat-text">
                          {!! $balasan->message !!}
                        </div>
                      </div>
                      @else
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-right">{{ $balasan->user->name }}</span>
                          <span class="direct-chat-timestamp float-left">{{ $balasan->updated_at->format('d M h:i a') }}</span>
                        </div>
                        <img class="direct-chat-img" src="{{ asset('data/users_img/'.$balasan->user->avatar()) }}" alt="Message User Image">
                        <div class="direct-chat-text">
                          {!! $balasan->message !!}
                        </div>
                      </div>
                      @endif
                      
                    @endforeach

                {{-- ============================  P E S A N ============================ --}}

                </div>
                <div style="height: 100px; width: 100%; position: relative;">
                  <div class="form-group mb-0 w-100" style="position: absolute; bottom: 0;">
                    <div class="input-group input-group">
                      <textarea class="form-control bg-white border-success elevation-2" style="resize: none" id="txtarea" spellcheck="false" placeholder="Tulis Pesan (bisa menggunakan emoji)..."></textarea>
                      <span class="input-group-append">
                        <button type="button" class="btn btn-success elevation-2" id="kirim">Kirim<i class="far fa-paper-plane ml-2"></i></button>
                      </span>
                    </div>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                      Tekan <strong>Enter</strong> untuk mengirim
                    </small>
                  </div>

                </div>
              </div>

        </div>
        <!-- /.card -->
    </div>
    </div>
</div>
</section>
<!-- /.content -->
@endif
@endsection