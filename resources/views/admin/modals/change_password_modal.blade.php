<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="changepassword"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form role="form" method="POST" action="{{ route('changepassword') }}" novalidate id="changepasswordfrm">
            @csrf
            <div class="modal-body">
               <div class="card mb-3 custom_form">
                  <div class="card-body">
                     <div class="col-xs-12">
                        <div class="row">
                           <div class="col-12">
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="old_password">Old Password </label>
                                 <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="{{ old('old_password') }}"  required data-validation="required server"  data-validation-error-msg-required="{{ Lang::get('messages.old_password') }}"  data-validation-url="{{ route('checkoldpassword') }}" />                                
                              </div>
                            
                              <div class="form-group required">
                                 <label class="form-label col-md-3 " for="password">New Password </label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  required data-validation="required length" data-validation-length="min8" data-validation-error-msg-required="{{ Lang::get('messages.password') }}" data-validation-error-msg-length="Password must be atleast 8 characters long">                                
                              </div>

                            <div class="form-group required">
                                 <label class="form-label col-md-3" for="password-confirm">Confirm New Password</label>
                                 <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="password_confirmation" required data-validation="required length confirmation" data-validation-confirm="password" data-validation-length="min8" data-validation-error-msg-required="{{ Lang::get('messages.confirm_password') }}" data-validation-error-msg-confirmation="{{ Lang::get('messages.confirm_password_not') }}" data-validation-error-msg-length="Password must be atleast 8 characters long"> 
                            </div>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light">Change Password</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>