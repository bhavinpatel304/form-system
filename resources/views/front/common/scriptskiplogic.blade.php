<script>
    $(document.body).on("change",".questionSkipLogic",function(){    
        var selectedAnswer = $(this).val();        
        var questionType = $(this).closest('.mainQuestionClass').attr("data-questiontype");
        var questionId = $(this).closest('.mainQuestionClass').attr("data-id");
        var skipLogicMode = 'preview';
        var url = '{{ route("skipLogicShowHideQuestion") }}';
        var routeName = '{{ Route::currentRouteName() }}';

        // for single checkbox 
        if(questionType == '7'){
            if($(this).is(":not(:checked)"))
            {            
                selectedAnswer = '';
            }
        }

        // for checkbox list 
        if(questionType == '2'){
            var finalAnswers = [];
            var checkBoxes = $(this).closest('.mainQuestionClass').find(".questionSkipLogic");
            $(checkBoxes).each(function () {
                if($(this).is(":checked")){
                    finalAnswers.push($(this).val());                     
                }
            });
            if(finalAnswers.length > 0){
                selectedAnswer = finalAnswers.join("###");
            }else {
                selectedAnswer = '';
            }

        }
        

        if(routeName == 'surveyform'){
            skipLogicMode = 'front';
        }
         data = {
                     'selectedAnswer': selectedAnswer,
                     'questionType': questionType,
                     'questionId': questionId,
                     'skipLogicMode':skipLogicMode,                     
                    };     
         $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: data,
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        
                        $('.loading_footer').hide();    
                        var data = JSON.parse(data);
                        var is_data_available = data.is_data_available;
                        // var is_answer_correct = data.is_answer_correct;
                        var is_required = data.is_required;
                        var singleQuestionIdToShow = data.singleQuestionIdToShow;

                        var arrQuestionIdsToHideCount = Object.keys(data.arrQuestionIdsToHide).length;
                        if(arrQuestionIdsToHideCount > 0){
                            $.each(data.arrQuestionIdsToHide, function(key, value) {
                                
                                var question_id = value;
                                $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').hide();
                                var questionType =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]');
                                questionType = $(questionType).data('questiontype');                                

                             });   
                        }

                        // if(singleQuestionIdToShow !== ''){
                        //     var question_id = singleQuestionIdToShow;
                        //     $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').show();
                        // }
                           
                        var arrQuestionIdsToShowCount = Object.keys(data.arrQuestionIdsToShow).length;
                         if(arrQuestionIdsToShowCount > 0){

                              $.each(data.arrQuestionIdsToShow, function(key, value) {
                                  
                                var question_id = value.question_id;
                                
                                var is_required = value.is_required;
                                var is_answer_correct = value.is_answer_correct;
                                 $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').show();
                                var questionType =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]');
                                questionType = $(questionType).data('questiontype');


                                removeRequiredForHiddenQuestions(question_id,questionType,is_required,is_answer_correct);
                            });

                         }





                        var arrIsRequiredCount = Object.keys(data.arr_is_required).length;
                        if(arrIsRequiredCount > 0){

                            $.each(data.arr_is_required, function(key, value) {
                                var question_id = value.question_id;
                                
                                var is_required = value.is_required;
                                var is_answer_correct = value.is_answer_correct;
                                
                                var questionType =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]');
                                questionType = $(questionType).data('questiontype');


                                removeRequiredForHiddenQuestions(question_id,questionType,is_required,is_answer_correct);
                            });
                        }

                                           
                       
                     },error: function(data) {
                       
                     }
               });
         
    });
    function removeRequiredForHiddenQuestions(question_id,questionType,is_required,is_answer_correct)
    {
         // for poll
        if(questionType == '1')
        {
            var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(allInputs.length > 0)
            {
                if(is_required == '1')
                {
                    if(is_answer_correct)
                    {
                        
                            $( allInputs ).each(function() {
                                $($(this)).removeClass('required').addClass('required');
                                
                            });
                        
                    }else {
                        $( allInputs ).each(function() {
                            $($(this)).removeClass('required');
                        
                        });
                    }
                }
                else 
                {
                    
                    $( allInputs ).each(function() {
                        $($(this)).removeClass('required');
                        
                    });
                
                }
            }
            
        }

        
        // for dropdown list
        if(questionType == '8')
        {
            var selectBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("select");

            if(is_required == '1')
            {
                if(is_answer_correct)
                {
                    $(selectBox).removeClass('required').addClass('required');                                            
                }else 
                {   
                    $(selectBox).removeClass('required');  
                }
            }
            else 
            {   
                $(selectBox).removeClass('required');  
            }
        }


        // for textbox
        if(questionType == '5')
        {
            var inputBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(is_required == '1')
            {
                if(is_answer_correct)
                {
                    $(inputBox).removeClass('required').addClass('required');                                            
                }else 
                {   
                    $(inputBox).removeClass('required');  
                }
            }
            else 
            {   
                $(inputBox).removeClass('required');  
            }
        }

        // for textarea
        if(questionType == '4')
        {
            // console.log(question_id);
            // console.log(is_required);
            var textAreaBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("textarea");

            if(is_required == '1')
            {
                if(is_answer_correct)
                {
                    $(textAreaBox).removeClass('required').addClass('required');                                            
                }else 
                {   
                    $(textAreaBox).removeClass('required');  
                }
            }
            else 
            {   
                $(textAreaBox).removeClass('required');  
            }
        }


        // for single checkbox
        if(questionType == '7')
        {
            var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(allInputs.length > 0)
            {
                if(is_required == '1')
                {
                    if(is_answer_correct)
                    {
                        
                            $( allInputs ).each(function() {
                                $($(this)).removeClass('required').addClass('required');
                                
                            });
                        
                    }else {
                        $( allInputs ).each(function() {
                            $($(this)).removeClass('required');
                        
                        });
                    }
                }
                else 
                {
                    
                    $( allInputs ).each(function() {
                        $($(this)).removeClass('required');
                        
                    });
                
                }
            }
        }

        // for checkbox list 
        if(questionType == '2')
        {
            var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(allInputs.length > 0)
            {
                if(is_required == '1')
                {
                    if(is_answer_correct)
                    {
                        
                            $( allInputs ).each(function() {
                                $($(this)).removeClass('required').addClass('required');
                                
                            });
                        
                    }else {
                        $( allInputs ).each(function() {
                            $($(this)).removeClass('required');
                        
                        });
                    }
                }
                else 
                {
                    
                    $( allInputs ).each(function() {
                        $($(this)).removeClass('required');
                        
                    });
                
                }
            }
        }

        // for radio button list 
        if(questionType == '6')
        {  
            var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(allInputs.length > 0)
            {
                if(is_required == '1')
                {
                    if(is_answer_correct)
                    {
                        
                            $( allInputs ).each(function() {
                                $($(this)).removeClass('required').addClass('required');
                                
                            });
                        
                    }else {
                        $( allInputs ).each(function() {
                            $($(this)).removeClass('required');
                        
                        });
                    }
                }
                else 
                {
                    
                    $( allInputs ).each(function() {
                        $($(this)).removeClass('required');
                        
                    });
                
                }
            }

        }


            // for matrix
        if(questionType == '3')
        { 
            var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

            if(allInputs.length > 0)
            {
                if(is_required == '1')
                {
                    if(is_answer_correct)
                    {
                        
                            $( allInputs ).each(function() {
                                $($(this)).removeClass('required').addClass('required');
                                
                            });
                        
                    }else {
                        $( allInputs ).each(function() {
                            $($(this)).removeClass('required');
                        
                        });
                    }
                }
                else 
                {
                    
                    $( allInputs ).each(function() {
                        $($(this)).removeClass('required');
                        
                    });
                
                }
            }
        }
        
    }
    // $(document.body).on("change",".questionSkipLogic",function(){    
    //     var selectedAnswer = $(this).val();        
    //     var questionType = $(this).closest('.mainQuestionClass').attr("data-questiontype");
    //     var questionId = $(this).closest('.mainQuestionClass').attr("data-id");
    //     var skipLogicMode = 'preview';
    //     var url = '{{ route("skipLogicShowHideQuestion") }}';
    //     var routeName = '{{ Route::currentRouteName() }}';

    //     // console.log(questionType);

    //     // for single checkbox 
    //     if(questionType == '7'){
    //         if($(this).is(":not(:checked)"))
    //         {            
    //             selectedAnswer = '';
    //         }
    //     }

    //     // for checkbox list 
    //     if(questionType == '2'){
    //         var finalAnswers = [];
    //         var checkBoxes = $(this).closest('.mainQuestionClass').find(".questionSkipLogic");
    //         $(checkBoxes).each(function () {
    //             if($(this).is(":checked")){
    //                 finalAnswers.push($(this).val());                     
    //             }
    //         });
    //         if(finalAnswers.length > 0){
    //             selectedAnswer = finalAnswers.join("###");
    //         }else {
    //             selectedAnswer = '';
    //         }

    //     }
    //     //console.log(selectedAnswer);

    //     if(routeName == 'surveyform'){
    //         skipLogicMode = 'front';
    //     }
    //      data = {
    //                  'selectedAnswer': selectedAnswer,
    //                  'questionType': questionType,
    //                  'questionId': questionId,
    //                  'skipLogicMode':skipLogicMode,                     
    //                 };     
    //      $.ajax({
    //                  url: url,
    //                  headers: {
    //                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                  },
    //                   data: data,
    //                  method: 'post',
    //                  beforeSend: function() {
    //                     $('.loading_footer').css('display', 'flex');
    //                  },
    //                  success: function(data) {
                        
    //                      $('.loading_footer').hide();    
    //                      var data = JSON.parse(data);
    //                         var is_data_available = data.is_data_available;
    //                        var is_answer_correct = data.is_answer_correct;
    //                        var is_required = data.is_required;
                           
    //                        if(is_data_available){
    //                         var question_id = data.data.question_id;    

    //                         if(is_required != ''){
    //                             var questionType =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]');
    //                             questionType = $(questionType).data('questiontype');
                                
    //                             // for poll
    //                             if(questionType == '1')
    //                             {
    //                                 var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(allInputs.length > 0)
    //                                 {
    //                                     if(is_required == '1')
    //                                     {
    //                                         if(is_answer_correct)
    //                                         {
                                                
    //                                                 $( allInputs ).each(function() {
    //                                                     $($(this)).removeClass('required').addClass('required');
                                                        
    //                                                 });
                                                
    //                                         }else {
    //                                             $( allInputs ).each(function() {
    //                                                 $($(this)).removeClass('required');
                                                
    //                                             });
    //                                         }
    //                                     }
    //                                     else 
    //                                     {
                                            
    //                                         $( allInputs ).each(function() {
    //                                             $($(this)).removeClass('required');
                                                
    //                                         });
                                        
    //                                     }
    //                                 }
                                    
    //                             }

                                
    //                             // for dropdown list
    //                             if(questionType == '8')
    //                             {
    //                                 var selectBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("select");

    //                                 if(is_required == '1')
    //                                 {
    //                                     if(is_answer_correct)
    //                                     {
    //                                         $(selectBox).removeClass('required').addClass('required');                                            
    //                                     }else 
    //                                     {   
    //                                         $(selectBox).removeClass('required');  
    //                                     }
    //                                 }
    //                                 else 
    //                                 {   
    //                                     $(selectBox).removeClass('required');  
    //                                 }
    //                             }


    //                             // for textbox
    //                             if(questionType == '5')
    //                             {
    //                                 var inputBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(is_required == '1')
    //                                 {
    //                                     if(is_answer_correct)
    //                                     {
    //                                         $(inputBox).removeClass('required').addClass('required');                                            
    //                                     }else 
    //                                     {   
    //                                         $(inputBox).removeClass('required');  
    //                                     }
    //                                 }
    //                                 else 
    //                                 {   
    //                                     $(inputBox).removeClass('required');  
    //                                 }
    //                             }

    //                             // for textarea
    //                             if(questionType == '4')
    //                             {
    //                                 // console.log(question_id);
    //                                 // console.log(is_required);
    //                                 var textAreaBox =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("textarea");

    //                                 if(is_required == '1')
    //                                 {
    //                                     if(is_answer_correct)
    //                                     {
    //                                         $(textAreaBox).removeClass('required').addClass('required');                                            
    //                                     }else 
    //                                     {   
    //                                         $(textAreaBox).removeClass('required');  
    //                                     }
    //                                 }
    //                                 else 
    //                                 {   
    //                                     $(textAreaBox).removeClass('required');  
    //                                 }
    //                             }


    //                             // for single checkbox
    //                             if(questionType == '7')
    //                             {
    //                                 var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(allInputs.length > 0)
    //                                 {
    //                                     if(is_required == '1')
    //                                     {
    //                                         if(is_answer_correct)
    //                                         {
                                                
    //                                                 $( allInputs ).each(function() {
    //                                                     $($(this)).removeClass('required').addClass('required');
                                                        
    //                                                 });
                                                
    //                                         }else {
    //                                             $( allInputs ).each(function() {
    //                                                 $($(this)).removeClass('required');
                                                
    //                                             });
    //                                         }
    //                                     }
    //                                     else 
    //                                     {
                                            
    //                                         $( allInputs ).each(function() {
    //                                             $($(this)).removeClass('required');
                                                
    //                                         });
                                        
    //                                     }
    //                                 }
    //                             }

    //                             // for checkbox list 
    //                             if(questionType == '2')
    //                             {
    //                                 var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(allInputs.length > 0)
    //                                 {
    //                                     if(is_required == '1')
    //                                     {
    //                                         if(is_answer_correct)
    //                                         {
                                                
    //                                                 $( allInputs ).each(function() {
    //                                                     $($(this)).removeClass('required').addClass('required');
                                                        
    //                                                 });
                                                
    //                                         }else {
    //                                             $( allInputs ).each(function() {
    //                                                 $($(this)).removeClass('required');
                                                
    //                                             });
    //                                         }
    //                                     }
    //                                     else 
    //                                     {
                                            
    //                                         $( allInputs ).each(function() {
    //                                             $($(this)).removeClass('required');
                                                
    //                                         });
                                        
    //                                     }
    //                                 }
    //                             }

    //                             // for radio button list 
    //                             if(questionType == '6')
    //                             {  
    //                                 var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(allInputs.length > 0)
    //                                 {
    //                                     if(is_required == '1')
    //                                     {
    //                                         if(is_answer_correct)
    //                                         {
                                                
    //                                                 $( allInputs ).each(function() {
    //                                                     $($(this)).removeClass('required').addClass('required');
                                                        
    //                                                 });
                                                
    //                                         }else {
    //                                             $( allInputs ).each(function() {
    //                                                 $($(this)).removeClass('required');
                                                
    //                                             });
    //                                         }
    //                                     }
    //                                     else 
    //                                     {
                                            
    //                                         $( allInputs ).each(function() {
    //                                             $($(this)).removeClass('required');
                                                
    //                                         });
                                        
    //                                     }
    //                                 }

    //                             }


    //                              // for matrix
    //                             if(questionType == '3')
    //                             { 
    //                                 var allInputs =  $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').find("input");

    //                                 if(allInputs.length > 0)
    //                                 {
    //                                     if(is_required == '1')
    //                                     {
    //                                         if(is_answer_correct)
    //                                         {
                                                
    //                                                 $( allInputs ).each(function() {
    //                                                     $($(this)).removeClass('required').addClass('required');
                                                        
    //                                                 });
                                                
    //                                         }else {
    //                                             $( allInputs ).each(function() {
    //                                                 $($(this)).removeClass('required');
                                                
    //                                             });
    //                                         }
    //                                     }
    //                                     else 
    //                                     {
                                            
    //                                         $( allInputs ).each(function() {
    //                                             $($(this)).removeClass('required');
                                                
    //                                         });
                                        
    //                                     }
    //                                 }
    //                             }
    //                            // console.log(questionType);
                                    

    //                         }
    //                             if(is_answer_correct){
                                    
    //                                 // $(document.body).find('.mainQuestionClass').attr("data-id",question_id).show();
    //                                 $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').show();
                                    
                                    
    //                             }else{
    //                                 //console.log(question_id);
    //                                 $(document.body).find('.mainQuestionClass[data-id="' + question_id + '"]').hide();
    //                                 //$(document.body).find('.mainQuestionClass').attr("data-id",question_id).hide();
    //                                 // $(this).closest('.mainQuestionClass').find("data-id",question_id).hide();
    //                             }
                             
    //                        }
                                           
                       
    //                  },error: function(data) {
                       
    //                  }
    //            });
         
    // });
</script>