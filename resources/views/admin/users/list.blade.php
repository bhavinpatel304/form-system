@extends('layouts.admin')
@section('page_title', 'Users')
@section('content')
@include('admin.common.header')
<div class="home">
   <div class="page-content container-fluid  dashboard-theme wow fadeIn " data-wow-duration="4s">
      <?php $data=[
        
            'mainTitle' => "Users",
            'breadCrumbTitle' => "Users",
            'breadCrumbUrl'=> "admin_users",
            


        ]  ?>
   
      @include('admin.common.breadcrumb', $data)      
      <div class="row mb-2">
         <div class="col-12 P-10">
            <div class="card">
               <div class="header">
                  <div class="row">
                     <div class="page_title tHeading col-sm-4 d-flex  ">
                        <h2 class="align-self-center">All Users</h2>
                     </div>
                     <div class="col-sm-8 text-right">
                        <div class="inline-block add_btn ">                            
                            <a href="{{  url('/') }}/{{ Route::getRoutes()->getByName('admin_adduser')->uri() }}" class="btn btn-s-sm btn-br-success waves-effect waves-light   mr-2" data-toggle="" id=""><i class="fa fa-plus mr-2"></i>Add</a>                           
                        </div>
                     </div>
                  </div>
               </div>
               <div class="table-theme">
                   <table id="ajax-table" class="display table  table-striped nowrap " style="width:100%">
                    <thead>
                        <tr>
                            
                                <th  width="1%" id="select" class="text-center v-middle">
                               
                                    <div class="checkbox">
                                        <label class="pure-material-checkbox">
                                            <input name="select_all"  type="checkbox">
                                            <span></span>
                                        </label>
                              </div>

                                </th>
                        
                            <th width="12%" class="text-left">Name</th>
                            <th width="20%" class="text-left v-middle" >Clients</th>
                            <th width="12%" class="text-left">Email</th>
                            <th width="12%" class="text-left">Mobile</th>
                            <th width="12%" class="text-left">Role</th>                
                            <th  width="5%" class="text-left">Status</th>         
                            <th  width="10%" class="text-center">Action</th> 
                        
                        </tr>
                        <tr>
                            <td colspan="1" rowspan="1"></td>
                            <td colspan="1" rowspan="1"><input id="user_name" name="user_name" class="form-control search-input-text " placeholder="Search" type="text"></td>
                            <td colspan="1" rowspan="1"><input id="company_name" name="company_name" class="form-control search-input-text " placeholder="Search" type="text"></td>
                            <td colspan="1" rowspan="1"><input name="email" id="email" class="form-control search-input-text " placeholder="Search" type="text"></td>
                            <td colspan="1" rowspan="1"><input name="mobile" id="mobile" class="form-control search-input-text " placeholder="Search" type="text"></td>
                            <td colspan="1" rowspan="1">
                                <div class=" w-150  ">
                                    <select id="role" class="select2_cls form-control">
                                        <option value="">All</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td colspan="1" rowspan="1">
                                <div class=" w-150  ">
                                    <select id="status" class="select2_cls form-control">
                                        <option value="">All</option>
                                        <option value="{{ (new \App\Http\Helpers\Common)::$intStatusActive }}">Active</option>
                                        <option value="{{ (new \App\Http\Helpers\Common)::$intStatusInActive }}">Inactive</option>
                                    </select>
                                </div>
                            </td>
                            <td colspan="1" class="text-center" rowspan="1">
                            
                            </td>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
 
 
               </div>
      
               </div>
            </div>
            </div>
         </div>
      
      </div>
   
   </div>
</div>
<?php

        $user_data_table_columns_array = array(
            array('data' =>  "bulkaction", 'name' =>  "bulkaction" , 'class' =>'text-center v-middle' ,'orderable'=> false, 'searchable'=> false),
            array('data' =>  "name", 'name' =>  "name",'class' =>'text-left v-middle'),
            array('data' =>  "company_name", 'name' =>  "company_name",'class' =>'text-wrap-datatable'),
            
            array('data' => "email", 'name' => "email",'class' =>'text-left v-middle'),
            array('data' => "contact_number", 'name' => "contact_number",'class' =>'text-left v-middle'),           
            array('data' => "role_name", 'name' => "role_name",'class' =>'text-left v-middle'), 
            array('data' => "status", 'name' => "status",'class' =>'text-left v-middle'),           
            array('data' => "action", 'name' => "action" , 'orderable'=> false, 'searchable'=> false, 'class' =>'text-center v-middle'),
        );
    
?>

@include('admin.common.footer')      
@endsection

@section('styles')
@parent
@include('admin.common.datatablecss')
@endsection

@section('jscode')
    
    @include('admin.common.multidatatables') 
    <script type="text/javascript">

        var urllink = "{{ route('admin_userlist') }}";
        var statuslink = "{{ route('admin_changeuserstatus') }}";
        var MSG_STATUS_CHOOSE = "{!! env('MSG_STATUS_CHOOSE') !!}";
        var MSG_RECORD_CHOOSE =  "{!! env('MSG_RECORD_CHOOSE') !!}";
        var MSG_STATUS_CHANGE_SUCCESS = "{!! env('MSG_STATUS_CHANGE_SUCCESS') !!}";
        var MSG_STATUS_CHANGE_ERROR = "{!! env('MSG_STATUS_CHANGE_ERROR') !!}";
        var params = {
            'data_table_columns': <?php echo json_encode($user_data_table_columns_array); ?>,
            'data_table_order_by': [],
            'columnDefsCust': [],
            'tblid': "#ajax-table",
            'urllink' : "{{ route('admin_userlist') }}"
        }
        var usertbl = datatables(params);   

        var status_drop_ele = "<select id='status_drop' class='form-control float-left'><option value=''>Select</option><option value='{{ (new \App\Http\Helpers\Common)::$intStatusActive }} '> Active</option><option value='{{ (new \App\Http\Helpers\Common)::$intStatusInActive }}'>  Inactive</option></select><button id='btnaction' class='btn btn-s-sm btn-success waves-effect waves-light ml-2'>Apply</button>";
        function ajax_call_delete(chk_array)
        {
            $.ajax({
                url: "{{  url('/') }}/{{ Route::getRoutes()->getByName('admin_deleteuser')->uri() }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //data:$(form).serialize(),
                data:{ 'select_all' : chk_array },
                method:'post',
                success:function(data){
                    if(data.suc == "1")
                    {
                        toastr["success"]("User Deleted Successfully.");
                        usertbl.ajax.reload();
                    }
                },
                error:function(data){
                // console.log(data)
                }
            });
        }

        function ajax_call_resend_activation(chk_array)
        {
            $.ajax({
                url: "{{  url('/') }}/{{ Route::getRoutes()->getByName('admin_resend_activation')->uri() }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //data:$(form).serialize(),
                data:{ 'select_all' : chk_array },
                method:'post',
                beforeSend: function() {
                        $('.loading_footer').css('display', 'flex');
                },
                success:function(data){
                     $('.loading_footer').hide();
                    if(data.suc == "1")
                    {
                        toastr["success"]("Activation email sent successfully.");
                       // usertbl.ajax.reload();
                    }
                },
                error:function(data){
                // console.log(data)
                }
            });
        }
            
        
    </script>
    <script src="{{ asset('js/custom/admin/users/list.js') }}" type="text/javascript"></script> 
@endsection
@section('blockUI')

@endsection