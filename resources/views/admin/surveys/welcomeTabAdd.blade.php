<div class="tab-pane fade" id="welcome" role="tabpanel" aria-labelledby="welcome-tab">
   <input type="hidden" value="" name="welcome_image_dummy" value="" id="welcome_image_dummy" />
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

                     <img class="file-upload-image" src="{{asset('images/image.png')}}" alt="your image"  id="welcome_image_img" />
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
                  <p> Welcome to the 2018 ARTC Employee Survey. The questions and statements should
                                          take less than 10
                                          minutes to complete.
                  </p>
                                       <p>
                                          PRIVACY: Your responses to the following questions are 100 percent anonymous.
                                          No individual
                                          responses are made available to management. All data is privately held by
                                          Perception Mapping Pty
                                          Ltd and is never shown to any third party.
                                       </p>
                                       <p>
                                          Please read the questions and statements carefully and complete your responses
                                          as quickly as
                                          possible. If you are interrupted while completing the survey, please just
                                          minimize the window
                                          and resume as soon as you are ready.
                                       </p>
                                       <p>
                                          Please contact Cassandra Carcary on 02 4941 9622 or ccarcary@artc.com.au with
                                          any questions regarding
                                          completing this survey.
                                       </p>
                                       <p>
                                          Thank you for your participation, your responses are valued!
                                       </p>
            </textarea>

            <textarea id="welcome_description" name="welcome_description_dummy" style="display:none">
                  <p> Welcome to the 2018 ARTC Employee Survey. The questions and statements should
                                          take less than 10
                                          minutes to complete.
                  </p>
                                       <p>
                                          PRIVACY: Your responses to the following questions are 100 percent anonymous.
                                          No individual
                                          responses are made available to management. All data is privately held by
                                          Perception Mapping Pty
                                          Ltd and is never shown to any third party.
                                       </p>
                                       <p>
                                          Please read the questions and statements carefully and complete your responses
                                          as quickly as
                                          possible. If you are interrupted while completing the survey, please just
                                          minimize the window
                                          and resume as soon as you are ready.
                                       </p>
                                       <p>
                                          Please contact Cassandra Carcary on 02 4941 9622 or ccarcary@artc.com.au with
                                          any questions regarding
                                          completing this survey.
                                       </p>
                                       <p>
                                          Thank you for your participation, your responses are valued!
                                       </p>
            </textarea>

            {{-- <div class="pr-5 welcomeEdit">

            </div> --}}
         </div>
      </div>
   </div>
</div>
