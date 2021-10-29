<fieldset class="form-group edtior dataClass" data-id="{{ $tmp_question_id }}">
   <div class="question-actions">
      @include('admin.surveys.editableIconLabel') 
   </div>
   <div class="form-edtior" @if($is_required == '1') style="border:1px solid red" @endif>
      <div class="editTitle">
         <div class="queTitle">
            {{-- Que:<span></span> --}}
            Q<span class="question_number">{{ $question_number }}</span>
         </div>
         <div class="inputBox">
            {{ $question }}
         </div>
      </div>
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
               {{ $curr_survey_radio_points->point_option }}
            </div>
         </div>
        @endforeach
         
      </div>
   </div>
</fieldset>