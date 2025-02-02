$('#asset_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getAsset`,
        type: 'GET',
    },
    columns: [
        { data: 'satgas', name: 'satgas' },
        { data: 'no_un', name: 'no_un' },
        { data: 'category', name: 'category' },
        { data: 'sub_category', name: 'sub_category' },
        { data: 'type', name: 'type' },
        { data: 'brand', name: 'brand' },
        { data: 'brand', name: 'brand' },
        { data: 'no_rangka', name: 'no_rangka' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});
$('#btn_add_asset').on('click', function(){
    getCallbackNoSwal('getMasterSatgas',null,function(response){
        $('#select_satgas').empty()
        for(i = 0 ; i < response.data.length ; i ++){
            $('#select_satgas').append(`
                <option value="${response.data[i].name}">${response.data[i].name}</option>
                `)
        }
    })
})
$('#btnAddAsset').on('click', function(){
    var data = {
        'satgas' : $('#select_satgas').val(),
        'kondisi' : $('#select_kondisi').val()
    } 
    postCallback('addAsset', data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#addAssetModal').modal('hide')
    })
})