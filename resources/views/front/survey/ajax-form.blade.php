

@include('front.common.header')

<div class="padder">


      <div class="col-12 h-p100">
         <div class="row">
            <div class="card survey_form position-xs-inherit wow fadeIn" data-wow-duration="4s">


                  
                  <form id="regiration_form" class="toggle-disabled"  action="{{ route('surveyformsave') }}" name="regiration_form" method="post">
                 
                       
                     

                  @for($i=0;$i<count($pages);$i++)

                
                 
                  <?php $survey_head = $survey_heading[$i];  ?>


                  <h3 class="d-none">{{ $i }}</h3>
                  <fieldset>
                     @if($i==0)
                        {{ csrf_field() }}
                        @php $randomStr = (string) Str::uuid(); @endphp
                        <input type="hidden" name="url_unique" value="{{ $randomStr }}" />
                        <input type="hidden" name="survey_id" value="{{ $survey['id'] }}" />
                        <input name="url" type="hidden" value="{{ $custom_url }}" />
                        <input name="user_id" type="hidden" value="{{ $survey['user_id'] }}" />
                        <input name="company_id" type="hidden" value="{{ $survey['comp_id'] }}" />
                     @endif

                        

                     @if( $survey_heading[$i]->show_heading == 1)
                        <div class="card-heading br-redius mb-3  @if($survey_head->heading_bg_color=="") bg-primary @endif "
                              style="background-color:{{ $survey_head->heading_bg_color }}!important;"
                             >
                           <h4 class="text-heading @if($survey_head->is_heading_bold == "1") bold  @endif 
                              @if($survey_head->is_heading_italic == 1) italic  @endif
                               @if($survey_head->is_heading_underline == 1) underline  @endif " 
                               style="color:{{ $survey_head->heading_fg_color }}!important;" >
                              {{  $survey_heading[$i]->survey_heading }}</h4>
                        </div>
                     @endif
                        
                     
                     @if( $survey_heading[$i]->show_subheading == 1)
                        <div class="card-heading @if($survey_head->sub_heading_bg_color=="") bg-success @endif "
                              style="background-color:{{ $survey_head->sub_heading_bg_color }}!important;"
                              >
                           <h4 class="text-heading 
                              @if($survey_head->is_subheading_bold == 1) bold  @endif 
                              @if($survey_head->is_subheading_italic == 1) italic  @endif 
                              @if($survey_head->is_subheading_underline == 1) underline  @endif"  

                           style="color:{{ $survey_head->sub_heading_fg_color }}!important;"
                           >{{ $survey_heading[$i]->survey_sub_heading }}</h4>
                        </div>
                     @endif

                     
                     <div class="border-top"></div>
                     <div class="form-body">
                        <div class="table-wrap">
                           <table class="display table  table-striped" cellspacing="1" cellpadding="2"
                              style="width:100%">
                              <tbody>

                                  
                                  
                              @foreach($survey_questions as $sq)
                              {{-- @php dd($sq); @endphp --}}
                                 {{-- @if(Route::currentRouteName() == "surveyform")
                                   
                                 @endif --}}
                                 @if(Route::currentRouteName() != "surveyform")
                                    <?php $sq['survey_blocks']->survey_question_type = $sq['survey_blocks']->question_type ?>
                                    <?php $sq['survey_blocks']->survey_question = $sq['survey_blocks']->question ?>  
                                 @endif
                                 <input name="survey_block_id[{{$sq['survey_blocks']->id}}]" type="hidden" value="{{ $sq['survey_blocks']->id }}" />
                                 <input name="question_type[{{$sq['survey_blocks']->id}}]" type="hidden" 
                                 value="{{ $sq['survey_blocks']->survey_question_type  }}" />

                                 <?php 
                                    $is_skip_logic_avail = $sq['survey_blocks']->is_skip_logic_avail;                                 $displayNoneStyle = '';
                                    if($is_skip_logic_avail){
                                       $displayNoneStyle = 'style="display: none"';
                                    }
                                    $surveyQuestionType = $sq['survey_blocks']->survey_question_type;
                                 ?>

                                    @if( $pages[$i] == $sq['survey_blocks']->page_number  )  

                                    
                                          <?php                                    
                                             $q = json_decode($sq['survey_blocks']->survey_question);                                            
                                          ?>
                                    
                                          <tr role="row" class="odd mainQuestionClass"  <?= $displayNoneStyle; ?> data-id="<?= $sq['survey_blocks']->id; ?>" data-questiontype="<?= $surveyQuestionType; ?>">

                                             @if($sq['survey_blocks']->survey_question_type !=
                                                   (new \App\Http\Helpers\Common)::$intMatrix)
                                                   <td width="50%">
                                                         {{ $q->question }}
                                                         @if($sq['survey_blocks']->is_required)
                                                            <span class="text-danger">*</span>
                                                         @endif
                                                   </td>
                                                   <td width="50%">
                                                @else
                                                   <td width="100%" colspan="2">
                                                @endif

                                                           {{-- For poll and radio button --}}


                                                          @php $chbx = 0; @endphp

                                                          

                                                         @if(!empty($sq['survey_radio_options']) )                                                       
                                                            @if( $sq['survey_blocks']->survey_question_type ==
                                                                   (new \App\Http\Helpers\Common)::$intPoll 
                                                                   &&
                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                               )

                                                              @php $iro = 0; $chbxRadioButton  = 0; @endphp

                                                              
                                                               
                                                               {{-- @php /* code here for poll and put comp_id*/ @endphp --}}
                                                               @foreach($sq['survey_radio_options'] as $option)

                                                               <div class="md-radio">
                                                                      
                                                                  <input type="radio" value="{{ $option->id }}" id="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option->point_option.$iro }}"
                                                                  
                                                                  

                                                                  @if($sq['survey_blocks']->is_required) class="required questionSkipLogic"  data-msg-required="{{ Lang::get('messages.ajaxformradio')  }}" @else class="questionSkipLogic" @endif
                                                                 
                                                                  name="ans[{{ $sq['survey_blocks']->id  }}][]" 
                                                                 
                                                                  
                                                                  >
                                                                        <label class="pr-2" for="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option->point_option.$iro }}">{{ $option->point_option }}</label>
                                                               </div>

                                                               @php  $iro++; @endphp
                                                               @endforeach


                                                            @endif
                                                         @endif

                                                        
                                                          {{--  End For poll and radio button --}}


                                                          @if( $sq['survey_blocks']->survey_question_type ==
                                                                   (new \App\Http\Helpers\Common)::$intRadioButtonList
                                                               )
            
                                                                  <?php  
                                                                  
                                                                  $matarr = json_decode($sq['survey_blocks']->survey_question);
                                                            
                                                                  $question_points = $matarr->question_points;
                                                                  
                                                                  $points =  $q->question_points;

                                                                  if(!is_array($points))
                                                                  {
                                                                     $points = array($points);
                                                                  }
                                                                  
                                                                     //$i++;
                                                                  ?>
                                                                  <?php $chbxRadioButton = $j = 0; ?>
                                                                  @foreach($points as $option)

                                                                  <div class="md-radio">
                                                                        <input type="radio" value="{{ $option }}" id="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option.$j }}"
                                                                        <?php if($sq['survey_blocks']->is_required && $chbxRadioButton == 0) { ?> class="required questionSkipLogic"  data-msg-required="{{ Lang::get('messages.ajaxformradio')}}" <?php $chbxRadioButton = 1; } else { ?> class="questionSkipLogic" <?php } ?>
                                                                        name="ans[{{ $sq['survey_blocks']->id  }}][]" 
                                                                       
                                                                        
                                                                        >
                                                                              <label class="pr-2" for="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option.$j }}">{{ $option }}</label>
                                                                           </div>

                                                                           @php $j++ @endphp
                                                                  @endforeach                                                             
                                                            @endif


                                                            {{--  For chekbox  --}}

                                                            @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                                  [ (new \App\Http\Helpers\Common)::$intCheckboxList 
                                                                  ]) 
                                                                  &&
                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                                  
                                                                  )

                                                                  <?php  $points =  $q->question_points;

                                                                     if(!is_array($points))
                                                                     {
                                                                        $points = array($points);
                                                                     }
                                                                  
                                                                  ?>
                                                               <?php $chbx=0; ?> 
                                                               @foreach($points as $option)

                                                                  <div class="checkbox">
                                                                        <label class="pure-material-checkbox">
                                                                           <input type="checkbox" value="{{ $option }}" 
                                                                           @if($sq['survey_blocks']->is_required)
                                                                           <?php if($chbx==0) { ?> class="required questionSkipLogic" data-msg-required="{{ Lang::get('messages.ajaxformchkbox')}}" <?php $chbx = 1; }else { ?> class="questionSkipLogic" <?php } ?>
                                                                           @else 
                                                                           class="questionSkipLogic" 
                                                                     @endif
                                                                           
                                                                           name="ans[{{ $sq['survey_blocks']->id  }}][]"  >
                                                                           <span>{{ $option }}</span>
                                                                        </label>
                                                                     </div>
                                                            
                                                               @endforeach
                                                              
                                                            @endif

                                                             {{--  End checkbox --}}

                                                                     

                                                             {{--  For single checkbox --}}

                                                            @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                            [ 
                                                               (new \App\Http\Helpers\Common)::$intCheckbox
                                                            ]) 
                                                            

                                                            &&

                                                             $pages[$i] == $sq['survey_blocks']->page_number
                                                            
                                                            )

                                                            

                                                            <div class="checkbox">
                                                                  <label class="pure-material-checkbox">
                                                                     <input type="checkbox"  
                                                                     @if($sq['survey_blocks']->is_required)
                                                                     class= "yesno required questionSkipLogic"
                                                                     data-msg-required="{{ Lang::get('messages.ajaxformchkbox')}}"
                                                                     
                                                                     @else

                                                                     class= "yesno questionSkipLogic"
                                                                     @endif
                                                                     value="yes" name="ans[{{ $sq['survey_blocks']->id  }}][]"
                                                                    
                                                                     >
                                                                     <span>Yes</span>
                                                                  </label>
                                                               </div>


                                                               <div class="checkbox">
                                                                     <label class="pure-material-checkbox">
                                                                        <input class="yesno questionSkipLogic" type="checkbox" value="no" name="ans[{{ $sq['survey_blocks']->id  }}][]" 
                                                                        
                                                                        >
                                                                        <span>No</span>
                                                                     </label>
                                                                  </div>
                                                      
                                                          
                                                                  <script>
                                                                       $('.yesno').on('change',function(){
                                                                           var th = $(this), name = th.prop('name'); 
                                                                           if(th.is(':checked')){
                                                                              $(':checkbox[name="'  + name + '"]').not($(this)).prop('checked',false);   
                                                                           }
                                                                           });
                                                                        </script>
                                                        

                                                         

                                                      @endif

                                                       {{--  End For  single checkbox --}}



                                                             {{--  For selectbox --}}
                                                             

                                                            @if(  ( $sq['survey_blocks']->survey_question_type == (new \App\Http\Helpers\Common)::$intDropDownList )
                                                                  &&

                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                                  )

                                                                  <?php  
                                                                     $points =  $q->question_points;
                                                                     if(!is_array($points))
                                                                     {
                                                                        $points = array($points);
                                                                     }                                                            
                                                                  ?>
                                                               <select class="form-control questionSkipLogic @if($sq['survey_blocks']->is_required) required " data-msg-required="{{ Lang::get('messages.ajaxformradio')}}" @else " @endif
                                                                     id="ans_{{ $sq['survey_blocks']->id  }}"
                                                                  name="ans[{{ $sq['survey_blocks']->id  }}][]" >
                                                                  <option value="">Select</option>
                                                                  @foreach($points as $option)                                                              
                                                                     <option value="{{ $option }}">{{ $option }}</option>
                                                                  @endforeach
                                                               </select>
                                                               <script>
                                                                 
                                                               //   $("#ans_{{ $sq['survey_blocks']->id }}").select2();

                                                               </script>

                                                           @endif

                                                            {{--  End For selectbox --}}


                                                            {{--  For textbox " --}}

                                                            @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                            [ (new \App\Http\Helpers\Common)::$intTextBox]) 
                                                            &&

                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                            )

                                                               <div class="">
                                                                     <input class="form-control questionSkipLogic @if($sq['survey_blocks']->is_required) required @endif"
                                                                   value="" name="ans[{{ $sq['survey_blocks']->id  }}][]" placeholder=""  type="text">
                                                                  </div>

                                                            @endif

                                                            {{--  End For textbox --}}


                                                             {{--  For textarea --}}

                                                             @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                             [ (new \App\Http\Helpers\Common)::$intTextArea]) 
                                                             &&

                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                             )
 
                                                                <div class="mb-0">
                                                                      

                                                                      <textarea placeholder="" 
                                                                       
                                                                      name="ans[{{ $sq['survey_blocks']->id  }}][]" name="txtbx_{{ $sq['survey_blocks']->id }}" class="text-area questionSkipLogic
                                                                      @if($sq['survey_blocks']->is_required)
                                                                      required                                                                         
                                                                        @endif " 
                                                                        data-msg-required="{{ Lang::get('messages.ajaxformtxtarea')  }}"
                                                                      rows="1" cols="1" onkeyup="auto_grow(this)" spellcheck="false"></textarea>


                                                                   </div>
 
                                                             @endif
 
                                                             {{--  End For textarea --}}

                                                            {{--  Start For matrix --}}

                                                             @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                             [ (new \App\Http\Helpers\Common)::$intMatrix]) 
                                                             &&

                                                                   $pages[$i] == $sq['survey_blocks']->page_number
                                                             )
                                                             <?php
                                                            
                                                             $matarr = json_decode($sq['survey_blocks']->survey_question);
                                                             $question_points = $matarr->question_points;
                                                                       array_multisort(array_map(function($element) {
                                                   return $element->question_number;
                                             }, $question_points), SORT_ASC, $question_points);
                                                             
                                                             ?>
                                                             <div class="table-wrap">

                                                                  <table class="display table  table-striped" style="width:100%" cellspacing="1" cellpadding="2">
                                                                     <thead>
                                                                        <tr>
                                                                           <th>  
                                                                              {{-- {{ $q->question }}  --}}
                                                                              @if($sq['survey_blocks']->is_required)
                                                                                 <span class="text-danger">*</span>
                                                                              @endif
                                                                           </th>
                                                                           @for($c=0;$c<count($sq['survey_radio_options']);$c++)
                                                                              <th class="text-center v-middle">
                                                                                 <span class="th-heading">{{ $sq['survey_radio_options'][$c]->point_option }} </span>
                                                                              </th>
                                                                           @endfor
                        
                                                                        </tr>
                                                                     </thead>
                                                                     
                                                                     @for($r=0;$r<count($question_points);$r++)
                                                                        <tr>
                                                                         
                                                                           <td class="v-middle">
                                                                              {{-- <span class="td-question">{{ $r + 1 }}. {{ $question_points[$r] }}</span> --}}
                                                                              <span class="td-question">{{ $question_points[$r]->question_number  }}. {{ $question_points[$r]->question  }}</span>
                                                                           </td>
                                                                           @for($c=0;$c<count($sq['survey_radio_options']);$c++)                        
                                                                                 <td class="v-middle text-center">                        
                                                                                       <div class="md-radio">

                                                                                             <input id="ans[{{ $sq['survey_blocks']->id }}][{{$r}}]_{{ $r.$c }}" 
                                                                                             value="{{ $sq['survey_radio_options'][$c]->id }}"
                                                                                                {{-- @if($c == 0 && $sq['survey_blocks']->is_required) class="required"  data-msg-required="{{ Lang::get('messages.ajaxformradio')  }}" @endif --}}
                                                                                                @if( $sq['survey_blocks']->is_required && $c==0) class="required questionSkipLogic"  data-msg-required="{{ Lang::get('messages.ajaxformradio')  }}" @else class="questionSkipLogic" @endif
                                                                                                name="ans[{{ $sq['survey_blocks']->id }}][{{$r}}]"
                                                                                                type="radio"
                                                                                             />

                                                                                             <label class="p-10" for="ans[{{ $sq['survey_blocks']->id }}][{{$r}}]_{{ $r.$c }}">
                                                                                                <span class="redio-label"> {{ $sq['survey_radio_options'][$c]->point_option }} </span>
                                                                                             </label>

                                                                                       </div>
                                                                                       <span></span>
                                                                                 </td>
                                                                           @endfor
                                                                        </tr>

                                                                     
                                                                     @endfor
                                                                     
                                                                    
                                                               </table>
                                                            </div>

                                                            @endif

                                                            {{--  End For matrix --}}

                                             </td>
                                          </tr>
                                          @endif

                                 @endforeach
                                
                              </tbody>
                           </table>
                        </div>
                     </div>

                  

                     @if($i<count($pages)-1  )
      
                     @if($i != 0)
                     {{-- <a class="previous btn btn-default  btn-round btn-s-md  waves-effect waves-light"
                  href="javascript:void(0)">Back</a> --}}
                  @endif

                     {{-- <input type="button" name="next"
                        class="next btn btn-br-success btn-round btn-s-md  waves-effect waves-dark" value="Next" /> --}}
                        
                     @else

                        @if($i != 0)
                        {{-- <input type="button" name="previous"
                        class="previous btn btn-default btn-round btn-s-md  waves-effect waves-light" value="Back" /> --}}
                        @endif
                        @if(Route::currentRouteName() == "previewsurveyform")

                        
                        @else
                        <a data-toggle="modal" data-target="#thankyou-popup"
                              class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light d-none" id="submit" style="color:#fff"
                               >Submit</a>

                               <a data-toggle="modal" data-target="#thankyou-popup" id="submitthanks"
                               class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light d-none" style="color:#fff"
                                >Submit</a>


                           {{-- <input data-toggle="modal" data-target="#thankyou-popup" type="submit" name="Submit"
                           class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light d-none"
                           value="Submit" id="submit" /> --}}
                        @endif
                     @endif

                  </fieldset>

                  @endfor

               </form>

               <div class="container alert alert-danger" style="display:none"></div>
                  
               
             <?php // } ?> 
             @if(Route::currentRouteName() != "tmp_previewsurveyform")
               <div class="progress_custom">
                  <div class="d-flex justify-content-between progress_per">
                     <div class="progress-bar-percentage"></div>
                     <div id="timecounter">
                        <img src="{{ asset('front/images/time-left.svg')}}" class="mr-2" width="18px" height="auto" alt="">
                       
                        <span id="time">10:00</span>
                        </div>
                  </div>
                  <div class="progress">
                     <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                        aria-valuemax="100"></div>
                  </div>

                 
               </div>
               @endif
               <div class="bg-btn-bottom"></div>

            </div>

         </div>
         <div class="blank-div"></div>
      </div>
   </div>
</div>



@if(Route::currentRouteName() != "tmp_previewsurveyform")
<div class="col-12 footer">
   <div class="row wow fadeIn" data-wow-duration="4s">
      
      
            @include('front.common.survey_trouble_text')
        
      @if($survey['show_logo'] == 1)
      <div class="col-md-6 hidden-xs  d-flex justify-content-end">
         <span class="powered">Powered by</span>
         <a href="http://www.perceptionmapping.com/" target="_blank">
            <img src="{{ asset('front/images/logo.png')}}" width="200px;" alt="logo">
         </a>
      </div>
      @endif

   </div>
</div>
@endif

<!-- Modal -->
@include('front.common.survey_trouble_modal')

<div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-dialog-centered theme-modal  w-450 " role="document">
      <div class="modal-content">
         <div class="modal-body thankyou">
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button> --}}
            <div class="success-checkmark">
               <div class="check-icon">
                  <span class="icon-line line-tip"></span>
                  <span class="icon-line line-long"></span>
                  <div class="icon-circle"></div>
                  <div class="icon-fix"></div>
               </div>
            </div>
            <h2 id="thank_head">Thank You.</h2>

            @if($survey['thankyou_description'] != "")
               <span id="thankyou_description">{{ $survey['thankyou_description'] }} 
               
               </span>
            @else
               {{-- <span>This survey is now completed and your participation has been recorded successfully.</span> --}}
            @endif

            @if(\Route::currentRouteName() == "surveyform")

                              
            <div class="mt-3">
                <a href="{{ route('surveyfrontdefault') }}"class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">
                  {{-- Back to home --}}
                  Close
               </a>
               {{-- <a href="{{ URL::previous() }}"class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">Back to home</a> --}}
               </div>
                          
                        @else
                        <div class="mt-3">
 <a href="{{ route('surveyfrontdefault') }}"class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">
   Close
 </a>
 </div>

                        {{-- <div class="mt-3"><a id="backtohome"
                        href="{{ URL::previous() }}"
                              class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">Back to home</a></div> --}}
                        @endif

                        
         </div>
      </div>
   </div>

<script>
$(document).ready(function(){
  var current = 1,current_step,next_step,steps;
  steps = $("fieldset").length;
  $(".next").click(function(){
    current_step = $(this).parent();
    next_step = $(this).parent().next();
    next_step.show();
    current_step.hide();
    setProgressBar(++current);
  });
  $(".previous").click(function(){
    current_step = $(this).parent();
    next_step = $(this).parent().prev();
    next_step.show();
    current_step.hide();
    setProgressBar(--current);
  });
  setProgressBar(current);
  // Change progress bar action
  function setProgressBar(curStep){
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    //$(".progress-bar").css("width",percent+"%").html(percent+"%");   

    $(".progress-bar").css("width",percent+"%");
    $(".progress-bar-percentage").html(percent+"%"+" Completed");       
  }
});


var interval;
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {            
            $("#timecounter").remove();
            $("#thank_head").empty().html("Oops...");
            $("#thankyou_description").empty().html("Your time is exceeded");
            $("#submitthanks").trigger('click');
            clearInterval(interval); 
            return false;
        }
    }, 1000);
}





</script>

@include('front.common.scriptskiplogic')