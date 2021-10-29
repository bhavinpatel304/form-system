


<script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.rowreorder.js') }}"></script>
<script src="{{ asset('js/datatables/select.js') }}"></script>
<script src="{{ asset('js/datatables/time.js') }}"></script>

<script type="text/javascript">
 var rows_selected = [];
  var table;

{{--
/* usage

   var params = {
                'data_table_columns': php_column_array
                'data_table_order_by': [ [1, 'ASC'] ],     
                'columnDefsCust': [],
                'tblid': "#data-table-is",
                'data': {}
                'urllink' : "{{ route('routename') }}"
               }


*/
--}}



// for multiple datatble on same page without  checkbox functions
function datatables(param)
{
   //$.fn.dataTable.moment( 'hh:mm A' );
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   

   if(typeof param.tblid === 'undefined' )
   {
      tblid = "#ajax-table";
   }

   if(typeof param.data === 'undefined' )
   {
      param.data = {};
   }

   if(typeof param.reorder === 'undefined' )
   {
      param.reorder = false;
   }
   else
   {
      param.reorder = {
         // dataSrc: 'order_by'
         selector: 'tr',
      }
   }

   

   
   // "<'header'<'row'<'page_title tHeading col-sm-6 d-flex  '>  <'header-dropdown col-sm-6 '<'inline-block add_btn '>> >>" +
   table  = $(param.tblid).DataTable({
      dom: 
         "tr" +
         "<'panel-footer'<'row'<'col-lg-4 col-md-4 col-sm-12 text-center-xs  status_drop'><'col-lg-4 col-md-3 col-sm-12 text-center info-padding 'i><'col-lg-4 col-md-5 col-sm-12 text-center-xs 'p> >>",
         "bSortCellsTop": true,
         "deferRender": true,        
         "scrollX": true,
         "sFilterInput": "dataTables_filter custom_filter_class form-control",
         "sPaginationType": "listbox",
         ajax: {
            url: param.urllink,
            type: 'POST',
            data: param.data,
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         },
         "processing": true,
         "serverSide": true,
         "iDisplayLength": 10,
         "aLengthMenu": [ [ 2, 3, 50, 100] , [ '2', '3', '50', '100'] ] ,
         columns: param.data_table_columns,
         "order":param.data_table_order_by,
         "language": {
            "search": "",
            "searchPlaceholder": "",
            "InfoEmpty": "No entries to show"
         },
         'rowCallback': function(row, data, dataIndex){
            $("#bulck_select").prop("checked", false);
         },       
         "columnDefs": param.columnDefsCust,
         "language": {
            "emptyTable": "{{ Lang::get('messages.empty_datatble') }}",
            //"processing": "<i class='fa fa-refresh fa-spin'></i>",
            "processing": '<div class="loading_footer"> <div class="progress"><div class="indeterminate"></div></div></div>',
         },
        
         'drawCallback': function(settings) {           
            var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');            
            if(this.api().page.info().pages == 0)
            {
               pagination.hide();
            }
               else
               {
                  pagination.show();
               }
         
         },
         rowReorder: param.reorder
   });

   return table;
}


$(document).ready(function(){
  
   var $user_id = '';
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
      $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
   } );

   // Handle click on "Select all" control
   $('thead input[name="select_all"]' ).on('click', function(e){

  
      if(this.checked){
         $('table tbody input[name="chkbox"]:not(:checked)').trigger('click');
      } else {
         $('table tbody input[name="chkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
      });
      // Handle click on checkbox
      $('table').on('click', 'input[type="checkbox"]', function(e){
         var $row = $(this).closest('tr');

         // Get row data
         var data = table.row($row).data();

         // Get row ID
         var rowId = data.id;
      
         // Determine whether row ID is in the list of selected row IDs 
         var index = $.inArray(rowId, rows_selected);

         // If checkbox is checked and row ID is not in list of selected row IDs
         if(this.checked && index === -1){
            rows_selected.push(rowId);

         // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
         } else if (!this.checked && index !== -1){
            rows_selected.splice(index, 1);
         }

      
         // Update state of "Select all" control
         updateDataTableSelectAllCtrl(table);

         // Prevent click event from propagating to parent
         e.stopPropagation();
      });
      function updateDataTableSelectAllCtrl(table)
      {
         var $table             = table.table().node();
         var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
         var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
         var $selected    = $('tr td input[type="checkbox"]:checked', $table);
         //var $tablechk    = $('tr td input[type="checkbox"]', $table);
         var $tablechk    = $('tr td input[type="checkbox"]:not(:disabled)', $table);
         var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);
      
         if( $('table').find('thead input[name="select_all"]').get(0) === undefined )
         {
            return;
         }

         if($chkbox_checked.length === 0){
            chkbox_select_all.checked = false;
            if('indeterminate' in chkbox_select_all){
               chkbox_select_all.indeterminate = false;
            }
         }
         else if ($chkbox_checked.length === $chkbox_all.length){
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
               chkbox_select_all.indeterminate = false;
            }
         } else {
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
               chkbox_select_all.indeterminate = false;
            }
         }
         if($selected.length < $tablechk.length)
         {
            $('thead input[name="select_all"]').prop('checked',false);
         }
         else if($selected.length == $tablechk.length && $selected.length > 0)
         {
            $('thead input[name="select_all"]').prop('checked',true);
         }
         else{}
      }
      // Handle table draw event
      table.on('draw', function(){
         // Update state of "Select all" control
         updateDataTableSelectAllCtrl(table);
      });
});

</script>