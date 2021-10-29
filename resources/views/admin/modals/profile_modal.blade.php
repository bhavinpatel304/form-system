<div class="modal fade" id="profilemodall" tabindex="-1" role="dialog" aria-labelledby="profilemodal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modalcustom" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">My Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form role="form" method="POST" action="{{ route('profile') }}" enctype="multipart/form-data" novalidate id="profile-edit">
            @csrf
            <div class="modal-body">
               <div class="card mb-3 custom_form">
                  <div class="card-body">
                     <div class="col-xs-12">
                        <div class="row">
                           <div class="col-12">
                              
                              <div class="form-group">
                                 <label class="form-label  col-md-3" for="profile_image">Profile Image
                                 
                                 </label>
                                 <div class="thumbnail-img">
                                    <span class="thumbnail">
                                    <?php 
                                       $imgUrl =  url(getenv('USER_THUMB_UPLOAD_PATH'));
                                       $user_original_path = public_path() . getenv('USER_ORIGINAL_UPLOAD_PATH');
                                       $user_thumb_path = public_path() . getenv('USER_THUMB_UPLOAD_PATH');
                                       
                                       
                                       ?>
 
                                      
                                     @if (empty(Auth::user()->profile_image) || !file_exists($user_thumb_path . Auth::user()->profile_image))
                                    <img src="{{ url('/images/' . env('DEFAULT_USER_IMAGE','')) }}" id="profile_photo_img" alt="profile_photo"  />
                                    @else
                                    @php  $imageUrl = url($imgUrl) . '/' . Auth::user()->profile_image; @endphp
                                    <img src="{{ url($imageUrl) }}" id="profile_photo_img" alt="profile_photo" />
                                    @endif

                                  
                                    {{-- <img src="{{ $profile_image }}" id="profile_photo_img" alt="profile_photo" /> --}}
                                    </span>

                                    <div class="input-file-main">
                              
                                       <input accept="image/*"  id="profile_image"  class="" name="profile_image" type="file" data-validation-allowing="jpg, png, jpeg"  data-validation="mime size" data-validation-error-msg-mime="{{ Lang::get('messages.profile_image.mime') }}" data-validation-max-size="1M" data-validation-error-msg-size="{{ Lang::get('messages.profile_image.size') }}" />
                                       
                                    </div>
                                 </div>
                              </div>
                              
                               <div class="form-group">
                                 <label class="form-label col-md-3" for="fname">First Name<span
                                    class="fill-start">*</span></label>
                                 <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" placeholder="Please enter first name" name="fname" value="{{ old('fname') ? old('fname') : Auth::user()->fname }}"  required required data-validation="required"  data-validation-error-msg-required="{{ Lang::get('messages.fname') }}" >
                              </div>
                              <div class="form-group">
                                 <label class="form-label col-md-3" for="lname">Last Name<span
                                    class="fill-start">*</span></label>
                                  <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') ? old('lname') : Auth::user()->lname }}"    data-validation="required"  data-validation-error-msg-required="{{ Lang::get('messages.lname') }}" placeholder="Please enter last name" >
                              </div>


                              <div class="form-group">
                                 <label class="form-label col-md-3" for="contact_number_profile">Mobile Number</label>
                                 <input id="contact_number_profile" type="text" class="form-control number @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') ? old('contact_number') : Auth::user()->contact_number }}" placeholder="Please enter mobile number"    data-validation=""  data-validation-error-msg-required="{{ Lang::get('messages.contact_number.required') }}" data-validation-error-msg-number="{{ Lang::get('messages.contact_number.numeric') }}"  >
                              </div>
                              <div class="form-group">
                                 <?php
                                    $json = json_encode(array(
                                                               'userId'=>Auth::user()->id,
                                                              
                                                            )
                                                      );
                                    ?>
                                 <label class="form-label col-md-3" for="emaill">Email<span
                                    class="fill-start">*</span></label>
                                 <input id="emaill" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}"   data-validation="required email server" data-validation-url="{{ route('checkemailprofileupdate') }}"
                                    data-validation-param-name="email"  data-validation-error-msg-required="{{ Lang::get('messages.email.required') }}" data-validation-error-msg-email="{{ Lang::get('messages.email.email') }}" data-validation-req-params='<?php echo $json ?>' placeholder="Please enter email" />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="update_profile_modal_btn"  class="btn btn-br-success  btn-s-md  waves-effect waves-light">Update Profile</button>
               <button type="button" class="btn btn-danger  btn-s-md  waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>