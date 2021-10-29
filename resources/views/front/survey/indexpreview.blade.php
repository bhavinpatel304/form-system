@extends('layouts.front-survey')
@section('page_title', 'Perception Mapping | Employee Engagement Survey')
@section('content')

<div class=" page bg-blue themeBannerScreen">


      <div class="col-12 h-p100">
         <div class="row welcomeTheme h-100">
            <div class="col-lg-5 d-flex left-image  justify-content-center  wow fadeIn " data-wow-duration="4s">
               <div class="align-self-center ">

               

                   @if (!empty($survey['welcome_image_dummy']))
                   
                   <img src="{{ $survey['welcome_image_dummy'] }}" alt="{{ $survey['survey_name'] }}" />


               @else
               <img src="{{ asset('front/images/image.png') }}" alt="Images">
                @endif



               </div>
            </div>
            <div class="col-lg-7 d-flex bannerpart justify-content-start position-xs-inherit wow fadeIn  "
               data-wow-duration="4s">
               <div class="align-self-center">
                  <div class="pr-5">
                     <div class="brand-logo">

                           <img src="{{ $survey['survey_company_logo_dummy'] }}" alt="{{ $survey['survey_name'] }}" class="">
                                 {{-- @if (!empty($survey['survey_company_logo']) && file_exists(public_path().$survey_company_thumb_path . $survey['survey_company_logo']))
                                    
                                    <img src="{{url($survey['survey_company_logo']) }}" alt="{{ $survey['survey_name'] }}">
                                 @elseif(empty($survey['survey_company_logo'] ) && $company_logo_only != "")
                                
                                       <img src="{{ url("uploads/clients/original/".$company_logo_only) }}" alt="{{ $survey['survey_name'] }}">
                                @else
                               
                                 <img src="{{ url('/images/' . env('DEFAULT_COMPANY_IMAGE','')) }}" id="liveimage" alt="survey_name" data-toggle="tooltip" title="{{ $survey['survey_name'] }}" data-placement="bottom" />
                                 @endif --}}


                     </div>

                   
                     <h4 class="welcome-text">
                           <?php

                              $head = explode(" ",$survey['survey_name']);

                              echo $head[0];

                           ?>
                        <span>

                           <?php
                              unset($head[0]);
                              echo implode(" ",$head);
                           ?>



                           </span>
                     </h4>
                     {!! $survey['welcome_description']  !!}
                     <div class="mt-5 sec-fix-xs">
                           <a class="btn btn-br-success  btn-round btn-lg  waves-effect waves-light linkform"
                              href="javascript:void(0)">Start Survey</a>
                        </div>

                     
                  </div>
               </div>
            </div>
            <div class="blank-div"></div>
         </div>

      </div>



   </div>



@endsection
