<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curhat... | Curhat Rekan & Rekanita</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet"> 
    {{-- <link rel="stylesheet" href="bootstrap/bootstrap.min.css"> --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/bootstrap/jquery.min.js') }}"></script> --}}
    <script>
        jQuery.fn.extend({
        autoHeight: function () {
            function autoHeight_(element) {
            return jQuery(element)
                .css({ 'height': 'auto', 'overflow-y': 'hidden' })
                .height(element.scrollHeight);
            }
            return this.each(function() {
            autoHeight_(this).on('input', function() {
                autoHeight_(this);
            });
            });
        }
        });

        $(document).ready(function(){
            $('#chatting-box').autoHeight();
        });
    </script>
    <style>
        @font-face {
            font-family: "Noto Emoji Regular";
            src: url('{{ asset("assets/fonts/NotoColorEmoji.ttf") }}')  format('truetype');
        }
        html, body{
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            font-family: 'Noto Emoji Regular';
            -webkit-touch-callout: none;
            user-select: none;
        }
        body > .atas {
            height: 50px;
            border-bottom: 1px solid #caced1;
            position: relative;
            z-index: 2;
        }
        body > .tengah {
            height: calc(100% - 121px);
            overflow-y: scroll;
            background: #ecf0f1;
        }
        body > .bawah {
            position: fixed;
            border-top: 1px solid #caced1;
            background: #fff;
            width: 100%;
            bottom: 0;
            min-height: 63px;
        }
        #chatting-box {
            resize: none;
            width: calc(100%);
            padding-bottom: 0 !important;
        }
        #chats-box > *:first-child {
            margin-top: 5px;
        }
        .pesan {
            width: 100%;
            display: flex;
            margin-bottom: 15px;
        }
        .pesan.me .foto-profil {
            order: 2;
        }
        .pesan.me .foto-profil img {
            margin: 5px 0 5px 8px;
        }
        .pesan .foto-profil img {
            width: 35px;
            height: 35px;
            border-radius: 100%;
            border: 1px solid #caced1;
            margin: 5px 8px 5px 0;
            display: inline-block;
        }
        .pesan .isi {
            padding: 10px !important;
            font-size: 16px;
            display: flex;
            background-color: #fff;
            color: #fff;
            border-radius: 5px;
            background-color: #2196F3;
            line-height: 1.3;
        }
        .pesan.me .isi {
            background-color: #4CAF50;
        }
        .pesan .pengirim {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 3px;
            display: flex;
        }
        .pesan:not(.me) .waktu::before, .pesan.me .waktu::after  {
            content: "";
            background: #7f8c8d ;
            width: 3px;
            height: 3px;
            border-radius: 100%;
            display: inline-block;
            margin: auto 8px;
        }
        .pesan .waktu {
            font-weight: lighter;
            color: #7f8c8d;
            font-size: 11px;
            margin: auto 0;
            display: flex;
        }
        .pesan.me .waktu {
            order: -1;
        }
        .pesan.me > .d-block {
            margin-left: auto;
        }

    </style>
</head>
<body>
    <div class="atas shadow-sm">
        a
    </div>
    <div class="tengah px-3" id="chats-box">
        ❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️
        <div class="pesan">
            <div class="foto-profil">
                <img src="default.jpg" alt="Foto Profil" class="shadow-sm">
            </div>
            <div class="d-block">
                <div class="pengirim">
                    <span>Aciap</span>
                    <span class="waktu">18:38</span>
                </div>
                <div class="isi">
                    Kenapa kamu selalkd askndasn askljd d dknsa dks,amsmdklm
                </div>
            </div>
        </div>

    </div>
    <div class="bawah shadow d-flex p-3">
        <textarea name="chatting-box" id="chatting-box" rows="1" class="form-control" placeholder="Tulis pesan..."></textarea>
        <button id="chatting-send" class="ml-2 btn btn-primary py-0 px-3"><i class="fas fa-paper-plane"></i></button>
    </div>
</body>
</html>