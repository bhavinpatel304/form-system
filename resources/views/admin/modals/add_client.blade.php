<!-- Add company modal popup Start -->
   <div class="modal fade" id="addcompany" tabindex="-1" role="dialog" aria-labelledby="addcompanyy" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Add Client</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form role="form" method="POST"  action="{{ route('addcompany') }}" id="addcompanyfrm" novalidate enctype="multipart/form-data" >
                @csrf
               <div class="modal-body">
                  <div class="card mb-3 custom_form">
                     <div class="card-body">
                        <div class="col-xs-12">
                           <div class="row">
                              <div class="col-12">
                                 <div class="form-group">
                                    <label class="form-label  col-md-3" for="company_logo">Company Logo 
                                       {{-- <span class="fill-start">*</span> --}}
                                    </label>

                                    <div class="thumbnail-img">
                                       
                                       <span class="thumbnail companyLogo"><img src="{{ url('/images/' . env('DEFAULT_COMPANY_IMAGE','')) }}"
                                             id="company_logo_img" alt="company_logo"></span>
                                       <div class="input-file-main">
                                           <input accept="image/*"  id="company_logo"  class="" name="company_logo" type="file" data-validation=" mime size" data-validation-allowing="jpg, png, jpeg"   data-validation-error-msg-required="{{ Lang::get('messages.company_logo.required') }}" data-validation-error-msg-mime="{{ Lang::get('messages.company_logo.mime') }}" data-validation-error-msg-size="{{ Lang::get('messages.company_logo.size') }}" data-validation-max-size="1M"  />
                                       
                                       </div>
                                    </div>


                                 </div>
                                 <div class="form-group">
                                    <label class="form-label col-md-3" for="company_name">Company Name <span
                                          class="fill-start">*</span></label>
                                   <input class="form-control" name="company_name" id="company_name" placeholder="Please enter company name"
                                       type="text"  data-validation="required server"  data-validation-error-msg-required="{{ Lang::get('messages.company_name') }}" data-validation-url="{{ route('checkclientname') }}" />
                                 </div>

                                 <div class="form-group">
                                    <label class="form-label col-md-3" for="contact_number">Mobile Number </label>
                                    <input class="form-control number" id="contact_number" placeholder="Please enter mobile number"
                                       type="text" name="contact_number"  data-validation=""  data-validation-error-msg-required="{{ Lang::get('messages.contact_number.required') }}" data-validation-error-msg-number="{{ Lang::get('messages.contact_number.numeric') }}" />
                                 </div>
                                 <div class="form-group">
                                    <label class="form-label col-md-3" for="email">Email </label>
                                    <input class="form-control" id="email" name="email" placeholder="Please enter email" type="text" data-validation=" email" data-validation-error-msg-required="{{ Lang::get('messages.email.required') }}" data-validation-error-msg-email="{{ Lang::get('messages.email.email') }}" data-validation-optional="true" />
                                 </div>
                                 <div class="form-group">
                                    <label class="form-label col-md-3" for="website">Website </label>
                                    <input class="form-control" id="website" name="website" placeholder="http://www.example.com"
                                       type="text" data-validation=" url"  data-validation-error-msg-required="{{ Lang::get('messages.website.required') }}" data-validation-error-msg-url="{{ Lang::get('messages.website.url') }}" data-validation-optional="true" />
                                 </div>
                                 <div class="form-group">
                                    <label class="form-label col-md-3 align-items-start" for="description">Description </label>
                                    <textarea placeholder="Please enter description" autocomplete="off" role="textbox"
                                       aria-autocomplete="list" aria-haspopup="true" id="description" name="description" ></textarea>
                                 </div>

                                 {{-- <div class="form-group">
                                     <label class="form-label col-md-3" for="status">Status <span
                                        class="fill-start">*</span></label>
                                     <select class="form-control select2_multiple" name="status" id="status">
                                        <option value="1" selected>Active</option>
                                        <option value="2" >Inactive</option>
                                        
                                     </select>
                                  </div> --}}

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-br-success  btn-s-md  waves-effect waves-light">Add Client</button>
                  <button type="button" class="btn btn-br-danger  btn-s-md  waves-effect waves-light"
                     data-dismiss="modal">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
    <!-- Add company modal popup End-->