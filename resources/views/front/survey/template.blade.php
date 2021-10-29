@extends('layouts.front-template')
@section('page_title', 'Perception Mapping | Employee Engagement Survey')
@section('content')


<div class=" page bg-blue themeBannerScreen">
         <div id="loader-Main" style="display:none;" >
               <div class="loader-center" >
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
               </div>
         </div>

      <div class="col-12 h-p100">
         <div class="row welcomeTheme h-100">
            <div class="col-lg-5 d-flex left-image  justify-content-center  wow fadeIn " data-wow-duration="4s">
               <div class="align-self-center ">
                 
                     <img src="{{ asset('front/images/image.png') }}" alt="Images">
                 
               </div>
            </div>
            <div class="col-lg-7 d-flex bannerpart justify-content-start position-xs-inherit wow fadeIn  "
               data-wow-duration="4s">
               <div class="align-self-center">
                  <div class="pr-5">
                     <div class="mb-4">
                        <img style="width:240px;  padding: 5px;" src="{{ asset('front/images/perception-mapping-logo.png') }}" alt="Images">
                     </div>
                     <h4 class="welcome-text">
                        Welcome to<span> Perception Mapping</span>
                     </h4>

                     @if($not_found_survey == 0)
                     <div class="small-text">
                        Welcome to the 2018 ARTC Employee Survey. The questions and statements should take less than 10
                        minutes to complete.
                     </div>
                     <div class="small-text">
                        PRIVACY: Your responses to the following questions are 100 percent anonymous. No individual
                        responses are made available to management. All data is privately held by Perception Mapping Pty
                        Ltd and is never shown to any third party.
                     </div>
                     <div class="small-text">
                        Please read the questions and statements carefully and complete your responses as quickly as
                        possible. If you are interrupted while completing the survey, please just minimise the window
                        and resume as soon as you are ready.
                     </div>
                     <div class="small-text">
                        Please contact Cassandra Carcary on <a class="textLink textlinkwhite" href="tel:0249419622">02
                           4941 9622</a> or <a class="textLink textlinkwhite" href="mailto:ccarcary@artc.com.au">ccarcary@artc.com.au</a> with any questions regarding
                        completing this survey.
                     </div>
                     <div class="small-text">
                        Thank you for your participation, your responses are valued!
                     </div>
                     @else
                        <div class="small-text">
                           Invalid survey URL.
                        </div>
                     @endif
                  </div>
               </div>
            </div>
            <div class="blank-div"></div>
         </div>

      </div>



   </div>


@endsection
