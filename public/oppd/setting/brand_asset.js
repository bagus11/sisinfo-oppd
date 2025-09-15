getCallback('getAssetBrand', null, function(response){
    swal.close()
    mappingTable(response.data)
})
$('#btn_save_sub_type').click(function(){
    var data = {
        name : $('#name').val()
    }
    postCallback('addAssetBrand', data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#name').val('')
        $('#addBrandAssetModal').modal('hide')
        getCallback('getAssetBrand', null, function(response){
            swal.close()
            mappingTable(response.data)
        }) 
    })
})

$('#brand_asset_table').on('click', '.edit', function(){
    var id = $(this).data('id')
    var name = $(this).data('name')
    $('#editAssetBrandModal').modal('show')
    $('#edit_name').val(name)
    $('#id').val(id)
})

$('#btn_update_sub_category').on('click', function(){
    var data ={
        'id' : $('#id').val(),
        'edit_name' : $('#edit_name').val(),
    }
    postCallback('updateAssetBrand',data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#editAssetBrandModal').modal('hide')
        getCallbackNoSwal('getAssetBrand', null, function(response){
            mappingTable(response.data)
        })
    })
})
function mappingTable(response){
    var data =''
    $('#brand_asset_table').DataTable().clear();
    $('#brand_asset_table').DataTable().destroy();
    for(i = 0; i < response.length; i++ )
        {
            data += `
                <tr>
                    <td style="width:80%">${response[i].name}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit" data-id="${response[i].id}" data-name="${response[i].name}"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>`
        }
    $('#brand_asset_table > tbody:first').html(data);
        $('#brand_asset_table').DataTable({
            scrollX  : true,
            language: {
                                'paginate': {
                                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                        'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
                                }
                            },
        }).columns.adjust()
}