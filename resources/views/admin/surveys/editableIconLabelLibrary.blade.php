<item-editor class="editableIcon">
    <div class="checkbox">
                  <label class="pure-material-checkbox" for="libraryQuestion_{{ $id }}">
                 <input type="checkbox" id="libraryQuestion_{{ $id }}" class="libraryQuestion" name="libraryQuestion[]"  value="{{ $id }}">
                  <span></span>
                  </label>
               </div>         
         <span class="icons deleteQuestionFromLibrary"  data-id="{{ $id }}" title="Delete From Library">
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
      </item-editor>