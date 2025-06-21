<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->app_name ?? config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page bg-dark">
    <div class="login-box">
        <div class="login-logo d-flex flex-column">
            @if($setting?->logo_path)
            <a href="/"><img src="{{asset('storage/'.$setting->logo_path)}}" alt="{{ $setting->app_name ?? config('app.name') }} Logo" class="img-thumbnail" style="height: 100px;"></a>
            @endif
            <a href="/" class="text-white">{{ $setting->app_name ?? config('app.name') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card rounded-4 border-0">
            @yield('content')
        </div>
    </div>
    <!-- /.login-box -->

    @vite('resources/js/app.js')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>
