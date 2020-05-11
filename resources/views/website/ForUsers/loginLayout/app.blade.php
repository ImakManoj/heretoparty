<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

       <title>@yield('title')</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Favicon -->
      <link rel="shortcut icon" href="{{asset('heretoparty')}}/favicon.png" sizes="64x64" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('heretoparty')}}/css/main.css">
    <link rel="stylesheet" href="{{asset('heretoparty')}}/css/custom.css">
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body class="home">
    <div id="app">
       
        <main>
            @yield('content')
        </main>
      
    </div>
</body>

  <!-- jQuery first, then Bootstrap JS. -->
  <script src="{{asset('heretoparty')}}/js/jquery.min.js"></script>
  <script src="{{asset('heretoparty')}}/js/popper.min.js"></script>
  <script src="{{asset('heretoparty')}}/js/bootstrap.min.js"></script>
  <script src="{{asset('heretoparty')}}/js/aos.js"></script>
  <script src="{{asset('heretoparty')}}/js/bootstrap-select.min.js"></script>
  <script src="{{asset('heretoparty')}}/js/slick.js"></script>
  <script src="{{asset('heretoparty')}}/js/custom.js"></script>
</html>
