<script>

$(document).on("change",".editmodal",function(){

    

});

$(document.body).on('click', '.deletePage', function (){
        event.preventDefault();
        var $this = $(this);
        alertify.confirm("Are you sure to delete this Page ?", function (e) {
            if (e) 
            {
                //enableDisableSortableFeature();
                    var pageId = $($this).data('remove-page-id'); 
                    
                    var url = '{{ route("deletesurveypage") }}';
                    var currentRouteName = '{{ Route::currentRouteName() }}';
                    var user_id = '{{ Auth::id() }}';
                    var data = {
                            
                            page_number:pageId,
                            user_id:user_id,
                            survey_id:'',
                            
                        };
                    if(currentRouteName == 'editsurvey'){
                        
                        var data = {
                                    
                                    page_number:pageId,
                                    user_id:user_id,
                                    survey_id: $("#survey_id").val(),
                                    

                                };
                    }
                    $.ajax({
                            type: "POST",
                            url: url,    
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },             
                            data: data,
                            beforeSend: function() {
                                $('.loading_footer').css('display', 'flex');
                            },
                            success: function(data){

                                $('.loading_footer').hide();
                                var data = JSON.parse(data);
                                var is_data_available = data.is_data_available;
                           
                           
                                if(is_data_available){
                                    var tmpIdsArrayCount = Object.keys(data.tmpIdsArray).length;
                                    
                                    if(tmpIdsArrayCount > 0){

                                        $.each(data.tmpIdsArray, function(key, value) {                                            
                                            
                                            $('#clsSkipLogic_'+value).prop("checked",false).trigger("change");                                 
                                        });    
                                    }
                                }
                            }
                                
                                
                            
                    }); 
                    $(document.body).find(".pageClasses[data-page-id='" + pageId +"']").remove();                 
                    $(document.body).find(".pageDiv[id='page" + pageId +"']").remove();

                    
                    $( ".pageClasses" ).each(function(index){
                        var num = index + 1;
                        var currPageId = $(this).attr('data-page-id');
                        if(currPageId > pageId){
                            
                            //console.log($(this).attr('data-page-id'));
                            $(this).attr('data-page-id', num );
                            $(this).find('a').attr('href',"#page" + num).text('PAGE ' + num).attr('id','page-tab-'+num);
                            $(this).find('a').append('&nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" aria-hidden="true" data-remove-page-id="'+ num + '" data-toggle="tooltip" title="" data-original-title="Delete Page" data-placement="right"></i>');

                        }
                    });

                    $( ".pageDiv" ).each(function(index){
                        
                        var num = index + 1;
                        var currPageId = $(this).attr('id');
                        currPageId = currPageId.replace('page',"");
                        
                        if(currPageId > pageId){
                            
                            $klon = $(this);
                            $klon.attr('id',"page"+ num ).attr('aria-labelledby','page'+ num);
                            $klon.find("#page_number").val(num);
                            $klon.find("#page_number_count").val(num);
                            
                            // Mittul updated starts 
                            $klon.find(".show_headingLabel").attr('for' ,'show_heading_' + num );
                            $klon.find(".show_heading").attr('id' ,'show_heading_' + num );

                            $klon.find(".show_sub_headingLabel").attr('for' ,'show_subheading_' + num );
                            $klon.find(".show_subheading").attr('id' ,'show_subheading_' + num );


                            // Mittul updated ends 

                            $klon.find(".show_heading").attr('name' ,'show_heading_' + num );
                            $klon.find(".show_subheading").attr('name' ,'show_subheading_' + num );
                            $klon.find(".survey_heading").attr('name' ,'survey_heading_' + num );
                            $klon.find(".survey_sub_heading").attr('name' ,'survey_sub_heading_' + num );
                            $klon.find(".is_heading_bold").attr('name' ,'is_heading_bold_' + num );
                            $klon.find(".is_heading_italic").attr('name' ,'is_heading_italic_' + num );
                            $klon.find(".is_heading_underline").attr('name' ,'is_heading_underline_' + num );
                            $klon.find(".is_subheading_bold").attr('name' ,'is_subheading_bold_' + num );
                            $klon.find(".is_subheading_italic").attr('name' ,'is_subheading_italic_' + num );
                            $klon.find(".is_subheading_underline").attr('name' ,'is_subheading_underline_' + num );
                            $klon.find(".survey_heading_fontSizeBtn").attr('name' ,'survey_heading_fontSize_' + num );
                            $klon.find(".survey_sub_heading_fontSizeBtn").attr('name' ,'survey_sub_heading_fontSize_' + num );
                            $klon.find(".heading-picker-color").attr('name' ,'heading_fg_color_' + num );
                            $klon.find(".sub-picker-color").attr('name' ,'sub_heading_fg_color_' + num );
                            $klon.find(".heading-picker-bckgrd").attr('name' ,'heading_bg_color_' + num );
                            $klon.find(".sub-picker-bckgrd").attr('name' ,'sub_heading_bg_color_' + num );
                            $('.select2_cls').select2();

                            

                            // updating page as per each record 
                            var url = '{{ route("updatesurveypage") }}';
                            var currentRouteName = '{{ Route::currentRouteName() }}';
                            var user_id = '{{ Auth::id() }}';
                            var data = {                                    
                                    
                                    user_id:user_id,
                                    survey_id:'',
                                    currPageId,currPageId,
                                    pageId:num
                                    
                                };
                            if(currentRouteName == 'editsurvey'){
                                
                                var data = {                                           
                                            
                                            user_id:user_id,
                                            survey_id: $("#survey_id").val(),
                                            currPageId,currPageId,
                                            pageId:num
                                            

                                        };
                            }
                            $.ajax({
                                    type: "POST",
                                    url: url,    
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },             
                                    data: data,
                                    beforeSend: function() {
                                        $('.loading_footer').css('display', 'flex');
                                    },
                                    success: function(data){
                                        $('.loading_footer').hide();
                                         enableDisableSortableFeature();
                                    }
                                        
                                        
                                    
                            }); 
                        
                        }
                    });

                  

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


                    var countMenuDiv = $( ".pageClasses" ).length;
                    if(countMenuDiv == 1){
                        var $div = $( ".pageClasses" ).first();    
                        $div.find('a i').remove();    
                    }
                    
                    

                    var num = 1;
                    $klon = $( ".pageDiv" ).first();    
                    $klon.attr('id',"page"+ num ).attr('aria-labelledby','page'+ num);
                    $klon.find("#page_number").val(num);
                    $klon.find("#page_number_count").val(num);


                    // Mittul updated starts 
                    $klon.find(".show_headingLabel").attr('for' ,'show_heading_' + num );
                    $klon.find(".show_heading").attr('id' ,'show_heading_' + num );

                    $klon.find(".show_sub_headingLabel").attr('for' ,'show_subheading_' + num );
                    $klon.find(".show_subheading").attr('id' ,'show_subheading_' + num );
                    // Mittul updated ends 


                    $klon.find(".show_heading").attr('name' ,'show_heading_' + num );
                    $klon.find(".show_subheading").attr('name' ,'show_subheading_' + num );
                    $klon.find(".survey_heading").attr('name' ,'survey_heading_' + num );
                    $klon.find(".survey_sub_heading").attr('name' ,'survey_sub_heading_' + num );
                    $klon.find(".is_heading_bold").attr('name' ,'is_heading_bold_' + num );
                    $klon.find(".is_heading_italic").attr('name' ,'is_heading_italic_' + num );
                    $klon.find(".is_heading_underline").attr('name' ,'is_heading_underline_' + num );
                    $klon.find(".is_subheading_bold").attr('name' ,'is_subheading_bold_' + num );
                    $klon.find(".is_subheading_italic").attr('name' ,'is_subheading_italic_' + num );
                    $klon.find(".is_subheading_underline").attr('name' ,'is_subheading_underline_' + num );
                    $klon.find(".survey_heading_fontSizeBtn").attr('name' ,'survey_heading_fontSize_' + num );
                    $klon.find(".survey_sub_heading_fontSizeBtn").attr('name' ,'survey_sub_heading_fontSize_' + num );
                    $klon.find(".heading-picker-color").attr('name' ,'heading_fg_color_' + num );
                    $klon.find(".sub-picker-color").attr('name' ,'sub_heading_fg_color_' + num );
                    $klon.find(".heading-picker-bckgrd").attr('name' ,'heading_bg_color_' + num );
                    $klon.find(".sub-picker-bckgrd").attr('name' ,'sub_heading_bg_color_' + num );
                    $('.select2_cls').select2();

                    $(".pageClasses").removeClass("active");
                    $(".pageClasses").removeClass("show");

                    $(".pageDiv").removeClass("active");
                    $(".pageDiv").removeClass("show");
        

                      // Showing last menu 
                    var $div = $(document.body).find(".pageClasses a").last();
                    var $pageClasses = $(document.body).find(".pageClasses ");
                    // console.log($div);
                    // console.log('sdsd');
                    $div.addClass('active');
                    $div.addClass('show');
                    $( $pageClasses).each(function( index ) {
                        $(this).addClass('transparentDiv');
                    });
                    
                    

                    // showing last page 
                    var $div = $(document.body).find(".pageDiv").last();
                    $div.addClass('active');
                    $div.addClass('show');
                    enableDisableSortableFeature();

                   
                    
                        
            } 
            else 
            {            
                return false; 
            } 
        }).set({title:"Action"}).set(
                                        {
                                           labels:{ok:'Yes', cancel: 'No'},
                                           
                                        }
                                        ).set('defaultFocus', 'cancel').set('reverseButtons', false);   
  });
$(document).on("click",".add-new-page",function(){

    var isDataEmptyArray = [];
                        
    $(document.body).find('.addQuestion').each(function(index){
        var QuestionData = $.trim($(this).html());
        if(QuestionData == ''){
            isDataEmptyArray.push("1");
        } 
        
    });

    if ($.inArray('1', isDataEmptyArray) != -1)
    {
        toastr.remove();
        toastr["error"]("Please add questions in existing pages first.");
        return false;
    }
    /* For Menu Starts */

    var maximum = null;

        $( ".pageDiv" ).each(function(){
            var value = parseInt( $(this).attr("id").match(/\d+/g), 10 );
        //    var value = parseFloat($(this).val());

             maximum = (value > maximum) ? value : maximum;

            
       });


    var $div = $( ".pageClasses" ).last();
    // var num = parseInt( $div.attr("data-page-id").match(/\d+/g), 10 ) +1;
    var num = maximum  + 1;
    var hrefId = $div.find('a:first').attr('href');
    
    var $klon = $div.clone().attr('data-page-id', num );
    $div.after( $klon );


    
    var $div = $( ".pageClasses" ).last();
    $div.find('a').attr('href',"#page" + num).text('PAGE ' + num).attr('id','page-tab-'+num);
    $div.find('a').append('&nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" aria-hidden="true" data-remove-page-id="'+ num + '" data-toggle="tooltip" title="" data-original-title="Delete Page" data-placement="right"></i>');
    /* For Menu ENDS */


    /* For PAGE Starts */
    $(document.body).find(".select2_cls").each(function(index){
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            } 
    });

    

       console.log(maximum);
    var $pageDiv = $( ".pageDiv" ).last();
    var tabName = $("#backend-pill").find('a.active').attr('id');
    
    // var num = parseInt( $pageDiv.attr("id").match(/\d+/g), 10 ) +1;
    var num = maximum  + 1;
    var $klon = $pageDiv.clone();
    
    
    $klon.find(".show_heading").prop('checked', false);
    $klon.find(".survey_heading").val("").end();
    $klon.find(".survey_heading").removeClass('bold');
    $klon.find(".survey_heading").removeClass('italic');
    $klon.find(".survey_heading").removeClass('underline');    
    $klon.find('.survey_heading').attr('disabled','disabled'); 
    $klon.find('.survey_heading').removeAttr('style'); 
    $klon.find('.survey_heading_bold').parent().removeClass('active'); 
    $klon.find('.survey_heading_italic').parent().removeClass('active'); 
    $klon.find('.survey_heading_underline').parent().removeClass('active'); 
    $klon.find('.heading-picker-color').removeAttr('style'); 
    $klon.find('.heading-picker-color').val('#000'); 
    $klon.find('.heading-picker-bckgrd').removeAttr('style'); 
    $klon.find('.heading-picker-bckgrd').val('#fff'); 
    


    $klon.find(".show_subheading").prop('checked', false);
    $klon.find(".survey_sub_heading").val("").end();
    $klon.find(".survey_sub_heading").removeClass('bold');
    $klon.find(".survey_sub_heading").removeClass('italic');
    $klon.find(".survey_sub_heading").removeClass('underline');
    $klon.find('.survey_sub_heading').removeAttr('style');     
    $klon.find('.survey_sub_heading').attr('disabled','disabled');  
    $klon.find('.survey_sub_heading_bold').parent().removeClass('active'); 
    $klon.find('.survey_sub_heading_italic').parent().removeClass('active'); 
    $klon.find('.survey_sub_heading_underline').parent().removeClass('active'); 
    

    $klon.find('.sub-picker-color').removeAttr('style'); 
    $klon.find('.sub-picker-color').val('#000'); 
    $klon.find('.sub-picker-bckgrd').removeAttr('style'); 
    $klon.find('.sub-picker-bckgrd').val('#fff');
    

    $klon.find(".is_heading_bold").val("2").end();
    $klon.find(".is_heading_italic").val("2").end();
    $klon.find(".is_heading_underline").val("2").end();
    $klon.find(".is_subheading_bold").val("2").end();
    $klon.find(".is_subheading_italic").val("2").end();
    $klon.find(".is_subheading_underline").val("2").end();
    
    
     
     
    
    $klon.attr('id',"page"+ num ).attr('aria-labelledby','page'+ num);
    
    $pageDiv.after( $klon );
    
    $klon.find('.addQuestion').empty();
    
    $klon.find("#page_number").val(num);
    $klon.find("#page_number_count").val(num);

    // Mittul updated starts 
    $klon.find(".show_headingLabel").attr('for' ,'show_heading_' + num );
    $klon.find(".show_heading").attr('id' ,'show_heading_' + num );

    $klon.find(".show_sub_headingLabel").attr('for' ,'show_subheading_' + num );
    $klon.find(".show_subheading").attr('id' ,'show_subheading_' + num );

    // Mittul updated ends 

    $klon.find(".show_heading").attr('name' ,'show_heading_' + num );
    $klon.find(".show_subheading").attr('name' ,'show_subheading_' + num );
    $klon.find(".survey_heading").attr('name' ,'survey_heading_' + num );
    $klon.find(".survey_sub_heading").attr('name' ,'survey_sub_heading_' + num );
    $klon.find(".is_heading_bold").attr('name' ,'is_heading_bold_' + num );
    $klon.find(".is_heading_italic").attr('name' ,'is_heading_italic_' + num );
    $klon.find(".is_heading_underline").attr('name' ,'is_heading_underline_' + num );
    $klon.find(".is_subheading_bold").attr('name' ,'is_subheading_bold_' + num );
    $klon.find(".is_subheading_italic").attr('name' ,'is_subheading_italic_' + num );
    $klon.find(".is_subheading_underline").attr('name' ,'is_subheading_underline_' + num );
    $klon.find(".survey_heading_fontSizeBtn").attr('name' ,'survey_heading_fontSize_' + num );
    $klon.find(".survey_sub_heading_fontSizeBtn").attr('name' ,'survey_sub_heading_fontSize_' + num );
    $klon.find(".heading-picker-color").attr('name' ,'heading_fg_color_' + num );
    $klon.find(".sub-picker-color").attr('name' ,'sub_heading_fg_color_' + num );
    $klon.find(".heading-picker-bckgrd").attr('name' ,'heading_bg_color_' + num );
    $klon.find(".sub-picker-bckgrd").attr('name' ,'sub_heading_bg_color_' + num );
    $klon.find(".survey_heading_fontSizeBtn").val(12).trigger('change');
    $klon.find(".survey_sub_heading_fontSizeBtn").val(12).trigger('change');
    $('.select2_cls').select2();
   
    if(tabName != 'primary-tab' && tabName != 'welcome-tab'){
        //console.log(tabName);
        //$pageDiv.removeClass('active');
         //$pageDiv.removeClass('show');
        $(".pageDiv").removeClass("active");
        $(".pageDiv").removeClass("show");
       
        $klon.addClass('active');
        $klon.addClass('show');
        $( ".pageClasses a" ).removeClass("active");
        $( ".pageClasses a" ).last().addClass("active");

    }

            var countMenuDiv = $( ".pageClasses" ).length;
            if(countMenuDiv == 2){
                    var $div = $( ".pageClasses" ).first();    
                    $div.find('a').append('&nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" aria-hidden="true" data-remove-page-id="'+ 1 + '" data-toggle="tooltip" title="" data-original-title="Delete Page" data-placement="right"></i>');
                    }
    
    
            var containers = $klon.find('.addQuestion').toArray();
    
                dragula([document.getElementById("card-drag-area")]), dragula(containers).on("drag", function (e) {
                    e.className = e.className.replace("card-moved", "")
                }).on("drop", function (e) {
                    var page_number = $(e).closest('.pageDiv').find('#page_number').val();
                    //console.log(page_number);
                    orderNumbers = [];
                    dataIds = [];
                    $("#page" + page_number).find('.dataClass').each(function (i) {
                        orderNumbers[i] = i + 1;
                        dataIds[i] = $(this).data('id');
                        $(this).find('.question_number').html(i + 1);
                        //console.log($(this).data('id'));
                    });
                    $.ajax({
                        url: urlOrder,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { dataIds: dataIds, orderNumbers: orderNumbers },
                        method: 'post',
                        beforeSend: function () {
                            $('.loading_footer').css('display', 'flex');
                        },
                        success: function (data) {

                            $('.loading_footer').hide();


                        }, error: function (data) {

                        }
                    });
                    // console.log(orderNumbers);
                    // console.log(dataIds);
                    e.className += " card-moved"
                }).on("over", function (e, t) {
                    t.className += " card-over"
                }).on("out", function (e, t) {
                    t.className = t.className.replace("card-over", "")
                }), dragula([document.getElementById("copy-left"), document.getElementById("copy-right")], {
                    copy: !0
                }), dragula([document.getElementById("left-handles"), document.getElementById("right-handles")], {
                    moves: function (e, t, n) {
                        return n.classList.contains("handle")
                    }
                }), dragula([document.getElementById("left-titleHandles"), document.getElementById("right-titleHandles")], {
                    moves: function (e, t, n) {
                        return n.classList.contains("titleArea")
                    }
                })

                //console.log(tabName);
                 if(tabName == 'primary-tab'){
                    $(".buttonPrevious").css('visibility', 'hidden');
                }else {
                    $(".buttonPrevious").css('visibility', 'visible');
                }

   
    //console.log($("#backend-pill").find('a.active').attr('id'));

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

    $($klon).find(".select2_cls").select2(); 

    $(document.body).find("#questionData").val("");
    $(document.body).find("#questionData").blur(function(){}).blur();

    enableDisableSortableFeature();
    /* For PAGE ENDS */
});
   




  var current = 1,current_step,next_step,steps;
  steps = $("fieldset").length;
  $(".next").click(function(){
    current_step = $(this).parent();
    next_step = $(this).parent().next();
    next_step.show();
    current_step.hide();
    setProgressBar(++current);
  });
  $(".previous").click(function(){
    current_step = $(this).parent();
    next_step = $(this).parent().prev();
    next_step.show();
    current_step.hide();
    setProgressBar(--current);
  });
  setProgressBar(current);
  // Change progress bar action
  function setProgressBar(curStep){
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    //$(".progress-bar").css("width",percent+"%").html(percent+"%");   

    $(".progress-bar").css("width",percent+"%");
    $(".progress-bar-percentage").html(percent+"%"+" Completed");       
  }


  


  $(document).on("click","#backend-pill .nav-item",function(){
    
    
        var $div = $(this).find("a");
        if($div.attr('href') != 'javascript:void(0)'){
            
            $div.parent().prevAll().addClass('transparentDiv');
            var $divAllMenu = $(document.body).find("#backend-pill li a");
            $( $divAllMenu).each(function( index ) {           
                $(this).removeClass('active');
                $(this).removeClass('show');
            });
            $div.parent().addClass('transparentDiv');
            $div.addClass('active');
            $div.addClass('show');

            $(document.body).find("#myTabContent #primary").removeClass('active');
            $(document.body).find("#myTabContent #primary").removeClass('show');

            $(document.body).find("#myTabContent #welcome").removeClass('active');
            $(document.body).find("#myTabContent #welcome").removeClass('show');


            var $divAllMenu = $(document.body).find(".pageDiv");
            $( $divAllMenu).each(function( index ) {           
                $(this).removeClass('active');
                $(this).removeClass('show');
            });
            var pageName = $div.attr('href');
            pageName = pageName.substring(1, pageName.length);
            
            $(document.body).find("#myTabContent #" + pageName).addClass('active');
            $(document.body).find("#myTabContent #" + pageName).addClass('show');
        }
        
        if($div.attr('href') == '#primary'){
            $(".buttonPrevious").css('visibility', 'hidden');
        }
        else if($div.attr('href') == 'javascript:void(0)'){
          //  $(".buttonPrevious").css('visibility', 'hidden');
        }
        else {
            $(".buttonPrevious").css('visibility', 'visible');
        }
       // console.log('sds');
        

  });

</script>
  <script>
function sortableEnable() {
    $(".sortableUl").sortable({
      items: "li:not(.unsortable)",
      start: function(e, ui) {
       
       ui.item.startPos = ui.item.index();
        },
        stop: function(e, ui) {
            
            var newIndex = parseInt(ui.item.index()) - 1 ;

            var oldIndex = parseInt(ui.item.startPos) - 1;
            
            var arrupdatePageNumber = [];
            $( ".pageClasses" ).each(function(index){

                var $this = $(this);

                num = index + 1;               
                

                $(this).attr('data-page-id', num);
                $(this).find('a').attr('href',"#page" + num).text('PAGE ' + num).attr('id','page-tab-'+num);

                $(this).find('a').append('&nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" aria-hidden="true" data-remove-page-id="'+ num + '" data-toggle="tooltip" title="" data-original-title="Delete Page" data-placement="right"></i>');

                
               
            });

            // page index changed from greater value to lesser value 
            if(newIndex <  oldIndex)
            {
                
                $klon = $(document.body).find(".pageDiv[id='page" + oldIndex +"']");
                $klon.attr('id',"page"+ newIndex + "###");
                //updatePageNumberAjax(oldIndex,newIndex+'000000','no');             
                arrupdatePageNumber.push({
                    oldPageNumber:oldIndex, 
                    newPageNumber:newIndex + '000000',
                    checkDragValue:'no'
                });
               
                
                for(i=newIndex;i<oldIndex;i++)
                {
                    $klon = $(document.body).find(".pageDiv[id='page" + i +"']");
                    $klon.each(function(){
                        if(!$(this).hasClass('changed')){         
                            num = (i + 1);
                            var oldPageNumber = i;
                            $klon = $(this);
                            updatePageNumber(num,$klon);                                 
                            //updatePageNumberAjax(oldPageNumber,num);               
                            arrupdatePageNumber.push({
                                oldPageNumber:oldPageNumber, 
                                newPageNumber:num,
                                checkDragValue:'yes'
                            });
                            
                        }
                    });
                    
                }

                $klon = $(document.body).find(".pageDiv[id='page" + newIndex +"###']");
                updatePageNumber(newIndex,$klon);
                //updatePageNumberAjax(newIndex + '000000',newIndex,'no');               
                 arrupdatePageNumber.push({
                                oldPageNumber:newIndex + '000000', 
                                newPageNumber:newIndex,
                                checkDragValue:'no'
                            });
                
                
                
            }
            else
            {                

                $klon = $(document.body).find(".pageDiv[id='page" + oldIndex +"']");
                $klon.attr('id',"page"+ newIndex + "###");
               // updatePageNumberAjax(oldIndex,newIndex+'000000','no');  
                arrupdatePageNumber.push({
                    oldPageNumber:oldIndex, 
                    newPageNumber:newIndex + '000000',
                    checkDragValue:'no'
                });
                for(i=oldIndex;i<newIndex;i++)
                {
                    var currPageNumber = (i + 1);
                    var updatedPageNumber = (currPageNumber - 1);
                    
                    
                    $klon = $(document.body).find(".pageDiv[id='page" + currPageNumber +"']");
                    $klon.each(function(){
                        if(!$(this).hasClass('changed')){         
                            num = updatedPageNumber;
                            var oldPageNumber = currPageNumber;
                            $klon = $(this);
                            updatePageNumber(num,$klon);               
                            //updatePageNumberAjax(oldPageNumber,num);                                
                            arrupdatePageNumber.push({
                                oldPageNumber:oldPageNumber, 
                                newPageNumber:num,
                                checkDragValue:'yes'
                            });
                        }
                    });
                }

                $klon = $(document.body).find(".pageDiv[id='page" + newIndex +"###']");
                updatePageNumber(newIndex,$klon);
                //updatePageNumberAjax(newIndex + '000000',newIndex,'no');
                arrupdatePageNumber.push({
                                oldPageNumber:newIndex + '000000', 
                                newPageNumber:newIndex,
                                checkDragValue:'no'
                            });
                
                
            }
            
            
            $(".pageDiv").removeClass("changed");
            

            $('.select2_cls').select2();
            
            $(".pageDiv").removeClass("active");
            $(".pageDiv").removeClass("show");

            $("#primary").removeClass("active");
            $("#primary").removeClass("show");


            $("#welcome").removeClass("active");
            $("#welcome").removeClass("show");

                        

            var $divAllMenu = $(document.body).find("#backend-pill li");
            $($divAllMenu).each(function (index) {
                $(this).find('a').removeClass('active');
                $(this).find('a').removeClass('show');
                $(this).removeClass('transparentDiv');
                
            });



            $($divAllMenu).each(function (index) {
                if (!$(this).hasClass("pageClasses")) {
                    $(this).addClass('transparentDiv');
                }
            });
            for(i=1;i<=newIndex;i++)
            {
                
                var $divMenu = $(document.body).find(".pageClasses[data-page-id='" + i + "']");
                
                $divMenu.addClass('transparentDiv');
            }

            var $divSelectedMenu = $(document.body).find(".pageClasses[data-page-id='" + newIndex + "']");
            $divSelectedMenu.find('a').addClass('active');
            $divSelectedMenu.find('a').addClass('show');

            var $divPage = $(document.body).find(".pageDiv[id='page" + newIndex +"']");                
            $divPage.addClass('active');
            $divPage.addClass('show');


            updatePageNumberAjaxArray(arrupdatePageNumber);
            removeDraggableValueAjax();

          
        }
    });

    $(".sortableUl").disableSelection();  

}

function sortableDisable() {
    $( ".sortableUl" ).sortable();
    $('.sortableUl').unbind('sort');
    $( ".sortableUl").sortable("destroy");
    
  }

enableDisableSortableFeature();
  function enableDisableSortableFeature(){
      
      var totalPages =  $(document.body).find('.pageDiv').length;
      
      if(totalPages > 1){
        sortableEnable();
      }else {          
        sortableDisable();
      }
  }


  function updatePageNumber(num,$klon)
  {
    $klon.attr('id',"page"+ num ).attr('aria-labelledby','page'+ num);
    $klon.find("#page_number").val(num);
    $klon.find("#page_number_count").val(num);
    
    
    $klon.find(".show_headingLabel").attr('for' ,'show_heading_' + num );
    $klon.find(".show_heading").attr('id' ,'show_heading_' + num );

    $klon.find(".show_sub_headingLabel").attr('for' ,'show_subheading_' + num );
    $klon.find(".show_subheading").attr('id' ,'show_subheading_' + num );

    $klon.find(".show_heading").attr('name' ,'show_heading_' + num );
    $klon.find(".show_subheading").attr('name' ,'show_subheading_' + num );
    $klon.find(".survey_heading").attr('name' ,'survey_heading_' + num );
    $klon.find(".survey_sub_heading").attr('name' ,'survey_sub_heading_' + num );
    $klon.find(".is_heading_bold").attr('name' ,'is_heading_bold_' + num );
    $klon.find(".is_heading_italic").attr('name' ,'is_heading_italic_' + num );
    $klon.find(".is_heading_underline").attr('name' ,'is_heading_underline_' + num );
    $klon.find(".is_subheading_bold").attr('name' ,'is_subheading_bold_' + num );
    $klon.find(".is_subheading_italic").attr('name' ,'is_subheading_italic_' + num );
    $klon.find(".is_subheading_underline").attr('name' ,'is_subheading_underline_' + num );
    $klon.find(".survey_heading_fontSizeBtn").attr('name' ,'survey_heading_fontSize_' + num );
    $klon.find(".survey_sub_heading_fontSizeBtn").attr('name' ,'survey_sub_heading_fontSize_' + num );
    $klon.find(".heading-picker-color").attr('name' ,'heading_fg_color_' + num );
    $klon.find(".sub-picker-color").attr('name' ,'sub_heading_fg_color_' + num );
    $klon.find(".heading-picker-bckgrd").attr('name' ,'heading_bg_color_' + num );
    $klon.find(".sub-picker-bckgrd").attr('name' ,'sub_heading_bg_color_' + num );
    $klon.addClass('changed');
    
  }
  function updatePageNumberAjaxArray(arrupdatePageNumber){
      var currentRouteName = '{{ Route::currentRouteName() }}';
      var url = '{{ route("updatePageNumberQuestionTmpArray") }}';
      var user_id = '{{ Auth::id() }}';
        if(currentRouteName == 'editsurvey'){
            var data = {
                            arrupdatePageNumber:arrupdatePageNumber,
                            survey_id: $("#survey_id").val(),
                            user_id:user_id,
                            
                        };
        }else{
            var data = {
                            arrupdatePageNumber:arrupdatePageNumber,
                            survey_id:'',
                            user_id:user_id,
                            
                        };
        }
        
        $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data,
                        method: 'post',
                        async: false,
                        beforeSend: function() {
                            $('.loading_footer').css('display', 'flex');
                            
                        },
                        success: function(data) { 
                            $('.loading_footer').hide();                                                 
                            //var data = JSON.parse(data);    
                                
                        },error: function(data) {
                        
                        }
                });

  }
  function removeDraggableValueAjax()
  {
        var currentRouteName = '{{ Route::currentRouteName() }}';
      var url = '{{ route("removeDraggableValue") }}';
      var user_id = '{{ Auth::id() }}';
        if(currentRouteName == 'editsurvey'){
            var data = {  
                            survey_id: $("#survey_id").val(),
                            user_id:user_id,
                        };
        }else{
            var data = {
                          
                            survey_id:'',
                            user_id:user_id,
                          
                        };
        }

        $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data,
                        method: 'post',
                        async: false,
                        beforeSend: function() {
                            $('.loading_footer').css('display', 'flex');
                        },
                        success: function(data) { 
                            $('.loading_footer').hide();                                                 
                            
                                
                        },error: function(data) {
                        
                        }
                });
        
  }

  function updatePageNumberAjax(oldPageNumber,newPageNumber,checkDragValue = 'yes')
  {
      var currentRouteName = '{{ Route::currentRouteName() }}';
      var url = '{{ route("updatePageNumberQuestionTmp") }}';
      var user_id = '{{ Auth::id() }}';
        if(currentRouteName == 'editsurvey'){
            var data = {
                            old_page_number: oldPageNumber,
                            new_page_number:newPageNumber,
                            survey_id: $("#survey_id").val(),
                            user_id:user_id,
                            checkDragValue:checkDragValue
                        };
        }else{
            var data = {
                            old_page_number: oldPageNumber,
                            new_page_number:newPageNumber,
                            survey_id:'',
                            user_id:user_id,
                            checkDragValue:checkDragValue
                        };
        }
        
         $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data,
                        method: 'post',
                        async: false,
                        beforeSend: function() {
                            $('.loading_footer').css('display', 'flex');
                        },
                        success: function(data) { 
                            $('.loading_footer').hide();                                                 
                            //var data = JSON.parse(data);    
                                
                        },error: function(data) {
                        
                        }
                });

        
  }
  </script>