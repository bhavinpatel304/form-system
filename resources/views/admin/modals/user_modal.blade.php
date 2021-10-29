<div class="modal fade" id="usermodal" tabindex="-1" role="dialog" aria-labelledby="usersModal" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <div class="d-flex">
               <h5 class="modal-title">Users</h5>
            </div>
            <div class="ml-auto">
               <a href="#" class="btn btn-br-success btn-s-md   waves-effect waves-light "><i
                  class="fa fa-plus mr-2"></i>Add</a>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
         </div>
         <form role="form" action="">
            <div class="modal-body">
               <div class="card mb-3 custom_form">
                  <div class="userDetails">
                     <div class="row ">
                        <div class="col-sm-6 profile">
                           <div class="avatar">
                              <img src="{{ asset('images/user-1.jpg') }}" alt="Profile img">
                           </div>
                           <h6 class="users-name">
                              John Smith
                           </h6>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label class="form-label col-md-3" for="number">Clients <span
                              class="fill-start">*</span></label>
                           <select class="form-control select2_multiple" name="clients[]" multiple="multiple">
                              <option value="01">Bigleap Digital</option>
                              <option value="02">Rosterelf</option>
                              <option value="03">Technobrave</option>
                           </select>
                        </div>
                        <div class="iconDelete">
                           <a href="#">
                           <img src="{{ asset('images/delete.svg') }}" class="icon" alt="icon" width="20" height="30">
                           </a>
                        </div>
                     </div>
                  </div>
                  
                 
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary  btn-s-md  waves-effect waves-light">Submit</button>
               <button type="button" class="btn btn-br-danger  btn-s-md  waves-effect waves-light"
                  data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>