<script>
$(document.body).on('change', '.clsSkipLogic', function (){
   var tmp_id = $(this).val();
   var $this = $(this);
   if(this.checked) {
      var url = '{{ route("checkSkipLogicDataExists") }}';
       data = {
                    tmp_id: tmp_id,                    
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
                        if(is_data_available === false){                         
                              alertify.alert('Error!', 'Please select skip logic first.');
                              $('#clsSkipLogic_'+$this.val()).prop("checked",false);      
                        }else {
                            updateSkipLogicFlag($this);
                            
                        }
                       
                       
                     },error: function(data) {
                       
                     }
               });
      
   }else {
      updateSkipLogicFlag($this);
   }

});

function updateSkipLogicFlag($this){
   
   var is_skip_logic_avail = 0;

   if($("#clsSkipLogic_" + $this.val()).is(':checked')){                                    
         is_skip_logic_avail = 1;
   }
      
   var url = '{{ route("isSkipLogicAvail") }}';

   $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     data: {
                     tmp_id: $this.val(),
                     is_skip_logic_avail:is_skip_logic_avail
                  },
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {                        

                        $('.loading_footer').hide();                                                 
                        
               
                     },error: function(data) {
                     
                     }
            });
}

$(document.body).on("click",".skipLogicPopup",function(){
   var currentRouteName = '{{ Route::currentRouteName() }}';
   var tmp_id = $(this).data('id');        
   var $this = $(this);
   var page_number = $(this).closest('.pageDiv').find('#page_number').val();
   var url = '{{ route("addSkipLogicPopup") }}';

   var data = {
                        tmp_id: tmp_id,     
                        page_number:page_number,   
                        survey_id:'',
                        
                    };

     if(currentRouteName == 'editsurvey'){
            
            var data = {
                        tmp_id: tmp_id,     
                        page_number:page_number,  
                        survey_id: $("#survey_id").val(),
                        

                    };
        }
      //   console.log( survey_id);
   $('#addSkipLogicModal #skip_question_id').empty();
   $('#addSkipLogicModal #skip_question_id').append('<option value="" >' + 'Select Option' + '</option>');

   $('#addSkipLogicModal #answer').empty();          
   $('#addSkipLogicModal #answer').append('<option value="" >' + 'Select Option' + '</option>');                                  

   
   $('#addSkipLogicModal .mainAnswerClass').hide();     
   toastr.remove();
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
                         if(!is_data_available){
                          $("#addSkipLogicModal  #skip_question_id").select2();  
                           $("#addSkipLogicModal  #answer").select2(); 
                         }
                        

                        var data = JSON.parse(data);  
                        var skipLogicQuestionDropdownArr = Object.keys(data.skipLogicQuestionDropdownArr).length;
                        var is_data_available = data.is_data_available;

                        if(skipLogicQuestionDropdownArr > 0){
                           $.each(data.skipLogicQuestionDropdownArr, function(key, value) {
                              $('#addSkipLogicModal  #skip_question_id').append($('<option>', { value : key }).text(value));
                           });    
                        }

                        
                         
                        
                        if(is_data_available){
                           $('#addSkipLogicModal #addSkipLogicModalSubmit').html('Update');

                           var answerData = Object.keys(data.answerData).length;
                           if(answerData > 0){
                              $.each(data.answerData, function(key, value) {
                                 $('#addSkipLogicModal  #answer').append($('<option>', { value : key }).text(value));
                              });  
                              
                                $('#addSkipLogicModal .modal-body #skip_question_id option[value="'+ data.skip_question_id  +'"]').attr("selected",true);
                                $('#addSkipLogicModal .modal-body #answer option[value="'+ data.answer  +'"]').attr("selected",true);
                         
                             
                              $('#addSkipLogicModal .mainAnswerClass').show();     
                           }
                        }else {
                           $('#addSkipLogicModal #addSkipLogicModalSubmit').html('Add');
                        }
                      
                        $('#addSkipLogicModal').modal('show');
                        $('#addSkipLogicModal').find('form').trigger('reset');
                        $('#addSkipLogicModal  #tmp_id').val(tmp_id); 
                        $('#addSkipLogicModal  #page_number').val(page_number); 
                     
                        




                     },error: function(data) {
                        
                       $('#addSkipLogicModal').modal('show');
                     }
               });
});


$("#addSkipLogicModalfrm").submit(function(e){ // click add on modal
         e.preventDefault(); // avoid to execute the actual submit of the form.
         var $this = $(this);
         var tmp_id = $("#addSkipLogicModal #tmp_id") .val();
         var page_number = $("#addSkipLogicModal #page_number") .val();
         var skip_question_id = $("#addSkipLogicModal #skip_question_id") .val();
         var answer = $("#addSkipLogicModal #answer") .val();
         $(this).find(':submit').attr('disabled','disabled');
          var url = '{{ route("addSkipLogicTmp") }}';
         


          data = {
                     tmp_id: tmp_id,
                     skip_question_id: skip_question_id,
                     answer: answer,
                     page_number:page_number
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
                        $($this).find(':submit').removeAttr('disabled');
                        $('.loading_footer').hide();
                        $("#addSkipLogicModal .close").click();
                        $('fieldset').find('#clsSkipLogic_'+tmp_id).prop('checked', true);

                        $('#clsSkipLogic_'+tmp_id).prop("checked",true).trigger("change");
                        //$('.clsSkipLogic').trigger("change");
                       
                       
                     },error: function(data) {
                       
                     }
               });



        
        
        
});

$(document.body).on('change', '#skip_question_id', function (e, answer = null){
   //console.log($(this).val());
   if($(this).val()===""){ 
      $('#addSkipLogicModal #answer').empty();               
      $('#addSkipLogicModal #answer').append('<option value="" selected>' + 'Select Option' + '</option>');                                  
      $(".mainAnswerClass").hide();
   }else {
      if(!answer){

         var skip_question_id = $(this).val();        
         var url = '{{ route("getSkipLogicQuestionData") }}';

         $.ajax({
                        url: url,
                        headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                           skip_question_id: skip_question_id,                     
                        },
                        method: 'post',
                        beforeSend: function() {
                           $('.loading_footer').css('display', 'flex');
                        },
                        success: function(data) {   
                           $('.loading_footer').hide();
                           $('#addSkipLogicModal #answer').empty();               
                           $('#addSkipLogicModal #answer').append('<option value="" selected>' + 'Select Option' + '</option>');                                  
                           $('#addSkipLogicModal .mainAnswerClass').show();                                                 
                           
                           
                           var data = JSON.parse(data);
                           var is_data_available = data.is_data_available;
                           
                           
                           if(is_data_available){

                              var answerData = Object.keys(data.answerData).length;
                              if(answerData > 0){
                                 $.each(data.answerData, function(key, value) {
                                    $('#addSkipLogicModal  #answer').append($('<option>', { value : key }).text(value));
                                 });    
                              }
                              
                           }
                           
                  
                        },error: function(data) {
                        
                        }
            });
         
      }
      
   }
});
</script>