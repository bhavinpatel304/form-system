<fieldset class="form-group edtior dataClass cursor-auto"  data-id="{{ $id }}">
   <div class="question-actions">
      @include('admin.surveys.editableIconLabelLibrary') 
   </div>
   <div class="form-edtior">
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
               <input class="form-control" id="text" value="" placeholder="" type="text" readonly />
            </div>
         </div>
      </div>
   </div>
</fieldset>