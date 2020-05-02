@extends('layouts.master')

@section('title', 'Tentang Kami')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h1>Tentang Kami</h1>
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
        <div class="card-body text-center">

            <div class="mx-md-5 px-md-4">
                <h1 class="font-weight-bold mt-2 mb-1">{{ config('app.name') }}</h1>
                <div class="d-block mb-4"><span class="badge badge-primary">Versi {{ config('app.version') }}</span></div>
                <p>Aplikasi ini didedikasikan kepada : <br /><b class="text-success">Pimpinan Anak Cabang Ikatan Pelajar Nahdlatul Ulama'
                    & Ikatan Pelajar Putri Nahdlatul Ulama' Kecamatan Watulimo</b><br /><br />
                    Terikat pada Lisensi Terbuka Creative Commons, bebas disebarluaskan dan digunakan kembali
                    dengan tetap mengikuti aturan - aturan yang berlaku pada lisensi. 
                    Mari kita tingkatkan kualitas managemen organisasi dan berpartisipasi sesuai dengan
                    keahliannya masing - masing.<br />
                    <small class="d-block mt-4"><b>Contributor :</b><br />
                        Muhammad Isnu Nasrudin &#x2027;
                        Dwi Aji Pangestu &#x2027;
                        Samsul Hadi &#x2027;
                        Hadi Mabrur &#x2027;
                        Ahmad Imron Rosidi &#x2027;
                        Bimi Maulana Hanif
                    </small>

                    <small class="d-block mt-4"><b>Project Started on :</b><br />
                        Jum'at, 3 April 2020 pada 17:32
                    </small>
                </p>
            </div>

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
