<item-editor class="editableIcon">
          
           {{-- <span class="icons addQuestionToLibrary" data-id="{{ $tmp_question_id }}" title="Add to Library">
             <span class="text"><i class="fa fa-plus mr-2"></i>Add to Library</span>
            </span> --}}
            <span class="icons addQuestionToLibraryPopup" data-id="{{ $tmp_question_id }}" title="Add to Library">
             <span class="text"><i class="fa fa-plus mr-2"></i>Add to Library</span>
            </span>
          <span class="action_separator"></span>
          
          <span class="icons editQuestion" data-id="{{ $tmp_question_id }}" title="Edit">
             <svg-icon class="svd-primary-icon">
                <svg class="svd-svg-icon">
                   <use xlink:href="#icon-inplaceedit">
                      <symbol viewBox="0 0 12 12" id="icon-inplaceedit">
                         <path d="M1 11h3L1 8zM6 3L2 7l3 3 4-4zM11 4L8 1 7 2l3 3zM7 10h5v1H7z">
                         </path>
                      </symbol>
                   </use>
                </svg>
             </svg-icon>
             <span class="text">Edit</span>
          </span>
          <span class="action_separator"></span>
          <span class="icons deleteQuestion" data-id="{{ $tmp_question_id }}" title="Delete Question">
             <svg-icon class="svd-primary-icon">
                <svg class="svd-svg-icon">
                   <use xlink:href="#icon-actiondelete">
                      <symbol viewBox="0 0 16 16" id="icon-actiondelete">
                         <path d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm3 8l-1 1-2-2-2 2-1-1 2-2-2-2 1-1 2 2 2-2 1 1-2 2 2 2z">
                         </path>
                      </symbol>
                   </use>
                </svg>
             </svg-icon>
          </span>
         <span class="action_separator"></span>
         <span class="icons requireQuestion" data-id="{{ $tmp_question_id }}" title="Is required?" data-is-required="{{ $is_required }}">
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
          <span class="icons cloneQuestion" title="Copy" data-id="{{ $tmp_question_id }}">
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
           <span class="icons skipLogicPopup" data-id="{{ $tmp_question_id }}" title="Skip Logic">
             <span class="text">Skip Logic&nbsp;</span>
            </span>
           <div class="checkbox">
                  <label class="pure-material-checkbox" for="clsSkipLogic_{{ $tmp_question_id }}">
                 <input type="checkbox" id="clsSkipLogic_{{ $tmp_question_id }}" class="clsSkipLogic" name="clsSkipLogic[]"  value="{{ $tmp_question_id }}" @if($is_skip_logic_avail == '1') checked @endif >
                  <span></span>
                  </label>
               </div> 
       </item-editor>