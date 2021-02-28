<!DOCTYPE html>
<html lang="UA">
<head>
<meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app">
    @include('template-parts.header')
    @yield('content')
    @include('template-parts.footer')
</div>
</body>
</html>
