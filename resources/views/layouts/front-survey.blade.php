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

     {{-- @show --}}
  
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

   @if(Route::currentRouteName() != "tmp_previewsurveyform")
      @include('front.common.footer')
   @endif
   
   @section('scripts') 
   <script>
      
   </script>
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
    
    @if(Route::currentRouteName() != "tmp_previewsurvey")
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
   @endif
         <script>
            
      @if(Route::currentRouteName() == "previewsurvey")
         $url =  "{{ route('previewsurveyform',['id' => $survey['id'] ]) }}";
      @elseif(Route::currentRouteName() == "tmp_previewsurvey")
         $url =  "{{ route('tmp_previewsurveyform') }}";
      @else
         $url =  "{{ route('surveyform',['id' => $custom_url ]) }}";
      @endif




         $(document).on('click','.linkform',function(){
           var company_logo = $('.brand-logo img').attr('src');
           
            $.ajax({
                  url: $url,                  
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  method:'post',
                  async: false ,
                  data:{'company_logo':company_logo},
                  beforeSend: function() {
                     $('.loading_footer').css('display', 'flex');              
                  },
                  success:function(data)
                  {
                    

                     ajaxchnage = $('.themeBannerScreen');               
                     ajaxchnage.empty();
                     ajaxchnage.html(data);
                    
                     $('.loading_footer').hide();

                     @if(Route::currentRouteName() == "tmp_previewsurvey")
                        @if(Str::contains(\URL::previous(), 'edit') ) 
                              <?php $sid = explode("/" , \URL::previous());

                                    $survey_id = end($sid) ;

                              ?>
                              id = "{{ $survey_id  }}";
                              // setTimeout(function(){  call_delete_tmp_preview(id ,"edit"); }, 10000);
                        @else
                              // setTimeout(function(){  call_delete_tmp_preview(id ,"add"); }, 3000);
                        @endif
                     
                        
                     @endif

                        // put validation here 

                                             

                           /* ************************************************************************ */

                           @if(Route::currentRouteName() != "tmp_previewsurvey")
                              var tenMinutes = 60 * 10,
                              display = document.querySelector('#time');
                              startTimer(tenMinutes, display);
                              surveyTroubleForm();
                           @endif 
                              var form = $("#regiration_form").show();

                              var current = 1; //,current_step,next_step,steps;
                              function setProgressBar(curStep)
                              {
                                 var percent = parseFloat(100 / steps) * curStep;
                                 percent = percent.toFixed();
                                 $(".progress-bar").css("width",percent+"%");
                                 $(".progress-bar-percentage").html(percent+"%"+" Completed");       
                              }
   
                              form.steps({
                                          headerTag: "h3",
                                          bodyTag: "fieldset",
                                          transitionEffect: "slideLeft",
                                          onInit: function (event, current) {
                                             $('.actions > ul > li:first-child').attr('style', 'display:none');
                                             var allInputs = $(document.body).find(".mainQuestionClass");
                                             $(allInputs).each(function(){
                                                if($(this).css("display")=="none"){
                                                   var allInputsDiv =  $(document.body).find($(this)).find("input");                                                   
                                                   $( allInputsDiv ).each(function() {
                                                      $($(this)).removeClass('required');                                                            
                                                   });         
                                                   
                                                   var selectBox = $(document.body).find($(this)).find("select");                                                     
                                                   $(selectBox).removeClass('required');                           
                                                   
                                                   var textAreaBox = $(document.body).find($(this)).find("textarea");  
                                                   $(textAreaBox).removeClass('required');                          
                                                }
                                             });
                                             
                                          },
                                          onStepChanging: function (event, currentIndex, newIndex)
                                          {
                                             
                                             
                                                // Allways allow previous action even if the current form is not valid!
                                                if (currentIndex > newIndex)
                                                {
                                                   return true;
                                                }
                                                // Forbid next action on "Warning" step if the user is to young
                                                if (newIndex === 3 && Number($("#age-2").val()) < 18)
                                                {
                                                   return false;
                                                }
                                                // Needed in some cases if the user went back (clean up)
                                                if (currentIndex < newIndex)
                                                {
                                                   // To remove error styles
                                                   form.find(".body:eq(" + newIndex + ") label.error").remove();
                                                   form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                                                }
                                                form.validate().settings.ignore = ":disabled,:hidden";
                                                return form.valid();
                                          },
                                          onStepChanged: function (event, currentIndex, priorIndex)
                                          {
                                             if(currentIndex > 0)
                                             {
                                                $('.actions > ul > li:first-child').attr('style', 'display:block');
                                             }
                                             else
                                             {
                                                $('.actions > ul > li:first-child').attr('style', 'display:none');
                                             }

                                             steps = $("fieldset").length;
                                             if(currentIndex > priorIndex)
                                             {
                                                setProgressBar(++current);
                                             }
                                             else
                                             {
                                                setProgressBar(--current);
                                             }
                                                                                          
                                             // Used to skip the "Warning" step if the user is old enough.
                                             // if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
                                             // {
                                             //    form.steps("next");                                             
                                             // }
                                             // // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                                             // if (currentIndex === 2 && priorIndex === 3)
                                             // {
                                             //    form.steps("previous");
                                             // }
                                          },
                                          onFinishing: function (event, currentIndex)
                                          {
                                                form.validate().settings.ignore = ":disabled";
                                                return form.valid();
                                          },
                                          onFinished: function (event, currentIndex)
                                          {
                                             clearInterval(interval); 
                                                @if(Route::currentRouteName() != "tmp_previewsurvey")
                                                   $("#submit").trigger('click');
                                                   event.preventDefault();
                                                   form = $('#regiration_form');
                                                   formData = $(form).serialize();

                                                   $.ajax({
                                                      type: 'POST',
                                                      url: $(form).attr('action'),
                                                      data: formData,
                                                      success:function(data)
                                                      {
                                                         if( data == "0")
                                                         {
                                                            $('#thank_head').empty().html("Opps..."); 
                                                            $('#thankyou_description').empty().html("{{ env('MSG_SURVEY_MAX_INVITATION_REACHED') }}"); 
                                                            
                                                            $("#submitthanks").trigger('click');                                                          
                                                         }
                                                         $('#submit').remove();
                                                         return false;
                                                      },
                                                      error:function(){
                                                      }

                                                   });
                                                @else
                                                   $("#submitthanks").trigger('click');
                                                   
                                                @endif

                                                
                                          }
                              });

                              var container = $('div.container');

                              var errorlist = [];

                              $.validator.setDefaults({
                                
                                 // errorLabelContainer: container,
                                 errorPlacement: function(error, element) {
                                     return false;
                                 },
                                 focusInvalid: true,
                                 invalidHandler: function(event, validator) {
                                    container.hide();
                                    v = validator.errorList;
                                    errorstr = "Please answer mandatory questions.";

                                    // for(i=0;i<v.length;i++)
                                    // {
                                    //    errorstr += v[i].message+"<br/>";
                                    // }
                                    toastr.remove();
                                    toastr["error"](errorstr);
                                 },
                                 highlight: function(element, errorClass, validClass) 
                                 {
                                                                       
                                    if(element.type == "radio")
                                    {
                                       // $(element).next().addClass('bg-danger-required-before');
                                       $(element).closest('tr').find('input[type="radio"]').next().addClass('bg-danger-required-before');;
                                    }
                                    else if(element.type == "checkbox")
                                    {
                                       $(element).next().addClass('bg-danger-required-before');
                                       $(element).closest('tr').find('input[type="checkbox"]').next().addClass('bg-danger-required-before');;
                                    }
                                    else
                                       $(element).addClass("bg-danger-required");

                                   
                                 },
                                 unhighlight: function(element, errorClass, validClass) {
                                    if(element.type == "radio")
                                    {
                                       $(element).closest('tr').find('input[type="radio"]').next().removeClass('bg-danger-required-before');;
                                    }
                                    else if(element.type == "checkbox")
                                    {
                                       $(element).closest('tr').find('input[type="checkbox"]').next().removeClass('bg-danger-required-before');;
                                    }
                                    else
                                       $(element).removeClass("bg-danger-required");
                                    
                                 }

                                 

                              });

                                                
                           /********************************************************************************/
                 
                  },
                  complete:function(){

                     
                    
                  },
                  error:function(data)
                  {
                              
                  }
            });

         });


         function call_delete_tmp_preview(id,str)
         {
            $.ajax({

                  url: "{{ route('tmp_delete') }}",

                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  method:'post',
                  data: { id : id , str : str },
                  beforeSend: function() {
                     $('.loading_footer').css('display', 'flex');              
                  },
                  success:function(data)
                  {
                     $('.loading_footer').hide();
                     setTimeout(function(){
                        $(document.body).find("input").blur(function(){     
                           
                        }).blur();


                        $(document.body).find("select").blur(function(){         
                           console.log('whte4ger');
                     }).blur();
                     $(document.body).find("checkbox").blur(function(){         
                           console.log('whte4ger');
                     }).blur();
                  }, 5000);
                  },
                  error:function(data)
                  {
                              
                  }
                  });
         }


         // $(document).on('click','#submit', function(event) {

         //    event.preventDefault();
         //    form = $('#regiration_form');
         //    formData = $(form).serialize();

         //    $.ajax({
         //          type: 'POST',
         //          url: $(form).attr('action'),
         //          data: formData,
         //          success:function(data)
         //          {
         //          $('#submit').remove();
         //          return false;
         //          },
         //          error:function(){

         //          }
         //       });

         //    // TODO
         // });


         $(document).on('submit','#regiration_form', function(event) {

            // event.preventDefault();
            // form = $('#regiration_form');
            // formData = $(form).serialize();

            // $.ajax({
            //       type: 'POST',
            //       url: $(form).attr('action'),
            //       data: formData,
            //       success:function(data)
            //       {
            //       $('#submit').remove();
            //       return false;
            //       },
            //       error:function(){

            //       }
            //    });

            // TODO
         });

</script>

 
      @if(session('success'))
         <script type="text/javascript">
            window.showAlert = function(){
                  alertify.set('notifier','position', alertify_position);
                  alertify.success( "{!!  session('successlogin')  !!}" );
            }
            window.showAlert();
         </script>
      @endif

        
        
    @show

   
   @section('jscode')

    @show

</body>
</html>