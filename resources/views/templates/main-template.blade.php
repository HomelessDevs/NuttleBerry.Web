<html lang="UA">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-55EC3CBLBC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-55EC3CBLBC');
    </script>
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
