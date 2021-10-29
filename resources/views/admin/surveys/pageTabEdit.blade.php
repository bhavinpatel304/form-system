<input type="hidden" name="total_page" value="{{ count($pages_count) }}" />
<input type="hidden" id="survey_id" value="{{ $survey->id }}" />
@for($i=0;$i<count($pages_count);$i++) 


@php $page_num = $i + 1; @endphp

@if(isset($page_heading[$i]))

@php
$survey_head = $page_heading[$i]; @endphp

<div class="tab-pane fade pageDiv" id="page{{ $page_num }}" role="tabpanel" aria-labelledby="page{{ $page_num }}">
   <div class="card-body survey_form">
      <fieldset class="form-group headingMain" >

         @if($page_num == 1)
          <div class="checkbox">
                  <label class="pure-material-checkbox show_headingLabel" for="show_heading">
                  <input type="checkbox" name="show_heading_1" id="show_heading" class="show_heading"  @if($survey_head->show_heading == 1) checked  @endif>
                  <span>Heading</span>
                  </label>
               </div>
         @else
               <div class="checkbox">
                  <label class="pure-material-checkbox show_headingLabel" for="show_heading_{{ $page_num }}">
                  <input type="checkbox" class="show_heading" id="show_heading_{{ $page_num }}" name="show_heading_{{ $page_num }}" @if($survey_head->show_heading == 1) checked  @endif>
                  <span>Heading</span>
                  </label>
               </div>
         @endif



         {{-- <label class="form-label" for="survey_heading"> <input type="checkbox" class="show_heading" id="show_heading_{{ $page_num }}" name="show_heading_{{ $page_num }}" @if($survey_head->show_heading == 1) checked  @endif> Heading</label> --}}
         <div class="form-row">
            <div class="col-xl-7 col-lg-12">
            <input type="hidden" value="{{  $page_num}}" id="page_number"  name="page_number[]" />               
            <input type="hidden" value="{{  $page_num}}" id="page_number_count"  name="page_number_count[]" />               
               <input class="form-control survey_heading  @if($survey_head->is_heading_bold == 1) bold  @endif @if($survey_head->is_heading_italic == 1) italic  @endif @if($survey_head->is_heading_underline == 1) underline  @endif " 
               
               id="survey_heading" name="survey_heading_{{ $page_num }}" value="{{ $survey_head->survey_heading }}"
               
                  placeholder="Please enter heading" type="text"  style="color:{{ $survey_head->heading_fg_color }}!important;background-color:{{ $survey_head->heading_bg_color }}!important;">



               <input type="hidden" name="is_heading_bold_{{ $page_num }}" id="is_heading_bold_{{ $page_num }}" class="is_heading_bold" value="{{ $survey_head->is_heading_bold }}" />
               <input type="hidden" name="is_heading_italic_{{ $page_num }}" id="is_heading_italic_{{ $page_num }}" class="is_heading_italic" value="{{ $survey_head->is_heading_italic }}" />
               <input type="hidden" name="is_heading_underline_{{ $page_num }}" id="is_heading_underline_{{ $page_num }}" class="is_heading_underline" value="{{ $survey_head->is_heading_underline }}" />
               <input type="hidden" name="is_subheading_bold_{{ $page_num }}" id="is_subheading_bold_{{ $page_num }}" class="is_subheading_bold" value="{{ $survey_head->is_subheading_bold }}" />
               <input type="hidden" name="is_subheading_italic_{{ $page_num }}" id="is_subheading_italic_{{ $page_num }}" class="is_subheading_italic" value="{{ $survey_head->is_subheading_italic }}" />
               <input type="hidden" name="is_subheading_underline_{{ $page_num }}" id="is_subheading_underline_{{ $page_num }}" class="is_subheading_underline" value="{{ $survey_head->is_subheading_underline }}" />
            </div>
            <div class="col-xl-5 col-lg-12">
               <div class="fontEditor">
                  <ul class="nav">
                     <li class="nav-item @if($survey_head->is_heading_bold == 1) active  @endif"><a class="nav-link bold survey_heading_bold" href="javascript:void()">B</a></li>
                     <li class="nav-item @if($survey_head->is_heading_italic == 1) active  @endif"><a class="nav-link italic survey_heading_italic" href="javascript:void()">I</a>
                     </li>
                     <li class="nav-item @if($survey_head->is_heading_underline == 1) active  @endif"><a class="nav-link underline survey_heading_underline" href="javascript:void()">U</a>
                     </li>
                     <li class="nav-item">
                        <a href="javascript:void()">
                        <select name="survey_heading_fontSize_{{ $page_num }}" id="survey_heading_fontSize_{{ $page_num }}" class="select2_cls form-control fontSizeBtn survey_heading_fontSizeBtn">
                           <option value="12" @if($survey_head->survey_heading_fontSize == 12) selected  @endif >12 pt</option>
                           <option value="14" @if($survey_head->survey_heading_fontSize == 14) selected  @endif>14 pt</option>
                           <option value="16" @if($survey_head->survey_heading_fontSize == 16) selected  @endif>16 pt</option>
                           <option value="18" @if($survey_head->survey_heading_fontSize == 18) selected  @endif>18 pt</option>
                           <option value="20" @if($survey_head->survey_heading_fontSize == 20) selected  @endif>20 pt</option>
                           <option value="22" @if($survey_head->survey_heading_fontSize == 22) selected  @endif>22 pt</option>
                           <option value="24" @if($survey_head->survey_heading_fontSize == 24) selected  @endif>24 pt</option>
                           <option value="26" @if($survey_head->survey_heading_fontSize == 26) selected  @endif>26 pt</option>
                           </select>
                        </a>
                     </li>
                  </ul>
                  <div class="color-picker">
                     <div class="form-control">
                        <input name="heading_fg_color_{{ $page_num }}" type="text" placeholder="#000" value="{{ $survey_head->heading_fg_color }}"
                           class="picker heading-picker-color" id="heading-picker-color" readonly style="border-right-color:{{ $survey_head->heading_fg_color }}"  />
                     </div>
                  </div>
                  <div class="color-picker">
                     <label class="form-label" for="text">B/G</label>
                     <div class="form-control">
                        <input name="heading_bg_color_{{ $page_num }}" type="text" placeholder="#000" value="{{ $survey_head->heading_bg_color }}"
                           class="picker heading-picker-bckgrd" id="heading-picker-bckgrd" readonly style="border-right-color:{{ $survey_head->heading_bg_color }}"  />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </fieldset>
      {{-- <fieldset class="form-group survey_sub_heading"> --}}
         <fieldset class="form-group subHeadingMain">
         
          @if($page_num == 1)

           <div class="checkbox">
                  <label class="pure-material-checkbox show_sub_headingLabel" for="show_subheading">
                  <input type="checkbox" name="show_subheading_1" id="show_subheading" class="show_subheading" @if($survey_head->show_subheading == 1) checked  @endif>
                  <span>Subheading</span>
                  </label>
               </div>
          
         @else


          <div class="checkbox">
                  <label class="pure-material-checkbox show_sub_headingLabel" for="show_subheading_{{ $page_num }}">
                  <input type="checkbox" id="show_subheading_{{ $page_num }}" name="show_subheading_{{ $page_num }}" class="show_subheading"  @if($survey_head->show_subheading == 1) checked  @endif>
                  <span>Subheading</span>
                  </label>
               </div>
              
         @endif



         {{-- <label class="form-label" for=""><input type="checkbox" id="show_subheading" name="show_subheading_{{ $page_num }}" class="show_subheading"  @if($survey_head->show_subheading == 1) checked  @endif > Subheading</label> --}}
         <div class="form-row">
            <div class="col-xl-7 col-lg-12">
               <input class="form-control survey_sub_heading @if($survey_head->is_subheading_bold == 1) bold  @endif @if($survey_head->is_subheading_italic == 1) italic  @endif @if($survey_head->is_subheading_underline == 1) underline  @endif" id="survey_sub_heading" name="survey_sub_heading_{{ $page_num }}" value="{{ $survey_head->survey_sub_heading }}"
                  placeholder="Please enter subheading" type="text"  style="color:{{ $survey_head->sub_heading_fg_color }}!important;background-color:{{ $survey_head->sub_heading_bg_color }}!important;" >
            </div>
            <div class="col-xl-5 col-lg-12">
               <div class="fontEditor">
                  <ul class="nav">
                     <li class="nav-item @if($survey_head->is_subheading_bold == 1) active  @endif "><a class="nav-link bold survey_sub_heading_bold" href="javascript:void()">B</a></li>
                     <li class="nav-item @if($survey_head->is_subheading_italic == 1) active  @endif "><a class="nav-link italic survey_sub_heading_italic" href="javascript:void()">I</a>
                     </li>
                     <li class="nav-item @if($survey_head->is_subheading_underline == 1) active  @endif"><a class="nav-link underline survey_sub_heading_underline" href="javascript:void()">U</a>
                     </li>
                     <li class="nav-item">
                        <a href="javascript:void()">
                        <select name="survey_sub_heading_fontSize_{{ $page_num }}" id="survey_sub_heading_fontSize" class="select2_cls form-control fontSizeBtn survey_sub_heading_fontSizeBtn">
                        <option value="12" @if($survey_head->survey_sub_heading_fontSize == 12) selected  @endif >12 pt</option>
                        <option value="14" @if($survey_head->survey_sub_heading_fontSize == 14) selected  @endif>14 pt</option>
                        <option value="16" @if($survey_head->survey_sub_heading_fontSize == 16) selected  @endif>16 pt</option>
                        <option value="18" @if($survey_head->survey_sub_heading_fontSize == 18) selected  @endif>18 pt</option>
                        <option value="20" @if($survey_head->survey_sub_heading_fontSize == 20) selected  @endif>20 pt</option>
                        <option value="22" @if($survey_head->survey_sub_heading_fontSize == 22) selected  @endif>22 pt</option>
                        <option value="24" @if($survey_head->survey_sub_heading_fontSize == 24) selected  @endif>24 pt</option>
                        <option value="26" @if($survey_head->survey_sub_heading_fontSize == 26) selected  @endif>26 pt</option>
                        </select>
                        </a>
                     </li>
                  </ul>
                  <div class="color-picker">
                     <div class="form-control">
                        <input name="sub_heading_fg_color_{{ $page_num }}" type="text" placeholder="#000" value="{{ $survey_head->sub_heading_fg_color }}"
                           class="picker sub-picker-color" id="sub-picker-color" style="border-right-color:{{ $survey_head->sub_heading_fg_color }}" readonly />
                     </div>
                  </div>
                  <div class="color-picker">
                     <label class="form-label" for="text">B/G</label>
                     <div class="form-control">
                        <input name="sub_heading_bg_color_{{ $page_num }}" type="text" placeholder="#000" value="{{ $survey_head->sub_heading_bg_color }}"
                           class="picker sub-picker-bckgrd" id="sub-picker-bckgrd" readonly style="border-right-color:{{ $survey_head->sub_heading_bg_color }}" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </fieldset>
      <div id="card-move" class="addQuestion">

         
         <?php $j = 0; ?>
         {{-- @php 
         dd($getview);
         @endphp  --}}

         @foreach($getview as $sd)
            @if($page_numbs[$j] == $page_num)

               {!! $sd !!}

               
          
            @endif
            <?php $j++; ?>
         @endforeach



      </div>
   </div>
   @include('admin.surveys.add_question_dropdown')  
</div>


@endif

@endfor



{{-- @include('admin.surveys.page2')   --}}
</div>