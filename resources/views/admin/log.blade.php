@extends('layouts.master')

@section('title', 'Ranting')

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
        <div class="col">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title">Catatan</h3>
            </div>
            <div class="card-body">
                @if( $logs->count() > 0 )
                <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Rincian</th>
                      </tr>
                    </thead>
                    <tbody style="height: 10px; overflow: auto">
                        @foreach( $logs as $key => $log )
                      <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td>@php
                            switch ($log->type) {
                              case 'act':
                                echo 'Pengelola';
                                break;
                              
                              default:
                                echo 'Sistem';
                                break;
                            }
                        @endphp</td>
                        <td>{{ $log->value }}</td>
                      </tr>
                       @endforeach
                    </tbody>
                  </table>
                  @else
                  <p class="mb-0 text-center">Data tidak tersedia</p>
                  @endif
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection
