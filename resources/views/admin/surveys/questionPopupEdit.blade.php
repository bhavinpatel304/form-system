<div class="modal fade" id="questionModalEdit" tabindex="-1" role="dialog" aria-labelledby="questionModalEdit"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Question</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form role="form" method="POST" action="" novalidate id="questionModalEditfrm">
            @csrf
            <div class="modal-body">
               <input type="hidden" name="page_number" id="page_number" value="" />
               <input type="hidden" name="tmp_id" id="tmp_id" value="" />
               <div class="card mb-3 custom_form">
                  <div class="card-body">
                     <div class="col-xs-12">
                        <div class="row">
                           
                           <div class="col-12">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="radio_id">Select Option</label>
                                 <select name="radio_id" id="radio_id" class="radio_id form-control" data-validation="required"  data-validation-error-msg-required="Please Select Option">
                                    <option value="" selected>Select Option</option>
                                    <option value="1">Poll</option>
                                    <option value="8">DropDownList</option>
                                    <option value="5">Text Box</option>
                                    <option value="4">Text Area</option>
                                    <option value="7">Checkbox (Single Question Yes/No)</option>
                                    <option value="2">Checkbox List</option>
                                    <option value="6">Radio Button List</option>
                                    <option value="3">Matrix</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-12 question questionMain">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="question">Question</label>
                                 <input class="form-control" id="question" name="question" value=""
                                    placeholder="Enter your question" type="text" data-validation="required"  data-validation-error-msg-required="Please Enter Question">
                              </div>
                           </div>
                           <div class="col-12 radio_id_sub_class" style="display:none">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="radio_id_sub">Select Points</label>
                                 <select name="radio_id_sub" id="radio_id_sub" class="radio_id_sub form-control" data-validation="required"  data-validation-error-msg-required="Please Select Points">
                                    
                                 </select>
                              </div>
                           </div>
                           <div class="appendRadio col-12" >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light">Save</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>