@extends('layouts.account')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="text-center">
    <h1 class="h5 text-gray-900 mb-4 mt-3">Ganti Kata Sandi
        <small class="d-block small text-muted mt-1">( {{ $email }} )</small>
    </h1>
</div>
<form action="{{ route('reset_pass.go', $link) }}" method="post" class="user mb-4" autocomplete="off">
  @csrf
  <div class="form-group">
    <input type="password" class="form-control form-control-user{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Masukkan kata sandi yang baru" name="password" autocomplete="off">
    <div class="invalid-feedback">
      {{ $errors->first('password') }}
    </div>
  </div>
  <div class="form-group">
    <input type="password" class="form-control form-control-user{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Ulangi kata sandi" name="password_confirmation" autocomplete="off">
    <div class="invalid-feedback">
      {{ $errors->first('password_confirmation') }}
    </div>
  </div>
  <button class="btn btn-success btn-user btn-block font-weight-bolder">
    Ganti Kata Sandi
  </button>
</form>
@endsection