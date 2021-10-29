<div class="tab-pane fade show active" id="primary" role="tabpanel" aria-labelledby="home-tab">
   <div class="card-body ">
      <div class="row">
         <div class="col-xl-6 col-lg-8">
            
            <div class="form-group">
               <label class="form-label " for="comp_id">Company Name <span
                  class="fill-start">*</span></label>
                 

                   <select  class="select2_cls form-control" name="comp_id" id="comp_id" data-validation="required" >
                  <option value="">Please select</option>
                  @foreach($clients as $currclient)
                  <option value="{{ $currclient->id }}" >{{ $currclient->company_name }}</option>
                  @endforeach
               </select>
               
            </div>
            <div class="form-group">
               <label class="form-label" for="survey_name">Survey Name <span
                  class="fill-start">*</span></label>
               <input class="form-control" id="survey_name" name="survey_name" placeholder="Enter survey name" type="text" data-validation="required">
            </div>
            <div class="form-group">
               <label class="form-label" for="max_invitations">#Invitations 
                  {{-- <span class="fill-start">*</span> --}}
               </label>
               <input class="form-control number" id="max_invitations" name="max_invitations" placeholder="Enter maximum invitations" type="text" data-validation="" data-validation-optional="true"  >
            </div>
            <div class="d-flex row">
               <div class="form-group col-6">
                  <label class="form-label" for="start_date">Start Date 
                     {{-- <span class="fill-start">*</span> --}}
                  </label>
                  <input class="datepicker form-control" placeholder="Start Date"
                     name="start_date" id="start_date" type="text"  readonly
                     autocomplete="off" data-validation="" data-validation-optional="true"  />
               </div>
               <div class="form-group col-6">
                  <label class="form-label" for="end_date">End Date 
                     {{-- <span class="fill-start">*</span> --}}
                  </label>
                  <input class="datepicker form-control" placeholder="End Date" name="end_date"
                     id="end_date" type="text"  readonly
                     autocomplete="off" data-validation="" data-validation-optional="true" />
               </div>
            </div>
            <div class="form-group">
               <div class="checkbox">
                  <label class="pure-material-checkbox" for="show_logo">
                  <input type="checkbox" name="show_logo" id="show_logo">
                  <span>Do you want to show Perception Mapping Logo?</span>
                  </label>
               </div>
            </div>
         </div>
         <div class="col-xl-6 col-lg-4">
            <div class="form-group ">
               <label class="form-label" for="survey_company_logo">Company Logo</label>
               <div class="thumbnail-img">
                  <span class="thumbnail thumb-lg"><img src="<?= $default_company_img; ?>"
                     id="survey_company_logo_img" alt="profile_photo"></span>
                  <div class="input-file-main mt-3">
                     <input type="file" name="survey_company_logo" id="survey_company_logo" />
                     <input type="hidden" value="" name="survey_company_logo_dummy" id="survey_company_logo_dummy" />
                  </div>
               </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="thankyou_description">Thank You Message</label>
               <textarea id="thankyou_description" name="thankyou_description"  cols="4" rows="4" >This survey is now completed and your participation has been recorded successfully.</textarea>
            </div>
         </div>
      </div>
   </div>
</div>