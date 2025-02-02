getCallback('getRole',null, function(response){
    swal.close()
    mappingRole(response.data)
})
getCallbackNoSwal('getPermission',null, function(response){
    swal.close()
    mappingPermission(response.data)
})

// Operation
    // Add Role
        $('#btn_save_role').on('click', function(){
            var data ={
                'name'  : $('#name').val()
            }
        postCallback('addRole',data,function(response){
                swal.close()
                $('.message_error').html('')
                $('#addRoleModal').modal('hide')
                $('#name').val('')
                toastr['success'](response.meta.message)
                getCallbackNoSwal("getRole", null, function(response){
                    mappingRole(response.data)
                })
            })
        })
    // Add Role
        $('#roles_table').on('click', '.edit', function(){
            $('#editRoleModal').modal('show')
            var name = $(this).data('name')
            var id = $(this).data('id')
            $('#name_edit').val(name)
            $('#role_id').val(id)
        })
        $('#btn_update_role').on('click', function(){
            var data={
                'id' :$('#role_id').val(),
                'name_edit' :$('#name_edit').val(),
            }
            postCallback('updateRole', data, function(response){
                swal.close()
                toastr['success'](response.meta.message)
                $('.message_error').html('')
                $('#editRoleModal').modal('hide')
                getCallbackNoSwal('getRole', null, function(response){
                    mappingRole(response.data)
                })

            })
        })

       // Add Permission
       $('#btn_add_permission').on('click',function(){
        $('.message_error').html('')
        getCallback('permissionMenus',null,function(response){
            swal.close();
            $('#menus_name').empty();
            $('#menus_name').append('<option value ="">Choose Menus</option>');
            $.each(response.menus_name,function(i,data){
                $('#menus_name').append('<option value="'+data.link+'">' + data.name +'</option>');
            });
        })
    })
        $('#option').on('change', function(){
            var option = $('#option').val()
            var menus_name = $('#menus_name').val()
            $('#permission_name').val(option+'-'+menus_name)
        })
        $('#menus_name').on('change', function(){
            var option = $('#option').val()
            var menus_name = $('#menus_name').val()
            $('#permission_name').val(option+'-'+menus_name)
        })

        $('#btn_save_permission').on('click', function(){
            var data={
                'permission_name':$('#permission_name').val(),
            }
            postCallback('savePermission',data,function(response){
                swal.close()
                if(response.status ==200){
                    $('#addPermissionModal').modal('hide');
                    toastr['success'](response.message);
                    getCallbackNoSwal('getPermission',null, function(response){
                        swal.close()
                        mappingPermission(response.data)
                    })

                }else{
                    toastr['error'](response.message);
                }
                
            })
            
        })
// Add Permission
     // Delete Permission
     $('#permission_table').on('click', '.deletePermission', function(){
        var data ={
            'id':$(this).data('id')
        }
        getCallback('deletePermission',data,function(response){
            swal.close()
            if(response.status == 200){
                toastr['success'](response.message);
                getCallbackNoSwal('getPermission',null, function(response){
                    swal.close()
                    mappingPermission(response.data)
                })

            }else{
                toastr['error'](response.message);
            }
        })
    })
// Delete Permission
// Operation
// Function
    function mappingRole(response){
        $('#roles_table').DataTable().clear();
        $('#roles_table').DataTable().destroy();
        var data=''
        for(i = 0; i < response.length; i++ )
        {
            data += `<tr style="text-align: center;">
                    <td style="text-align: left;">${response[i]['name']==null?'':response[i]['name']}</td>
                    <td style="width:25%;text-align:center">
                           
                            <button title="Detail" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-name ="${response[i].name}"data-target="#editRoleModal">
                               <i class="fa-solid fa-circle-info"></i>
                            </button>   
                            
                    </td>
                </tr>
                `;
        }
            $('#roles_table > tbody:first').html(data);
            $('#roles_table').DataTable({
                scrollX  : true,
                searching  :true,
                // language: {
                //     'paginate': {
                //     'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                //     'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                //     }
                // },
                scrollY  :300
            }).columns.adjust()
    }
    function mappingPermission(response){
        $('#permission_table').DataTable().clear();
        $('#permission_table').DataTable().destroy();
        var data=''
        for(i = 0; i < response.length; i++ )
        {
            data += `<tr style="text-align: center;">
                    <td style="text-align: left;">${response[i]['name']==null?'':response[i]['name']}</td>
                    <td style="width:25%;text-align:center">
                            <button title="Delete" class="deletePermission btn btn-sm btn-danger"data-id="${response[i]['id']}">
                            <i class="fas fa-solid fa-trash"></i>
                            </button>   
                            
                    </td>
                </tr>
                `;
        }
            $('#permission_table > tbody:first').html(data);
            $('#permission_table').DataTable({
                scrollX  : true,
                searching  :true,
                // language: {
                //     'paginate': {
                //     'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                //     'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                //     }
                // },
                scrollY  :300
            }).columns.adjust()
    }
// Function