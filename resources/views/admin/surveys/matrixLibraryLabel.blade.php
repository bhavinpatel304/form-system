<fieldset class="form-group edtior dataClass cursor-auto" data-id="{{ $id }}">
   <div class="question-actions">
      @include('admin.surveys.editableIconLabelLibrary') 
   </div>
   <div class="table-wrap" >
      <span class="question_number_lib" style="visibility: hidden; position: absolute;">{{ $question_number }}</span>
      <table class="display table table-bordered " style="width:100%;background-color:#fff" cellspacing="1" cellpadding="2">
         <thead>
            <tr>
               <th>
                  {{-- {{ $question }} --}}
               </th>
               @for($c=0;$c<count($survey_radio_points);$c++)
               <th class="text-center v-middle">
                  <span class="th-heading">{{ $survey_radio_points[$c]->point_option }} </span>
               </th>
               @endfor
            </tr>
         </thead>
          @php 
                                             array_multisort(array_map(function($element) {
                                                   return $element->question_number;
                                             }, $question_points), SORT_ASC, $question_points);
                                             
                                             @endphp
         @for($r=0;$r<count($question_points);$r++)
         <tr>
            <td class="v-middle">
               {{-- <span class="td-question">{{ $r + 1 }}. {{ $question_points[$r] }}</span> --}}
               <span class="td-question">{{ $question_points[$r]->question_number }}. {{ $question_points[$r]->question }}</span>
            </td>
            @for($c=0;$c<count($survey_radio_points);$c++)
            <td class="v-middle text-center">
               <div class="md-radio">
                  <input id="_{{ $r.$c }}" name="_{{ $r.$c }}" type="radio" disabled  >
                  <label class="p-10" for="_{{ $r.$c }}""><span class="redio-label"></span></label>
               </div>
            </td>
            @endfor
         </tr>
         @endfor
      </table>
   </div>
</fieldset>