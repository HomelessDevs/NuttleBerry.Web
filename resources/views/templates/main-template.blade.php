<html lang="UA">
<head>
    <meta charset="UTF-8">
    <title>Nuttleberry</title>
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <meta name="description" content="Nuttleberry - Open source platform for distance learning">
    <meta name="author" content="Tarnavskyi Vitalii">
    <meta name="viewport" content="width=device-width">
    <!--<meta name="main-component" author="first nuttleberry tester: ©marichka" content="В кожну м'ятну вспливашку було вкладено душу" > -->
</head>
<body>
<div class="app">
    @include('template-parts.header')
    <div class="main-wrap">
        @yield('content')
    </div>
    @include('template-parts.footer')
</div>
<script src="{{ url('js/hamburger.js') }}"></script>
</body>
</html>
