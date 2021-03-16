<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/loginRegis.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Admin Data Jemaat</title>
    <link rel="icon" href="{{ asset('gambar/logo-gkj.png') }}" type="image/icon type">
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="row border-box rounded float-left">
                    <div class="col-md-5 mt-5">
                        <h3>Selamat Datang</h3>
                        <form class="p-2" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <input id="username" type="text" class="form-control form-control-user @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Masuk</button>
                            <hr>
                        </form>
                    </div>
                    <div class="col-md-7 p-0 latihan">
                        <img src="{{ asset('gambar/gkj.jpg') }}" alt="" class="img-fluid rounded float-left gambar2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>