getCallback('getLocation', null, function(response){
    swal.close()
    mappingTable(response.data)
})

$('#btn_add_location').on('click', function(){
    $('.parent_container').prop('hidden',true)
    $('.message_error').html('')
    $('#name').val('')
    $('#type').val('')
    $('#select_type').val('')
    $('#select_type').select2().trigger('change')
    $('#parent').val('')
    $('#select_parent').val('')
    $('#select_parent').select2().trigger('change')
    $('#logo').val('')
    $('#x').val('')
    $('#y').val('')
    $('#address').val('')
})
onChange('select_type', 'type')
onChange('select_parent', 'parent')
$('#select_type').on('change', function(){
    var select_type = $('#select_type').val()
    select_type == 2 ? $('.parent_container').prop('hidden', false) : $('.parent_container').prop('hidden', true)
})
$('#btn_save_location').on('click', function(e){
    e.preventDefault();
    var data = new FormData();
    data.append('name',$('#name').val())
    data.append('type',$('#type').val())
    data.append('parent',$('#parent').val())
    data.append('address',$('#address').val())
    data.append('x',$('#x').val())
    data.append('y',$('#y').val())
    postAttachment('addLocation',data,false,function(response){
        swal.close()
        $('.message_error').html('')
        toastr['success'](response.meta.message);
        $('#addLocationModal').modal('hide')
        getCallbackNoSwal('getLocation',null,function(response){
            mappingTable(response.data)
        })
    })
})
// Function
    function mappingTable(response){
        var data =''
        
        $('#location_table').DataTable().clear();
        $('#location_table').DataTable().destroy();
        for(i = 0; i < response.length; i++ )
            {
                var type = response[i].type == 1 ?'Company Group' :'Company'
                var parent = response[i].parent == 0 ? '-' : response[i].parent_relation.name
                data += `
                    <tr>
                        <td>${response[i].name}<td>
                        <td>${type}<td>
                        <td>${parent}<td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-id="${response[i].id}">
                                <i class="fas fa-edit"></i>
                            </button>
                        <td>
                    </tr>
                `
            }
        $('#location_table > tbody:first').html(data);
        $('#location_table').DataTable({
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