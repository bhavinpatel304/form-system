<div class="tab-pane fade show active" id="primary" role="tabpanel" aria-labelledby="home-tab">
   <div class="card-body">
      <div class="row">
         <div class="col-xl-6 col-lg-8">
            <div class="form-group">
               <label class="form-label " for="comp_id">Company Name <span
                  class="fill-start">*</span></label>
                

                   <select class="select2_cls form-control" name="comp_id" id="comp_id" data-validation="required"  >
                        <option value="">Please select</option>
                        @foreach($clients as $currclient)
                        <option value="{{ $currclient->id }}" @if($survey->comp_id == $currclient->id) selected  @endif >{{ $currclient->company_name }}</option>
                        @endforeach
                     </select>
            </div>
            <div class="form-group">
               <label class="form-label" for="survey_name">Survey Name <span
                  class="fill-start">*</span></label>
               <input class="form-control" id="survey_name" name="survey_name" placeholder="Enter survey name" type="text" value="{{ $survey->survey_name }}" data-validation="required">
            </div>
            <div class="form-group">
               <label class="form-label" for="max_invitations">#Invitations 
                  {{-- <span class="fill-start">*</span> --}}
               </label>
               <input class="form-control number" id="max_invitations" name="max_invitations" placeholder="Enter maximum invitations" type="text" value="{{ $survey->max_invitations }}" data-validation="" data-validation-optional="true">
            </div>
            <div class="d-flex row">
               <div class="form-group col-6">
                  <label class="form-label" for="start_date">Start Date 
                     {{-- <span class="fill-start">*</span> --}}
                  </label>
                  @php
                  if(!empty($survey->start_date)){
                     $start_date = \Carbon\Carbon::parse($survey->start_date)->format('m/d/Y');
                  }
                  else {                  
                     $start_date = '';
                  }
                  @endphp
                  <input class="datepicker form-control" placeholder="Start Date"
                     name="start_date" id="start_date" type="text" value="<?= $start_date ?>"  readonly
                     autocomplete="off"    data-validation-depends-on="end_date" />
               </div>
               <div class="form-group col-6">
                  <label class="form-label" for="end_date">End Date 
                     {{-- <span class="fill-start">*</span> --}}
                  </label>
                   @php
                  if(!empty($survey->end_date)){
                     $end_date = \Carbon\Carbon::parse($survey->end_date)->format('m/d/Y');
                  }
                  else {                  
                     $end_date = '';
                  }
                  @endphp
                  <input class="datepicker form-control" placeholder="End Date" name="end_date"
                     id="end_date" type="text"  readonly
                     autocomplete="off" value="<?= $end_date ?>"  data-validation-depends-on="start_date"  />
               </div>
            </div>
            {{-- <div class="form-group">
               <label class="form-label " for="status">Status</label>
               <select class="select2_cls form-control" name="status" id="status">
               <option value="1" @if($survey->status == 1) selected  @endif >Active</option>
               <option value="2" @if($survey->status == 2) selected  @endif  >Inactive</option>
               </select>
            </div> --}}
            <div class="form-group">
               <div class="checkbox">
                  <label class="pure-material-checkbox" for="show_logo">
                  <input type="checkbox" name="show_logo" id="show_logo" @if($survey->show_logo == 1) checked  @endif >
                  <span>Do you want to show Perception Mapping Logo?</span>
                  </label>
               </div>
            </div>
         </div>
         <div class="col-xl-6 col-lg-4">
            <div class="form-group ">
               <label class="form-label" for="survey_company_logo">Company Logo</label>
               <div class="thumbnail-img">
                  <span class="thumbnail thumb-lg">
                        <?php  $imageUrl = "" ?>
                  @if (!empty($survey->survey_company_logo) && file_exists($survey_company_thumb_path . $survey->survey_company_logo))
                  <?php  $imageUrl = url($survey_company_imgUrl) . '/' . $survey->survey_company_logo; ?>
                  <img src="<?= url($imageUrl); ?>" id="survey_company_logo_img" alt="company_logo" />
                  <input type="hidden" value="<?= url($imageUrl); ?>" name="survey_company_logo_dummy" id="survey_company_logo_dummy" />
                  @elseif (!empty($survey->company_logo) && file_exists($company_thumb_path . $survey->company_logo))
                  <?php  $imageUrl = url($imgUrl) . '/' . $survey->company_logo; ?>
                  <img src="<?= url($imageUrl); ?>" id="survey_company_logo_img" alt="company_logo" />
                  <input type="hidden" value="<?= url($imageUrl); ?>" name="survey_company_logo_dummy" id="survey_company_logo_dummy" />
                  @else
                  <img src="<?= $default_company_img; ?>" id="survey_company_logo_img" alt="company_logo" />
                  <input type="hidden" value="<?= $default_company_img; ?>" name="survey_company_logo_dummy" id="survey_company_logo_dummy" />
                  @endif
                  </span>
                  <div class="input-file-main mt-3">
                     <input type="file" name="survey_company_logo" id="survey_company_logo" />
                     
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="form-label" for="thankyou_description">Thank You Message</label>
               <textarea id="thankyou_description" name="thankyou_description"  cols="4" rows="4">{{ $survey->thankyou_description }}</textarea>
            </div>
         </div>
      </div>
   </div>
</div>