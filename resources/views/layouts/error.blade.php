<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <title>
            {{ Config('app.name') }}
        </title>
        <noscript>
            <meta content="0;url={{ route('noscript') }}" http-equiv="refresh"/>
        </noscript>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>
        <!-- CSRF Token -->
        <meta content="{{ csrf_token() }}" name="csrf-token">
            <link href="{{ asset('assets/images/theagency.ico') }}" rel="icon" type="image/x-icon"/>
            <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.css') }}" />
             <link rel="stylesheet" type="text/css" href="{{ asset('front/css/theme/theme-main.css') }}" />
            <!-- jquery -->
            <script src="{{ asset('assets/js/bootstrap/jquery.js') }}" type="text/javascript">
            </script>
        </meta>
    </head>
    <body class="theme-color site-menubar-unfold" data-scrolling-animations="true">
        <div class="page">
            @yield('content')
        </div>
        <div class="page">
        </div>
    </body>
</html>