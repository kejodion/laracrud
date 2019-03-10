<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:regular,bold">
    <link rel="stylesheet" href="{{ asset('laracrud/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laracrud/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laracrud/css/fa.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laracrud/css/laracrud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>@yield('title') | {{ config('app.name') }}</title>
</head>
<body class="bg-light h-100">
    @yield('parent-content')

    <script src="{{ asset('laracrud/js/jquery.min.js') }}"></script>
    <script src="{{ asset('laracrud/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('laracrud/js/datatables.min.js') }}"></script>
    <script src="{{ asset('laracrud/js/laracrud.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>