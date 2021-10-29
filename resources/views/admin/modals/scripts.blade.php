<script>
    $(".number").numeric();


    $("#changepassword").on("show.bs.modal", function(e) {
         $('#changepassword').find('form').trigger('reset');
    });

    $("#changepasswordfrm").submit(function(e){
        
         e.preventDefault(); // avoid to execute the actual submit of the form.
         var form = $(this);
         var url = form.attr('action');
           $.ajax({
                    type: "POST",
                    url: url,                 
                    data : new FormData($('#changepasswordfrm')[0]),                    
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                        $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        $('#changepassword').modal('toggle');
                        if(data.status == 0){                        
                            toastr["error"]("Problem changing password.");
                        } else {                   
                            toastr["success"]("Password changed successfully.");
                        }
                        
                        
                    }
                }); 

    });
    $('body').on('click', '.showProfileModal', function (){  
        var url = '{{ route("getprofile") }}';
        $.ajax({
           url: url,
           method: 'get',
            beforeSend: function() {
                $('.loading_footer').css('display', 'flex');
           },
           success: function(data) {
               $('.loading_footer').hide();
               console.log(data);
              var data = JSON.parse(data); 
              
              
              
              if ( data.length != 0 ) {
   
               
                 var status = data.status.toString();
               
                 $('#profilemodall').find('form').trigger('reset');
                 $("#profilemodall .modal-body #fname").val(data.data.fname);
                 $("#profilemodall .modal-body #lname").val(data.data.lname);
                 $("#profilemodall .modal-body #contact_number_profile").val(data.data.contact_number);
                 $("#profilemodall .modal-body #email").val(data.data.email);
                 $("#profilemodall .modal-body #profile_photo_img").attr("src",data.data.profile_image);
                 $('#profilemodall').modal('show');
              
           
              }
           
     
           },error: function(data) {
                          $(".modal-body").html('<div class="col-12 tab-content"><div class="alert alert-info tab-content text-center"><strong>There is some problem loading client data!</strong></div></div>');
                    $(".modal-footer").hide();
                     $('#profilemodall').modal('show');
           }
        });
    });
    $("#profilemodall").on("show.bs.modal", function(e) {       
       
    });
    
    $("#profile-edit").submit(function(e){
        toastr.remove();
        e.preventDefault(); // avoid to execute the actual submit of the form.
         var form = $(this);
         var url = form.attr('action');
         $.ajax({
                    type: "POST",
                    url: url,                 
                    data : new FormData($('#profile-edit')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                        $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        $('#profilemodall').modal('toggle');
                        if(data.status == 0){
                        
                            toastr["error"]("Problem updating profile.");
                        } else {
                            
                            $( "div.username" ).html( data.data.name + '<i class=" fa fa-angle-down  ml-3"></i>' );
                            $( "div.usernameMenu" ).html('<h6 class="user-name m-b-0">'+ data.data.name +'</h6>' );
                            $('#header_img').attr('src', data.data.image);                            
                            toastr["success"]("Profile Updated Successfully.");
                        }
                        
                        
                    }
                }); 
        
    });
</script>