<fieldset class="edtior">
   <div class="form-edtior cursor-pointer">
      <div class="question_editable">
        @foreach ($survey_radio_points as $curr_survey_radio_points)
         <div class="question">
            <div class="ans">
               <div class="md-radio">
                  <input id="1" type="radio" name="employmentstatus" disabled="" value="">
                  <label for="1"></label>
               </div>
            </div>
            <div class="inputBox">
            <input class="form-control" id="text" placeholder="Enter an answer choice" value="{{ $curr_survey_radio_points->point_option }}" type="text"  disabled="">
            </div>
         </div>         
         @endforeach
      </div>
   </div>
</fieldset>