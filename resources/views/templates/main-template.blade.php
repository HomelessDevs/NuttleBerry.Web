<!DOCTYPE html>
<html lang="UA">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width">
</head>
<body>
<div class="app">
    @include('template-parts.header')
    <div class="main-wrap">
        @yield('content')
    </div>
    @include('template-parts.footer')
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
