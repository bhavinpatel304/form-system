<div class="tab-pane fade pageDiv" id="page1" role="tabpanel" aria-labelledby="page1">
   <div class="card-body survey_form">
      <fieldset class="form-group headingMain">
         
         <div class="checkbox">
                  <label class="pure-material-checkbox show_headingLabel" for="show_heading">
                  <input type="checkbox" name="show_heading_1" id="show_heading" class="show_heading">
                  <span>Heading</span>
                  </label>
               </div>
         {{-- <label class="form-label" for="survey_heading"><input type="checkbox" name="show_heading_1" id="show_heading" class="show_heading"> Heading</label> --}}
         <div class="form-row">
            <div class="col-xl-7 col-lg-12">
               <input type="hidden" value="1" id="page_number"  name="page_number[]" />               
               <input class="form-control survey_heading" id="survey_heading" name="survey_heading_1" value=""
                  placeholder="Please enter heading" type="text" disabled>
               <input type="hidden" name="is_heading_bold_1" id="is_heading_bold" class="is_heading_bold" value="2" />
               <input type="hidden" name="is_heading_italic_1" id="is_heading_italic" class="is_heading_italic" value="2" />
               <input type="hidden" name="is_heading_underline_1" id="is_heading_underline" class="is_heading_underline" value="2" />
               <input type="hidden" name="is_subheading_bold_1" id="is_subheading_bold" class="is_subheading_bold" value="2" />
               <input type="hidden" name="is_subheading_italic_1" id="is_subheading_italic" class="is_subheading_italic" value="2" />
               <input type="hidden" name="is_subheading_underline_1" id="is_subheading_underline" class="is_subheading_underline" value="2" />
            </div>
            <div class="col-xl-5 col-lg-12">
               <div class="fontEditor">
                  <ul class="nav">
                     <li class="nav-item"><a class="nav-link bold survey_heading_bold" href="javascript:void()">B</a></li>
                     <li class="nav-item"><a class="nav-link italic survey_heading_italic" href="javascript:void()">I</a>
                     </li>
                     <li class="nav-item"><a class="nav-link underline survey_heading_underline" href="javascript:void()">U</a>
                     </li>
                     <li class="nav-item">
                        <a href="javascript:void()">
                           <select name="survey_heading_fontSize_1" id="survey_heading_fontSize" class="select2_cls form-control fontSizeBtn survey_heading_fontSizeBtn">
                              <option value="12">12 pt</option>
                              <option value="14">14 pt</option>
                              <option value="16">16 pt</option>
                              <option value="18">18 pt</option>
                              <option value="20">20 pt</option>
                              <option value="22">22 pt</option>
                              <option value="24">24 pt</option>
                              <option value="26">26 pt</option>
                           </select>
                        </a>
                     </li>
                  </ul>
                  <div class="color-picker">
                     <div class="form-control">
                        <input name="heading_fg_color_1" type="text" placeholder="#000" value="#000"
                           class="picker heading-picker-color" id="heading-picker-color"  readonly />
                     </div>
                  </div>
                  <div class="color-picker">
                     <label class="form-label" for="text">B/G</label>
                     <div class="form-control">
                        <input name="heading_bg_color_1" type="text" placeholder="#000" value="#fff"
                           class="picker heading-picker-bckgrd" id="heading-picker-bckgrd" readonly />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </fieldset>
      <fieldset class="form-group subHeadingMain">

          <div class="checkbox">
                  <label class="pure-material-checkbox show_sub_headingLabel" for="show_subheading">
                  <input type="checkbox" name="show_subheading_1" id="show_subheading" class="show_subheading">
                  <span>Subheading</span>
                  </label>
               </div>


          {{-- <div class="checkbox">
                  <label class="pure-material-checkbox" for="show_subheading">
                  <input type="checkbox" id="show_subheading" name="show_subheading_1" class="show_subheading">
                  <span>Subheading</span>
                  </label>
               </div> --}}
         {{-- <label class="form-label" for="survey_sub_heading"><input type="checkbox" id="show_subheading" name="show_subheading_1" class="show_subheading"> Subheading</label> --}}
         <div class="form-row">
            <div class="col-xl-7 col-lg-12">
               <input class="form-control survey_sub_heading" id="survey_sub_heading"  name="survey_sub_heading_1" value=""
                  placeholder="Please enter subheading" type="text" disabled>
            </div>
            <div class="col-xl-5 col-lg-12">
               <div class="fontEditor">
                  <ul class="nav">
                     <li class="nav-item"><a class="nav-link bold survey_sub_heading_bold" href="javascript:void()">B</a></li>
                     <li class="nav-item"><a class="nav-link italic survey_sub_heading_italic" href="javascript:void()">I</a>
                     </li>
                     <li class="nav-item"><a class="nav-link underline survey_sub_heading_underline" href="javascript:void()">U</a>
                     </li>
                     <li class="nav-item">
                        <a href="javascript:void()">
                           <select name="survey_sub_heading_fontSize_1" id="survey_sub_heading_fontSize" class="select2_cls form-control fontSizeBtn survey_sub_heading_fontSizeBtn">
                              <option value="12">12 pt</option>
                              <option value="14">14 pt</option>
                              <option value="16">16 pt</option>
                              <option value="18">18 pt</option>
                              <option value="20">20 pt</option>
                              <option value="22">22 pt</option>
                              <option value="24">24 pt</option>
                              <option value="26">26 pt</option>
                           </select>
                        </a>
                     </li>
                  </ul>
                  <div class="color-picker">
                     <div class="form-control">
                        <input name="sub_heading_fg_color_1" type="text" placeholder="#000" value="#000"
                           class="picker sub-picker-color" id="sub-picker-color" readonly />
                     </div>
                  </div>
                  <div class="color-picker">
                     <label class="form-label" for="text">B/G</label>
                     <div class="form-control">
                        <input name="sub_heading_bg_color_1" type="text" placeholder="#000" value="#fff"
                           class="picker sub-picker-bckgrd" id="sub-picker-bckgrd" readonly />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </fieldset>
      <div id="card-move" class="addQuestion">
      </div>
   </div>
   @include('admin.surveys.add_question_dropdown')  
</div>
{{-- @include('admin.surveys.page2')   --}}
</div>