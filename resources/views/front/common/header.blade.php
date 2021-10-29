 <nav class="navbar site-navbar h_header navbar-fixed-top d-flex justify-content-between">
         <div class="navbar-brand-logo w-p33">
            <a href="javascript:void(0)">
               {{-- <img src="{{ asset('front/images/artc-logo.png') }}" alt=""> --}}
               <img src="<?= $company_logo_new; ?>" alt="">
            </a>
         </div>
         <div class="d-flex justify-content-center  w-p33">
            <span class="welcome-text">
               {{-- Employment <span>Engagement Survey</span></span> --}}

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

         </div>
         
         <div class=" d-flex justify-content-end  w-p33">
            @if($survey['show_logo'] == 1)
               <a class="second-logo" href="http://www.perceptionmapping.com/" target="_blank">
                  <img src="{{ asset('front/images/logo.png') }}" alt="logo">
               </a>
            @endif
         </div>
        
      </nav>