<fieldset class="edtior">
   {{-- <div class="question-actions">
      <item-editor class="editableIcon">         
         <span class="icons removeMe" title="Delete Question">
            <svg-icon class="svd-primary-icon">
               <svg class="svd-svg-icon">
                  <use xlink:href="#icon-actiondelete">
                     <symbol viewBox="0 0 16 16" id="icon-actiondelete">
                        <path
                           d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm3 8l-1 1-2-2-2 2-1-1 2-2-2-2 1-1 2 2 2-2 1 1-2 2 2 2z">
                        </path>
                     </symbol>
                  </use>
               </svg>
            </svg-icon>
         </span>
         <span class="action_separator"></span>
         <span class="icons" title="Is required?">
            <svg-icon class="svd-primary-icon">
               <svg class="svd-svg-icon">
                  <use xlink:href="#icon-actionisrequired">
                     <symbol viewBox="0 0 16 16" id="icon-actionisrequired">
                        <circle cx="7.5" cy="13.5" r="1.5"></circle>
                        <path d="M8 10l1-9H6l1 9z"></path>
                     </symbol>
                  </use>
               </svg>
            </svg-icon>
         </span>
         <span class="action_separator"></span>
         <span class="icons cloneMe" title="Copy">
            <svg-icon class="svd-primary-icon">
               <svg class="svd-svg-icon">
                  <use xlink:href="#icon-actioncopy">
                     <symbol viewBox="0 0 16 16" id="icon-actioncopy">
                        <path d="M2 6h9v9H2z"></path>
                        <path d="M5 3v2h7v7h2V3z"></path>
                     </symbol>
                  </use>
               </svg>
            </svg-icon>
         </span>
         <span class="action_separator"></span>
         <span class="icons" title="Add toolbox">
            <select class="select2_cls form-control replaceQuestion">
               <option value="">Select Type</option>
               <option value="1">Radiogroup</option>
               <option value="2">Checkboxes</option>
               <option value="3">Matrix</option>
               <option value="4">Comment</option>
               <option value="5">Single textbox</option>
            </select>
         </span>
      </item-editor>
   </div> --}}
   <div class="form-edtior">
   {{-- <div class="editTitle">
      <div class="queTitle">
         Q<span></span>
      </div>
      <div class="inputBox">
         <input class="form-control" id="text" value=""
            placeholder="Enter your question" type="text">
      </div>
   </div> --}}
   <div class="question_editable">
      <div class="question">
         <div class="inputBox">
            <textarea placeholder="Comment" type="text" class="text-area" rows="1"
               cols="1" onkeyup="auto_grow(this)" id="singletextarea" name="singletextarea"></textarea>
         </div>
      </div>   
   </div>
</fieldset>