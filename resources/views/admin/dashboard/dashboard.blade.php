

@extends('layouts.admin')
@section('page_title', 'Dashboard')
@section('content')
@include('admin.common.header')
<div class="home">
    <div class="page-content container-fluid  dashboard-theme wow fadeIn " data-wow-duration="4s">
        <?php
        $data = [
            'mainTitle' => "Dashboard",
            'breadCrumbTitle' => "Dashboard",
            'breadCrumbUrl' => "dashboard",
            'isDashboardPage' => true,
                ]
        ?>

        @include('admin.common.breadcrumb', $data)
        <div class="row mb-2">
            <div class="col-12 P-10">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="page_title tHeading col-sm-4 d-flex  ">
                                <h2 class="align-self-center">Summary</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 summary-main">
                <div class="row ">
                    <div class="col-xl-3 col-sm-6 col-xs-12 P-10">
                        <div class="card summary-card">
                            <div class="card-body text-center">
                                <h1 class="count active-survey-text">{{ $intActiveSurvey }}</h1>
                                <span class="summery-text ">Active surveys</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-12 P-10">
                        <div class="card summary-card">
                            <div class="card-body text-center">
                                <h1 class="count invited-text">{{ $intInvited }}</h1>
                                <span class="summery-text">Invited</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-12 P-10">
                        <div class="card summary-card">
                            <div class="card-body text-center">
                                <h1 class="count respond-text">{{ $intResponed }}</h1>
                                <span class="summery-text">Respondents</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-12 P-10">
                        <div class="card summary-card">
                            <div class="card-body text-center">
                                <h1 class="percent-count  count percent-count-text">{{ $intAverageParticipation }}%</h1>
                                <span class="summery-text">Average Participation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 P-10">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="page_title tHeading col-sm-4 d-flex  ">
                                <h2 class="align-self-center">Recent Surveys</h2>
                            </div>
                            <div class="header-dropdown col-sm-8 ">
                                {{-- <div class="theme-search">
                                    <input type="search" id="survey_name_val" value="" name="survey_name_val" placeholder="Search Survey">
                                    <a href="javascript:void(0)"  class="search_icon" id="search_survey">
                                        <img src="{{ asset('images/search.svg') }}" width="20" height="25" alt="icon">
                                     </a>
                                 </div> --}}
                                   <input type="hidden" name="statusVal" id="statusVal" value="1" />
                        <input type="hidden" name="dataEnds" id="dataEnds" value="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row surveyData">
                    @include ('admin.surveys.search')
                    

                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.common.footer')
@endsection
@section('jscode')
@include('admin.surveys.surveyLinkModal')
<script type="text/javascript">
function animateCouhter(){
    jQuery('.count').each(function () {
    var $this = $(this);
    jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 3000,
    easing: 'swing',
    step: function () {
        
        if($this.hasClass('percent-count')){
            var n = this.Counter.toFixed(2).replace(/[.,]00$/, "");
            if(n == '99.99'){
                n = '100';
            }
            $this.text(n + '%');
        }else {
            $this.text(Math.ceil(this.Counter));
        }
    
    }
    });
    });

}
    
animateCouhter()

    $('body').on('click', '.clearBtn', function (){
         $('body').find('.searchBtns').removeClass('active');
   });
    $(document.body).on("click",".showLink",function(){
      var surveyId = $(this).data('id');
      var url = '{{ route("getSurveyLink") }}';


        $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },

                     method: 'post',
                      data: {
                        surveyId: surveyId,
                    },
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        var data = $.parseJSON(data);
                        $('.loading_footer').hide();
                        var surveyLink = "{{ url('/') }}" + '/' + data.surveyUrl;
                        //var surveyLink = '{{ URL::asset('+ data.surveyUrl +') }}';
                        $("#surveyLinkModal .modal-body .surveyLinkLabel").html(surveyLink);
                        $("#surveyLinkModal .modal-body .surveyLink").val(surveyLink);
                        $('#surveyLinkModal').modal('show');
                     },error: function(data) {
                                    $("#surveyLinkModal .modal-body").html('<div class="col-12 tab-content"><div class="alert alert-info tab-content text-center"><strong>There is some problem loading data!</strong></div></div>');
                              $("#surveyLinkModal .modal-footer").hide();
                              $('#surveyLinkModal').modal('show');
                     }
        });

    });



   $('button.copyButton').click(function(){
       
      $(this).siblings('input.linkToCopy').select();
      document.execCommand("copy");

      var $this = $(this);                    
      $this.html('Copied');          
      
      setTimeout(function(){                
            $this.html('Copy Link');
      }, 1000);

   });
   $("#surveyLinkModal").on("hidden.bs.modal", function(e) {
      $('#surveyLinkModal .modal-body button.copyButton').html('Copy link');
   });

   $('body').on('click', '.removeMe', function (){
         event.preventDefault();
          var $this = $(this);
          
         alertify.prompt( 'Are you sure to delete this survey ?', 'Type <b>DELETE</b> to Confirm.', ''
               , function(evt, value) { 
                  //alertify.success('You entered: ' + value) 
                  if(value == 'DELETE'){
                     var id = $($this).data('id');
                     var url = '{{ route("deletesurvey") }}';
                     
                     $.ajax({
                        type: "POST",
                        url: url,                 
                        data: { 
                           'id': id, 						
                        },
                        beforeSend: function() {
                              $('.loading_footer').css('display', 'flex');
                           },
                        success: function(data)
                        {
                           toastr.remove();
                           $('.loading_footer').hide();
                              var data = $.parseJSON(data);
                              
                              if(data.status == 0){
                              
                                 toastr["error"]("Problem deleting survey.");
                              }else if(data.status == 2){
                                 toastr["error"]("Sorry!!! This survey is already submitted and can not be deleted.");
                                 
                              } else {                 
                                 toastr["success"]("Survey Deleted Successfully.");
                                resetAll();
                                $(".active-survey-text").text(data.dashboardData.intActiveSurvey);
                                $(".invited-text").text(data.dashboardData.intInvited);
                                $(".respond-text").text(data.dashboardData.intResponed);
                                $(".percent-count-text").text(data.dashboardData.intAverageParticipation);
                                animateCouhter();
                                 
                                 
                              }
                            
                              
                              
                        }
                     });
                  }else{
                     if(value.trim() == ''){
                        toastr["error"]("Please Enter text to delete survey.");
                     }else {
                        toastr["error"]("You have entered an invalid text. Please Try Again.");
                     }
                  }
               }
               , function() {
                 //  alertify.error('Cancel') 
            });



         

      }); 
    var offset = 0;
    </script>
    @if (count($surveys) > 0)
    <script>
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {


                var statusVal  = $('#statusVal').val();

                if(statusVal == ''){
                    $("#survey_name_val").val('');
                    var survey_name = '';
                }else {
                var survey_name =  $("#survey_name_val").val();
                }
                offset = offset + 1;


                getSurveyData(survey_name,statusVal,offset,true);


        }
        });
    </script>
    @endif

    <script>
     $('body').on('click', '.copyMe', function (){
      
      event.preventDefault();
            var $this = $(this);
            var id = $($this).data('id');
            var url = '{{ route("copysurvey") }}';

             $.ajax({
                    type: "POST",
                  url: url,                 
                  data: { 
                     'id': id, 						
                  },
                  beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                        toastr.remove();
                       $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        
                        if(data.status == 0){
                        
                            toastr["error"]("Problem copying survey.");
                        } else {                 
                           toastr["success"]("Survey Copied Successfully.");
                           resetAll();
                           $(".active-survey-text").text(data.dashboardData.intActiveSurvey);
                           $(".invited-text").text(data.dashboardData.intInvited);
                           $(".respond-text").text(data.dashboardData.intResponed);
                           $(".percent-count-text").text(data.dashboardData.intAverageParticipation);
                           animateCouhter();
                           
                           
                        }
                        
                        
                    }
                }); 
   });
   
   
   
   function getSurveyData(survey_name,statusVal,offset,isAppend = false){
       
    
    $(".link").tooltip('hide');
    $(".showLink").tooltip('hide');
    $(".removeMe").tooltip('hide');
    $(".csvLink a").tooltip('hide');
    $(".copySurveyLink a").tooltip('hide');
    if($('#dataEnds').val() == ''){

       $.ajax({
             url: "{{ route('searchsurveysdashboard') }}",
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {
                survey_name: survey_name,
                status: statusVal,
                offset:offset,
             },
             method: 'post',
             beforeSend: function() {

                $('.loading_footer').css('display', 'flex');
             },
             success: function(data) {

                   $('.loading_footer').hide();
                if(isAppend){
                   var noResultsLength = $(data).closest('.no-data').length;
                   //var noResultsLength = $(data).find('.alert-info').length;
                   if (noResultsLength != 1) {
                      $('.surveyData').append(data);
                   }else {
                      $("#dataEnds").val('1');

                   }
                } else {
                   $('.surveyData').html(data);
                }

             },
             error: function(data) {

             }


       });
    }




   }
   $(".searchBtns").click(function(){

    $('#statusVal').val($(this).data('status'))
    var statusVal  = $('#statusVal').val();
    $("#dataEnds").val('');

    if(statusVal == ''){
        $("#survey_name_val").val('');
       var survey_name = '';
    }else {
    var survey_name =  $("#survey_name_val").val();
    }
    offset = 0;
    isAppend = false;
    getSurveyData(survey_name,statusVal,offset,isAppend);
   });

   $('body').on('click', '#search_survey', function (){
     
        $("#dataEnds").val('');
        var survey_name =  $("#survey_name_val").val();
        var statusVal  = $('#statusVal').val();
        offset = 0;
        isAppend = false;

        getSurveyData(survey_name,statusVal,offset,isAppend);

   });
   $("#survey_name_val").keypress(function(e){
    var key = e.which;
    if(key == 13)  // the enter key code
    {
          $("#dataEnds").val('');
          var survey_name =  $(this).val();
          var statusVal  = $('#statusVal').val();
          offset = 0;
          isAppend = false;

          getSurveyData(survey_name,statusVal,offset,isAppend);
    }

   });
   window.onbeforeunload = function () {
      window.scrollTo(0, 0);
   }

   function resetAll(){
      // $('body').find('.searchBtnActive').addClass('active');
      // $('body').find('.searchBtnInActive').removeClass('active');
      $("#dataEnds").val('');
    //  $("#survey_name_val").val('');
      // $("#statusVal").val(1);
      var survey_name =  $("#survey_name_val").val();
      var statusVal  = $('#statusVal').val();
      offset = 0;
      isAppend = false;
      getSurveyData(survey_name,statusVal,offset,isAppend);
   }

</script>
@endsection

