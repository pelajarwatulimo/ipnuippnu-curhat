@extends('layouts.master')

@section('title', 'Kotak Curhat')

@section('header')
    <link rel="stylesheet" href="{{ asset('/assets/vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('footer')
    <script src="{{ asset('/assets/vendor/tinysort/tinysort.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('tr[href] td').click(function(e){
                if (e.target === this){
                    location.href = $(this).parent().attr('href');
                }
            });
            tinysort($('.table-responsive.mailbox-messages tbody tr'),{attr: 'time', order: 'desc'});
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kotak Curhat</h3>
            </div>
            <div class="card-body p-0">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <a href="{{ route('user.pesan.create') }}" class="btn btn-primary btn-sm checkbox-toggle"><i class="far fa-edit mr-1"></i>Tulis Curhat</a>
                    <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm disabled"><i class="far fa-trash-alt"></i></button>
                    <button type="button" class="btn btn-default btn-sm disabled"><i class="fas fa-reply"></i></button>
                    <button type="button" class="btn btn-default btn-sm disabled"><i class="fas fa-share"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm  disabled"><i class="fas fa-sync-alt"></i></button>
                    <div class="float-right">
                    {{ $curhatan->count() . ' / ' . $curhatan->count() }}
                    <div class="btn-group ml-2">
                        <button type="button" class="btn btn-default btn-sm disabled"><i class="fas fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-default btn-sm disabled"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                    @if( $curhatan->count() > 0 )
                    <table class="table table-hover">
                    <tbody>
                    @foreach ($curhatan as $key => $curhat) 
                    <tr style="cursor: pointer" href="{{ \URL::to('/') }}/user/pesan/{{ $curhat->id }}/view" class="{{ $curhat->last_message()->user_read ? '' : 'font-weight-bold' }}" time="{{ $curhat->last_message()->updated_at->timestamp }}">
                      <td style="width: 20px" class="d-none">
                        <div class="icheck-primary">
                          <input type="checkbox" value="" id="check{{ $key }}">
                          <label for="check{{ $key }}"></label>
                        </div>
                      </td>
                      <td class="mailbox-name py-3 d-none d-md-table-cell text-primary">{{ \Str::limit($curhat->title, 20) }}</td>
                      <td class="mailbox-subject py-3">
                        <div class="d-block d-md-none text-primary">{{ \Str::limit($curhat->title, 13) }}</div>
                        @if ($curhat->last_message()->user->is_admin)
                            <img src="{{ asset('/assets/img/ig-trusted.png') }}" alt="Logo Admin" width="20">
                        @endif
                        {{ $curhat->last_message()->user->panggilan() }}
                        :
                        {{  \Str::limit(strip_tags($curhat->last_message()->message), 30 ) }}
                      </td>
                      <td class="mailbox-attachment py-3"></td>
                      <td class="mailbox-date text-right py-3">{{ $curhat->last_message()->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                    <!-- /.table -->
                    @else
                        <div class="p-3 text-center text-secondary">Tidak Ada Pesan</div>
                    @endif
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection
