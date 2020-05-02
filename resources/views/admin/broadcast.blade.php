@extends('layouts.master')

@section('title', 'Pesan Broadcast')
@section('footer')
<link rel="stylesheet" href="{{ asset('/assets/vendor/summernote/summernote-bs4.min.css') }}">
<script src="{{ asset('/assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $('#compose-textarea').summernote({
        maximumImageFileSize: 524288,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['font', ['superscript', 'subscript']],
            ['para', ['paragraph']],
            ['insert', ['link', 'picture']],
            ['view', ['codeview']]
        ],
        height: 200,
        placeholder: 'Silahkan tulis pesan siaran'
    });
  });
  $(document).ready(function(){
    $('input[name="title"]').focus();
    $('form').submit(function(){
        if( $('#compose-textarea').summernote('isEmpty') )
        {
            $('#compose-textarea').summernote('focus');
            return false;
        }
    })
  });
</script>
@endsection

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card bg-danger">
                    <div class="card-header">
                        <h3 class="card-title">Kirim Pesan ke <b>Semua Akun</b></h3>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="card-body">
                            <form action="{{ route('admin.broadcast') }}" method="post">
                                @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-danger border-danger">Judul Pesan</div>
                                </div>
                                <input type="text" class="form-control bg-dark border-danger" name="title" maxlength="50" placeholder="Masukkan judul pesan siaran..." required>
                            </div>
                            <div class="form-group mb-4 text-dark">
                                <textarea id="compose-textarea" class="form-control" name="message"></textarea>
                                <small id="passwordHelpBlock" class="form-text text-muted font-weight-bold">
                                    Nb: Setelah terkirim, pesan tidak dapat ditarik kembali
                                </small>
                            </div>
                            <button class="btn btn-danger btn-block" type="submit">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info mr-2"></i>Informasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 pr-0">Pengikut<div class="float-right">:</div></div>
                            <div class="col-8 pl-1">{{ is_integer($subscriber) ? ($subscriber . ' pengikut') : $subscriber }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4 pr-0">Broadcaster<div class="float-right">:</div></div>
                            <div class="col-8 pl-1">OneSignal</div>
                        </div>
                    </div>
                </div>
                <div class="card bg-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-clock mr-2"></i>Pesan Terakhir</h3>
                    </div>
                    <div class="card-body">
                        @if ($broadcast->count() < 1)
                            <div class="text-center font-weight-bold">Tidak Ada</div>
                        @else
                        <ul class="list-group">
                            @foreach ($broadcast as $pesan)
                            <li class="list-group-item list-group-item-action bg-dark h5 d-flex">
                                <div class="w-100">
                                    <div class="d-flex">
                                        {{ $pesan->title }}
                                            <a href="{{ route('broadcast', $pesan->slug) }}" target="_blank" type="submit" class="btn btn-success btn-sm py-0 px-2 ml-auto"\
                                                data-toggle="tooltip" data-placement="left" title="Lihat"><i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="small mt-1">
                                        <span class="badge badge-secondary badge-sm">{{ $pesan->created_at->diffForHumans() }}</span>
                                        <span class="badge badge-secondary badge-sm">{{ $pesan->user->panggilan() }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
