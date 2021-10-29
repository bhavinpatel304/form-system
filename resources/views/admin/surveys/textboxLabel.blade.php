<fieldset class="form-group edtior dataClass"  data-id="{{ $tmp_question_id }}">
                                 <div class="question-actions">
                                    @include('admin.surveys.editableIconLabel') 
                                 </div>
                                 <div class="form-edtior" @if($is_required == '1') style="border:1px solid red" @endif>
                                    <div class="editTitle">
                                       <div class="queTitle">
                                          {{-- Que:<span></span> --}}
                                          Q<span class="question_number">{{ $question_number }}</span>
                                       </div>
                                       <div class="inputBox">
                                          {{ $question }} 
                                       </div>
                                    </div>
                                    <div class="question_editable">
                                       <div class="question">

                                             <div class="inputBox">
                                                   <input class="form-control" id="text" value="" placeholder="" type="text" readonly />
                                                </div>                                       
                                          
                                       </div>
                                      

                                    </div>
                                 </div>
                              </fieldset>