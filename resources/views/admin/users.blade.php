@extends('layouts.master')

@section('title', 'Daftar Akun')

@section('footer')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $(document).ready(function(){

      var dialog = true;
        
      $('form[data="deluser"]').submit(function(e){

          if( dialog ){
              dialog = false;
              var form = $(this);
              e.preventDefault();
              Swal.fire({
                title: 'Yakin ingin menghapus akun?',
                text: "Pastikan akun \""+form.parents('.d-flex').find('.nama').text()+"\" memang perlu dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batalkan'
                }).then((result) => {
                if (result.value) {
                    form.submit();
                }else {
                    dialog = true;
                }
              });
          }
      });

    });
</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title">Pengguna</h3>
            </div>
            <div class="card-body">
                @if ($users->count() < 1)
                    <div class="text-center">Tidak Ada</div>
                @else
                <ul class="list-group">
                    @foreach ($users as $user)
                    <li class="list-group-item list-group-item-action bg-dark h5 d-flex">
                        <img width="60" height="60" src="{{ asset('data/users_img/') . '/' . $user->avatar() }}" class="mr-2 rounded-lg">
                        <div class="w-100">
                            <div class="d-flex">
                                <span class="nama">
                                    {{ $user->name }}
                                </span>
                                <div class="ml-auto d-flex">
                                    <form action="{{ route('admin.users.del', $user->id) }}" method="post" class="ml-auto" data="deluser">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm mr-2" data-toggle="tooltip" data-placement="left" title="Hapus Akun"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <form action="{{ route('admin.users.up', $user->id) }}" method="post" class="ml-auto">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Jadikan Administrator"{{ $user->email_verified_at ? '' : ' disabled' }}><i class="fas fa-arrow-circle-up"></i></button>
                                    </form>

                                </div>
                            </div>
                            <div class="small mt-1">
                                <span class="badge badge-secondary badge-sm">{{ $user->email }}</span>
                                <span class="badge badge-secondary badge-sm">{{ $user->email_verified_at ? $user->email_verified_at->format('d M y') : 'Belum Konfirmasi Email' }}</span>
                                <span class="badge badge-secondary badge-sm">R. {{ $user->ranting }}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Default box -->
            <div class="card bg-danger">
            <div class="card-header">
                <h3 class="card-title">Administrator</h3>
            </div>
            <div class="card-body">
                @if ($admins->count() < 1)
                    <div class="text-center font-weight-bold">Tidak Ada</div>
                @else
                <ul class="list-group">
                    @foreach ($admins as $admin)
                    <li class="list-group-item list-group-item-action bg-dark h5 d-flex">
                        <img width="60" height="60" src="{{ asset('data/users_img/') . '/' . $admin->avatar() }}" class="mr-2 rounded-lg">
                        <div class="w-100">
                            <div class="d-flex">
                                {{ $admin->name }}
                                <form action="{{ route('admin.users.down', $admin->id) }}" method="post" class="ml-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Jadikan User Biasa"{{ $admin->email_verified_at ? '' : ' disabled' }}><i class="fas fa-arrow-circle-down"></i></button>
                                </form>
                            </div>
                            <div class="small mt-1">
                                <span class="badge badge-secondary badge-sm">{{ $admin->jabatan() }}</span>
                                <span class="badge badge-secondary badge-sm">{{ $admin->email }}</span>
                            </div>
                        </div>
                    </li>
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
