<fieldset class="form-group edtior">
                                   
   <div class="form-edtior w-100 cursor-pointer">

      <div class="question_editable">
         <div class="question">
            <div class="ans">
               <div class="checkbox">
                  {{-- <label class="pure-material-checkbox">
                     <input type="checkbox" disabled="" value="">
                     <span></span>
                  </label> --}}
               </div>
            </div>
            <div class="inputBox">               
               <input class="form-control" name="dropdownarr[]" value="" placeholder="Enter an answer choice" type="text" data-validation="required" data-validation-error-msg-container="dropdownarr_error" data-validation-error-msg="You have to agree to our terms">
               <span id="dropdownarr_error"></span>
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
            <span class="add-Item addSingle">Add</span>
         </div>
      </div>
   </div>
</fieldset>