<div class="col-12 footer">
      <div class="row">
         @if(Route::currentRouteName() != "tmp_previewsurvey")
            @include('front.common.survey_trouble_text')
         @else
            <div class="col-md-6 d-flex">
            </div>
         @endif
         @if($survey['show_logo'] == 1)
         <div class="col-md-6 hidden-xs  d-flex justify-content-end">
            <span class="powered">Powered by</span>
            <a href="http://www.perceptionmapping.com/" target="_blank">
               <img src="{{ asset('front/images/logo.png') }}" width="200px;" alt="logo">
            </a>
         </div>
         @endif
      </div>
   </div>

   <!-- Modal -->
   @include('front.common.survey_trouble_modal')
   