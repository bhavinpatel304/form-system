<div class="tab-pane fade" id="welcome" role="tabpanel" aria-labelledby="welcome-tab">
   
   <div class="card-body">
      <div class="row">
         <div class="col-lg-6">
            <div class="file-upload">
               <div class="image-upload-wrap">
                  <div class="drag-text">
                     <h3>Drag and drop a file or select add Image</h3>
                     <button class="btn btn-primary btn-s-md file-upload-btn mt-3 add_welcome_image" type="button"
                        >Add
                     Image</button>
                     <input class="file-upload-input" name="welcome_image" id="welcome_image" type='file' 
                        accept="image/*" />
                  </div>
               </div>
               <div class="file-upload-content">
                  <div class="image-upload">
                     @if (!empty($survey->welcome_image) && file_exists($welcome_image_path . $survey->welcome_image))
                              <?php  $welcomeimgUrl = url($welcomeimgUrl) . '/' . $survey->welcome_image; ?>
                        <img class="file-upload-image"  alt="your image"  id="welcome_image_img" src="<?= url($welcomeimgUrl); ?>" />
                     @else 
                              <?php  $welcomeimgUrl = asset('images/image.png'); ?>
                     <img class="file-upload-image" src="{{asset('images/image.png')}}" alt="your image"  id="welcome_image_img" />
                      @endif
                  </div>
                  <div class="image-title-wrap">
                     <a href="javascript:void(0)" onclick="removeUpload('welcome_image')">
                     <img src="{{asset('images/delete.svg')}}" class="icon" alt="icon" width="23"
                        height="30">
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <textarea id="welcome_description" name="welcome_description">
               {{ $survey->welcome_description }}
            </textarea>
            
            <textarea style="display:none" id="welcome_description_dummy" name="welcome_description_dummy">
                 
               </textarea>
         </div>
      </div>
   </div>
   <input type="hidden" value="<?= url($welcomeimgUrl); ?>" name="welcome_image_dummy" value="" id="welcome_image_dummy" />
</div>