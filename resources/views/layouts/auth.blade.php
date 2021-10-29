<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <noscript>
        <meta content="0;url={{ route('noscript') }}" http-equiv="refresh"/>
    </noscript>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('page_title'))) @yield('page_title') | @endif {{ config('app.name', 'Perception Mapping') }} | Admin Panel</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/perception-favicon.ico') }}" />

    <!--css  start-->
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/theme-main.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/theme-animate.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/theme-icon.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/waves.css') }}" />
        
        {{-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/css/themes/default.min.css"/> --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/developer.css') }}" />
    @show
    <!--css End-->
    
</head>
<body data-scrolling-animations="true" class="theme-color site-menubar-unfold">
  
    @yield('content')

    @section('scripts')

        <script src="{{ asset('js/bootstrap/jquery.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap/popper.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/theme/theme-wow.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/theme/waves.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/toastr.js') }}" type="text/javascript"></script>
        {{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/alertify.min.js"></script> --}}
        {{-- <script src="{{ asset('js/theme/theme.min.js') }}" type="text/javascript"></script> --}}
    @show


    @section('jscode')
    @show


    {{-- @include('admin.common.alertify') --}}
   @include('admin.common.toastr')
    
</body>
</html>
