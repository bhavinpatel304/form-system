
<div class="page second-theme  themeBannerScreen">
      @include('front.common.header')
      
      <input type="hidden" name="survey_id" value="{{ $survey['id'] }}" />
      
      
      <input name="url" type="hidden" value="{{ $custom_url }}" />
      
      <div class="padder">
      
      
            <div class="col-12 h-p100">
               <div class="row">
                  <div class="card survey_form position-xs-inherit wow fadeIn" data-wow-duration="4s">
      
                        @for($i=0;$i<count($pages);$i++)
      
                       
      
                        <?php $survey_head = $survey_heading[$i];  ?>
                        
                        <fieldset>
                           @if( $survey_heading[$i]->show_heading)
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
                              
                           {{-- <pre>
                              {{ print_r($survey_head) }}
                              
                           </pre> --}}
                           @if( $survey_heading[$i]->show_subheading )
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
      
                                       <input name="survey_block_id[{{$sq['survey_blocks']->id}}]" type="hidden" value="{{ $sq['survey_blocks']->id }}" />
      
                                       <input name="question_type[{{$sq['survey_blocks']->id}}]" type="hidden" value="{{ $sq['survey_blocks']->survey_question_type  }}" />
      
                                          <?php
                                             $q = json_decode($sq['survey_blocks']->survey_question);
                                          ?>

                                          @if( $pages[$i] == $sq['survey_blocks']->page_number )  
      
                                          
                                                <tr role="row" class="odd">
      
                                                      @if($sq['survey_blocks']->survey_question_type !=
                                                      (new \App\Http\Helpers\Common)::$intMatrix)
                                                      <td width="50%">
      
                                                        
      
                                                            {{ $q->question }}
      
                                                        
                                                      
                                                      </td>
                                                      <td width="50%">
      
                                                      @else
                                                      <td width="100%" colspan="2">
                                                          
                                                      @endif
      
                                                                {{--  For poll and radio button --}}
                                                               @if(!empty($sq['survey_radio_options']) )                                                       
                                                                  @if( $sq['survey_blocks']->survey_question_type ==
                                                                         (new \App\Http\Helpers\Common)::$intPoll 
                                                                         &&
      
                                                                         $pages[$i] == $sq['survey_blocks']->page_number
      
                                                                     )
                                                                     <?php $i = 0; ?>
                                                                     @foreach($sq['survey_radio_options'] as $option)
      
      
                                                                     {{-- <div class="md-radio">
                                                                           <input id="a11" type="radio" name="a1" checked="">
                                                                           <label class="p-10" for="a11"><span class="redio-label">Strongly
                                                                                 Agree</span></label>
                                                                        </div> --}}
      
                                                                        <div class="md-radio">
                                                                     <input type="radio" value="{{ $option->id }}" id="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option->id }}"
                                                                     name="ans[{{ $sq['survey_blocks']->id  }}][]" >
                                                                           <label class="pr-2" for="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $i }}">{{ $option->point_option }}</label>
                                                                        </div>
                                                                  
                                                                        <?php $i++; ?>
      
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
                                                                        
                                                                           $i++;
                                                                        ?>
      
                                                                        @foreach($points as $option)
      
                                                                        <div class="md-radio">
                                                                              <input type="radio" value="{{ $option }}" id="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option }}"
                                                                              name="ans[{{ $sq['survey_blocks']->id  }}][]" >
                                                                                    <label class="pr-2" for="ans[{{ $sq['survey_blocks']->id  }}][]_{{ $option }}">{{ $option }}</label>
                                                                                 </div>
      
                                                                        {{-- <input type="radio" value="{{ $option }}" 
                                                                        name="ans[{{ $sq['survey_blocks']->id  }}][]"
                                                                      >
                                                                                 <label for="1">{{ $option }}</label> --}}
      
                                                                        {{-- <div class="md-radio">
                                                                              <input type="radio" value="{{ $option }}" name="rdob_{{ $sq['survey_blocks']->id }}" >
                                                                                 <label for="1">{{ $option }}</label>
                                                                              </div> --}}
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
      
                                                                     @foreach($points as $option)
                                                                          
                                                                        
                                                                        <div class="checkbox">
                                                                              <label class="pure-material-checkbox">
                                                                                 <input type="checkbox" value="{{ $option }}" name="ans[{{ $sq['survey_blocks']->id  }}][]"  >
                                                                                 <span>{{ $option }}</span>
                                                                              </label>
                                                                           </div>
                                                                  
                                                                      
      
                                                                     @endforeach
      
                                                                     {{-- <script>  data-validation="checkbox_group"
                                                                           $("[name='ans[{{ $sq['survey_blocks']->id  }}][]']:eq(0)")
                                                                             .valAttr('','validate_checkbox_group')
                                                                             .valAttr('qty','1')
                                                                             .valAttr('error-msg','check any one');
                                                                           </script> --}}
      
                                                                  @endif
      
                                                                   {{--  End single checkbox --}}
      
      
      
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
                                                                           <input type="checkbox" class="yesno" value="yes" name="ans[{{ $sq['survey_blocks']->id  }}][]"
                                                                           
                                                                           >
                                                                           <span>Yes</span>
                                                                        </label>
                                                                     </div>
      
      
                                                                     <div class="checkbox">
                                                                           <label class="pure-material-checkbox">
                                                                              <input class="yesno" type="checkbox" value="no" name="ans[{{ $sq['survey_blocks']->id  }}][]" 
                                                                              
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
      
                                                                  @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                                        [ (new \App\Http\Helpers\Common)::$intDropDownList]) 
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
                                                                     <select class="form-control" name="ans[{{ $sq['survey_blocks']->id  }}][]" >
                                                                        @foreach($points as $option)                                                              
                                                                           <option value="{{ $option }}">{{ $option }}</option>
                                                                        @endforeach
                                                                     </select>
      
      
                                                                 @endif
      
                                                                  {{--  End For selectbox --}}
      
      
                                                                  {{--  For textbox data-validation="required" --}}
      
                                                                  @if( in_array( $sq['survey_blocks']->survey_question_type ,
                                                                  [ (new \App\Http\Helpers\Common)::$intTextBox]) 
                                                                  &&
      
                                                                         $pages[$i] == $sq['survey_blocks']->page_number
                                                                  )
      
                                                                     <div class="">
                                                                           <input class="form-control" value="" name="ans[{{ $sq['survey_blocks']->id  }}][]" placeholder=""  type="text">
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
                                                                            
      
                                                                            <textarea placeholder="" name="ans[{{ $sq['survey_blocks']->id  }}][]" name="txtbx_{{ $sq['survey_blocks']->id }}" class="text-area" rows="1" cols="1" onkeyup="auto_grow(this)" spellcheck="false"></textarea>
      
      
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
      
                                                                   
                                                                   ?>
                                                                   <div class="table-wrap">
      
                                                                        <table class="display table  table-striped" style="width:100%" cellspacing="1" cellpadding="2">
                                                                           <thead>
                                                                              <tr>
                                                                                 <th>  {{ $q->question }}</th>
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
                                                                           <span class="td-question">{{ $question_points[$r] }}</span>
                                                                           </td>
                                                                     @for($c=0;$c<count($sq['survey_radio_options']);$c++)
                              
                                                                           <td class="v-middle text-center">
                              
                                                                                 <div class="md-radio">
                                                                                 <input id="_{{ $r.$c }}" value="{{ $sq['survey_radio_options'][$c]->id }}"
                                                                                 
                                                                                 name="ans[{{ $sq['survey_blocks']->id  }}][{{$r}}]"
      
                                                                                 {{-- name="{{ $sq['survey_blocks']->id }}_{{ $r }}"  --}}
                                                                                 
                                                                                 type="radio" >
                                                                                       <label class="p-10" for="_{{ $r.$c }}"">
                                                                                          <span class="redio-label"> {{ $sq['survey_radio_options'][$c]->point_option }} </span>
                                                                                       </label>
                                                                                    </div>
                              
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
      
                           <input type="button" name="next"
                              class="next btn btn-br-success btn-round btn-s-md  waves-effect waves-dark" value="Next" />
                              
                           @else
      
                              @if($i != 0)
                              <input type="button" name="previous"
                              class="previous btn btn-default btn-round btn-s-md  waves-effect waves-light" value="Back" />
                              @endif
                             
                              {{-- <input  type="submit" name="submit" class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light"
                        value="Submit" /> --}}
                            
                              @if(Route::currentRouteName() == "previewsurveyform")
      
                                    <a data-toggle="modal" data-target="#thankyou-popup"
                                    class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light" style="color:#fff"
                                     >Submit</a>
                                
                              @else
                                 <input data-toggle="modal" data-target="#thankyou-popup" type="button" name="Submit"
                                 class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light"
                                 value="Submit" id="submit" />
                              @endif
                           @endif
      
      
      
                        </fieldset>
      
                        @endfor
                        
                     
                   <?php // } ?> 
                     <div class="progress_custom">
                        <div class="d-flex justify-content-between progress_per">
                           <div class="progress-bar-percentage"></div>
                           <div><img src="{{ asset('front/images/time-left.svg')}}" class="mr-2" width="18px" height="auto" alt="">
                             
                              <span id="time">10:00</span>
                              </div>
                        </div>
                        <div class="progress">
                           <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                              aria-valuemax="100"></div>
                        </div>
      
                        {{-- <input  type="submit" name="submit"
                        class="submit btn btn-br-success btn-round btn-s-md  waves-effect waves-light"
                        value="Submit" /> --}}
                     </div>
                     <div class="bg-btn-bottom"></div>
      
                  </div>
      
               </div>
               <div class="blank-div"></div>
            </div>
         </div>
      </div>
      
      
      
      
      <div class="col-12 footer">
         <div class="row wow fadeIn" data-wow-duration="4s">
            @if(Route::currentRouteName() != "tmp_previewsurvey")
               @include('front.common.survey_trouble_text')
            @endif
      
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
      
      <!-- Modal -->
      @include('front.common.survey_trouble_modal')
      <div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered theme-modal  w-450 " role="document">
            <div class="modal-content">
               <div class="modal-body thankyou">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
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
                     <span id="thankyou_description">{{ $survey['thankyou_description'] }}</span>
                  @else
                     {{-- <span>This survey is now completed and your participation has been recorded successfully.</span> --}}
                  @endif
      
                  @if(Route::currentRouteName() == "previewsurveyform")
      
                                    
                  <div class="mt-3">
                     {{-- <a href="javascript:void(0)"class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">Back to home</a> --}}
                  </div>
                                
                              @else
      
                              <div class="mt-3">
                                 {{-- <a href="{{ route('surveyfrontdefault') }}"class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light">Back to home</a> --}}
                              </div>
                              @endif
      
                              
               </div>
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
      
      
      
      // function startTimer(duration, display) {
      //     var timer = duration, minutes, seconds;
      //     setInterval(function () {
      //         minutes = parseInt(timer / 60, 10)
      //         seconds = parseInt(timer % 60, 10);
      
      //         minutes = minutes < 10 ? "0" + minutes : minutes;
      //         seconds = seconds < 10 ? "0" + seconds : seconds;
      
      //         display.textContent = minutes + ":" + seconds;
      
      //         if (--timer < 0) {
      //             $("#submit").trigger('click');
      //             break;
      //          //   $("#time").remove();             
      //         }
      //     }, 1000);
      // }
      
      
      
      
      
      </script>
      
      