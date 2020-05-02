@extends('layouts.master')

@section('title', 'Tulis Pesan')

@section('header')
    <link rel="stylesheet" href="{{ asset('/assets/vendor/summernote/summernote-bs4.min.css') }}">
@endsection

@section('footer')
<script src="{{ asset('/assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $('#compose-textarea').summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
        ],
        placeholder: 'Silahkan tulis curhatan anda'
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
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h1>Tulis Curhatan Baru</h1>
        </div>
    </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
<div class="container-fluid">
    <div class="row">
    <div class="col-12">
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.pesan.create') }}" method="post">
                    @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Judul Curhatan</div>
                    </div>
                    <input type="text" class="form-control" name="title" maxlength="50" placeholder="Masukkan judul / garis besar curhatan..." required>
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" name="message"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Kirim</button>
                </form>
              </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>
</div>
</section>
<!-- /.content -->
@endsection
