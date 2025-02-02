getCallback('getUser', null, function(response){
    swal.close()
    mappingTable(response.data)
})

$('#user_table').on('click', '.edit',function(){
    var id = $(this).data('id')
    var data = {
        'id' : id
    }
    $('#editUserModal').modal('show')
    $('#edit_id').val(id)
})
function mappingTable(response){
    var data =''
    
    $('#user_table').DataTable().clear();
    $('#user_table').DataTable().destroy();
    for(i = 0; i < response.length; i++ )
        {
            var active = response[i].active == 1 ? 'active' : 'inactive'
            data += `
                <tr>
                    <td>
                        <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" data-id="${response[i]['id']}" ${response[i].active == 1? 'checked' : ''}>
                    </td>
                    <td>${active}</td>
                    <td>${response[i].name}</td>
                    <td>${response[i].nik}</td>
                    <td>${response[i].location_relation.name}</td>
                    <td>${response[i].position_relation.name}</td>
                    <td>
                        <button class="btn edit btn-sm btn-warning" data-id="${response[i].id}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            `
        }
    $('#user_table > tbody:first').html(data);
    $('#user_table').DataTable({
        scrollX  : true,
        language: {
                            'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
                            }
                        },
    }).columns.adjust()
}