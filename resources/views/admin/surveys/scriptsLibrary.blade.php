<script>
   $(document.body).on("click",".deleteQuestionFromLibrary",function(){
        toastr.remove();
        var id = $(this).data('id');    
        var template_id = $("#questionLibraryModal  #template_id").val();
        

         var $this = $(this);
        var url = '{{ route("removeQuestionFromLibrary") }}';
        
        
        $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: {
                        id: id,
                        template_id:template_id
                     },
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {                        
                        $('.loading_footer').hide();     
                        //$($this).closest("fieldset").remove();     
                        
                        toastr["success"]("Question removed from library.");  
                         var data = JSON.parse(data);    
                        var is_data_available = data.is_data_available.toString();
                        
                        if(is_data_available == 0){
                           $("#questionLibraryModal .modal-body .libraryData").empty();
                           $("#questionLibraryModal .modal-body .libraryNoData").show();
                           $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").hide();
                           $("#questionLibraryModal  .ckbCheckAllLabel").hide();
                           $("#questionLibraryModal .modal-body .survey_form").show();
                           $("#questionLibraryModal .ckbCheckAll").prop('checked', false); 
                           $("#questionLibraryModal .checkboxCount").val('');
                           $("#questionLibraryModal #checkAllCountRequired").html('');
                           
                        }else {
                            var finalview = '';
                           for (var key in data.data){
                              finalview += data.data[key]['dataView'];
                              
                           }
                           $("#questionLibraryModal .modal-body .libraryData").html(finalview);
                           
                           $("#questionLibraryModal .modal-body .libraryNoData").hide();
                           $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").show();
                           $("#questionLibraryModal  .ckbCheckAllLabel").show();
                           $("#questionLibraryModal .modal-body .survey_form").show();
                           $("#questionLibraryModal .ckbCheckAll").prop('checked', false); 
                           $("#questionLibraryModal .checkboxCount").val('');
                           $("#questionLibraryModal #checkAllCountRequired").html('');
                        }                                          
               
                     },error: function(data) {
                       
                     }
            });

   });
$(document.body).on("click",".addQuestionToLibrary",function(){
        toastr.remove();
        var tmp_id = $(this).data('id');        
        var $this = $(this);
        var url = '{{ route("addQuestionToLibrary") }}';
        
        $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: {
                     tmp_id: tmp_id,
                     
                     
                  },
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {                        

                        $('.loading_footer').hide();   
                        var data = JSON.parse(data);    
                        var is_question_already_added = data.is_question_already_added.toString();
                        
                        if(is_question_already_added == 0){  
                           toastr["success"]("Question added to library.");                                            
                        }else {
                           toastr["error"]("Question already added into library.");                                            
                        }
        
               
                     },error: function(data) {
                       
                     }
            });
          
});



$(document.body).on("click",".questionLibraryPopup",function(){
        var url = '{{ route("questionLibraryPopup") }}';
        var page_number = $(this).closest('.pageDiv').find('#page_number').val();
      
         $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: {},
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {    
                        $('.loading_footer').hide();                                            
                         $("#questionLibraryModal  #page_number").val(page_number);
                         $("#questionLibraryModal .checkboxCount").val('');
                          var data = JSON.parse(data);    
                           var status = data.status.toString();
                           $("#questionLibraryModal .modal-body .libraryNoData").hide();
                           $("#questionLibraryModal .modal-body .survey_form").hide();
                          
                           var is_data_available = data.is_data_available.toString();
                        
                           $("#questionLibraryModal #template_id").empty();
                           $("#questionLibraryModal #template_id").append("<option value=''>Select Library</option>");
                           if(is_data_available == 1){
                              $.each(data.data,function(key, value)
                              {
                                 $("#questionLibraryModal #template_id").append('<option value=' + key + '>' + value + '</option>');
                              });
                             
                               $("#questionLibraryModal .templateSelectbox").show();
                              
                           }else {
                              $("#questionLibraryModal .templateSelectbox").hide();
                              $("#questionLibraryModal .modal-body .libraryData").empty();
                              $("#questionLibraryModal .modal-body .libraryNoData").show();
                              $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").hide();
                              $("#questionLibraryModal  .ckbCheckAllLabel").hide();
                              $("#questionLibraryModal .modal-body .survey_form").show();
                           }
                        
                        

                        //   $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").hide();
                           $("#questionLibraryModal  .ckbCheckAllLabel").hide();
                            $('#questionLibraryModal').modal('show');
                            
                            
               
                     },error: function(data) {
                        
                       
                     }
            });

        
});

 $("#questionLibraryModalfrm").submit(function(e){ // click add on modal

 
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var checkedlibraryQuestions = $('.libraryQuestions:checked').length;
     
      var $this = $(this);
      $(this).find(':submit').attr('disabled','disabled');
      var currentRouteName = '{{ Route::currentRouteName() }}';
      var page_number = $("#questionLibraryModal  #page_number") .val();
      var user_id = '{{ Auth::id() }}';   
      var libraryQuestions = [];
      $('.libraryQuestion:checked').each(function(i, e) {
         libraryQuestions.push($(this).val());
      });
      if (libraryQuestions.length === 0) {
         toastr.remove();
         toastr["error"]("Please select atleast one question.");
         return false;
      }
       
     
      
      
      
      var url = '{{ route("addQuestionfromLibrary") }}';
      var data = {
                     
                     page_number:page_number,
                     user_id:user_id,
                     survey_id:'',
                     'libraryQuestions[]':libraryQuestions,
                     
                  };
      if(currentRouteName == 'editsurvey'){
            
            var data = {                        
                        page_number:page_number,
                        user_id:user_id,
                        survey_id: $("#survey_id").val(),
                        'libraryQuestions[]':libraryQuestions,
                        

                    };
        }
        

       $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     data:data,
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        
                        $('.loading_footer').hide();
                        $($this).find(':submit').removeAttr('disabled');                        
                        var data = JSON.parse(data);   
                        var finalview = '';
                        for (var key in data.data){
                           finalview += data.data[key]['dataView'];
                           
                        }
                         $("#questionLibraryModal .close").click();
                        $("#page" + page_number).find('.addQuestion').append(finalview);
                         var isDataEmptyArray = [];
                        
                            $(document.body).find('.addQuestion').each(function(index){
                                var QuestionData = $.trim($(this).html());
                                if(QuestionData == ''){
                                    isDataEmptyArray.push("1");
                                } 
                                
                            });
                       
                            if ($.inArray('1', isDataEmptyArray) != -1)
                            {        
                                
                                $(document.body).find("#questionData").val("");
                            }else {
                                
                                $(document.body).find("#questionData").val("1");
                            }
                            
                            $(document.body).find("#questionData").blur(function(){}).blur();
                         $('.select2_cls').select2();
                       

                     },error: function(data) {
                       // $($this).find(':submit').removeAttr('disabled');
                       
                     }
               });
      
    //  $($this).find(':submit').removeAttr('disabled');
      
     
});


 $("#questionLibraryModal").on("hidden.bs.modal", function(e) {
    
        $('#questionLibraryModalfrm').find('form').trigger('reset');
         $("#questionLibraryModal  #page_number").val('');
          $("#questionLibraryModal .modal-body .libraryData").html('');
          $("#questionLibraryModal #get_template_id").html('');
          $("#questionLibraryModal #checkAllCountRequired").html('');
          //$(document.body).find(".btnAddQuestionLibrary").attr( "disabled" );
          
    });

    $(document.body).on("change",".libraryQuestion",function(){
    
         var checkedlibraryQuestions = $("[name='libraryQuestion[]']:checked").length;
       var alllibraryQuestions = $("[name='libraryQuestion[]']").length;
      
      if(checkedlibraryQuestions === alllibraryQuestions){
         $(".ckbCheckAll").prop('checked', true); 
      }else {
         $(".ckbCheckAll").prop('checked', false); 
      }
        
    
         var libraryQuestions = [];
         $('.libraryQuestion:checked').each(function(i, e) {
            libraryQuestions.push($(this).val());
         });
         if (libraryQuestions.length === 0) {
            $("#questionLibraryModal .checkboxCount").val('');
            // $(document.body).find(".btnAddQuestionLibrary").attr( "disabled", "disabled" );
      
         }else {
            $("#questionLibraryModal .checkboxCount").val('1');
            // $(document.body).find(".btnAddQuestionLibrary").removeAttr( "disabled" );
         }
    
      });

      $(document.body).on("change",".ckbCheckAll",function(){
         //alert('sdgs');
       //$("#ckbCheckAll").click(function () {
        $(".libraryQuestion").prop('checked', $(this).prop('checked'));
        $('.libraryQuestion').trigger("change");
    });


    $(document.body).on("click",".addQuestionToLibraryPopup",function(){   
         var tmp_id = $(this).data('id');        
         var $this = $(this);
         var url = '{{ route("addQuestionToLibraryPopup") }}';
          toastr.remove();
          $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },                     
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        
                        $('.loading_footer').hide();
                         var data = JSON.parse(data);    
                        var is_data_available = data.is_data_available.toString();
                        $("#addQuestionToLibraryModal #template_new").val('');    
                        $("#addQuestionToLibraryModal .template_new").hide();    
                        $("#addQuestionToLibraryModal #template_name").empty();
                        $("#addQuestionToLibraryModal #template_name").append("<option value=''>Select Library</option>");
                        if(is_data_available == 1){
                           $.each(data.data,function(key, value)
                           {
                              $("#addQuestionToLibraryModal #template_name").append('<option value=' + key + '>' + value + '</option>');
                           });
                           
                        }
                        $("#addQuestionToLibraryModal #tmp_id").val(tmp_id);
                        $("#addQuestionToLibraryModal #template_name").append("<option value='0'>Add new library</option>");
                        $('#addQuestionToLibraryModal').modal('show');
                       

                     },error: function(data) {
                        $("#addQuestionToLibraryModal #tmp_id").val(tmp_id);
                       $('#addQuestionToLibraryModal').modal('show');
                     }
               });

           
   });
   $(document.body).on("change",".selectLibraryemplate",function(){
      if($(this).val() == '0'){
         $("#addQuestionToLibraryModal .template_new").show();         
      }else {
         $("#addQuestionToLibraryModal .template_new").hide();         
      }
   });


   $("#addQuestionToLibraryModalfrm").submit(function(e){ // click add on modal

      e.preventDefault(); // avoid to execute the actual submit of the form.
      var $this = $(this);
       toastr.remove();
      //$(this).find(':submit').attr('disabled','disabled');
      var url = '{{ route("addQuestionToLibrary") }}';
      
      var template_new_name = '';
      var template_name = $("#addQuestionToLibraryModal  #template_name") .val();
      var tmp_id = $("#addQuestionToLibraryModal  #tmp_id") .val();
      if(template_name == '0'){
         var template_new_name = $("#addQuestionToLibraryModal  #template_new") .val();
      }
      var data = {                        
                        template_name:template_name,
                        template_new_name:template_new_name,
                        tmp_id:tmp_id
                    };

      
                     $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     data:data,
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        
                        $('.loading_footer').hide();
                        var data = JSON.parse(data);    
                        var is_question_already_added = data.is_question_already_added.toString();
                        
                        if(is_question_already_added == 0){  
                           $("#addQuestionToLibraryModal .close").click();
                           toastr["success"]("Question added to library.");                                            
                        }else {
                           $("#addQuestionToLibraryModal .close").click();
                           toastr["error"]("Question already added in this library.");                                            
                        }
                        
                        
                       

                     },error: function(data) {
                        
                       
                     }
               });
      
      
      
   });

   $(document.body).on("change",".getQuestionsbyTemplate",function(){
      $("#questionLibraryModal #checkAllCountRequired").html('');
      if($(this).val() == ''){
         
         $("#questionLibraryModal .modal-body .libraryNoData").hide();
         $("#questionLibraryModal .modal-body .survey_form").hide();
          $("#questionLibraryModal  .mainSelectAllCheckbox").hide();
      }else {
         var template_id =  $(this).val();
         var url = '{{ route("getQuestionsbyTemplate") }}';
        //var page_number = $(this).closest('.pageDiv').find('#page_number').val();
      
         $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: {
                         template_id,template_id
                      },
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {    
                        $('.loading_footer').hide();                                            
                        // $("#questionLibraryModal  #page_number").val(page_number);
                          var data = JSON.parse(data);    
                        var status = data.status.toString();
                        
                        if(status == 0){
                           $("#questionLibraryModal .modal-body .libraryNoData").show();
                           $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").hide();
                           $("#questionLibraryModal  .ckbCheckAllLabel").hide();
                           $("#questionLibraryModal .modal-body .survey_form").show();
                           $("#questionLibraryModal  .mainSelectAllCheckbox").hide();
                           $("#questionLibraryModal .modal-body .libraryData").html('');
                           
                           
                        }else {
                           
                           var finalview = '';
                           for (var key in data.data){
                              finalview += data.data[key]['dataView'];
                              
                           }
                           $("#questionLibraryModal .modal-body .libraryData").html(finalview);
                            
                           
                           $("#questionLibraryModal .modal-footer .btnAddQuestionLibrary").show();
                           $("#questionLibraryModal  .ckbCheckAllLabel").show();
                            $("#questionLibraryModal .modal-body .survey_form").show();
                            $("#questionLibraryModal  .mainSelectAllCheckbox").show();
                            $("#questionLibraryModal .modal-body .libraryNoData").hide();
                        }
                           
                        
                        $('#questionLibraryModal').modal('show');
                        
                                          $(document.body).find(".select2_cls").each(function(index)
                        {
                              if ($(this).data('select2')) {
                                 $(this).select2('destroy');
                              } 
                        });
                        $('.select2_cls').select2();
                       
                        $(".ckbCheckAll").prop('checked', false); 
                        //$(".btnAddQuestionLibrary").attr( "disabled", "disabled" );
                        
               
                     },error: function(data) {
                        $('.loading_footer').hide();
                        
                       
                     }
            });
      }
   });
   

   
</script>


