<div class="modal fade" id="addSkipLogicModal" tabindex="-1" role="dialog" aria-labelledby="addSkipLogicModal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Skip Logic</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form role="form" method="POST" action="" novalidate id="addSkipLogicModalfrm">
            @csrf
            <input type="hidden" name="page_number" id="page_number" value="" />
            <input type="hidden" name="tmp_id" id="tmp_id" value="" />
            <div class="modal-body">
               
               <div class="card mb-3 custom_form">
                  <div class="card-body">
                     <div class="col-xs-12">
                        <div class="row">
                           <div class="col-12">
                              <div class="form-group">
                                 <label>Only show this question when:</label>
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="skip_question_id">Question Number:</label>
                                 {{-- <select name="skip_question_id" id="skip_question_id" class=" form-control dropdownQuestion skip_question_id" data-validation="required"  data-validation-error-msg-required="Please Select Question"> --}}
                                     <select name="skip_question_id" id="skip_question_id" class="skip_question_id form-control" data-validation="required"  data-validation-error-msg-required="Please select question number">
                                    {{-- <option value="" selected>Select Option</option> --}}
                                    
                                 </select>
                              </div>
                           </div>
                           <div class="col-12 mainAnswerClass" style="display:none;">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="answer">Answer Is:</label>
                                 <select name="answer" id="answer" class=" form-control " data-validation="required"  data-validation-error-msg-required="Please Select answer">
                                    {{-- <option value="" selected>Select Option</option> --}}
                                    
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light" id="addSkipLogicModalSubmit">Add</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>

