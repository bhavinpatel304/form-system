@extends('layouts.admin')
@section('page_title', 'Add Survey')
@section('styles')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker/datepicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/color-picker/colorpicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/drag-drop/dragula.min.css') }}">
@endsection
@section('content')
@include('admin.common.header')
<section class="home  create-theme ">
   <div class="page-content container-fluid wow fadeIn" data-wow-duration="1s">
      <?php $data=[
         'mainTitle' => "Surveys",
         'breadCrumbTitle' => "Surveys",
         'breadCrumbUrl'=> "surveylist",
         'breadCrumbSubTitle' => "Create Survey",
         'breadCrumbSubUrl'=> "addsurvey"
         ]  ?>
      @include('admin.common.breadcrumb', $data)   
      <div class="row mb-2">
         <div class="col-12 create-survey">
            <form role="form" class="custom_form toggle-disabled" action="{{ route('addsurvey') }}" id="addsurvey" novalidate enctype="multipart/form-data" method="POST" autocomplete="off">
               @csrf
               <input type="hidden" name="questionData" id="questionData" value="" data-validation="required" />
            {{-- <input type="hidden" name="randomStr" id="randomStr" value="{{ $randomStr }}" /> --}}
            <input type="hidden" name="isWelcomeComeExists"  id="isWelcomeComeExists" value="0" />
               <div class="card ">
                  <div class="header b-b">
                     <div class="row">
                        <div class="page_title tHeading col-sm-4 d-flex  ">
                           <h2 class="align-self-center">Create New Survey</h2>
                        </div>
                        <div class="header-dropdown col-sm-8">
                           <a href="{{ route('surveylist') }}" class="btn btn-s-sm btn-br-success waves-effect waves-light"
                              id=""><i class="fa fa-chevron-left mr-2"></i>Back</a>
                        </div>
                     </div>
                  </div>
                  <div class="tabs">
                     @include('admin.surveys.TabsAdd')                     
                  </div>
                  <div class="tab-content" id="myTabContent">
                     @include('admin.surveys.primaryTabAdd')  
                     @include('admin.surveys.welcomeTabAdd')                       
                     @include('admin.surveys.pageTabAdd')                     
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="fix-footer fixe-bottom">
      <a href="javascript:void(0)" class="btn btn-secondary    btn-s-md   waves-effect waves-light buttonPrevious" id="btnTabPrv">Previous</a>
      <a href="javascript:void(0)" class="btn btn-br-success  btn-s-md   waves-effect waves-dark buttonNext" id="btnTabnext">Next </a>
   </div>
</section>
@include('admin.common.footer')      
@endsection
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
@section('scripts')
@parent
<script>
   var urlOrder = '{{ route("reorderQuestions") }}';
</script>
<script src="{{ asset('js/datepicker/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('tinymce-editor/tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/tinymce/tinymce.custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/color-picker/colorpicker.js') }}"></script>
<script src="{{ asset('js/drag-drop/dragula.min.js') }}"></script>
<script src="{{ asset('js/drag-drop/draggable.min.js') }}"></script>
@endsection

@section('jscode')
 @include('admin.surveys.questionPopup') 
 @include('admin.surveys.questionPopupEdit') 
 @include('admin.surveys.questionLibraryPopup') 
 @include('admin.surveys.addQuestionToLibraryPopup') 
 @include('admin.surveys.addSkipLogicPopup') 
@include('admin.surveys.scripts')  
<script>
   $('.file-upload-content').show();
   $('.image-upload-wrap').hide();
   jQuery(document).ready(function() {
      
      $("#comp_id").change(function() {
         var comp_id = $(this).val();

         $.ajax({
                  url: "{{ route('searchcompanyforsurvey') }}",
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  data: {
                     comp_id: comp_id,
                     
                  },
                  method: 'post',
                  beforeSend: function() {
                     
                      $('.loading_footer').css('display', 'flex');               
                  },
                  success: function(data) {
                     var data = jQuery.parseJSON(data);
                     if(data.status == '1'){
                           $('#survey_company_logo_img').attr('src', data.clientImage);
                           $('#survey_company_logo_dummy').val( data.clientImage);
                           $("#survey_company_logo").val(null);
                        
                     }
                     $('.loading_footer').hide();
                  
                     
                  },
                  error: function(data) {
                     
                  }
                  
            
            });
      });
   });

window.onload = function ()
{
   $("#btnpreview").show();
};
</script>
@endsection