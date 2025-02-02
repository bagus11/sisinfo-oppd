getCallback('getMenus', null, function(response){
    swal.close()
    mappingMenus(response.data)
})
getCallback('getSubMenus', null, function(response){
    swal.close()
    mappingSubmenus(response.data)
})

// Add Menus
    onChange('select_menus_type','menus_type')
    $('#btn_save_menus').on('click', function(){
        var data ={
            'menus_name'        : $('#menus_name').val(),
            'menus_link'        : $('#menus_link').val(),
            'menus_type'        : $('#menus_type').val(),
            'menus_icon'        : $('#menus_icon').val(),
            'menus_description' : $('#menus_description').val(),
        }
        postCallback('addMenus', data, function(response){
            swal.close()
            $('#menus_name').val(''),
            $('#menus_link').val(''),
            $('#menus_type').val(''),
            $('#select_menus_type').val(''),
            $('#select_menus_type').select2().trigger('change'),
            $('#menus_icon').val(''),
            $('#menus_description').val(''),
            toastr['success'](response.meta.message)
            $('#addMenusModal').modal('hide')
            getCallbackNoSwal('getMenus',null, function(response){
                mappingMenus(response.data)
            })
        })
    })
// Add Menus

getActiveItems('getActiveParent',null,'select_menus_edit','Menu')
// Add Submenus
    onChange('select_menus','parent');
    $('#btn_add_submenus').on('click', function(){
        getActiveItems('getActiveParent',null,'select_menus','Menu')
        $('#submenus_name').val('');
        $('#submenus_link').val('');
        $('#submenus_icon').val('');
        $('#select_menus').val('');
        $('#select_menus').select2().trigger('change');
        $('#parent').val('');
        $('#submenus_description').val('');

    })
    $('#btn_save_submenus').on('click', function(){
        var data ={
            'submenus_name'        : $('#submenus_name').val(),
            'submenus_link'        : $('#submenus_link').val(),
            'parent'               : $('#parent').val(),
            'submenus_icon'        : $('#submenus_icon').val(),
            'submenus_description' : $('#submenus_description').val(),
        }
        postCallback('addSubMenus', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#addSubmenusModal').modal('hide')
            getCallbackNoSwal('getSubMenus', null, function(response){
                mappingSubmenus(response.data)
            })
        })
    })
// Add Submenus

// Update Status
    $('#menus_table').on('change','.check',function(){
        var data ={
            'id' : $(this).data('id')
        }
        postCallbackNoSwal('updateStatusMenu', data, function(response){
            toastr['success'](response.meta.message)
            getCallbackNoSwal('getMenus', null, function(response){
                mappingMenus(response.data)
            })
        })
    })
    $('#submenus_table').on('change','.check',function(){
        var data ={
            'id' : $(this).data('id')
        }
        postCallbackNoSwal('updateStatusSubMenu', data, function(response){
            toastr['success'](response.meta.message)
            getCallbackNoSwal('getSubMenus', null, function(response){
                mappingSubmenus(response.data)
            })
        })
    })
// Update Status
// Edit
    $('#menus_table').on('click', '.edit', function(){
        $('#editMenusModal').modal('show')
        var id = $(this).data('id')
        var name = $(this).data('name')
        var icon = $(this).data('icon')
        var link = $(this).data('link')
        var description = $(this).data('description')
        var type = $(this).data('type')

        $('#menus_id').val(id)
        $('#menus_name_edit').val(name)
        $('#menus_icon_edit').val(icon)
        $('#menus_link_edit').val(link)
        $('#menus_description_edit').val(description)
        $('#menus_type_edit').val(type)
        $('#select_menus_type_edit').val(type)
        $('#select_menus_type_edit').select2().trigger('change')
    })
    onChange('select_menus_type_edit','menus_type_edit')
    $('#btn_update_menus').on('click', function(){
        var data = {
            'id' : $('#menus_id').val(),
            'menus_name_edit'           : $('#menus_name_edit').val(),
            'menus_icon_edit'           : $('#menus_icon_edit').val(),
            'menus_link_edit'           : $('#menus_link_edit').val(),
            'menus_description_edit'    : $('#menus_description_edit').val(),
            'menus_type_edit'           : $('#menus_type_edit').val(),
        }
        postCallback('updateMenus', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#editMenusModal').modal('hide')
            getCallbackNoSwal('getMenus', null, function(response){
                mappingMenus(response.data)
            })
        })
    })
    $('#btn_update_submenus').on('click', function(){
        var data = {
            'id' : $('#submenus_id').val(),
            'submenus_name_edit'     :$('#submenus_name_edit').val(),
            'submenus_link_edit'     :$('#submenus_link_edit').val(),
            'submenus_icon_edit'     :$('#submenus_icon_edit').val(),  
            'parent_edit'            :$('#parent_edit').val(),
            'submenus_description_edit'      :$('#submenus_description_edit').val(),
        }
        postCallback('updateSubMenus', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#editSubmenusModal').modal('hide')
            getCallbackNoSwal('getSubMenus', null, function(response){
                mappingSubmenus(response.data)
            })
        })
    })

    onChange('select_menus_edit','parent_edit')
    $('#submenus_table').on('click', '.edit', function(){
        $('#editSubmenusModal').modal('show')
        var id = $(this).data('id')
        var name = $(this).data('name')
        var icon = $(this).data('icon')
        var link = $(this).data('link')
        var description = $(this).data('description')
        var menus = $(this).data('menus')

        $('#submenus_id').val(id)
        $('#submenus_name_edit').val(name)
        $('#submenus_icon_edit').val(icon)
        $('#submenus_link_edit').val(link)
        $('#submenus_description_edit').val(description)
        $('#submenus_type_edit').val(menus)
        $('#select_menus_edit').val(menus)
        $('#select_menus_edit').select2().trigger('change')
    })
// Edit

// Function
function mappingMenus(response){
    var data =''
        
        $('#menus_table').DataTable().clear();
        $('#menus_table').DataTable().destroy();
        for(i = 0; i < response.length; i++ )
            {
                var type = response[i].type == 1 ? 'Stand Alone' : 'Parent'
                var status = response[i].status == 1 ? 'Active' : 'Inactive'
                data +=`
                    <tr style ="text-align :left">
                       <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="check" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                        <td> ${status}</td>
                        <td> ${response[i].name}</td>
                        <td> ${type}</td>
                        <td style ="text-align :center"> 
                            <button class="edit btn btn-sm btn-warning btn-rounded" data-name="${response[i].name}"  data-icon="${response[i].icon}" data-status="${response[i].status}" data-type="${response[i].type}" data-link="${response[i].link}" data-id ="${response[i].id}" data-description="${response[i].description}" data-toggle="modal" data-target="#editMenusModal"> <i class="fas fa-edit"></i></button>
                        </td>
                        
                    </tr>
                `
            }
        $('#menus_table > tbody:first').html(data);
        $('#menus_table').DataTable({
            scrollX  : true,
            // language: {
            //                     'paginate': {
            //                             'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            //                             'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
            //                     }
            //                 },
        }).columns.adjust()
}
function mappingMenus(response){
    var data =''
        
        $('#menus_table').DataTable().clear();
        $('#menus_table').DataTable().destroy();
        for(i = 0; i < response.length; i++ )
            {
                var type = response[i].type == 1 ? 'Stand Alone' : 'Parent'
                var status = response[i].status == 1 ? 'Active' : 'Inactive'
                data +=`
                    <tr style ="text-align :left">
                       <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="check" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                        <td> ${status}</td>
                        <td> ${response[i].name}</td>
                        <td> ${type}</td>
                        <td style ="text-align :center"> 
                            <button class="edit btn btn-sm btn-warning btn-rounded" data-name="${response[i].name}"  data-icon="${response[i].icon}" data-status="${response[i].status}" data-type="${response[i].type}" data-link="${response[i].link}" data-id ="${response[i].id}" data-description="${response[i].description}" data-toggle="modal" data-target="#editMenusModal"> <i class="fas fa-edit"></i></button>
                        </td>
                        
                    </tr>
                `
            }
        $('#menus_table > tbody:first').html(data);
        $('#menus_table').DataTable({
            scrollX  : true,
            // language: {
            //                     'paginate': {
            //                             'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            //                             'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
            //                     }
            //                 },
        }).columns.adjust()
}
function mappingSubmenus(response){
    var data =''
        
        $('#submenus_table').DataTable().clear();
        $('#submenus_table').DataTable().destroy();
        for(i = 0; i < response.length; i++ )
            {
                var status = response[i].status == 1 ? 'Active' : 'Inactive'
                data +=`
                    <tr style ="text-align :left">
                       <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="check" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                       <td> ${status}</td>
                       <td> ${response[i].name}</td>
                        <td> ${response[i].menus_relation.name}</td>
                        <td style ="text-align :center"> 
                            <button class="edit btn btn-sm btn-warning btn-rounded" data-name="${response[i].name}"  data-icon='${response[i].logo}' data-status="${response[i].status}" data-menus="${response[i].menus_id}" data-link="${response[i].link}" data-id ="${response[i].id}" data-description="${response[i].description}" data-toggle="modal" data-target="#editSubmenusModal"> <i class="fas fa-edit"></i></button>
                        </td>
                        
                    </tr>
                `
            }
        $('#submenus_table > tbody:first').html(data);
        $('#submenus_table').DataTable({
            scrollX  : true,
            // language: {
            //                     'paginate': {
            //                             'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            //                             'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
            //                     }
            //                 },
        }).columns.adjust()
}
// Function

