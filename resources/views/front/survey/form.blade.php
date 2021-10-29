@extends('layouts.front-survey')
@section('page_title', 'Perception Mapping | Employee Engagement Survey')
@section('content')
@include('front.common.header')

<div class="page second-theme  themeBannerScreen">

   
   <div class="padder">
         <div class="col-12 h-p100">
            <div class="row">
               <div class="card survey_form position-xs-inherit wow fadeIn" data-wow-duration="4s">

              <div class="progress_custom">
                     <div class="d-flex justify-content-between progress_per">
                        <div class="progress-bar-percentage"></div>
                        <div><img src="assets/images/time-left.svg" class="mr-2" width="18px" height="auto" alt="">6
                           mins</div>
                     </div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                           aria-valuemax="100"></div>
                     </div>
                  </div>

                  <div class="bg-btn-bottom"></div>

              

               </div>

            </div>
            <div class="blank-div"></div>
         </div>
      </div>
   </div>


@endsection