<fieldset class="form-group edtior dataClass cursor-auto" data-id="{{ $id }}">
   <div class="question-actions">
      @include('admin.surveys.editableIconLabelLibrary') 
   </div>
   <div class="form-edtior" >
      <div class="editTitle">
         <div class="queTitle">
            Q<span class="question_number_lib">{{ $question_number }}</span>
         </div>
         <div class="inputBox">
            {{ $question }}
         </div>
      </div>
      <div class="question_editable">
         @php $i =0; @endphp
         @foreach($question_points as $qs)
         <div class="question">
            <div class="ans">
               @php $i++; @endphp
               <div class="md-radio">
                  <input id="_{{ $i }}" name="_{{ $i }}" type="radio" disabled  >
                  <label class="p-10" for="_{{ $i }}""><span class="redio-label"></span></label>
               </div>
            </div>
            <div class="inputBox">
               {{ $qs }}
            </div>
         </div>
         @endforeach
      </div>
   </div>
</fieldset>