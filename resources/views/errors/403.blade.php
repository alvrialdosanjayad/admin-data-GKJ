@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('gambar')
<img src="{{ asset('gambar/forbidden.png') }}" alt="" class="img-fluid rounded float-left gambar2">
@endsection
@section('code', '403')
@section('message')

@if ($exception->getMessage() === 'admin')
<div class="d-flex justify-content-center">
    <h2>Maaf Anda Tidak Memiliki Akses</h2>
</div>
<div class="d-flex justify-content-center">
    <a href="{{ route('dasboardgereja') }}" class="btn btn-primary">Kembali</a>
</div>
@else
<div class="d-flex justify-content-center">
    <h2>Maaf Anda Tidak Memiliki Akses</h2>
</div>
<div class="d-flex justify-content-center">
    <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Keluar</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endif
@endsection