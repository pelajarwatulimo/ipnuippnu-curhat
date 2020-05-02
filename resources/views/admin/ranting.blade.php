@extends('layouts.master')

@section('title', 'Ranting')

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-4 order-md-2">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title">Tambahkan Data</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ranting') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Ranting</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Masukkan nama..." name="ranting" required>
                    </div>
                    <button class="btn btn-dark btn-block py-2" type="submit">Simpan Data</button>
                </form>
            </div>
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title">Daftar Ranting</h3>
            </div>
            <div class="card-body">
                @if ($ranting->count() < 1)
                    <div class="text-center">Tidak Ada</div>
                @else
                <ul class="list-group">
                    @foreach ($ranting as $key => $desa)
                    <li class="list-group-item list-group-item-action bg-dark h5">{{ ++$key }}. Ranting {{ $desa->name }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection
