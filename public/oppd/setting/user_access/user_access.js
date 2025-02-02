getCallback('getRoleUser', null, function(response){
    swal.close()
    mappingRoleUser(response.roleUser)
    mappingRole(response.role)
})
getActiveItems('getRole',null, 'select_role_edit', 'Role')
getActiveItems('getUser',null, 'select_user_edit', 'User')
onChange('select_user','user')
onChange('select_role','role')
onChange('select_user_edit','user_edit')
onChange('select_role_edit','role_edit')
// Operation
    $('#btn_add_role_user').on('click', function(){
        getActiveItems('getRole',null, 'select_role', 'Role')
        getActiveItems('getUser',null, 'select_user', 'User')
        $('.message_error').html('')
        $('#role').val('')
        $('#user').val('')
    })
    
    $('#btn_save_role_user').on('click', function(){
        var data = {
            'role'  : $('#role').val(),
            'user'  : $('#user').val(),
        }
        postCallback('addRoleUser', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#addRoleUserModal').modal('hide')
            getCallbackNoSwal('getRoleUser', null, function(response){
                mappingRoleUser(response.roleUser)
                mappingRole(response.role)
            })
        })
     })

     $('#role_user_table').on('click','.edit', function(){
        $('#editRoleUserModal').modal('show')
        $('#select_user_edit').prop('disabled', true)
        var role = $(this).data('role')
        var user = $(this).data('user')
        $('#role_edit').val(role)
        $('#user_edit').val(user)
        $('#select_role_edit').val(role)
        $('#select_user_edit').val(user)
        $('#select_user_edit').select2().trigger('change')
        $('#select_role_edit').select2().trigger('change')
     })

     $('#btn_update_role_user').on('click', function(){
        var data = {
            'user_edit' : $('#user_edit').val(),
            'role_edit' : $('#role_edit').val(),
        }
        postCallback('updateRoleUser', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#editRoleUserModal').modal('hide')
            getCallbackNoSwal('getRoleUser', null, function(response){
                mappingRoleUser(response.roleUser)
                mappingRole(response.role)
            })
        })
     })

      // Role Permission
         // Add Role Permission
         $('#role_permission_table').on('click','.addPermission', function(){
            var id = $(this).data('id');
            $('#addPermissionModal').modal('show')
            $.ajax({
                url: 'getRolePermissionDetail',
                type: "get",
                dataType: 'json',
                data:{
                    'id':id
                },
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#roleIdPermissionAdd').val(id)
                    mappingInactive(response.inactive)
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to delete record, please contact ICT Developer');
                }
            });   
        })

        $('#btnAddRolePermission').on('click', function(){
            var checkArray = [];
            var lengthParsed = 0;
            var rolePermissionInactiveTable = $('#rolePermissionInactiveTable').dataTable();
            var rowcollection =  rolePermissionInactiveTable.$("input:checkbox[name=check]:checked",{"page": "all"});
            rowcollection.each(function(){
                checkArray.push($(this).data("name"));
            });

            lengthParsed = checkArray.length;
            if(lengthParsed == 0)
            {
                toastr['error']('Cannot be null');
                return false;
            }

            var data ={
                'checkArray':checkArray,
                'roleIdPermissionAdd':$('#roleIdPermissionAdd').val(),
            }
            postCallback('saveRolePermission',data,function(response){
                swal.close()
                toastr['success'](response.meta.message)
                $('#addPermissionModal').modal('hide')
                getCallbackNoSwal('getRoleUser', null, function(response){
                    mappingRoleUser(response.roleUser)
                    mappingRole(response.role)
                })

            })
        })
        $('#checkAllPermissionInnactiveTable').on('click', function(){
            // Get all rows with search applied
            var table = $('#rolePermissionInactiveTable').DataTable();
            var rows = table.rows({ 'search': 'applied' }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    

// Add Role Permission

// Delete Role Permission
    $('#role_permission_table').on('click','.deletePermission', function(){
        $('#deletePermissionModal').modal('show')
        var id = $(this).data('id');
        $.ajax({
            url: 'getRolePermissionDetail',
            type: "get",
            dataType: 'json',
            data:{
                'id':id
            },
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#roleIdPermissionDelete').val(id)
                mappingActive(response.active)
            },
            error: function(response) {
                swal.close();
                toastr['error']('Failed to delete record, please contact ICT Developer');
            }
        });   
    })
    $('#btnDeleteRolePermission').on('click', function(){
        var checkArray = [];
        var lengthParsed = 0;
        var rolePermissionActiveTable = $('#rolePermissionActiveTable').dataTable();
        var rowcollection =  rolePermissionActiveTable.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });

        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Cannot be null');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'roleIdPermissionDelete':$('#roleIdPermissionDelete').val(),
        }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "destroyRolePermission",
            type: "get",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                if(response.status==500)
                {
                    toastr['error'](response.message);
                    return false
                }else{
                    toastr['success'](response.message);
                    $('#deletePermissionModal').modal('hide')
                    getCallbackNoSwal('getRoleUser', null, function(response){
                        mappingRoleUser(response.roleUser)
                        mappingRole(response.role)
                    })
                }
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    })
    $('#checkAllPermissionActiveTable').on('click', function(){
        // Get all rows with search applied
        var table = $('#rolePermissionActiveTable').DataTable();
        var rows = table.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });
    
// Delete Role Permission
// Role Permission
// Operation


// Function
function mappingRoleUser(response){
    var data =''
    $('#role_user_table').DataTable().clear();
    $('#role_user_table').DataTable().destroy();
    for(i =0; i < response.length; i++){
        data += `
            <tr>
                <td>${response[i].employee_id}</td>
                <td>${response[i].userName}</td>
                <td>${response[i].rolesName}</td>
                <td style="text-align:center">
                    <button title="Detail" class="edit btn btn-sm btn-primary rounded" data-user="${response[i].user_id}" data-role="${response[i].role_id}" data-toggle="modal" data-target="#editRoleUserModal">
                            <i class="fas fa-solid fa-eye"></i>
                    </button>
                
                </td>
            </tr>
        `
    }
    $('#role_user_table > tbody:first').html(data);    
    var table = $('#role_user_table').DataTable({
        scrollX     : true,
        scrollY     :300,
        // language: {
        //         'paginate': {
        //         'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
        //         'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
        //         }
        //     },
        // scrollY     :300,
        // searching   :false
    }).columns.adjust()
    autoAdjustColumns(table)
}
function mappingRole(response){
    var data =''
    $('#role_permission_table').DataTable().clear();
    $('#role_permission_table').DataTable().destroy();
    for(i = 0; i < response.length; i ++){
        data +=`
            <tr>
                <td>${response[i].name}</td>
                <td style="text-align:center">
                    <button title="Add Permission" class="addPermission btn btn-sm btn-success rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#addPermission">
                            <i class="fas fa-solid fa-plus"></i>
                    </button>    
                    <button title="List" class="deletePermission btn btn-sm btn-danger rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#deletePermissionModal">
                            <i class="fas fa-solid fa-list"></i>
                    </button>    
                </td>
            </tr>
        `;
    }
    $('#role_permission_table > tbody:first').html(data);    
    var table = $('#role_permission_table').DataTable({
        scrollX     : true,
        scrollY     :300,
        // language: {
        //         'paginate': {
        //         'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
        //         'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
        //         }
        //     },
        // searching   :false
    }).columns.adjust()
    autoAdjustColumns(table)
}

function mappingInactive(response){
    var data =''
    $('#rolePermissionInactiveTable').DataTable().clear();
    $('#rolePermissionInactiveTable').DataTable().destroy();
    for(i = 0; i < response.length; i ++){
        data +=`
            <tr>
                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-name="${response[i]['name']}"></td>
                <td>${response[i].name}</td>
            </tr>
        `;
    }
    $('#rolePermissionInactiveTable > tbody:first').html(data);    
    var table = $('#rolePermissionInactiveTable').DataTable({
        scrollX     : true,
        scrollY     :false,
        language: {
            'paginate': {
            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
            }
        },
        // searching   :false
    }).columns.adjust()
    autoAdjustColumns(table)
}
// Mapping Active
function mappingActive(response){
    var data =''
    $('#rolePermissionActiveTable').DataTable().clear();
    $('#rolePermissionActiveTable').DataTable().destroy();
    console.log(response)
    for(i = 0; i < response.length; i ++){
        data +=`
            <tr>
                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-name="${response[i]['id']}"></td>
                <td>${response[i].name}</td>
            </tr>
        `;
    }
    $('#rolePermissionActiveTable > tbody:first').html(data);    
    var table = $('#rolePermissionActiveTable').DataTable({
        scrollX     : true,
        scrollY     :false,
        language: {
            'paginate': {
            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
            }
        },
        // searching   :false
    }).columns.adjust()
    autoAdjustColumns(table)
}
// Mapping Active
// Function