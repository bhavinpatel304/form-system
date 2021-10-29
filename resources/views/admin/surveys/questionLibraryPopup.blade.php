<div class="modal fade" id="questionLibraryModal" tabindex="-1" role="dialog" aria-labelledby="questionLibraryModal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add From Library</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         
         <form role="form" method="POST" action="" novalidate id="questionLibraryModalfrm">
            @csrf
            
            <input type="hidden" name="page_number" id="page_number" value="" />
            <input type="hidden" name="checkboxCount" id="checkboxCount" value="" data-validation="required"  data-validation-error-msg-container="#checkAllCountRequired" data-validation-error-msg-required="Please select atleast one question" data-validation-depends-on="template_id" class="checkboxCount"  />
            
            <div class="form-group col-sm-12 templateSelectbox">
                  <label class="form-label " for="template_id">Select Library <span class="fill-start">*</span></label>
                  <select  class="select2_cls form-control getQuestionsbyTemplate" name="template_id" id="template_id" data-validation="required" data-validation-error-msg-required="Please select library"  data-validation-error-msg-container="#get_template_id" >
                     <option value="" selected>Please select</option>
                  </select>
                  <div id="get_template_id"></div>
            </div>
            
            <div class="p-2 b-b mainSelectAllCheckbox" style="display:none;">
                  <div class="checkbox checkLibrary">
                     
                     <label class="pure-material-checkbox ckbCheckAllLabel m-0">
                     <input type="checkbox" class="ckbCheckAll" id="ckbCheckAll" name="ckbCheckAll">
                     <span>Select All</span>
                     </label>
                     
                  </div>
                  
                 

               </div>
                
            <div class="modal-body">
               
               
               <div class="card mb-3 survey_form">
                  {{-- <div  id="checkAllCountRequired" role="alert"></div> --}}
                  <div  id="checkAllCountRequired" class="m-2 p-2 font-weight-bold" role="alert"></div>

                  {{-- <div id="checkAllCountRequired" class="text-center m-2 p-2"></div> --}}
                  <div class="card-body">
                     <div class="alert alert-danger text-center libraryNoData" role="alert">Sorry !!! No questions found in this library. Please add in your library.</div>
                     <div class="libraryData surveyLibrary">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light btnAddQuestionLibrary">Add</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>