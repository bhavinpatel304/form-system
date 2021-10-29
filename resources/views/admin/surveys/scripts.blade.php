<script>
    
$.validate({
    form: '#questionModalfrm, #questionModalEditfrm',      
    validateOnBlur: true,
});


 $.validate({
            form:'#addsurvey , #updatesurvey',
            modules : 'toggleDisabled',
            disabledFormFilter : 'form.toggle-disabled',
            showErrorDialogs : false,
            validateHiddenInputs:true,
            onSuccess : function($form) {
                //$(".surveySaveSubmitBtn").attr("disabled", true);
                //$(".surveySaveSubmitBtn").hide();
            }
           
        });

$.validate({
    form: '#addQuestionToLibraryModalfrm',       
    validateOnBlur: true,
    validateHiddenInputs:true,
});

$.validate({
    form: '#questionLibraryModalfrm',       
    validateOnBlur: true,
    validateHiddenInputs:true,
    
});

$.validate({
    form: '#addSkipLogicModalfrm',       
    validateOnBlur: true,
    validateHiddenInputs:true,
    
});
 $(".buttonPrevious").css('visibility', 'hidden');
        $("#addsurvey").submit(function (e) {

            

            //disable the submit button
            $(".surveySaveSubmitBtn").attr("disabled", true);

           

            return true;

        });
        
        function view_preview()
        {
            var isValidFirstPage_view = true;
            var msg_view = '';
            
            if($("#comp_id").val() == ''){
                isValidFirstPage_view = false;
                msg_view += 'Please Enter Company Name.';
            }
            //if($("#survey_name").val() == ''){
            if($.trim($("#survey_name").val()) == ''){
                isValidFirstPage_view = false;
                msg_view += '<br /> Please Enter Survay Name.';
            }
            if( ($("#start_date").val() == '') && $("#end_date").val() != ''){
                    isValidFirstPage = false;
                    msg_view += '<br /> Please Select Start Date.';
                }

                if( ($("#end_date").val() == '') && $("#start_date").val() != ''){
                    isValidFirstPage = false;
                    msg_view += '<br /> Please Select End Date.';
                }
            // if($("#max_invitations").val() == ''){
            //     isValidFirstPage_view = false;
            //     msg_view += '<br /> Please Enter Number of Invitations.';
            // }
            // if($("#start_date").val() == ''){
            //     isValidFirstPage_view = false;
            //     msg_view += '<br /> Please Select Start Date.';
            // }
            // if($("#end_date").val() == ''){
            //     isValidFirstPage_view = false;
            //     msg_view += '<br /> Please Select End Date.';
            // }

            if(isValidFirstPage_view == false){
                $("#btnpreview").prop( "disabled", true );
                return true;
            } 

            $("#btnpreview").prop( "disabled", false );
           
            

        }
    $(document).ready(function () {
       
       
        view_preview();        

        $("#start_date").datepicker({
            startDate: "dateToday",
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);
            $(this).datepicker('hide');
        });

        $("#end_date").datepicker({
            startDate: "dateToday",
        })
        .on('changeDate', function (selected) {            
            var maxDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
            $(this).datepicker('hide');
        });


        $(document.body).on("click",".survey_heading_bold",function(){

            $(this).parent().toggleClass('active');
            $(this).closest('.pageDiv').find('.survey_heading').toggleClass('bold');  
            
            //$('#survey_heading').toggleClass('bold');     
            toggleFieldVal($(this).closest('.pageDiv').find('.is_heading_bold'));
        
        });


        $(document.body).on("click",".survey_heading_italic",function(){
        
            $(this).parent().toggleClass('active');  
            $(this).closest('.pageDiv').find('.survey_heading').toggleClass('italic');  
            toggleFieldVal($(this).closest('.pageDiv').find('.is_heading_italic'));

            //$('#survey_heading').toggleClass('italic');      
            //toggleFieldVal("#is_heading_italic");
        });


        $(document.body).on("click",".survey_heading_underline",function(){
           
            $(this).parent().toggleClass('active');
            $(this).closest('.pageDiv').find('.survey_heading').toggleClass('underline');  
            toggleFieldVal($(this).closest('.pageDiv').find('.is_heading_underline'));
            
            //$('#survey_heading').toggleClass('underline');      
            //toggleFieldVal("#is_heading_underline");
        });
        

        $(document.body).on("change",".survey_heading_fontSizeBtn",function(){
            $(this).closest('.pageDiv').find('.survey_heading').css("font-size", $(this).val() + "px");
         //   $('#survey_heading').css("font-size", $(this).val() + "px");
        });


        $(document.body).on("click",".survey_sub_heading_bold",function(){        
            $(this).parent().toggleClass('active');
            $(this).closest('.pageDiv').find('.survey_sub_heading').toggleClass('bold');  
            toggleFieldVal($(this).closest('.pageDiv').find('.is_subheading_bold'));
            
            //$('#survey_sub_heading').toggleClass('bold');
            //toggleFieldVal("#is_subheading_bold");
        });


        $(document.body).on("click",".survey_sub_heading_italic",function(){                
            $(this).parent().toggleClass('active');
            $(this).closest('.pageDiv').find('.survey_sub_heading').toggleClass('italic');  
            toggleFieldVal($(this).closest('.pageDiv').find('.is_subheading_italic'));
            
            
            //$('#survey_sub_heading').toggleClass('italic');
            //toggleFieldVal("#is_subheading_italic");
        });

        $(document.body).on("click",".survey_sub_heading_underline",function(){                
        
            $(this).parent().toggleClass('active');
            $(this).closest('.pageDiv').find('.survey_sub_heading').toggleClass('underline');  
            toggleFieldVal($(this).closest('.pageDiv').find('.is_subheading_underline'));
            
            //$('#survey_sub_heading').toggleClass('underline');
            //toggleFieldVal("#is_subheading_underline");
        });

        $(document.body).on("change",".survey_sub_heading_fontSizeBtn",function(){                
             $(this).closest('.pageDiv').find('.survey_sub_heading').css("font-size", $(this).val() + "px");
            //$('#survey_sub_heading').css("font-size", $(this).val() + "px");
        });

       
        // @if(Route::currentRouteName() == "editsurvey")
            
               
        
        // @endif

           


            $("#btnpreview").bind("click", function() {
                view_preview();

                if($('#btnpreview').prop('disabled'))
                {
                    toastr["error"]("Please fill all mendetory fileds.");
                    return false;
                }

            });
            

            $("#btnTabnext").bind("click", function() {
                
                var isValidFirstPage = true;
                var msg = '';

                
                if($("#comp_id").val() == ''){
                    isValidFirstPage = false;
                    msg += 'Please Select Company Name.';
                }
                if($.trim($("#survey_name").val()) == ''){
                    isValidFirstPage = false;
                    msg += '<br /> Please Enter Survay Name.';
                }
                if( ($("#start_date").val() == '') && $("#end_date").val() != ''){
                    isValidFirstPage = false;
                    msg += '<br /> Please Select Start Date.';
                }

                if( ($("#end_date").val() == '') && $("#start_date").val() != ''){
                    isValidFirstPage = false;
                    msg += '<br /> Please Select End Date.';
                }
                // if($("#max_invitations").val() == ''){
                //     isValidFirstPage = false;
                //     msg += '<br /> Please Enter Number of Invitations.';
                // }
                // if($("#start_date").val() == ''){
                //     isValidFirstPage = false;
                //     msg += '<br /> Please Select Start Date.';
                // }
                // if($("#end_date").val() == ''){
                //     isValidFirstPage = false;
                //     msg += '<br /> Please Select End Date.';
                // }
               
             

                if(isValidFirstPage == false){
                    $("#btnpreview").prop( "disabled", true );
                    toastr.remove();
                    toastr["error"](msg);
                    return true;
                }
                  
                $("#btnpreview").prop( "disabled", false );
                
                $("#backend-pill > li .active")
                .parent("li")
                .next("li")
                .find("a")
                .trigger("click");
                $("#backend-pill > li .active")
                .parent("li")
                .find("a")
                .addClass("active-fixed");
                $("#backend-pill > li .active-fixed")
                .parent("li")
                .addClass("transparentDiv");


                $('#backend-pill > li').each(function(){
                    if($(this).children().hasClass('active')){
                        $(this).addClass('mobile-active')
                    }else {
                        $(this).removeClass('mobile-active')
                    }
                })

                 var tabName = $("#backend-pill").find('a.active').attr('id');
                    if(tabName == 'primary-tab')
                    {
                        $(".buttonPrevious").css('visibility', 'hidden');
                    }else {
                        $(".buttonPrevious").css('visibility', 'visible');
                    }
                
            });
        $("#btnTabPrv").bind("click", function() {
            $("#backend-pill > li .active")
            .parent("li")
            .prev("li")
            .find("a")
            .trigger("click");

            $('#backend-pill > li').each(function(){
                if($(this).children().hasClass('active')){
                $(this).addClass('mobile-active')
                }else {
                $(this).removeClass('mobile-active')
                }
            })


            var tabName = $("#backend-pill").find('a.active').attr('id');
             if(tabName == 'primary-tab')
             {
                $(".buttonPrevious").css('visibility', 'hidden');
             }else {
                 $(".buttonPrevious").css('visibility', 'visible');
             }
        });

        $('.datepicker').datepicker({         
            "autoclose": true
        });
    });


    function preview(previewClass, previewSel) {
    $('#iframeWrapper').removeClass();
    $('#iframeWrapper').addClass(previewClass);
    $('.resize-buttons a').removeClass('active');
    $(previewSel).addClass('active');
    }



    function removeUpload(attr) {
        
        
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
         $("#" + attr).val(null);
         $("#isWelcomeComeExists").val('0');

        
        $("#welcome_image_dummy").val("{{ asset('front/images/image.png') }}");
        

    }

    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });

$('.add_welcome_image').on('click', function () {
  $("#isWelcomeComeExists").val('1');
  $('.file-upload-input').trigger('click');
});


$('.heading-picker-bckgrd').colpick({
	layout:'hex',
	submit:1,
    color: '#000',
    onSubmit:function(hsb,hex,rgb,el) {
            $(el).colpickHide();
        },
    onChange:function(hsb,hex,rgb,el,bySetColor) {
        $(el).closest('.pageDiv').find('.survey_heading').css("background-color",'#'+hex);
        // $(this).closest('.pageDiv').find('#survey_heading').css("background-color",'#'+hex);
   // $("#survey_heading").css("background-color",'#'+hex);
    $(el).css('border-right-color','#'+hex);
            if(!bySetColor) $(el).val('#' +hex);
        }
    }).keyup(function(){
	    $(this).colpickSetColor(this.value);
    });
$('.sub-picker-bckgrd').colpick({
	layout:'hex',
	submit:1,
    color: '#000',
    onSubmit:function(hsb,hex,rgb,el) {
            $(el).colpickHide();
        },
    onChange:function(hsb,hex,rgb,el,bySetColor) {
        $(el).closest('.pageDiv').find('.survey_sub_heading').css("background-color",'#'+hex);
    //$("#survey_sub_heading").css("background-color",'#'+hex);
    $(el).css('border-right-color','#'+hex);
            if(!bySetColor) $(el).val('#' +hex);
        }
    }).keyup(function(){
	    $(this).colpickSetColor(this.value);
    });







$('.heading-picker-color').colpick({
	layout:'hex',
	submit:1,
    color:'#f6f6f6',
    onSubmit:function(hsb,hex,rgb,el) {
		$(el).colpickHide();
	},
    onChange:function(hsb,hex,rgb,el,bySetColor) {
        //console.log($(el).closest('.pageDiv').find('.survey_heading'));
        // $(el).closest('.pageDiv').find('.survey_heading').css("background-color",'#'+hex);
        $(el).closest('.pageDiv').find('.survey_heading').css("color",'#'+hex);
       // $("#survey_heading").css("color",'#'+hex);
    $(el).css('border-right-color','#'+hex);
		if(!bySetColor) $(el).val('#' +hex);
	}
    }).keyup(function(){
	    $(this).colpickSetColor(this.value);
    });



$('.sub-picker-color').colpick({
	layout:'hex',
	submit:1,
    color:'#f6f6f6',
    onSubmit:function(hsb,hex,rgb,el) {
		$(el).colpickHide();
	},
    onChange:function(hsb,hex,rgb,el,bySetColor) {
        $(el).closest('.pageDiv').find('.survey_sub_heading').css("color",'#'+hex);
        //$("#survey_sub_heading").css("color",'#'+hex);
    $(el).css('border-right-color','#'+hex);
		if(!bySetColor) $(el).val('#' +hex);
	}
    }).keyup(function(){
	    $(this).colpickSetColor(this.value);
    });


   


  

    $("#welcome_image").on('change',function(){
        
       
        readURL(this,'welcome_image_img');
        
        $('.image-upload-wrap').hide();
         $('.file-upload-content').show();

      
    });
 $("#survey_company_logo").change(function() {
       
        readURL(this,'survey_company_logo_img');
    });

 


 
/* Survey Script Starts  */
    function addQuestion(type,replace = false,html = ''){

         $.ajax({
            url: "{{ route('addQuestion') }}",
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
               type: type,
               
            },
            method: 'post',
            beforeSend: function() {
                 $('.loading_footer').css('display', 'flex');
              
            },
            success: function(data) {
               $('.loading_footer').hide();
               
               if(replace){
                  $( html ).replaceWith( data);
               } else {
                  $(".addQuestion").append(data);
               }
               
                $(".select2_cls").select2();
               
               
            },
            error: function(data) {
               
            }
            
      
        });

   }

   $(document.body).on("change",".replaceQuestion",function(){
      var type = $(this).val();
      if(type != ''){
         var html =  $(this).closest("fieldset");     
         addQuestion(type,true,html);
      }   
      
      
   });
   
   $(document.body).on("click",".cloneMe",function(){
    
        $(document.body).find(".select2_cls").each(function(index)
        {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            } 
        });
        //$(this).closest('.pageDiv').find('.addQuestion').append($(this).closest("fieldset").clone());
        $(".addQuestion").append($(this).closest("fieldset").clone());
        $('.select2_cls').select2();
        
    });

   $(document.body).on("click",".removeMe",function(){
      $(this).closest("fieldset").remove();
    
   });

   $(document.body).on("click",".removeSingle",function(){
      var numItems = $(this).closest(".question_editable").find('.question').length - 1 ;
      if(numItems == 0){
         alert('Please enter maximum one answer');
      }else {
         $(this).closest(".question").remove();
      }
      
   });

   var option_inc = 1;
   $(document.body).on("click",".addSingle",function(){
      
       var appendX = '<div class="actionBtn"><div class="BtnIcon removeBtn removeSingle" title="Delete this choice."><svg class="svd-svg-icon" style="width: 16px; height: 16px;"><use xlink:href="#icon-inplaceplus"><symbol viewBox="0 0 12 12" id="icon-inplaceplus"><path d="M11 5H7V1H5v4H1v2h4v4h2V7h4z"></path></symbol></use></svg></div></div>';


       $(this).closest(".question_editable").find(".question:first").clone().find("input:text").val("").end().insertAfter($(this).closest(".question_editable").find(".question:last")).append(appendX);

   });

   $(document.body).on("click",".addSingleMatrix",function(){
      
       var appendX = '<div class="actionBtn"><div class="BtnIcon removeBtn removeSingle" title="Delete this choice."><svg class="svd-svg-icon" style="width: 16px; height: 16px;"><use xlink:href="#icon-inplaceplus"><symbol viewBox="0 0 12 12" id="icon-inplaceplus"><path d="M11 5H7V1H5v4H1v2h4v4h2V7h4z"></path></symbol></use></svg></div></div>';


       $(this).closest(".question_editable").find(".question:first").clone().find("input:text").val("").end().insertAfter($(this).closest(".question_editable").find(".question:last")).append(appendX);
        var maximum = null;
       $(this).closest('.question_editable').find('.matrixnumberarr').each(function(){
           var value = parseFloat($(this).val());
            maximum = (value > maximum) ? value : maximum;
            
       });
       $(this).closest('.question_editable').find('.matrixnumberarr:last').val(maximum + 1);
    //    console.log(maximum);

   });
/* Survey Script Ends  */


/* Add Question Popup Starts */
    $("#questionModal").on("hidden.bs.modal", function(e) {
    
        $('#questionModalfrm').find('form').trigger('reset');
        $('[name=radio_id]').val(""); 
        $("#radio_id").select2("destroy").select2();  
       // $('[name=radio_id_sub]').val(""); 
        $("#radio_id_sub").select2("destroy").select2(); 
        $('#radio_id_sub').trigger('change');
    });


    $(document.body).on("click",".questionPopup",function(){
        var url = '{{ route("questionPopup") }}';
        var page_number = $(this).closest('.pageDiv').find('#page_number').val();
        $('#questionModal .modal-body .radio_id_sub_class').hide();
                    $(".appendRadio").html('');
        $.ajax({
                     url: url,                     
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     
                     method: 'get',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                         
                        $('.loading_footer').hide();
                        $("#questionModal .modal-body #question").val('');
                        $("#questionModal .modal-body #page_number").val(page_number);
                        var data = JSON.parse(data);    
                        var status = data.status.toString();
                        var radioPointsOptions = data.data.radioPointsOptions;
                     //        $("#radio_id_sub").select2("destroy").select2();
                        $('#questionModal .modal-body #radio_id_sub').empty();
                        $('#questionModal .modal-body #radio_id_sub').append('<option value="" selected>' + 'Select Option' + '</option>');
                        $.each(radioPointsOptions, function(key, value) {
                            $('#questionModal .modal-body #radio_id_sub')
                                .append($('<option>', { value : key })
                                .text(value));
                        });                          
                        $('#questionModal .modal-body #radio_id_sub').hide();
                        $('#questionModal').modal('show');
               
                     },error: function(data) {
                                    $("#questionModal .modal-body").html('<div class="col-12 tab-content"><div class="alert alert-info tab-content text-center"><strong>There is some problem loading data!</strong></div></div>');
                              $("#questionModal .modal-footer").hide();
                              $('#questionModal').modal('show');
                     }
        });
    });


    function get_sub_id()
    {
        var url = '{{ route("questionPopup") }}';
        $.ajax({
                     url: url,                     
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     
                     method: 'get',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                         
                        $('.loading_footer').hide();
                       
                        //$("#questionModalEdit .modal-body #page_number").val(page_number);
                        var data = JSON.parse(data);    
                        var status = data.status.toString();
                        var radioPointsOptions = data.data.radioPointsOptions;
                     //        $("#radio_id_sub").select2("destroy").select2();
                        $('#questionModalEdit .modal-body #radio_id_sub').empty();
                        $('#questionModalEdit .modal-body #radio_id_sub').append('<option value="" selected>' + 'Select Option' + '</option>');
                        $.each(radioPointsOptions, function(key, value) {
                            $('#questionModalEdit .modal-body #radio_id_sub')
                                .append($('<option>', { value : key })
                                .text(value));
                        });                          
                       
               
                     },error: function(data) {
                              
                     }
        });
    }

    function get_sub_id_add()
    {
        var url = '{{ route("questionPopup") }}';
        $.ajax({
                     url: url,                     
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     
                     method: 'get',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                         
                        $('.loading_footer').hide();
                       
                       // $("#questionModal .modal-body #page_number").val(page_number);
                        var data = JSON.parse(data);    
                        var status = data.status.toString();
                        var radioPointsOptions = data.data.radioPointsOptions;
                     //        $("#radio_id_sub").select2("destroy").select2();
                        $('#questionModal .modal-body #radio_id_sub').empty();
                        $('#questionModal .modal-body #radio_id_sub').append('<option value="" selected>' + 'Select Option' + '</option>');
                        $.each(radioPointsOptions, function(key, value) {
                            $('#questionModal .modal-body #radio_id_sub')
                                .append($('<option>', { value : key })
                                .text(value));
                        });                          
                       
               
                     },error: function(data) {
                              
                     }
        });
    }

    

    $(document.body).on("change","#questionModal .modal-body .radio_id",function(){
        
        var val = $(this).val();

        //$("#questionModal .modal-body .question").show();
        if(val == 3){
            $("#questionModal .modal-body .questionMain").hide();    
        }else{
            $("#questionModal .modal-body .questionMain").show();
        }
        $('#questionModal .modal-body #radio_id_sub').val("").trigger('change');
   
        if(val != ""){
            
                if(val == 1){
                   
                    
                    $("#questionModal .modal-body .radio_id_sub_class").show();
                    $('#questionModal .modal-body #radio_id_sub').show();
                     $('#questionModal .modal-body .appendRadio').show();
                    

                }
                else if(val == 4 || val == 5)
                {
                   
                   $('#questionModal .modal-body .radio_id_sub_class').hide();
                     $('#questionModal .modal-body .appendRadio').hide();
                }                
                
             


                 else {
                     $('#questionModal .modal-body .appendRadio').show();
                     $("#questionModal .modal-body .radio_id_sub_class").hide();
                     
                     var url = '{{ route("questionparentData") }}';
                        $.ajax({
                                        url: url,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {
                                        id: val,
                                        
                                    },
                                        method: 'post',
                                        beforeSend: function() {
                                            $('.loading_footer').css('display', 'flex');
                                        },
                                        success: function(data) {
                                            $('.loading_footer').hide();

                                            if(val == 3)
                                            {
                                                get_sub_id_add();

                                                $("#questionModal .modal-body .radio_id_sub_class").show();
                                                $("#questionModal .modal-body .modal-body > .question").hide();
                                                $('#questionModal .modal-body #radio_id_sub').show();
                                                $("#questionModal .modal-body .appendRadio").html(data);
                                            }
                                            else if(val) {
                                                $("#questionModal .modal-body .appendRadio").html(data);
                                                
                                            } else {
                                                $("#questionModal .modal-body .appendRadio").html('');
                                            }
                                            
                                
                                        },error: function(data) {
                                        
                                        }
                                });
                }
                

           
            
        } else {
             $("#questionModal .modal-body .appendRadio").html('');
            
            $("#questionModal .modal-body .radio_id_sub_class").hide();
        }
      
       $("#questionModal .modal-body #radio_id_sub").select2("destroy").select2();  
        

         
        
    });

    $(document.body).on("change","#questionModalEdit .modal-body .radio_id",function(){
        
        var val = $(this).val();

        //$("#questionModalEdit .modal-body .question").show();

        if(val == 3){
            $("#questionModalEdit .modal-body .questionMain").hide();    
        }else{
            $("#questionModalEdit .modal-body .questionMain").show();
        }

       
        $('#questionModalEdit .modal-body #radio_id_sub').val("").trigger('change');
   
        if(val != ""){
            
                if(val == 1){
                   
                    
                    $("#questionModalEdit .modal-body .radio_id_sub_class").show();
                    $('#questionModalEdit .modal-body #radio_id_sub').show();
                     $('#questionModalEdit .modal-body .appendRadio').show();
                    

                }
                else if(val == 4 || val == 5)
                {
                   
                   $('#questionModalEdit .modal-body .radio_id_sub_class').hide();
                     $('#questionModalEdit .modal-body .appendRadio').hide();
                }                
                
             


                 else {
                     $('#questionModalEdit .modal-body .appendRadio').show();
                     $("#questionModalEdit .modal-body .radio_id_sub_class").hide();
                     
                     var url = '{{ route("questionparentData") }}';
                        $.ajax({
                                        url: url,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {
                                        id: val,
                                        
                                    },
                                        method: 'post',
                                        beforeSend: function() {
                                            $('.loading_footer').css('display', 'flex');
                                        },
                                        success: function(data) {
                                            $('.loading_footer').hide();

                                            if(val == 3)
                                            {
                                                get_sub_id();

                                                $("#questionModalEdit .modal-body .radio_id_sub_class").show();
                                                $("#questionModalEdit .modal-body .modal-body > .question").hide();
                                                $('#questionModalEdit .modal-body #radio_id_sub').show();
                                                $("#questionModalEdit .modal-body .appendRadio").html(data);
                                            }
                                            else if(val) {
                                                $("#questionModalEdit .modal-body .appendRadio").html(data);
                                                
                                            } else {
                                                $("#questionModalEdit .modal-body .appendRadio").html('');
                                            }
                                            
                                
                                        },error: function(data) {
                                        
                                        }
                                });
                }
                

           
            
        } else {
             $("#questionModalEdit .modal-body .appendRadio").html('');
            
            $("#questionModalEdit .modal-body .radio_id_sub_class").hide();
        }
      
       $("#questionModalEdit .modal-body #radio_id_sub").select2("destroy").select2();  
        

         
        
    });

    function getQuestionNumber(){
      var intIndex = 0;
      $( ".queTitle" ).each(function() {
          intIndex += 1;
          $( this ).html('Q ' + intIndex);
                  // $( this ).children('span').html(intIndex);
      }); 
    }
    $(document.body).on("change","#questionModal .modal-body #radio_id_sub",function(){
        
        var id = $(this).val();

        $radio_option = $("#questionModal .modal-body #radio_id option:selected").val();

        

        if($radio_option == 3)
        {
            return;
        }
        
        var url = '{{ route("questionsubData") }}';
        $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                        id: id,
                        
                    },
                        async:false,
                        method: 'post',
                        beforeSend: function() {
                            $('.loading_footer').css('display', 'flex');
                        },
                        success: function(data) {
                            $('.loading_footer').hide();
                            if(id){
                                
                                $(".appendRadio").html(data);
                                
                            } else {
                                $(".appendRadio").html('');
                            }
                           // getQuestionNumber();
                        },error: function(data) {
                        
                        }
                });

    });

     $(document.body).on("change","#questionModalEdit .modal-body #radio_id_sub",function(){
        
        var id = $(this).val();

        $radio_option = $("#questionModalEdit .modal-body #radio_id option:selected").val();

        

        if($radio_option == 3)
        {
            return;
        }
        
        var url = '{{ route("questionsubData") }}';
        $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                        id: id,
                        
                    },
                        method: 'post',
                        async:false,
                        beforeSend: function() {
                            $('.loading_footer').css('display', 'flex');
                        },
                        success: function(data) {
                            $('.loading_footer').hide();
                            if(id){
                                
                                $(".appendRadio").html(data);
                                
                            } else {
                                $(".appendRadio").html('');
                            }
                           // getQuestionNumber();
                        },error: function(data) {
                        
                        }
                });

    });


/* Add Question Popup Ends */
    $(".radio_id").select2();
    $(".radio_id_sub").select2(); 
    

   

   $("#questionModalfrm").submit(function(e){ // click add on modal
        var $this = $(this);
       $(this).find(':submit').attr('disabled','disabled');
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var radio_id = $("#questionModal .modal-body #radio_id") .val();
        if(radio_id == 3){
            var question = '';
        }else {
            var question = $("#questionModal .modal-body #question") .val();
        }
        
        
        var radio_id_sub = $("#questionModal .modal-body #radio_id_sub").val();
        var page_number = $("#questionModal .modal-body #page_number").val();
        var url = '{{ route("addQuestionTmp") }}';
        
        var data = {};

        survey_id = $("#survey_id").val();

        

        if (typeof survey_id === "undefined") 
        {
            survey_id = "";
        } 
        

         
        if(radio_id == 1){
           
            data = {
                     question: question,
                     radio_id: radio_id,
                     radio_id_sub: radio_id_sub,
                     page_number:page_number,
                     'survey_id' : survey_id,
                     
                  };

        }

        if(radio_id == 8){
             data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='dropdownarr[]']").map(function(){return $(this).val();}).get()
                    };  

          

        }
        
        if(radio_id == 5){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='singletextbox']").val()
                    };  
        }
         if(radio_id == 4){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='singletextarea']").val()
                    };  
        }


        

        if(radio_id == 7){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='singlechkbox']").val()
                    };               
        }

        if(radio_id == 2){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='chkboxarr[]']").map(function(){return $(this).val();}).get()
                    };               
        }

        if(radio_id == 6){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='rdbtnarr[]']").map(function(){return $(this).val();}).get()
                    };               
        }

        if(radio_id == 3){
            data = {
                     'question': question,
                     'radio_id': radio_id,
                     'radio_id_sub': radio_id_sub,
                     'page_number':page_number,
                     'survey_id' : survey_id,
                     'array_points' : $("#questionModal .modal-body input[name='matrixarr[]']").map(function(){return $(this).val();}).get(),
                     'array_points_numbers' : $("#questionModal .modal-body input[name='matrixnumberarr[]']").map(function(){return $(this).val();}).get()
                    };               
        }

       


        

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
                         $("#questionModal .close").click();
                        // console.log($("#page" + page_number));
                         $("#page" + page_number).find('.addQuestion').append(data);
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
                       
                     },error: function(data) {
                       
                     }
               });
        
        
   });


    $(document.body).on("click",".deleteQuestion",function(){
        
         var tmp_id = $(this).data('id');
        var url = '{{ route("checkSkipLogicAvail") }}';
        var $this = $(this);
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
                           
                           
                           if(is_data_available){
                               
                                deleteWithAlertify($this,data.tmpIdsArray);
                           }else {
                                deleteWithOutAlertify($this);
                           }
                       
                       
                     },error: function(data) {
                       
                     }
               });
        

    });
    function deleteQuestionCode($this,tmpIdsArray = []){
    
        var currentRouteName = '{{ Route::currentRouteName() }}';
        var tmp_id = $this.data('id');
        

        var url = '{{ route("deleteQuestionTmp") }}';
        var page_number = $this.closest('.pageDiv').find('#page_number').val();
        var user_id = '{{ Auth::id() }}';
        var data = {
                        tmp_id: tmp_id,
                        page_number:page_number,
                        user_id:user_id,
                        survey_id:'',
                        tmpIdsArray:tmpIdsArray,
                        
                    };
        if(currentRouteName == 'editsurvey'){
            
            var data = {
                        tmp_id: tmp_id,
                        page_number:page_number,
                        user_id:user_id,
                        survey_id: $("#survey_id").val(),
                        tmpIdsArray:tmpIdsArray,

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
                            var tmpIdsArrayCount = Object.keys(tmpIdsArray).length;
                            
                            if(tmpIdsArrayCount > 0){
                                $.each(tmpIdsArray, function(key, value) {
                                    $('#clsSkipLogic_'+value).prop("checked",false).trigger("change");                                 
                                });    
                              }
                            var data = JSON.parse(data);    
                            $('.loading_footer').hide();                                                 
                            $($this).closest(".dataClass").remove();
                            var newQuestionNumber = 1;
                             $("#page" + page_number).find('.question_number').each(function( i ) {
                                $(this).html(newQuestionNumber);
                                newQuestionNumber = newQuestionNumber + 1;
                             });

                             if(data.isDataAvailable == 'no'){
                                 $("#questionData").val("");
                             }
                             $("#questionData").blur(function(){                                
                                }).blur();
                                
                        },error: function(data) {
                        
                        }
                });

    }
    function deleteWithOutAlertify($this,tmpIdsArray = []){
        deleteQuestionCode($this,tmpIdsArray);
    }
    function deleteWithAlertify($this,tmpIdsArray = []){
        alertify.confirm("You may loose skip logic data after deleting this question. Do you want to continue ?", function (e) {
        if (e) 
        {
           deleteQuestionCode($this,tmpIdsArray);
        }else 
            {            
                return false; 
            } 
        }).set({title:"Notice!"}).set(
                                        {
                                           labels:{ok:'Yes', cancel: 'No'},
                                           
                                        }
                                        ).set('defaultFocus', 'cancel').set('reverseButtons', false);         
    }



    $(document.body).on("click",".cloneQuestion",function(){
        var tmp_id = $(this).data('id');
        var $this = $(this);
        var url = '{{ route("cloneQuestionTmp") }}';
        var page_number = $(this).closest('.pageDiv').find('#page_number').val();
      
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
                        //$(".addQuestion").append(data);
                        $("#page" + page_number).find('.addQuestion').append(data);
               
                     },error: function(data) {
                       
                     }
            });
      
    });

    $(document.body).on("click",".editQuestion",function(){
        var tmp_id = $(this).data('id');
        
        var $this = $(this);
        var url = '{{ route("editQuestionTmpPopup") }}';

        $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     
                     method: 'post',
                      data: {
                        tmp_id: tmp_id,
                        
                        
                    },
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {
                        $('.loading_footer').hide();
                        
                        var data = JSON.parse(data);    
                        question_type = data.data.tmp_survey_question.question_type;
                        $('#questionModalEdit .modal-body #radio_id').val(data.data.tmp_survey_question.question_type); 
                           
                            $("#questionModalEdit .modal-body #radio_id").select2("destroy").select2();  
                            var radioPointsOptions = data.data.radioPointsOptions;                     
                            $('#questionModalEdit .modal-body #radio_id_sub').empty();
                            $('#questionModalEdit .modal-body #radio_id_sub').append('<option value="">' + 'Select Option' + '</option>');
                            $.each(radioPointsOptions, function(key, value) {
                                $('#questionModalEdit .modal-body #radio_id_sub')
                                    .append($('<option>', { value : key })
                                    .text(value));
                            });    
                        if(question_type == 1){
                              
                            var status = data.status.toString();
                            $('#questionModalEdit .modal-body #tmp_id').val(data.data.tmp_id); 
                            var jsonQuestion = JSON.parse(data.data.tmp_survey_question.question);  
                            $("#questionModalEdit .modal-body #question").val(jsonQuestion.question);                      
                            $("#questionModalEdit .modal-body #page_number").val(data.data.page_number);   
                            
                                
                            
                            
                            $('[name=radio_id_sub]').val(jsonQuestion.sro_id); 
                            $("#questionModalEdit .modal-body #radio_id_sub").select2("destroy").select2();  
                            $('#questionModalEdit .modal-body #radio_id_sub').trigger('change');
                            $("#questionModalEdit .modal-body .radio_id_sub_class").show();

                        }
                        if(question_type == 5){
                          
                            $('#questionModalEdit .modal-body #tmp_id').val(data.tmp_id); 
                            $("#questionModalEdit .modal-body #question").val(data.question); 
                            $("#questionModalEdit .modal-body .appendRadio").html('');
                            $("#questionModalEdit .modal-body .radio_id_sub_class").hide();
                            $("#questionModalEdit .modal-body .appendRadio").hide();
                          
                            
                            
                        }   
                         if(question_type == 4){
                          
                            $('#questionModalEdit .modal-body #tmp_id').val(data.tmp_id); 
                            $("#questionModalEdit .modal-body #question").val(data.question); 
                            $("#questionModalEdit .modal-body .appendRadio").html('');
                            $("#questionModalEdit .modal-body .radio_id_sub_class").hide();
                            $("#questionModalEdit .modal-body .appendRadio").hide();
                            //  $('[name=radio_id_sub]').val(''); 
                            //$("#questionModalEdit .modal-body #radio_id_sub").select2("destroy").select2();  
                            //$('#questionModalEdit .modal-body #radio_id_sub').trigger('change');
                            
                        }                        

                        
                        if(question_type == 3){
                            //console.log(data.dataView);
                            $("#questionModalEdit .modal-body #question").val(data.question); 
                            $('#questionModalEdit .modal-body #tmp_id').val(data.tmp_id); 
                             $("#questionModalEdit .modal-body #page_number").val(data.page_number);  
                               var jsonQuestion = JSON.parse(data.tmp_survey_question.question); 

                               $('[name=radio_id_sub]').val(jsonQuestion.sro_id); 
                            $("#questionModalEdit .modal-body #radio_id_sub").select2("destroy").select2();  
                            $('#questionModalEdit .modal-body #radio_id_sub').trigger('change');
                            $("#questionModalEdit .modal-body .radio_id_sub_class").show();
                            $(".appendRadio").html(data.dataView);
                            $(".appendRadio").show();
                            $("#questionModalEdit .modal-body .questionMain").hide();
                        }

                        if(question_type == 7 || question_type == 2 || question_type == 6 || question_type == 8){
                            $('#questionModalEdit .modal-body #tmp_id').val(data.tmp_id); 
                            $(".appendRadio").html(data.dataView);
                            $(".appendRadio").show();
                            $("#questionModalEdit .modal-body #question").val(data.question); 
                             $('#questionModalEdit .modal-body #page_number').val(data.page_number); 
                             $("#questionModalEdit .modal-body .radio_id_sub_class").hide();
                        }

                      








                        /***************** Bhavin Code ENDS   *************************/ 
                       
                        $('#questionModalEdit').modal('show');
               
                     },error: function(data) {
                                    $("#questionModalEdit .modal-body").html('<div class="col-12 tab-content"><div class="alert alert-info tab-content text-center"><strong>There is some problem loading data!</strong></div></div>');
                              $("#questionModalEdit .modal-footer").hide();
                              $('#questionModalEdit').modal('show');
                     }
        });

    });

     $("#questionModalEditfrm").submit(function(e){
        e.preventDefault(); // avoid to execute the actual submit of the form.

        // first we are checking whether this question has any skip logic involved or not 
        // if exists then ask alert before editing question , else dont ask 

        var tmp_id = $("#questionModalEdit .modal-body #tmp_id") .val();
        var url = '{{ route("checkSkipLogicAvail") }}';
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
                           
                           
                           if(is_data_available){
                            //    var tmpIdsArray = Object.keys(data.tmpIdsArray).length;
                            //   if(tmpIdsArray > 0){
                            //      $.each(data.tmpIdsArray, function(key, value) {
                            //          $('#clsSkipLogic_'+value).prop("checked",false).trigger("change");
                                 
                            //      });    
                            //   }
                               
                                editWithAlertify(e,data.tmpIdsArray);
                           }else {
                                editWithOutAlertify(e);
                           }
                       
                       
                     },error: function(data) {
                       
                     }
               });

       
       
       


     });
     function editWithOutAlertify(e,tmpIdsArray = []){
         editQuestionCode(e,tmpIdsArray);
     }
     function editWithAlertify(e,tmpIdsArray = []){
        alertify.confirm("You may loose skip logic data after editing this question. Do you want to continue ?", function (e) {
        if (e) 
        {
           editQuestionCode(e,tmpIdsArray);
        }else 
            {            
                return false; 
            } 
        }).set({title:"Notice!"}).set(
                                        {
                                           labels:{ok:'Yes', cancel: 'No'},
                                           
                                        }
                                        ).set('defaultFocus', 'cancel').set('reverseButtons', false); 
     }
     function editQuestionCode(e,tmpIdsArray = []){
         
            var radio_id = $("#questionModalEdit .modal-body #radio_id") .val();
            if(radio_id == 3){
                var question = '';
            }else {
                var question = $("#questionModalEdit .modal-body #question") .val();
            }
            
            
            var radio_id_sub = $("#questionModalEdit .modal-body #radio_id_sub") .val();
            var tmp_id = $("#questionModalEdit .modal-body #tmp_id") .val();
            var url = '{{ route("updateQuestionTmp") }}';
            var page_number = $("#questionModalEdit .modal-body #page_number") .val();
            var data = {};
            
            if(radio_id == 1){
            
                data = {
                        question: question,
                        radio_id: radio_id,
                        radio_id_sub: radio_id_sub,
                        tmp_id:tmp_id,
                        tmpIdsArray:tmpIdsArray,
                        
                    };

            }
            if(radio_id == 2){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                        'radio_id_sub': radio_id_sub,
                        'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='chkboxarr[]']").map(function(){return $(this).val();}).get()
                        };               
            }
            if(radio_id == 3){
                
                data = {
                        'question': question,
                        'radio_id': radio_id,
                        'radio_id_sub': radio_id_sub,
                        'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='matrixarr[]']").map(function(){return $(this).val();}).get(),
                         'array_points_numbers' : $("#questionModalEdit .modal-body input[name='matrixnumberarr[]']").map(function(){return $(this).val();}).get()
                        };               
            }
            if(radio_id == 4){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                    'radio_id_sub': radio_id_sub,
                    'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='singletextarea']").val()
                        };  
            }
            if(radio_id == 5){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                    'radio_id_sub': radio_id_sub,
                    'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='singletextbox']").val()
                        };  
            }
            if(radio_id == 6){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                        'radio_id_sub': radio_id_sub,
                        'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='rdbtnarr[]']").map(function(){return $(this).val();}).get()
                        };               
            }
            if(radio_id == 7){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                        'radio_id_sub': radio_id_sub,
                        'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='singlechkbox']").val()
                        };               
            }

            if(radio_id == 8){
                data = {
                        'question': question,
                        'radio_id': radio_id,
                        'radio_id_sub': radio_id_sub, 
                        'tmpIdsArray':tmpIdsArray,
                        tmp_id:tmp_id,                   
                        'array_points' : $("#questionModalEdit .modal-body input[name='dropdownarr[]']").map(function(){return $(this).val();}).get()
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
                        $("#questionModalEdit .close").click();     


                        $('fieldset').find("[data-id="+tmp_id+"]").closest('.dataClass').replaceWith(data);

                        var tmpIdsArrayCount = Object.keys(tmpIdsArray).length;
                            
                            if(tmpIdsArrayCount > 0){
                                $.each(tmpIdsArray, function(key, value) {
                                    $('#clsSkipLogic_'+value).prop("checked",false).trigger("change");                                 
                                });    
                              }
                        
                    $('.select2_cls').select2();

                    },error: function(data) {
                    
                    }
            });
     }
     

     $(document.body).on("change",".show_heading",function(){
    //$('#show_heading').change(function() {
        if($(this).is(":checked")) {
            $(this).closest('.pageDiv').find('.survey_heading').removeAttr('disabled');
           
        }else {
            
            
            $(this).closest('.pageDiv').find('.survey_heading').attr('disabled','disabled');           
            
        }
    });

    $(document.body).on("change",".show_subheading",function(){
    //$('#show_subheading').change(function() {
        
        if($(this).is(":checked")) {
            $(this).closest('.pageDiv').find('.survey_sub_heading').removeAttr('disabled');
            
        }else {
            $(this).closest('.pageDiv').find('.survey_sub_heading').attr('disabled','disabled');           
            
        }
    });


    $(document).on('click','#btnpreview',function(){

            // alert($('#btnpreview').prop('disabled'));

            // setTimeout(function(){
            //     $("#updatesurvey input").blur(function(){}).blur();
            //     $("#updatesurvey select").blur(function(){}).blur();
            // }, 500);


            if($('#btnpreview').prop('disabled'))
            {
                toastr["error"]("Please fill all mendetory fileds");
                return false;
            }
        
        
            $("#welcome_description_dummy").val(tinyMCE.activeEditor.getContent());


            formData = $(".custom_form").serializeArray();

                     
            cust_url = "{{ route('tmp_previewsurvey') }}";

            
            $.ajax({
                url:cust_url,            
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:formData ,
                async: false ,
                method: 'post',
                beforeSend: function() {
                    $('.loading_footer').css('display', 'flex');
                },
                success: function(data) {
                  
                $('.loading_footer').hide(); 
                //    http://127.0.0.1:8000/admin/preview
                    newWin = window.open("","_blank");
                    newWin.document.write(data);
                },
                error: function(data) {
                
                }      
            });

    });

 
     $(document.body).on("click",".requireQuestion",function(){

        var is_required = $(this).data('is-required');
        var new_is_required = 0;
        if(is_required == 0){
            new_is_required = 1;
        }
        
        var tmp_id = $(this).data('id');
        var $this = $(this);
        var url = '{{ route("isRequiredQuestionTmp") }}';
        var page_number = $(this).closest('.pageDiv').find('#page_number').val();

            $.ajax({
                     url: url,
                     headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                      data: {
                     tmp_id: tmp_id,
                     is_required:new_is_required
                  },
                     method: 'post',
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                     success: function(data) {                        

                        $('.loading_footer').hide();                                                 
                        $('fieldset').find("[data-id="+tmp_id+"]").closest('.dataClass').replaceWith(data);                        
               
                     },error: function(data) {
                       
                     }
            });
        
    });

    $(document.body).on("click","#backend-pill li a",function(){
    
        var tabName = $(this).attr('id');
    
        if(tabName == 'primary-tab')
        {
            $(".buttonPrevious").css('visibility', 'hidden');
        }else {
            $(".buttonPrevious").css('visibility', 'visible');
        }
                
    });
    $(".surveyEditSubmitBtn").click(function (e) {

            var $this = $(this);
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var isValidFirstPage = true;
            var msg = '';
            
            if( ($("#start_date").val() == '') && $("#end_date").val() != ''){
                isValidFirstPage = false;
                msg += '<br /> Please Select Start Date.';
            }

            if( ($("#end_date").val() == '') && $("#start_date").val() != ''){
                isValidFirstPage = false;
                msg += '<br /> Please Select End Date.';
            }
            //alert(isValidFirstPage);

            if(isValidFirstPage == false){                
                toastr.remove();
                toastr["error"](msg);
               // return false;
            }else {
                //alert('sdsdf');
                //disable the submit button
                
                $('#updatesurvey').submit();
                $(".surveySaveSubmitBtn").attr("disabled", true);
               // return true;
            }

            

        });
    
   
</script>



@include('admin.surveys.scriptsExtra')  
@include('admin.surveys.scriptsLibrary')
@include('admin.surveys.scriptsSkipLogic')