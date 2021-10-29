/*********User Data Tables start*************/
function user_page()
{    
    pageTitle = " <h2 class='align-self-center'>System Users List</h2> ";
add_btn = "<a href='?page=add-users&submenu=settings' class='btn btn-s-sm btn-primary waves-effect waves-light   mr-2'  data-toggle=''  id=''><i class='fa fa-plus mr-2'></i>Add</a></a> ";
status_drop = "<select class='select2_cls'><option value='1'>All</option><option value='0'> Active</option><option value='0'>  Inactive</option><option value='3'> Archived</option></select><button class='btn btn-s-sm btn-primary waves-effect waves-light   ml-2'>Apply</button>";

$('#user').DataTable({
dom: "<'header'<'row'<'page_title tHeading col-sm-6 d-flex  '>  <'header-dropdown col-sm-6 '<'inline-block add_btn '>> >>" +
    "tr" +
    "<'panel-footer'<'row'<'col-lg-4 col-md-4 col-sm-12 text-center-xs  status_drop'><'col-lg-4 col-md-3 col-sm-12 text-center info-padding 'i><'col-lg-4 col-md-5 col-sm-12 text-center-xs 'p> >>",
"processing": true,
"bSortCellsTop": true,
"deferRender": true,
"order": [],
"scrollX": true,
"scrollY": true,
"sFilterInput": "dataTables_filter custom_filter_class form-control",
"sPaginationType": "listbox",
ajax: {
url: "./json/users.json",
type: 'POST',
},
"order": [],
    columns: [
        {data: "checkbox"},
         {data: "code"},
        {data: "name"},
        {data: "email"},
        {data: "mobile"},
        {data: "position"},
        {data: "timezone"},
        {data: "loaction"},
        {data: "action"},
    ],
"language": {
"search": "",
"searchPlaceholder": "Test",
"InfoEmpty": "No entries to show"
},
"sFilterInput": "form-control",
    "columnDefs": [
        {
            "targets": [0,8], //last column
            "orderable": false //set not orderable
        },
        {
            "targets": [], //to hide column
            "visible": false
        },
        {
            className: "v-middle",
            "targets": []
        },
        {
            className: "text-center v-middle",
            "targets": [0,8]
        },
    ]
});
if (pageTitle != "") {
$('.page_title').html(pageTitle);
}
if (add_btn != "") {
$('.add_btn').html(add_btn);
}
if (status_drop != "") {
$(".status_drop").html(status_drop);
}
}
user_page();
/*********User Data Tables End*************/
 