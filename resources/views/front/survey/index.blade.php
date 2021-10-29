@extends('layouts.front-survey')
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


                  @if (!empty($survey['welcome_image']) && file_exists(public_path().$welcome_img_path . $survey['welcome_image']))
                     <img src="{{ url($welcome_img_path . $survey['welcome_image']) }}" alt="{{ $survey['survey_name'] }}">
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
                        
                   
                  @if (!empty($survey['survey_company_logo']) && file_exists($survey_company_thumb_path . $survey['survey_company_logo']))
                        <?php  $imageUrl = url($survey_company_imgUrl) . '/' . $survey['survey_company_logo']; ?>                   
                        <img src="<?= $imageUrl; ?>" alt="{{ $survey['survey_name'] }}">
                  @elseif (!empty($survey['company_logo']) && file_exists($company_thumb_path . $survey['company_logo']))
                     <?php  $imageUrl = url($imgUrl) . '/' . $survey['company_logo']; ?>  
                     <img src="<?= url($imageUrl); ?>" id="survey_company_logo_img" alt="company_logo" />
                  
                  @else
                  
                     <img src="<?= $default_company_img; ?>" id="survey_company_logo_img" alt="company_logo" />
                  @endif
                                 


                               


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
                     <?php 
                     $surveyShown = false;
                     ?>
                     @if($survey['status'] == 2)
                        Survey is not active.
                     @else
                           @if($clients_check->status == 2 )
                              
                                 <div class="small-text">
                                    Survey related to this organization is no longer active.
                                 </div>
                           @else
                           
                           
                                    <?php
                                          $start_date = $survey['start_date'];
                                          $end_date = $survey['end_date'];
                                          $today =\Carbon\Carbon::today()->format('Y-m-d');

                                          if (($today >= $start_date) && ($today <= $end_date)){
                                                if($max_invitations != $total_submitted_surveys){
                                                   $surveyShown = true;
                                       
                                    ?>

                                       {!! $survey['welcome_description']  !!}

                                       <div class="mt-5 sec-fix-xs">
                                          <a class="btn btn-br-success  btn-round btn-lg  waves-effect waves-light linkform"
                                             href="javascript:void(0)">Start Survey</a>
                                       </div>
                                       
                                    <?php } } 
                                       elseif($today > $end_date)
                                       {
                                          ?>
                                          
                                                Survey is exipred on <?php echo \Carbon\Carbon::parse($end_date)->format('d-m-Y') ?>.
                                          <?php
                                       }
                                       elseif($today < $start_date)
                                       {
                                          ?>
                                          
                                                Survey will start on <?php echo \Carbon\Carbon::parse($start_date)->format('d-m-Y') ?>.
                                          <?php
                                       } else
                                       {
                                          echo '';
                                       }
                                    ?>
                                    
                                          <?php 
                                          if($max_invitations != 0){
                                             if($max_invitations === $total_submitted_surveys){
                                             
                                                   echo env('MSG_SURVEY_MAX_INVITATION_REACHED');
                                             }
                                          }else {
                                             if(!$surveyShown){
                                          ?>
                                           {!! $survey['welcome_description']  !!}

                                       <div class="mt-5 sec-fix-xs">
                                          <a class="btn btn-br-success  btn-round btn-lg  waves-effect waves-light linkform"
                                             href="javascript:void(0)">Start Survey</a>
                                       </div>
                                          <?php 
                                             }
                                          }
                                          ?>
                           @endif
                  @endif
                  </div>
               </div>
            </div>
            <div class="blank-div"></div>
         </div>

      </div>



   </div>


@endsection
