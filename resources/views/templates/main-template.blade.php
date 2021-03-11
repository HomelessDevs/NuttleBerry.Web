<!DOCTYPE html>
<html lang="UA">
<head>
    <meta charset="UTF-8">
    <title>Nuttleberry</title>
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
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
<script src="{{ url('js/script.js') }}"></script>
</body>
</html>
