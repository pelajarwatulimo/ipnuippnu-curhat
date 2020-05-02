@extends('layouts.account')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="text-center">
    <h1 class="h5 text-gray-900 mb-4 mt-3">Lupa Kata Sandi</h1>
</div>
<form action="{{ route('reset_pass') }}" method="post" class="user">
  @csrf
  <div class="form-group">
    <input type="email" class="form-control form-control-user{{ $errors->has('email') ? ' is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Masukkan alamat email" name="email" value="{{ old('email') }}">
    <div class="invalid-feedback">
      {{ $errors->first('email') }}
    </div>
  </div>
  <div class="mb-3">
    <div class="d-flex justify-content-center">
      {!! captcha_img() !!}
      <input type="text" class="ml-2" name="captcha" placeholder="Masukkan Captcha">
    </div>
    @if( $errors->has('captcha') )
    <div class="small text-danger text-center">
      {{ $errors->first('captcha') }}
    </div>
    @endif
  </div>
  <button class="btn btn-success btn-user btn-block font-weight-bolder">
    Atur Ulang Kata Sandi
  </button>
</form>
<div class="text-center mt-4 mb-2">
  Belum punya akun? <a class="text-success d-block d-lg-inline" href="{{ route('signup') }}">Buat sekarang!</a>
</div>
@endsection