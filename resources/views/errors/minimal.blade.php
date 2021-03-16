<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body>
    <div class="d-flex justify-content-center mt-5">
        @yield('gambar')
    </div>
    <div class="d-flex justify-content-center mt-2">
        <h2>@yield('code')</h2>
    </div>
    @yield('message')
</body>

</html>