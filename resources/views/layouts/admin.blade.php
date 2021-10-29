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

    <title> @if (trim($__env->yieldContent('page_title'))) @yield('page_title') | @endif {{ config('app.name', 'Perception Mapping') }} | Admin Panel</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/perception-favicon.ico') }}" />

    <!--css  start-->
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/theme-main.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.css') }}" /> 
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/theme-icon.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/waves.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/css/themes/default.min.css"/>
        
    @show
    <link rel="stylesheet" type="text/css" href="{{ asset('css/developer.css') }}" />
    <!--css End-->
     <script>
        var base_url = "{!! url('/') !!}";
        // var currentRouteNameForAllPages = '{{ Route::currentRouteName() }}';
    </script>
    
</head>

<body data-scrolling-animations="true" class="theme-color site-menubar-unfold">
   
        <div class="loading_footer text-center" style="display:none">
               <div class="progress">
                  <div class="indeterminate"></div>
               </div>
            </div>
            <div id="loader-Main" style="display:none;" >
               <div class="loader-center" >
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
               </div>
         </div>
    @yield('content')

<!-- Change Password modal popup Start -->    
@include('admin.modals.change_password_modal')
<!-- Change Password modal popup End -->    

<!-- Profile modal popup Start -->
@include('admin.modals.profile_modal')
<!-- Profile modal popup End-->

<!-- Users modal popup Start -->
@include('admin.modals.user_modal')
<!-- Users modal popup End--> 
    @section('scripts')
        <script src="{{ asset('js/bootstrap/jquery.js') }}" type="text/javascript"></script>
        @if (Route::currentRouteName() == 'editsurvey' || Route::currentRouteName() == 'addsurvey')             
            <script src="{{ asset('js/bootstrap/jquery-ui.js') }}" type="text/javascript"></script>
        @endif
        <script src="{{ asset('js/bootstrap/popper.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap/tooltip.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('js/theme/waves.js') }}" type="text/javascript"></script>  
        <script src="{{ asset('js/select2/select2.js') }}" type="text/javascript"></script>        
        {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script> --}}

        

       
        <script src="{{ asset('js/validator/jquery.form-validator.min.js') }}" type="text/javascript"></script>
        {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script> --}}

        <script src="{{ asset('js/validator/date.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/validator/security.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/validator/file.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/validator/logic.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/validator/sanitize.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/validator/sweden.js') }}" type="text/javascript"></script>


        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.3/build/alertify.min.js"></script> 
        
        
        <script src="{{ asset('js/bootstrap/jquery.numeric.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('js/toastr.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/theme/theme.min.js') }}" type="text/javascript"></script> 

        <script src="{{ asset('js/bootstrap/jquery.blockUI.min.js') }}" type="text/javascript"></script>

       
        
        @include('admin.common.alertify')
        @include('admin.common.toastr')

       
        
    @show
 
        @include('admin.modals.scripts')
       
         
    @section('jscode')
       
    @show

    @section('blockUI')
     <script>       
            $(document).ajaxStart(function() {
                $.blockUI({       
                    baseZ: 2000,                   
                    //  message: $('#loader-Main').html(),                   
                    // message: '<img src="{{ asset('images/lg.dual-ring-loader.gif') }}" alt="*" />',
                    message: null,                   
                    css: {
                        border:     'none',
                        backgroundColor:'transparent'
                    }
                })
            }).ajaxStop($.unblockUI);
        </script>
       
    @show

    
</body>
</html>