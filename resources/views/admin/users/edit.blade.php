

@extends('layouts.admin')
@section('page_title', 'User')
@section('content')
@include('admin.common.header')
<div class="home">
   <div class="page-content container-fluid  dashboard-theme">
      <?php $data=[
         'mainTitle' => "Users",
         'breadCrumbTitle' => "Users",
         'breadCrumbUrl'=> "admin_users",
         'breadCrumbSubTitle' => "Edit User",
         'breadCrumbSubUrl'=> "admin_edituser"
         ]  ?>
      @include('admin.common.breadcrumb', $data)      
      <div class="row mb-2">
         <div class="col-12 P-10">
            <div class="card">
               <div class="header b-b">
                  <div class="row">
                     <div class="page_title tHeading col-sm-4 d-flex  ">
                        <h2 class="align-self-center">Edit User</h2>
                     </div>
                     <div class="col-sm-8 text-right">
                        <div class="inline-block add_btn ">                            
                           <a href="{{  url('/') }}/{{ Route::getRoutes()->getByName('admin_users')->uri() }}" class="btn btn-s-sm btn-br-success waves-effect waves-light" data-toggle="" id=""><i class="fa fa-chevron-left mr-2"></i>Back</a>                           
                        </div>
                     </div>
                  </div>
               </div>
                      <form id="frmuser" class="frmuser" role="form" method="post" enctype="multipart/form-data" name="frmuser" action="
                     {{ route('admin_updateuser',['user_id' => $user_id]) }}
                     ">
                     {{ csrf_field() }}
                     
                     <input type="hidden" name="is_company_deletable" id="is_company_deletable" value="{{ $is_company_deletable}}" />
            <input type="hidden" name="role_id_default" id="role_id_default" value="{{ $role_id}}" />
                     <div class="col-xs-12 ">
                        <div class="card-body d-flex justify-content-center">
                           <div class="col-lg-6 col-xs-12">
                              <div class="custom-group">
                                 <div class="col-lg-4 col-xs-12">
                                    <label class="col-form-label" for="fname">First Name <span class="fill-start">*</span></label>
                                 </div>
                                 <div class="col-lg-8 col-xs-12">
                                    <input class="form-control" name="fname"
                                       title="first name"
                                       data-validation="required length" 
                                     data-validation-length="2-200"
                                    data-validation-error-msg-length="Enter first name between 2-200 characters"
                                       data-validation-error-msg="{{ Lang::get('messages.fname') }}"
                                       id="fname" value="{{ old('fname') ? old('fname') : $fname }}" placeholder="Please enter first name" type="text" >
                                    <small class="error">{{$errors->first('fname')}}</small>
                                 </div>
                              </div>
                              <div class="custom-group">
                                 <div class="col-lg-4 col-xs-12">
                                    <label class="col-form-label" for="lname ">Last Name <span class="fill-start">*</span></label>
                                 </div>
                                 <div class="col-lg-8 col-xs-12">
                                    <input class="form-control" name="lname"
                                       title="last name"
                                       data-validation="required length" 
                                     data-validation-length="2-200"
                                    data-validation-error-msg-length="Enter last name between 2-200 characters"
                                       data-validation-error-msg="{{ Lang::get('messages.lname') }}"
                                       id="lname " value="{{ old('lname') ? old('lname') : $lname }}" placeholder="Please enter last name" type="text" >
                                    <small class="error">{{$errors->first('lname')}}</small>
                                 </div>
                              </div>
                              <div class="custom-group">
                                 <div class="col-lg-4 col-xs-12">
                                    <label class="col-form-label" for="email">Email<span class="fill-start">&nbsp;*</span></label>
                                 </div>
                                 <div class="col-lg-8 col-xs-12">
                                    <?php
                                       $json = json_encode(array(
                                                                  'userId'=>$user_id,                                                              
                                                               )
                                                         );
                                       ?>
                                    <input type="text" class="form-control" id="email" name="email"  placeholder="Please enter email"
                                       value="{{ old('email') ? old('email') : $email }}"
                                       data-validation-url="{{ route('checkemailexists') }}"
                                       data-validation-req-params='<?php echo $json ?>'
                                       data-validation="required email server"
                                       data-validation-error-msg-required="{{ Lang::get('messages.email.required') }}"
                                       data-validation-error-msg-email="{{ Lang::get('messages.email.email') }}"     
                                       >
                                    <small class="error">{{$errors->first('email')}}</small>
                                 </div>
                              </div>
                              <div class="custom-group">
                                 <div class="col-lg-4 col-xs-12">
                                    <label class="col-form-label" for="contact_number">Mobile Number</label>
                                 </div>
                                 <div class="col-lg-8 col-xs-12">
                                    <input type="text" class="form-control number" id="contact_number" name="contact_number"  placeholder="Please enter mobile number"
                                       value="{{ old('contact_number') ? old('contact_number') : $contact_number }}"
                                       data-validation=""
                                      
                                       data-validation-error-msg-required="{{ Lang::get('messages.contact_number.required') }}"
                                       data-validation-error-msg-number="{{ Lang::get('messages.contact_number.numeric') }}"
                                       >
                                    <small class="error">{{$errors->first('contact_number')}}</small>
                                 </div>
                              </div>
                              <div class="custom-group">
                                 <div class="col-lg-4 col-xs-12">
                                    <label class="col-form-label" for="role_id">Role<span class="fill-start">&nbsp;*</span></label>
                                 </div>
                                 
                                 
                                 <?php 
                                 $disableRole = '';
                                 if(Auth::user()->id == $id){
                                    $disableRole = 'disabled';
                                 }
                                 ?>
                                 <div class="col-lg-8 col-xs-12">
                                    <select <?= $disableRole; ?>  name="role_id" id="role_id" class="select2_cls form-control" data-validation="required"
                                       data-validation-error-msg="{{ Lang::get('messages.role') }}"
                                       >
                                    @foreach ($roles as $role)
                                    <option
                                    @if($role_id == $role->id  )
                                    selected
                                    @elseif(old('role_id')==$role->id)
                                    selected
                                    @endif
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    </select>
                                    <small class="error">{{$errors->first('role_id')}}</small>
                                 </div>
                              </div>
                              @php $required = "required"; $none=""; @endphp
                              @if(!empty($client_exclude_inactive_name)  )
                               @php $required = "" ; $none="d-none"; @endphp
                                 <div class="custom-group select-client ">
                                 
                                       <div class="col-lg-4 col-xs-12">
                                          <label class="col-form-label" for="client_id">
                                             Survey associated with these companies
                                          </label>
                                       </div>
                                       <div class="col-lg-8 col-xs-12">
                                          @foreach ($client_exclude_inactive_name as $item)
                                               @php 
                                                   if($item->status == 1)
                                                   {
                                                      $class  = "badge badge-success";
                                                      $status = "Active";
                                                   } 
                                                   else {
                                                      $class  = "badge badge-secondary";
                                                      $status = "Inactive";
                                                   }
                                                @endphp
                                                <span class=" {{ $class }} text-capitalize m-1">{{ $item->company_name }}
                                                   @if( !in_array ($item->id , $asso_survey_id ) )
                                                      <a data-id="{{ $item->id }}" class="unselect-client pl-1"><i class="close fa fa-trash"></i></a>
                                                   @endif
                                                </span>
                                             <input type="hidden" class='cls-{{ $item->id }} hdn' name="client_associated_id[]" value="{{ $item->id }}" />
                                                
                                          @endforeach

                                             @foreach ($clients as $k => $client)
                                                @if($client->status != 1 && in_array( $client->id, explode(",",$client_id) ) )
                                                   <input type="hidden" name="client_associated_id[]" value="{{ $client->id }}" />
                                                   <span class="badge badge-info text-capitalize">{{ $client->company_name }}</span>
                                                   @php
                                                      unset($clients[$k]);
                                                   @endphp
                                                @endif                                          
                                             @endforeach 
                                             

                                       </div>
                                 
                                 </div>
                              @endif

                              <div class="custom-group select-client ">
                                
                                    <div class="col-lg-4 col-xs-12">
                                       <label class="col-form-label" for="client_id">Client<span class="{{ $none }} astrick fill-start">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-lg-8 col-xs-12">
                                          {{-- multiple --}}
                                        
                                       <select name="client_id[]" multiple  id="client_id" class="select2_cls form-control"

                                    data-validation="{{ $required }}"
                                     
                                      
                                          data-validation-error-msg="{{ Lang::get('messages.client') }}"
                                          >

                                          
                                          <option value="">Select</option>
                                         
                                          @foreach ($clients as $client)
                                             <option

                                               @if($client->status != 1 )
                                                   disabled
                                                @endif

                                             @if( in_array( $client->id, explode(",",$client_id) ) ) 
                                                selected                                             
                                             @endif
                                                value="{{ $client->id }}">{{ $client->company_name }}</option>
                                             @endforeach


                                       </select>
                                       <small class="error">{{$errors->first('client_id')}}</small>
                                    </div>
                                
                              </div>


                            
                            
                           </div>

                           {{-- <p>
  <strong>Home phone number:</strong>
  <input name="home-phone" data-validation="number" 
		 data-validation-optional-if-answered="cell-phone">
</p>
<p>
  <strong>Cell phone number:</strong>
  <input name="cell-phone" data-validation="" 
		 data-validation-optional-if-answered="home-phone">
</p> --}}

                           
                        </div>
                          <div class="card-footer">
                                
                                 <div class="col-lg-12  d-flex justify-content-center">
                                    <button class="btn btn-br-success btn-s-sm waves-effect waves-light m-1" type="submit">Update</button>
                                    <a href="{{ route('admin_users') }}" class="btn btn-danger  btn-s-sm  waves-effect waves-light m-1">Cancel</a>
                                 </div>
                              </div>
                     </div>
               </div>
               </form>
            </div>
         </div>
       
      </div>

   </div>
   <div class="col-12">
      <div class="row "></div>
   </div>
</div>
</div>
</div>
@include('admin.common.footer')      
@endsection
@section('jscode')
<script>
   $(".number").numeric();
   $.validate({
            form:'#frmuser',
           onElementValidate : function(valid, $el, $form, errorMess) {
           if( !valid ) {
               // gather up the failed validations
               if($el.hasClass('select2_cls'))
               {
                   $el.next().children().find('.select2-selection').css('border','1px solid red');
               }
           }
           else{
               if($el.hasClass('select2_cls'))
               {
                   $el.next().children().find('.select2-selection').css('border','1px solid #444');
               }
           }
       }
   }
   ,{
       modules: 'logic'
   });

   
   var userrole = "{{ (new \App\Http\Helpers\Common)::$intRoleUser }}";
   
   $('#role_id').on('select2:select', function (e) { 
           var data = e.params.data;   
           
           if(data.id ==userrole)
           {
               $('.select-client').css('display', 'flex');
           }
           else{
               $('.select-client').hide();
           }
      });  

      $("#client_id").select2({
         placeholder: "  Select client",
         width: 'auto',
         allowClear: true
      });


$('.select2-search__field').css('width','auto');  

$('.unselect-client').on('click',function(){
   $val = $(this).data('id');
   $(this).parent().remove();
   $('.cls-'+$val).remove();

   $len = $('.hdn').length;

   if($len == 0)
   {
      $("#client_id").attr('data-validation','required');

      $(".astrick").addClass('d-block');
   }



});


</script>
@if( (new \App\Http\Helpers\Common)::$intRoleUser == $role_id )
<script> $('.select-client').css('display', 'flex'); </script>
@endif
@endsection

