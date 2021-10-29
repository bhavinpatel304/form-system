<fieldset class="form-group edtior dataClass" data-id="{{ $tmp_question_id }}">
                                 <div class="question-actions">
                                    @include('admin.surveys.editableIconLabel') 
                                 </div>
                                 <div class="form-edtior" @if($is_required == '1') style="border:1px solid red" @endif>
                                    <div class="editTitle">
                                       <div class="queTitle">
                                          Q<span class="question_number">{{ $question_number }}</span>
                                       </div>
                                       <div class="inputBox">
                                          {{ $question }}
                                       </div>
                                    </div>
                                    <div class="question_editable">
                                       
                                       @foreach($question_points as $qs)
                                          <div class="question">
                                                <div class="ans">
                                                      {{-- <input type="checkbox"  value=""> --}}
                                                   <div class="checkbox">
                                                      <label class="pure-material-checkbox">
                                                         <input type="checkbox" disabled value="">
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                                <div class="inputBox">
                                                  {{ $qs }}
                                                </div>
                                             </div>
                                       @endforeach
                                             

                                    </div>
                                 </div>
                              </fieldset>