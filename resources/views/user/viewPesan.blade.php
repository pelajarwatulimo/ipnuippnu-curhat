<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#27ae60">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting... | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chatting.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/sweetalert2/sweetalert2.min.css') }}">
</head>
<body class="p-3">
    <audio src="{{ asset('assets/audio/ping.mp3') }}" class="d-none"></audio>
    <div class="bg-shadow" style="display: none"></div>
    <div class="container-fluid h-100">
         <div class="row h-100">
             <div class="col-lg-3" id="body-kiri">
                <div class="expand d-lg-none" sliding="false"><i class="fas fa-angle-right m-auto"></i></div>
                <a href="{{ route('user.beranda') }}" class="item mb-3">
                    <i class="fas fa-chevron-circle-left mr-1"></i>
                    Back to Kotak Masuk
                </a>
                <a href="#development" class="item">
                    <i class="far fa-calendar-alt mr-1"></i>
                    Agenda Bulan Ini
                </a>
                <a href="#development" class="item">
                    <i class="far fa-address-card mr-1"></i>
                    Pengajuan KTA
                </a>
                <a href="{{ route('user.info') }}" class="item">
                    <i class="far fa-question-circle mr-1"></i>
                    Tentang Kami
                </a>
             </div>
             <div class="col-12 col-lg-9 h-100" id="body-kanan">
                <div class="atas d-flex">
                    <span class="logo d-flex">
                        <i class="fas fa-comments m-auto"></i>
                    </span>
                    <abbr class="judul h6 ml-3 my-auto" title="{{ strip_tags($pesan['message']) }}">{{ strip_tags($pesan['message']) }}</abbr>
                </div>
                <div id="chats" style="overflow: hidden">
                    <div class="loading">
                        <h3 class="m-auto text-white pb-5 text-center">
                            <div class="display-3 mb-0"><i class="fas fa-circle-notch fa-spin"></i></div>
                            <small style="font-size: 14px">Sedang menghubungi doi, eh server ding...</small>
                        </h3>
                    </div>
                    @if( $pesan->message_answer->count() )
                        @foreach ($pesan->message_answer as $balasan)
                            <div class="chat{{ $balasan->user->is_admin ? '' : ' kanan' }}">
                                <img src="{{ asset('data/users_img/' . $balasan->user->avatar()) }}" alt="{{ $balasan->user->panggilan() }}" class="foto-profil">
                                <div class="lailioo">
                                    <div class="nama">{{ $balasan->user->panggilan() }}</div>
                                    <div class="pesan">
                                        {!! app('profanityFilter')->filter($balasan->message) !!}
                                    </div>
                                    <time class="waktu">{{ $balasan->updated_at->format('d M H:i') }}</time>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-message">Belum ada riwayat percakapan</div>
                    @endif
                </div>
                <form method="post" id="tulis-pesan" class="d-flex" style="height: 50px;">
                    <input type="text" placeholder="Tuliskan Pesan" class="mr-auto" />
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
             </div>
         </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script>
        var double_ready = false; // Untuk melakukan persiapan total

        $.fn.animateRotate = function(angle, duration, easing, complete) {
            var args = $.speed(duration, easing, complete);
            var step = args.step;
            return this.each(function(i, e) {
                args.complete = $.proxy(args.complete, e);
                args.step = function(now) {
                    $.style(e, 'transform', 'rotate(' + now + 'deg)');
                    if (step) return step.apply(e, arguments);
                };

                $({deg: 0}).animate({deg: angle}, args);
            });
        };

        function acak(length = 50) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        function pesan(isi, kunci_lokal = null, dari_ku = true, dari_nama = '{{ auth()->user()->name }}', waktu = "Mengirim...", dari_avatar = "{{  auth()->user()->avatar() }}")
        {
            isi = jQuery('<div />').text(isi).html()

            var html = '   <img src="{{ asset("data/users_img") }}/'+ dari_avatar +'" alt="'+ dari_nama +'" class="foto-profil">' +
                    '   <div class="lailioo"> <div class="nama">'+ dari_nama +'</div> <div class="pesan">' + isi + '</div> <time class="waktu">'+ waktu +'</time> </div>' +
                    '</div>';
                    
            if( dari_ku )
            {
                html = '<div class="chat kanan" chat-key="'+ kunci_lokal +'">' + html;
            } else
            {
                html = '<div class="chat" chat-key="'+ kunci_lokal +'">' + html;

            }

            if( $('#chats .no-message').length > 0 )
            {
                $('#chats .no-message').remove();
            }

            $('#chats').append(html).animate({ scrollTop: $('#chats').prop("scrollHeight")}, 1000);

            return true;
        }

        function siap()
        {
            if( !double_ready )
            {
                double_ready = true;
                return false;
            }

            $('#chats .loading').fadeOut('slow', function(){
                $('#chats').removeAttr('style');
                $('#chats').animate({ scrollTop: $('#chats').prop("scrollHeight")}, 0);
            });
            return true;
        }

        $(document).ready(function(){
            // GRETING, Tujuannya first action agar audio bisa play otomatis
            var d = new Date();
            var time = d.getHours();

            if (time < 12) {
                var greeting = ("Jangan Lupa Sarapan Ya");
            }
            if (time > 12) {
                var greeting = ("Tetap Semangat, Pantang Menyerah!");
            }
            if (time == 12) {
                var greeting =("Udah Sholat Dhuhur Kan");
            }
            Swal.fire(
                'Assalamu\'alaikum',
                greeting,
                'info'
            ).then(function(){
                setTimeout(siap,200);
            });
            // ============= GRETING ===================================
            $('#body-kiri .expand').click(function(){
                if($(this).attr('sliding') == "false")
                {
                    $(this).find('i').animateRotate(180);
                    $(this).attr('sliding', "true");
                    $('.bg-shadow').fadeIn(500);
                    $('#body-kiri').animate({
                        left: "0%"
                    }, 800);
                } else {
                    $(this).find('i').animateRotate(0);
                    $(this).attr('sliding', "false");
                    $('.bg-shadow').fadeOut(500);
                    $('#body-kiri').animate({
                        left: "-50%"
                    }, 800);
                }
            });
            $('.bg-shadow').click(function(){
                $('#body-kiri .expand').click();
            })

            $('a[href="#development"]').click(function(e){
                e.preventDefault();
                Swal.fire(
                    'Mohon Maaf!',
                    "Fitur masih dalam pengembangan, akan tersedia dalam waktu dekat.",
                    'info'
                );
            });

            // === PUSHER ===========================================
            var pusher = new Pusher('{{ config('app.pusher_key') }}', {
            cluster: 'ap1',
            forceTLS: true
            });

            var channel = pusher.subscribe('CurhatRekanRekanita');
            pusher.connection.bind('connected', function() {
                siap();
            });
            channel.bind('TerimaBalasan-{{ $pesan->id }}', function(data) {

            if( $('.chat[chat-key="'+data.message.kunci+'"]').length == 0 )
            {
                $('audio')[0].currentTime = 0; $('audio')[0].play();

                data = data.message;
                if( data.is_admin == 0 )
                {
                    pesan(data.message, data.kunci, true, data.name, data.created_at, data.avatar );
                }
                else
                {
                    pesan(data.message, data.kunci, false, data.name, data.created_at, data.avatar );
                }

                $.post('{{ route("user.pesan.jawab",[$pesan->id]) }}', {answer_id: data.id});
            }

            });

            channel.bind('{{ auth()->user()->remember_token }}', function(e){
            if( e.action == 'refresh' )
            {
                location.href = "";
            }
            })
            //  END OF PUSHER ==============================================

            $('#tulis-pesan').submit(function(e){
                e.preventDefault();
                var teks = $(this).find('input').val();
                $(this).find('input').val('');
                if( teks == null || teks == undefined || teks == "" )
                    return false;

                var kunci = acak();
                pesan(teks, kunci);

                $.ajax({
                    method: "POST",
                    url: '{{ route('user.pesan', $pesan->id) }}',
                    data: { balasan: teks, client_id: kunci }
                }).done(function( msg ) {
                    $('.chat[chat-key="'+msg.client_id+'"]').find('.waktu').html(msg.time);
                    $('.chat[chat-key="'+msg.client_id+'"]').find('.pesan').html(msg.message);
                }).fail(function( msg ) {
                    console.log(msg);
                    $('.chat[chat-key="'+kunci+'"]').find('.waktu').html('<div class="text-danger">Gagal dikirim!</div>');
                });
            })

        });
    </script>
</body>
</html>