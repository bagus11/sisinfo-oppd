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
                    <td>${response[i].email}</td>
                    <td>${response[i].nrp == '' ? '-' : response[i].nrp}</td>
                    <td>${response[i].position_relation.name}</td>
                    <td>${response[i].location_relation.name}</td>
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
getActiveItems('getPosition',  null, 'select_position','Position')
getCallbackNoSwal('getSatgas', null, function(response) {
    $('#select_location').empty();
    var select_satgas = '';
    var groupedData = {};

    // Kelompokkan data berdasarkan tipe
    for (i = 0; i < response.data.length; i++) {
        var type = response.data[i].type;
        var name = response.data[i].name;

        if (!groupedData[type]) {
            groupedData[type] = [];
        }
        groupedData[type].push(name);
    }

    // Buat option dengan struktur parent-child
    for (var type in groupedData) {
        select_satgas += `<optgroup label="${type}">`;
        groupedData[type].forEach(function(name) {
            select_satgas += `<option value="${name}">${name}</option>`;
        });
        select_satgas += '</optgroup>';
    }

    // Set HTML ke dalam select2
    $('#select_location').html(select_satgas);
    $('#select_location').select2();
});
onChange('select_location', 'location')
onChange('select_position', 'position')
$('#btn_save_user').on('click', function(){
    var data = {
        'name' : $("#name").val(),
        'email' : $("#email").val(),
        'location' : $("#location").val(),
        'position' : $("#position").val(),
        'nrp' : $("#nrp").val(),
    }
    postCallback('addUser',data, function(response){
        swal.close()
        $('#addUserModal').modal('hide');
        toastr['success'](response.meta.message)
        getCallbackNoSwal('getUser', null, function(response){
            mappingTable(response.data)
        })
    })
})

getActiveItems('getPosition',  null, 'edit_select_position','Position')
getCallbackNoSwal('getSatgas', null, function(response) {
    $('#edit_select_location').empty();
    var select_satgas = '';
    var groupedData = {};

    // Kelompokkan data berdasarkan tipe
    for (i = 0; i < response.data.length; i++) {
        var type = response.data[i].type;
        var name = response.data[i].name;

        if (!groupedData[type]) {
            groupedData[type] = [];
        }
        groupedData[type].push(name);
    }

    // Buat option dengan struktur parent-child
    for (var type in groupedData) {
        select_satgas += `<optgroup label="${type}">`;
        groupedData[type].forEach(function(name) {
            select_satgas += `<option value="${name}">${name}</option>`;
        });
        select_satgas += '</optgroup>';
    }

    // Set HTML ke dalam select2
    $('#edit_select_location').html(select_satgas);
    $('#edit_select_location').select2();
});

$('#user_table').on('click','.edit', function(){
    var id = $(this).data('id')
    getCallbackNoSwal('detailUser', {'id' : id}, function(response){
    
        $('#edit_name').val(response.detail.name)
        $('#edit_nrp').val(response.detail.nrp)
        $('#edit_select_location').val(response.detail.location_relation.name)
        $('#edit_select_location').select2().trigger('change')
        $('#edit_select_position').val(response.detail.position)
        $('#edit_select_position').select2().trigger('change')
    })
})