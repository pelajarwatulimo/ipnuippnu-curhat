@extends('layouts.account')

@section('title', 'Masuk')

@section('content')
<div class="text-center">
    <div class="d-block">
      <img src="{{ asset('/') }}assets/img/ipnu-ippnu.png" alt="Logo IPNU IPPNU" class="px-5" style="height: 70px" />
    </div>
    <h1 class="h4 text-gray-900 mb-4 mt-3">Silahkan Login, <span class="d-block d-md-inline">Rekan / Rekanita</span></h1>
</div>
<form action="{{ route('login.post') }}" method="post" class="user">
  @csrf
  <div class="form-group">
    <input type="email" class="form-control form-control-user{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Masukkan alamat email" name="email" value="{{ old('email') }}" required>
    <div class="invalid-feedback">
      {{ $errors->first('email') }}
    </div>
  </div>
  <div class="form-group m-0">
    <input type="password" class="form-control form-control-user{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Kata Sandi" name="password" requi>
    <div class="invalid-feedback float-left" style="width: inherit">
      {{ $errors->first('password') }}
    </div>
    <div class="text-right px-3">
      <a class="small" href="{{ route('reset_pass') }}">Lupa kata sandi?</a>
    </div>
  </div>
  <div class="form-group">
    <div class="custom-control custom-checkbox small">
        <input type="checkbox" class="custom-control-input" id="customCheck" name="login_remember" value="1" checked>
        <label class="custom-control-label p-pointer" for="customCheck">Tetap masuk perangkat ini</label>
    </div>
  </div>
  <button class="btn btn-success btn-user btn-block font-weight-bolder">
  Masuk
  </button>
</form>
<div class="text-center mt-4 mb-2">
  Belum punya akun? <a class="text-success d-block d-lg-inline" href="{{ route('signup') }}">Buat sekarang!</a>
</div>
@endsection