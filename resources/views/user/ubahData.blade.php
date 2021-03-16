@extends('layouts.appUtama')

@section('tambahanCSS')
@endsection

@section('user','active')

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card">
        <div class="card-header bg-dark text-white">
            Ubah Password
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('user.update',$post['id'] )}}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for=role">Role</label>
                            <input type="text" class="form-control" name="role" id="role" value="Admin" readonly>
                            <!-- <input type="text" class="form-control" name="role" id="role" value="admin" disabled> -->
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="{{$post['username']}}" readonly>
                            <div class="alert-message text-danger" id="usernameError"></div>
                        </div>
                        <div class="form-group">
                            <label for="passsword" id="lPassword">Kata Sandi</label>
                            <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                            @error('password')
                            <p class=" text-danger">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" id="lnPassword">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" autocomplete="new-password">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Simpan
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

@endsection

@section('tambahanModal')

@endsection



@section('tambahanJS')
@endsection