@extends('layouts.account')

@section('title', 'Buat Akun')
@section('prepare')
<style>
  form > .loading{
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background: rgba(0, 0, 0, 0.342);
    position: absolute;
    z-index: 2;
    display: none;
  }
</style>
@endsection

@section('content')
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4 mt-3">Buat Akun</h1>
</div>
<form action="{{ route('signup') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="loading text-white" style="font-size: 80px"><i class="m-auto fas fa-circle-notch fa-spin"></i></div>
  <div class="form-group">
    <label for="sign-nama" class="mb-1">Nama Lengkap</label>
    <input type="text" class="form-control{{ $errors->has('sign-nama') ? ' is-invalid' : '' }}" id="sign-nama" name="sign-nama" minlength="3" required value="{{ old('sign-nama') }}">
    <div class="invalid-feedback">
      {{ $errors->first('sign-nama') }}
    </div>
  </div>
  <div class="form-group">
    <label for="sign-email" class="mb-1">Alamat Email</label>
    <input type="email" class="form-control{{ $errors->has('sign-email') ? ' is-invalid' : '' }}" id="sign-email" name="sign-email" minlength="5" required value="{{ old('sign-email') }}">
    <div class="invalid-feedback">
      {!! $errors->first('sign-email') !!}
    </div>
  </div>
  <div class="form-group">
    <label for="sign-ranting" class="mb-1">Ranting</label>
    <select class="form-control{{ $errors->has('sign-ranting') ? ' is-invalid' : '' }}" id="sign-ranting" name="sign-ranting" required>
      @foreach ($ranting as $desa)
        <option value="{{ $desa->id }}">{{ $desa->name }}</option>
      @endforeach
    </select>
    <div class="invalid-feedback">
      {{ $errors->first('sign-ranting') }}
    </div>
  </div>
  <div class="form-group">
    <label for="sign-pass" class="mb-1{{ $errors->has('sign-pass') ? ' is-invalid' : '' }}">Kata Sandi</label>
    <input type="password" class="form-control" id="sign-pass" name="sign-pass" placeholder="Min. 8 karakter" minlength="8" required>
    <div class="invalid-feedback">
      {{ $errors->first('sign-pass') }}
    </div>
  </div>
  <div class="form-group">
    <label for="sign-pass2" class="mb-1">Ulangi Kata Sandi</label>
    <input type="password" class="form-control{{ $errors->has('sign-pass_confirmation') ? ' is-invalid' : '' }}" id="sign-pass2" minlength="8" required name="sign-pass_confirmation">
    <div class="invalid-feedback">
      {{ $errors->first('sign-pass_confirmation') }}
    </div>
  </div>
  <div class="form-group">
    <label for="sign-foto">Pilih Foto profil</label>
    <input type="file" class="form-control-file" id="sign-foto" name="sign-foto">
  </div>
  <div class="form-group mt-4">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input{{ $errors->has('sign-agree') ? ' is-invalid' : '' }}" id="sign-agree" name="sign-agree" value="1" required>
        <label class="custom-control-label p-pointer" for="sign-agree">Saya siap mengabdi kepada IPNU & IPPNU</label>
    </div>
    <div class="invalid-feedback">
      {{ $errors->first('sign-agree') }}
    </div>
  </div>
  <button type="submit" class="btn btn-success d-block w-100 py-2 mt-3">Buat Akun</button>
</form>
<div class="text-center mt-4 mb-2">
    Punya akun? <a class="text-success d-block d-lg-inline" href="{{ route('login') }}">Masuk!</a>
</div>
@endsection