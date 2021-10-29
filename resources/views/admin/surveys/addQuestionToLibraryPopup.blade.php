<div class="modal fade" id="addQuestionToLibraryModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionToLibraryModal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add To Library</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form role="form" method="POST" action="" novalidate id="addQuestionToLibraryModalfrm">
            @csrf
            <input type="hidden" name="tmp_id" id="tmp_id" value="" />
            <div class="modal-body">
               <div class="form-group">
                  <label class="form-label " for="template_name">Select Library <span class="fill-start">*</span></label>
                  <select  class="select2_cls form-control selectLibraryemplate" name="template_name" id="template_name" data-validation="required" data-validation-error-msg-required="Please select library"   >
                     <option value="" selected>Please select</option>
                  </select>
                  <div id="template_id"></div>
               </div>
               <div class="form-group template_new" style="display:none;">
                    <?php
                                    $json = json_encode(array(
                                                               'userId'=>Auth::user()->id,
                                                              
                                                            )
                                                      );
                                    ?>
                                    
                  <label class="form-label" for="template_new">Library Name <span
                     class="fill-start">*</span></label>
                  <input class="form-control" id="template_new" name="template_new" placeholder="Enter library name" type="text" data-validation="required server"  data-validation-depends-on="template_name" 
                     data-validation-depends-on-value="0" data-validation-error-msg-container="#template_new_name" data-validation-error-msg-required="Please enter library name" data-validation-req-params='<?php echo $json ?>' placeholder="Please enter email" data-validation-url="{{ route('checkQuestionTemplateName') }}">
                  <div id="template_new_name"></div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light" >Add</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>