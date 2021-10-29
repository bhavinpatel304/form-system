<fieldset class=" edtior">
   
   <div class="form-edtior cursor-pointer">
      
      <div class="question_editable">
         <div class="tableHeading">
            Questions
         </div>
         <div class="question">
            {{-- <div class="inputBox">
               <input class="form-control" name="matrixarr[]" value="" data-validation="required" data-validation-error-msg-container="dropdownarr_error" data-validation-error-msg="You have to agree to our terms" placeholder="Enter your question" type="text">
            </div>             --}}
            <div class="form-row inputBox">
                     <div class=" form-group col-md-1">
                        <input class="form-control matrixnumberarr" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="matrixnumberarr[]" maxlength="2" value="" placeholder="No." type="text" data-validation="required" data-validation-error-msg-container="dropdownarr_number_error" data-validation-error-msg="Enter question number">
                        <span id="dropdownarr_number_error"></span>
                     </div>
                     <div class="form-group col-md-11">
                        <input class="form-control"  name="matrixarr[]"   placeholder="Enter an answer choice" type="text" data-validation="required" data-validation-error-msg-container="dropdownarr_error" data-validation-error-msg="You have to agree to our terms">
                        <span id="dropdownarr_error"></span>
                     </div>
                  </div>
         </div>         
         <div class="add-new-item">
            <span>
               <svg class="svd-svg-icon" style="width: 12px; height: 12px;">
                  <use xlink:href="#icon-inplaceplus">
                     <symbol viewBox="0 0 12 12" id="icon-inplaceplus">
                        <path d="M11 5H7V1H5v4H1v2h4v4h2V7h4z"></path>
                     </symbol>
                  </use>
               </svg>
            </span>
            <span class="add-Item addSingleMatrix">Add Question</span>
         </div>
      </div>

      
   </div>
</fieldset>