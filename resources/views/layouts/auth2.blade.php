<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Kubre') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('layouts.partials.css')
    <link rel="stylesheet" href="{{ asset('css/auth-modern.css') }}?v={{ time() }}">

    <!-- Recaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="auth-body">
    @inject('request', 'Illuminate\Http\Request')
    
    @if (session('status') && session('status.success'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
            data-msg="{{ session('status.msg') }}">
    @endif

    <!-- Contenedor Pantalla Completa Fluido (100vw x 100vh) -->
    @yield('content')

    @include('layouts.partials.javascripts')

    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    @yield('javascript')
</body>
</html>
