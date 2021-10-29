

@extends('layouts.admin')
@section('page_title', 'Clients')
@section('content')
@include('admin.common.header')
<div class="home">
   <div class="page-content container-fluid  dashboard-theme wow fadeIn " data-wow-duration="4s">
      <?php $data=[
         'mainTitle' => "Clients",
         'breadCrumbTitle' => "Clients",
         'breadCrumbUrl'=> "clientslist"
         ]  ?>
      @include('admin.common.breadcrumb', $data)      
      <div class="row mb-2">
         <div class="col-12 P-10">
            <div class="card">
               <div class="header">
                  <div class="row">
                     <div class="page_title tHeading  col-lg-3 col-md-12 d-flex  ">
                        <h2 class="align-self-center pageHeading">Active Clients</h2>
                     </div>
                     <div class="header-dropdown  col-lg-9 col-md-12">
                        <div class="theme-search">
                           <input type="search" id="company_name_val" value="" name="company_name_val" placeholder="Search company name">
                            <a href="javascript:void(0)"  class="search_icon" id="search_company">
                               <img src="{{ asset('images/search.svg') }}" width="20" height="25" alt="icon">
                            </a>
                        </div>
                        <div class="activeTabe">
                           <ul class="nav">
                              <li class="nav-item">
                                 <a class="nav-link searchBtns searchBtnActive active" data-status="1" data-toggle="tab" href="#active-tab"
                                    onclick="changePageHeading('Active Clients')">Active</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link searchBtns searchBtnInActive" data-toggle="tab" data-status="2" href="#inactive-tab"
                                    onclick="changePageHeading('Inactive Clients')">Inactive</a>
                              </li>
                              
                              
                           </ul>
                        </div>
                        <input type="hidden" name="statusVal" id="statusVal" value="1" />
                        <input type="hidden" name="dataEnds" id="dataEnds" value="" />
                        {{-- <a href="javascript:void(0)"  class="btn btn-danger btn-md   waves-effect waves-light clearBtn searchBtns" id=""><i class="fa fa-refresh" onclick="changePageHeading('All Clients')" title="Clear"></i></a> --}}
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addcompany"
                           class="btn btn-br-success btn-md   waves-effect waves-light " id=""><i
                           class="fa fa-plus mr-2"></i>Add</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 tab-content">
            <div id="active-tab" class="tab-pane active">
               <div class="row clientsData">
                  @include ('admin.clients.search')
               </div>
            </div>
            
         </div>
      </div>
   </div>
</div>
@include('admin.common.footer')      
@include('admin.modals.add_client')      
@include('admin.modals.edit_client')      
@endsection
@section('jscode')
{{-- @include('admin.common.alertifyDeleteCommon')       --}}
<script>
   $(".number").numeric();
   var offset = 0;
   $('body').on('click', '.clearBtn', function (){
         $('body').find('.searchBtns').removeClass('active');
   });
   
   $('body').on('click', '.showEditModal', function (){   
      var id = $(this).data('target-id');
         var url = '{{ route("getcompany", ":id") }}';
         url = url.replace(':id', id);
         
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
                        var data = JSON.parse(data);    
                        
                        if ( data.length != 0 ) {
               
                           
                           var status = data.status.toString();
                           
                           $('#editcompany').find('form').trigger('reset');
                           $("#editcompany .modal-body #company_name_edit").val(data.company_name);
                           $("#editcompany .modal-body #contact_number_edit").val(data.contact_number);
                           $("#editcompany .modal-body #email_edit").val(data.email);
                           $("#editcompany .modal-body #website_edit").val(data.website);
                           $("#editcompany .modal-body #description_edit").val(data.description);
                           $("#editcompany .modal-body #company_logo_img_edit").attr("src",data.company_logo);
                           $("#editcompany .modal-body #client_id").val(id);
                           $("#editcompany .modal-body #status_edit").select2("val",status);
                           
                           $("#editcompany .modal-body #company_name_edit").attr('data-validation-req-params', '{"id":'+id+'}');
                              $('#editcompany').modal('show');
                        
                     
                        }
                     
               
                     },error: function(data) {
                                    $(".modal-body").html('<div class="col-12 tab-content"><div class="alert alert-info tab-content text-center"><strong>There is some problem loading client data!</strong></div></div>');
                              $(".modal-footer").hide();
                              $('#editcompany').modal('show');
                     }
               });
         
         
            
         
         
              
   });
      // $('body').on('click', '.removeMe', function (){
      // event.preventDefault();
      //     var $this = $(this);
          
        
      //    alertify.genericDialog || alertify.dialog('genericDialog',function(){
      //       return {
      //          main:function(content){
      //                this.setContent(content);
      //          },
      //          setup:function(){
      //                return {
      //                   focus:{
      //                      element:function(){
      //                            return this.elements.body.querySelector(this.get('selector'));
      //                      },
      //                      select:true
      //                   },
      //                   options:{
      //                      basic:true,
      //                      maximizable:false,
      //                      resizable:false,
      //                      padding:false
      //                   }
      //                };
      //          },
      //          settings:{
      //                selector:undefined
      //          }
      //       };
      //    });
      //    alertify.genericDialog ($('#deleteRecordForm')[0]).set({title:"Action"});

      // }); 
   $('body').on('click', '.inactiveActiveLink', function (){
      event.preventDefault();
          var $this = $(this);
           var $status = $($this).data('status');
           var alertifyMsg = "Are you sure to inactivate this Client ?";
           if($status == 1){
             var alertifyMsg = "Are you sure to activate this Client ?";
           }
          alertify.confirm(alertifyMsg, function (e) {
            if (e) {
				var id = $($this).data('id');
           
             var messageSuccess = "Client Inactivated Successfully."
             var messageError = "Problem Inactivating Client.";
             
            if($status == 1){
               
                var messageSuccess = "Client Activated Successfully.";
                var messageError = "Problem Activating Client.";
            }
               var url = '{{ route("inactivateActivatecompany") }}';
               
               $.ajax({
                    type: "POST",
                     url: url,                 
                     data: { 
                        'id': id, 
                        'status':$status
                     },
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                       
                        toastr.remove();
                       $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        
                        if(data.status == 0){
                        
                            toastr["error"](messageError);
                        }  else {                 
                           toastr["success"](messageSuccess);
                           resetAll();
                           
                           
                           
                        }
                        
                        
                    }
                }); 
               
            } else {            
              return false; 
            }        
        }).set({title:"Action"}).set(
                                      {
                                         labels:{ok:'Yes', cancel: 'No'},
                                         
                                      }
                                      ).set('defaultFocus', 'cancel').set('reverseButtons', false); 
   });
      
   $('body').on('click', '.removeMe', function (){
      event.preventDefault();
          var $this = $(this);
   
          alertify.confirm("Are you sure to delete this Client ?", function (e) {
            if (e) {
				var id = $($this).data('id');
               var url = '{{ route("deletecompany") }}';
               
               $.ajax({
                    type: "POST",
                     url: url,                 
                     data: { 
                        'id': id, 						
                     },
                     beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                        toastr.remove();
                       $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        
                        if(data.status == 0){
                        
                            toastr["error"]("Problem Deleting Client.");
                        }  else if(data.status == 2){
                           toastr["error"]("Sorry!!! This client is already associated to user and can not be deleted.");
                            
                        } else {                 
                           toastr["success"]("Client Deleted Successfully.");
                           resetAll();
                           
                           
                           
                        }
                        
                        
                    }
                }); 
               
            } else {            
              return false; 
            }        
        }).set({title:"Action"}).set(
                                      {
                                         labels:{ok:'Yes', cancel: 'No'},
                                         
                                      }
                                      ).set('defaultFocus', 'cancel').set('reverseButtons', false);   
   });
   
   
   $.validate({
      form: '#addcompanyfrm, #editcompanyfrm',
      modules: 'security , file',
      validateOnBlur: true,
   });


   $(window).scroll(function() {
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
         
         
            var statusVal  = $('#statusVal').val();
            
            if(statusVal == ''){
               $("#company_name_val").val('');
               var company_name = '';
            }else {
            var company_name =  $("#company_name_val").val();    
            }
            offset = offset + 1;
            
            
            getClientData(company_name,statusVal,offset,true);
            
            
      }
   });
   
   function getClientData(company_name,statusVal,offset,isAppend = false){
      $(".link").tooltip('hide');
      $(".inactiveActiveLink").tooltip('hide');

      if($('#dataEnds').val() == ''){
      
         $.ajax({
               url: "{{ route('searchclients') }}",
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {
                  company_name: company_name,
                  status: statusVal,               
                  offset:offset,
               },
               method: 'post',
               beforeSend: function() {
                  $("body").append('<div id="overlayLoader" style="background-color:transparent;position:absolute;top:0;left:0;height:100%;width:100%;z-index:999"></div>');
               $('.loading_footer').css('display', 'flex');
               },
               success: function(data) {
                  $("#overlayLoader").remove();     
                  $('.loading_footer').hide();
                  if(isAppend){
                     //console.log(data);
                     //alert(document.getElementsByClassName('no-data').length);
                     //var noResultsLength = $(data).find('div').length;
                     var noResultsLength = $(data).closest('.no-data').length;                    
                     
                     if (noResultsLength != 1) {
                        $('.clientsData').append(data);   
                     }else {
                        $("#dataEnds").val('1');
                        
                     }
                  } else {
                     $('.clientsData').html(data);
                  }
                  
               },
               error: function(data) {
                  
               }
               
         
         });
      }
   
   
   
   
   }

   $(".searchBtns").click(function(){
   
      $('#statusVal').val($(this).data('status'))
      var statusVal  = $('#statusVal').val();
      $("#dataEnds").val('');
      
      if(statusVal == ''){
         $("#company_name_val").val('');
      var company_name = '';
      }else {
      var company_name =  $("#company_name_val").val();    
      }
      offset = 0;
      isAppend = false;
      getClientData(company_name,statusVal,offset,isAppend);
   });
   
   $('body').on('click', '#search_company', function (){
        $("#dataEnds").val('');
        var company_name =  $("#company_name_val").val();
        var statusVal  = $('#statusVal').val();
        offset = 0;
        isAppend = false;
       
        getClientData(company_name,statusVal,offset,isAppend);
   
   });

   $("#company_name_val").keypress(function(e){
      
      var key = e.which;
      if(key == 13)  // the enter key code
      {
         $("#dataEnds").val('');
         var company_name =  $(this).val();
         var statusVal  = $('#statusVal').val();
         offset = 0;
         isAppend = false;
         
         getClientData(company_name,statusVal,offset,isAppend);
      }
   
   });

   window.onbeforeunload = function () {
      window.scrollTo(0, 0);
   }

   
   
   
   
   
   
   $("#addcompany").on("hidden.bs.modal", function (e) {
       $('#addcompany').find('form').trigger('reset');
       var default_image_url = {!! json_encode(url('/images/' . env('DEFAULT_COMPANY_IMAGE','')) ) !!}       
       $("#addcompany .modal-body #company_logo_img").attr("src",default_image_url);
   
   
   });
   
   
   $("#addcompanyfrm").submit(function(e){
        
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $(this);
      var url = form.attr('action');
      $.ajax({
                    type: "POST",
                    url: url,                 
                    data : new FormData($('#addcompanyfrm')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                       $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        $('#addcompany').modal('toggle');
                        if(data.status == 0){
                        
                            toastr["error"]("Problem adding client.");
                        } else {                 
                           toastr["success"]("Client Added Successfully.");
                           resetAll();
                           
                        }
                        
                        
                    }
                }); 

   });
   
   $("#editcompanyfrm").submit(function(e){
        toastr.remove();
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $(this);
      var url = form.attr('action');
      $.ajax({
                    type: "POST",
                    url: url,                 
                    data : new FormData($('#editcompanyfrm')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                     },
                    success: function(data)
                    {
                       $('.loading_footer').hide();
                        var data = $.parseJSON(data);
                        $('#editcompany').modal('toggle');
                        if(data.status == 0){
                        
                            toastr["error"]("Problem updating client.");
                        } else {                 
                           toastr["success"]("Client Updated Successfully.");
                           resetAll();
                           
                        }
                        
                        
                    }
                }); 

   });
   function resetAll(){
      // $('body').find('.searchBtnActive').addClass('active');
      // $('body').find('.searchBtnInActive').removeClass('active');
      $("#dataEnds").val('');
      //$("#company_name_val").val('');
      //$("#statusVal").val(1);

      var company_name =  $("#company_name_val").val();
      var statusVal  = $('#statusVal').val();
      offset = 0;
      isAppend = false;
      getClientData(company_name,statusVal,offset,isAppend);
   }
   
</script>
@endsection

