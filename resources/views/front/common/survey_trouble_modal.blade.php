<div class="modal fade" id="survey" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Please provide below details</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form role="form" id="survey-trouble" method="post">
            <div class="modal-body bg-light">
               <div class="card m-0">
                  <div class="card-body custom_form">
                     
                        <div class="form-group">
                           <label class="form-label" for="survey-number">Survey number  <span class="fill-start">*</span></label>
                           <input class="form-control" id="survey-number" placeholder="Please enter survey number"
                              type=" title " data-validation="required" data-validation-error-msg-required="Please enter survey number"">
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="name">Name <span class="fill-start">*</span></label>
                           <input class="form-control" id="name" placeholder="Please enter name " type=" title " data-validation="required" data-validation-error-msg-required="Please enter name">
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="email">Email <span class="fill-start">*</span></label>
                           <input class="form-control" id="email" placeholder="Please enter email " type=" title " data-validation="required email" data-validation-error-msg-required="Please enter email" data-validation-error-msg-email="Please enter valid email" />
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="issue">Issue <span class="fill-start">*</span></label>
                           <textarea name="survey_issue" id="issue" class="form-control" placeholder="Please enter issue" data-validation="required" data-validation-error-msg-required="Please enter issue"> </textarea>
                           
                        </div>
                     
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit"
                  class="btn btn-br-success btn-round btn-s-md  waves-effect waves-light" id="survey_trouble_submit">Send</button>
               <button type="button" class="btn btn-default  btn-round btn-s-md  waves-effect waves-light"
                  data-dismiss="modal">Close</button>
            </div>
            </form>
         </div>
      </div>
   </div>