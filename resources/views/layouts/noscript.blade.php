<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <title>
            {{ Config('app.name') }}
        </title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/perception-favicon.ico') }}" />
        <!-- CSRF Token -->
        <meta content="{{ csrf_token() }}" name="csrf-token" />
            
            <script type="text/javascript">
                window.location = '{{ url('/') }}';
            </script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.css') }}" />
         
    </head>
    <body class="theme-color site-menubar-unfold" data-scrolling-animations="true">
        <div class="page">
            @yield('content')
        </div>
    </body>
</html>
