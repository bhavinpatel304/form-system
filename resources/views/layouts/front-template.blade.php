<!DOCTYPE html>
<html>

<head>

   <noscript>
        <meta content="0;url={{ route('noscript') }}" http-equiv="refresh"/>
    </noscript>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


   <meta charset="utf-8" />

    <title> @if (trim($__env->yieldContent('page_title'))) @yield('page_title') | @endif {{ config('app.name', 'Perception Mapping') }} | Employee Engagement Survey</title>

   <meta name="description"
      content="Description on how a management consultant can generate extra reveune by offering Perception Maps to their product list.">
   <meta name="keywords" content="survey, management consultant, case studies, business, leadership">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <link rel="icon" type="image/x-icon" href="{{ asset('images/perception-favicon.ico') }}" />
   <!--css  start-->
  

   <!--css  start-->
    @section('styles')
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap/bootstrap.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/theme/theme-main.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/theme/theme-animate.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/theme/theme-icon.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/theme/waves.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/developer.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.css') }}" /> 
      <script src="{{ asset('front/js/bootstrap/jquery.js') }}" type="text/javascript"></script>
        
    @show

    <!--css End-->
      <script>
        var base_url = "{!! url('/') !!}";
      </script>
   <!--css End-->
</head>

<body data-scrolling-animations="true" class="theme-color">
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

<div class="col-12 footer">
      <div class="row">
        
            <div class="col-md-6 d-flex">
    <a href="javascript:void(0)" data-toggle="modal" data-target="#survey" class="copy-right-login textLink textlinkwhite">
        <i class="fa fa-question-circle mr-2 f-20"></i>Having trouble with survey?</a>
</div>
        
        
         <div class="col-md-6 hidden-xs  d-flex justify-content-end">
            <span class="powered">Powered by</span>
            <a href="http://www.perceptionmapping.com/" target="_blank">
               <img src="{{ asset('front/images/logo.png') }}" width="200px;" alt="logo">
            </a>
         </div>
       
      </div>
   </div>

   <!-- Modal -->
   @include('front.common.survey_trouble_modal')
   
   @section('scripts') 

   <script src="{{ asset('front/js/bootstrap/popper.js') }}" type="text/javascript"></script>
   <script src="{{ asset('front/js/bootstrap/bootstrap.js') }}" type="text/javascript"></script>

   <script src="{{ asset('js/validator/jquery.form-validator.min.js') }}" type="text/javascript"></script>

   <script src="{{ asset('front/js/steps/jquery.validation.min.js') }}"></script>

   <script src="{{ asset('front/js/steps/jquery.steps.min.js') }}" type="text/javascript"></script>
   

   <script src="{{ asset('front/js/theme/theme-wow.js') }}" type="text/javascript"></script>
   <script src="{{ asset('front/js/theme/waves.js') }}" type="text/javascript"></script>
   <script src="{{ asset('front/js/theme/theme.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/toastr.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/select2/select2.js') }}" type="text/javascript"></script>    
   <script src="{{ asset('js/bootstrap/jquery.blockUI.min.js') }}" type="text/javascript"></script>
         <script>       
            $(document).ajaxStart(function() {
               
                $.blockUI({       
                    baseZ: 2000,
                    // message: '<img src="{{ asset('images/lg.dual-ring-loader.gif') }}" alt="*" />',
                   // message: $('#loader-Main'),
                   message: null,
                  // message: $('#loader-Main').html(),
                    css: {
                        border:     'none',
                        backgroundColor:'transparent'
                    }
                })
            }).ajaxStop($.unblockUI);
        </script> 
    @include('admin.common.toastr')

   <script>
      surveyTroubleForm();
      function surveyTroubleForm(){
          
 
         $.validate({
            form:'#survey-trouble',
            validateOnBlur: true,
         });
         $('#survey').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
         });


         
            $('#survey').on('shown.bs.modal', function () {
            url =  "<?= $survey['url']; ?>";
               $('#survey .modal-body #survey-number') .val(url);
               $('#survey .modal-body #name') .val('');
               $('#survey .modal-body #email') .val('');
               $('#survey .modal-body #issue') .val('');
            });
         

         $("#survey-trouble").submit(function(e){ // click add on modal
               e.preventDefault(); 
               var $this = $(this);

               var survey_number = $("#survey .modal-body #survey-number") .val();
               var name = $("#survey .modal-body #name") .val();
               var email = $("#survey .modal-body #email") .val();
               var issue = $("#survey .modal-body #issue") .val();

               var data =  {
                        survey_number: survey_number,
                        name: name,
                        email: email,
                        issue:issue,
                     };
               var url = '{{ route("surveyTroubleForm") }}';

               $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: data,
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        toastr["success"]('Thank you for your enquiry. <br /> We will get back to you soon.');
                        $("#survey .close").click();                         
                        $('.loading_footer').hide();
                     },error: function(data) {
                       
                     }
               });
              
         });

      }
      
   </script>

  

        
        
    @show

   
   @section('jscode')

    @show

</body>
</html>