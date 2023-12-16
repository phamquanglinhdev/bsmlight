"use strict";$((function(){var e,a=$(".datatables-permissions"),t=baseUrl+"app/user/list";a.length&&(e=a.DataTable({ajax:assetsPath+"json/permissions-list.json",columns:[{data:""},{data:"id"},{data:"name"},{data:"assigned_to"},{data:"created_date"},{data:""}],columnDefs:[{className:"control",orderable:!1,searchable:!1,responsivePriority:2,targets:0,render:function(e,a,t,n){return""}},{targets:1,searchable:!1,visible:!1},{targets:2,render:function(e,a,t,n){return'<h6 class="text-nowrap mb-0 fw-normal">'+t.name+"</h6>"}},{targets:3,orderable:!1,render:function(e,a,n,s){for(var r=n.assigned_to,o="",l={Admin:'<a href="'+t+'"><span class="badge rounded-pill bg-label-primary m-1">Administrator</span></a>',Manager:'<a href="'+t+'"><span class="badge rounded-pill bg-label-warning m-1">Manager</span></a>',Users:'<a href="'+t+'"><span class="badge rounded-pill bg-label-success m-1">Users</span></a>',Support:'<a href="'+t+'"><span class="badge rounded-pill bg-label-info m-1">Support</span></a>',Restricted:'<a href="'+t+'"><span class="badge rounded-pill bg-label-danger m-1">Restricted User</span></a>'},d=0;d<r.length;d++){o+=l[r[d]]}return'<span class="text-nowrap">'+o+"</span>"}},{targets:4,orderable:!1,render:function(e,a,t,n){return'<span class="text-nowrap">'+t.created_date+"</span>"}},{targets:-1,searchable:!1,title:"Actions",orderable:!1,render:function(e,a,t,n){return'<span class="text-nowrap"><button class="btn btn-sm btn-icon btn-text-secondary rounded-pill btn-icon me-2" data-bs-target="#editPermissionModal" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="mdi mdi-pencil-outline mdi-20px"></i></button><button class="btn btn-sm btn-icon btn-text-secondary rounded-pill btn-icon delete-record"><i class="mdi mdi-delete-outline mdi-20px"></i></button></span>'}}],order:[[1,"asc"]],dom:'<"d-flex justify-content-sm-between justify-content-center align-items-center mx-3 px-1 flex-column flex-sm-row"<"me-sm-3 me-0"f><"dt-action-buttons "B>>t<"row mx-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',language:{sLengthMenu:"Show _MENU_",search:"Search:",searchPlaceholder:""},buttons:[{text:"Add Permission",className:"add-new btn btn-primary mb-3 mb-sm-0",attr:{"data-bs-toggle":"modal","data-bs-target":"#addPermissionModal"},init:function(e,a,t){$(a).removeClass("btn-secondary")}}],responsive:{details:{display:$.fn.dataTable.Responsive.display.modal({header:function(e){return"Details of "+e.data().name}}),type:"column",renderer:function(e,a,t){var n=$.map(t,(function(e,a){return""!==e.title?'<tr data-dt-row="'+e.rowIndex+'" data-dt-column="'+e.columnIndex+'"><td>'+e.title+":</td> <td>"+e.data+"</td></tr>":""})).join("");return!!n&&$('<table class="table"/><tbody />').append(n)}}},initComplete:function(){this.api().columns(3).every((function(){var e=this,a=$('<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Role </option></select>').appendTo(".user_role").on("change",(function(){var a=$.fn.dataTable.util.escapeRegex($(this).val());e.search(a?"^"+a+"$":"",!0,!1).draw()}));e.data().unique().sort().each((function(e,t){a.append('<option value="'+e+'" class="text-capitalize">'+e+"</option>")}))}))}})),$(".datatables-permissions tbody").on("click",".delete-record",(function(){e.row($(this).parents("tr")).remove().draw()}))}));