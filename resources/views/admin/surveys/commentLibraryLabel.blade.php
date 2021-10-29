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
         <div class="question">
            <div class="inputBox">
               <textarea placeholder="" type="text" class="text-area" rows="1" cols="1" onkeyup="auto_grow(this)" spellcheck="false" readonly></textarea>
            </div>
         </div>
      </div>
   </div>
</fieldset>