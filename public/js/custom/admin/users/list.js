$(document).ready(function(){   

   status_drop = status_drop_ele;
   if (status_drop != "") {
      $(".status_drop").html(status_drop);
   }
   
   $('#role').select2();

   $('#status').select2();
   
   $('body').on('click','#btnaction', function(e){
      toastr.remove();
      //console.log(rows_selected);
      status_id = $('#status_drop').val();
      if(status_id == 0 )
      {
         toastr["error"](MSG_STATUS_CHOOSE);
         return false;
      }
      else if( rows_selected.length === 0 )
      {
         toastr["error"](MSG_RECORD_CHOOSE);
         return false;
      }
      else
      {

      }

      $.ajax({
         url: statuslink,
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{ 'users_id' : rows_selected , 'status_id' :  status_id },
         method:'post',
         success:function(data)
         {
            table.ajax.reload();

            console.log(data)
            if(data.success)
            {
               toastr["success"](MSG_STATUS_CHANGE_SUCCESS);
               // window.showAlert = function(){         
               //    alertify.notify(MSG_STATUS_CHANGE_SUCCESS, 'customSuccess', 2, function(){console.log('dismissed');});
               // }
               // window.showAlert();
            }
            else
            {
               toastr["error"](MSG_STATUS_CHANGE_ERROR);

               // window.showAlert = function(){
                 
               //    // alertify.set('notifier','position', alertify_position);
               //    // alertify.error( MSG_STATUS_CHANGE_ERROR );
               //    alertify.notify(MSG_STATUS_CHANGE_ERROR, 'customSuccess', 2, function(){console.log('dismissed');});
               // }
               // window.showAlert();
            }            
         },
         error:function(data)
         {
            // window.showAlert = function(){
            //       alertify.set('notifier','position', alertify_position);
            //       alertify.error( MSG_STATUS_CHANGE_ERROR );
            // }
            // window.showAlert();

            toastr["error"](MSG_STATUS_CHANGE_ERROR);

         }
      });
      rows_selected = [];
   });


   $('table').on('click', '.delete', function (){
      event.preventDefault();
          
          var chk_array = $(this).data('id');
          alertify.confirm("Are you sure to delete this User ?", function (e) {
              if (e) {
                                  ajax_call_delete(chk_array);
              } else {            
              return false; 
              }        
          }).set({title:"Action"}).set(
                                      {
                                          labels:{ok:'Yes', cancel: 'No'},
                                          
                                      }
                                      ).set('defaultFocus', 'cancel').set('reverseButtons', false);   

                                      $('input[name="id\[\]"]', form).remove();
    });
    

   $('table').on('click', '.resend_activation', function () {
      event.preventDefault();

      var chk_array = $(this).data('id');
      alertify.confirm("Are you sure to resend activation link to this user ?", function (e) {
         if (e) {
            ajax_call_resend_activation(chk_array);
         } else {
            return false;
         }
      }).set({ title: "Action" }).set(
         {
            labels: { ok: 'Yes', cancel: 'No' },

         }
      ).set('defaultFocus', 'cancel').set('reverseButtons', false);

     // $('input[name="id\[\]"]', form).remove();
   });
  


   $('table').on('keyup', '#user_name', function() {
         usertbl.columns(1).search(this.value).draw();
   });
   

   $('table').on('keyup', '#company_name', function() {
      usertbl.columns(2).search(this.value).draw();
   });


   $('table').on('keyup', '#email', function() {
         usertbl.columns(3).search(this.value).draw();
   });
   $('table').on('keyup', '#mobile', function() {        
         usertbl.columns(4).search(this.value).draw();
   });
   $('table').on('change', '#role', function() {        
         usertbl.columns(5).search(this.value).draw();
   });
   $('table').on('change', '#status', function() {        
      usertbl.columns(6).search(this.value).draw();
});

});