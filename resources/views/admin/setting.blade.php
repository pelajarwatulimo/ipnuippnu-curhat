@extends('layouts.master')

@section('title', 'Pengaturan App')

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-4 order-md-2">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title"> <i class="fab fa-laravel mr-2"></i>Laravel (Artisan)</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.setting.aksi', ['fresh']) }}" class="btn btn-success d-block mb-2">Segarkan Aplikasi</a>
                <a href="{{ route('admin.setting.aksi', ['migrate']) }}" class="btn btn-success d-block">Migrasi Database</a>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection
