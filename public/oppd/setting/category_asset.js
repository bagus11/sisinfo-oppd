getCallback('getCategoryAsset', null, function(response){
    swal.close()
    mappingTable(response.data)
})
$('#btn_save_category').click(function(){
    var data = {
        name : $('#name').val()
    }
    postCallback('addCategoryAsset', data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#name').val('')
        $('#addCategoryAssetModal').modal('hide')
        getCallback('getCategoryAsset', null, function(response){
            swal.close()
            mappingTable(response.data)
        })
    })
})

$('#category_asset_table').on('click', '.edit', function(){
    var id = $(this).data('id')
    var name = $(this).data('name')
    $('#editCategoryModal').modal('show')
    $('#edit_name').val(name)
    $('#id').val(id)
})

$('#btn_update_category').on('click', function(){
    var data ={
        'id' : $('#id').val(),
        'edit_name' : $('#edit_name').val(),
    }
    postCallback('updateCategory',data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#editCategoryModal').modal('hide')
        getCallbackNoSwal('getCategoryAsset', null, function(response){
            mappingTable(response.data)
        })
    })
})
function mappingTable(response){
    var data =''
    $('#category_asset_table').DataTable().clear();
    $('#category_asset_table').DataTable().destroy();
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
    $('#category_asset_table > tbody:first').html(data);
        $('#category_asset_table').DataTable({
            scrollX  : true,
            language: {
                                'paginate': {
                                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                        'next': '<span class="next-icon pr-2"><i class="fa-solid fa-arrow-right"></i></span>'
                                }
                            },
        }).columns.adjust()
}