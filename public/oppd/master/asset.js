$(document).ready(function () {
   if(userHasPermission){
    var table = $('#asset_table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getMasterAsset`,
            type: 'GET',
            data: function (d) {
                d.satgas_type = $('#select_satgas').val();
                d.kondisi = $('#select_filter_kondisi').val();
            }
        },
        columns: [
            { 
                data: 'asset_code', 
                name: 'asset_code',
                render: function (data, type, row) {
                    return data ? `<input type="checkbox" class="checkbox" data-asset="${data}">` : '';
                }
            },
            { data: 'asset_code', name: 'asset_code' },
            { data: 'no_un', name: 'no_un' },
            { 
                data: 'category_relation.name', 
                name: 'category_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'sub_category_relation.name', 
                name: 'sub_category_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'type_relation.name', 
                name: 'type_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'merk_relation.name', 
                name: 'merk_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { data: 'no_mesin', name: 'no_mesin' },
            { data: 'no_rangka', name: 'no_rangka' },
            { 
                data: 'satgas_relation.type', 
                name: 'satgas_relation.type',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'satgas_relation.name', 
                name: 'satgas_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
        ]
    });
   }else{
    var table = $('#asset_table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getMasterAsset`,
            type: 'GET',
            data: function (d) {
                d.satgas_type = $('#select_satgas').val();
                d.kondisi = $('#select_filter_kondisi').val();
            }
        },
        columns: [
            { data: 'asset_code', name: 'asset_code' },
            { data: 'no_un', name: 'no_un' },
            { 
                data: 'category_relation.name', 
                name: 'category_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'sub_category_relation.name', 
                name: 'sub_category_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'type_relation.name', 
                name: 'type_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'merk_relation.name', 
                name: 'merk_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { data: 'no_mesin', name: 'no_mesin' },
            { data: 'no_rangka', name: 'no_rangka' },
            { 
                data: 'satgas_relation.type', 
                name: 'satgas_relation.type',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            { 
                data: 'satgas_relation.name', 
                name: 'satgas_relation.name',
                render: function(data) {
                    return data ? data : '-';
                }
            },
        ]
    });
   }
  

    // Event handler untuk tombol filter
    $('#filterAsset').on('click', function(){
        table.ajax.reload(); // Reload DataTables dengan filter baru
    });


getCallbackNoSwal('getSatgasType', null, function(response){
    $('#select_satgas').empty()
    $('#select_satgas').append(`<option value="">All Satgas</option>`)
    var data =''
    for(i = 0; i < response.data.length; i ++){
        $('#select_satgas').append(`
            <option value="${response.data[i].type}">${response.data[i].type}</option>
        `)
    }
})

$('#deleteButton').prop('hidden', true); // Hide the delete button by default
$('#checkAllAsset').on('click', function (e) {
    e.stopPropagation(); // Prevent event bubbling
    var rows = table.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
    toggleDeleteButton()
});

getActiveItems('getInventoryCategory', null, 'edit_select_kategori', 'Kategori');
getActiveItems('getInventorySubCategory', null, 'edit_select_subkategori', 'Subkategori');
getActiveItems('getInventoryType', null, 'edit_select_jenis', 'Jenis');
getActiveItems('getInventoryBrand', null, 'edit_select_brand', 'Merk');
// Detail Asset
$('#asset_table tbody').on('click', 'tr', function (e) {
    // Ignore clicks on checkbox elements
    if ($(e.target).closest('.checkbox').length) return;

    const row = table.row(this).data();
    if (!row) {
        console.error('Row data is undefined.');
        return;
    }
    
    // Show & Hide Buttons
    $("#btn_edit_asset").prop('hidden', false);
    $("#btn_cancel_edit_asset, #btn_update_asset").prop('hidden', true);

    // Disable Fields
    $('#edit_no_un, #edit_no_rangka, #edit_no_mesin').prop('readOnly', true);
    $('#edit_select_kategori, #edit_select_subkategori, #edit_select_brand, #edit_select_jenis').prop('disabled', true);

    // Populate Form Fields
    $('#asset_code').val(row.asset_code || '');
    $('#edit_select_kategori').val(row.category_relation?.id || '').trigger('change');
    $('#edit_select_subkategori').val(row.subkategori || '').trigger('change');
    $('#edit_select_brand').val(row.merk || '').trigger('change');
    $('#edit_select_jenis').val(row.jenis || '').trigger('change');

    $('#edit_no_un').val(row.no_un || '');
    $('#edit_no_rangka').val(row.no_rangka || '');
    $('#edit_no_mesin').val(row.no_mesin || '');

    // Show Modal
    $('#editAssetModal').modal('show');

    // Ensure #asset_table_log exists
    if (!$('#asset_table_log').length) {
        console.error('Table #asset_table_log does not exist in the DOM.');
        return;
    }

    // Destroy previous DataTable instance
    if ($.fn.DataTable.isDataTable('#asset_table_log')) {
        $('#asset_table_log').DataTable().clear().destroy();
    }

    // Initialize DataTable for Logs
    const table_log = $('#asset_table_log').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getLogAsset`,
            type: 'GET',
            data: { asset_code: row.asset_code }, // Send only necessary data
            error: function (xhr, error, code) {
                console.error('Error loading log data:', error, code, xhr.responseText);
            }
        },
        columns: [
            {
                data: 'created_at',
                name: 'created_at',
                render: function (data) {
                    if (!data) return '';
                    const date = new Date(data);
                    return date.toISOString().replace('T', ' ').substring(0, 19);
                }
            },
            { 
                data: 'pic_relation', 
                name: 'pic_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { 
                data: 'satgas_relation', 
                name: 'satgas_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { data: 'no_un', name: 'no_un' },
            { 
                data: 'category_relation', 
                name: 'category_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { 
                data: 'sub_category_relation', 
                name: 'sub_category_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { 
                data: 'type_relation', 
                name: 'type_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { 
                data: 'merk_relation', 
                name: 'merk_relation.name',
                render: function(data) {
                    return data ? data.name : '-';
                }
            },
            { data: 'no_mesin', name: 'no_mesin' },
            { data: 'no_rangka', name: 'no_rangka' },
            {
                data: 'kondisi',
                name: 'kondisi',
                render: function (data) {
                    switch (parseInt(data)) {
                        case 0: return '-';
                        case 1: return 'BAIK';
                        case 2: return 'RR OPS';
                        case 3: return 'RB';
                        case 4: return 'RR TDK OPS';
                        case 5: return 'M';
                        case 6: return 'D';
                        default: return 'Unknown';
                    }
                }
            },
            { data: 'remark', name: 'remark' },
        ],
        order: [[0, 'asc']],
        createdRow: function (row, data, dataIndex) {
            if (dataIndex === 0) return; // Skip first row

            const previousRowData = table_log.row(dataIndex - 1).data();
            if (!previousRowData) return;

            // Column indices mapping
            const columnsToCheck = {
                'no_un': 2,
                'category_relation.name': 3,
                'sub_category_relation.name': 4,
                'type_relation.name': 5,
                'merk_relation.name': 6,
                'no_mesin': 7,
                'no_rangka': 8
            };

            Object.entries(columnsToCheck).forEach(([key, index]) => {
                if (data[key] !== previousRowData[key]) {
                    $(row).find('td').eq(index).css('color', 'red');
                }
            });
        }
    });
});


// Detail Asset

// Edit Asset
    $('#btn_edit_asset').on('click', function(){
        $("#btn_cancel_edit_asset").prop('hidden', false)
        $("#btn_edit_asset").prop('hidden', true)
        $("#btn_update_asset").prop('hidden', false)
        $('#edit_no_un').prop('readOnly' ,false);
        $('#edit_no_rangka').prop('readOnly' ,false);
        $('#edit_no_mesin').prop('readOnly' ,false);
        $('#edit_select_kategori, #edit_select_subkategori, #edit_select_brand, #edit_select_jenis').prop('disabled', false);
    })
    $('#btn_cancel_edit_asset').on('click', function(){
        $("#btn_edit_asset").prop('hidden', false)
        $("#btn_cancel_edit_asset").prop('hidden', true)
        $("#btn_update_asset").prop('hidden', true)
        $('#edit_no_un').prop('readOnly' ,true);
        $('#edit_no_rangka').prop('readOnly' ,true);
        $('#edit_no_mesin').prop('readOnly' ,true);
        $('#edit_select_kategori, #edit_select_subkategori, #edit_select_brand, #edit_select_jenis').prop('disabled', true);
    })
// Edit Asset
// Add Asset
    $('#btn_add_asset').on('click', function(){
        $('#no_un').val('')
        $('#no_rangka').val('')
        $('#no_mesin').val('')
        $('#kategori').val('')
        $('#subkategori').val('')
        $('#jenis').val('')
        $('#brand').val('')
        resetSelect2('select_kategori');
        resetSelect2('select_subkategori');
        resetSelect2('select_jenis');
        resetSelect2('select_brand');

        getActiveItems('getInventoryCategory', null, 'select_kategori', 'Kategori');
        getActiveItems('getInventorySubCategory', null, 'select_subkategori', 'Subkategori');
        getActiveItems('getInventoryType', null, 'select_jenis', 'Jenis');
        getActiveItems('getInventoryBrand', null, 'select_brand', 'Merk');
    })
    onChange('select_kategori','kategori')
    onChange('select_subkategori','subkategori')
    onChange('select_jenis','jenis')
    onChange('select_brand','merk')

    $('#btn_save_asset').on('click', function(){
        var data ={
            no_un:$('#no_un').val(),
            no_rangka:$('#no_rangka').val(),
            no_mesin:$('#no_mesin').val(),
            kategori:$('#kategori').val(),
            subkategori:$('#subkategori').val(),
            jenis:$('#jenis').val(),
            merk:$('#merk').val(),
        }
        postCallback('addMasterAsset', data, function(response){
            swal.close()
            $('#addAssetModal').modal('hide')
            toastr['success'](response.meta.message)
            $('#asset_table').DataTable().ajax.reload();
            
        })
    })
// Add Asset
    onChange('edit_select_kategori','edit_kategori')
    onChange('edit_select_subkategori','edit_subkategori')
    onChange('edit_select_jenis','edit_jenis')
    onChange('edit_select_brand','edit_merk')
// Update Asset
    $('#btn_update_asset').on('click', function(){
        var data = {
            'asset_code' : $('#asset_code').val(),
            'edit_no_un':$('#edit_no_un').val(),
            'edit_no_rangka':$('#edit_no_rangka').val(),
            'edit_no_mesin':$('#edit_no_mesin').val(),
            'edit_kategori':$('#edit_kategori').val(),
            'edit_subkategori':$('#edit_subkategori').val(),
            'edit_jenis':$('#edit_jenis').val(),
            'edit_merk':$('#edit_merk').val(),
        }
        postCallback('updateAsset', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#asset_table_log').DataTable().ajax.reload();
            
        })
    })
// Update Asset
$('#asset_table').on('change', '.checkbox', function () {
    toggleDeleteButton(); // Check and toggle the delete button visibility
});

function toggleDeleteButton() {
    const checkedCount = $('.checkbox:checked').length;
    if (checkedCount >= 1) {
        $('#deleteButton').prop('hidden', false); // Show the button
    } else {
        $('#deleteButton').prop('hidden', true); // Hide the button
    }
}

// Handle the delete action
    $('#deleteButton').on('click', function () {
        // Gather the IDs of selected rows
        const selectedIds = $('.checkbox:checked').map(function () {
            return $(this).data('asset'); // Assuming data-id contains the unique ID for each row
        }).get();

        if (selectedIds.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var data ={
                        'asset_code': selectedIds
                    }
                    postCallback('deleteAsset',data, function(response){
                        swal.close()
                        toastr['success'](response.meta.message)
                        $('#deleteButton').prop('hidden', true);
                        $('#asset_table').DataTable().ajax.reload();        
                    })
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
                }
            });
        } else {
            toastr.warning('No items selected for deletion.');
        }
    });

    $('#uploadAssetForm').on('submit', function (e) {
        e.preventDefault();
        let data = new FormData(this);
        postAttachment('uploadAsset', data, false, function(response){
            swal.close()
            $('#uploadAssetModal').modal('hide')
            toastr['success'](response.message)
            $('#asset_table').DataTable().ajax.reload();
        })
    });
});
$('#btn_print_pdf').on('click', function(){
    var detail = $('#asset_code').val()
    var final = detail.replaceAll('/','_')
    console.log(final)
    window.open(`printDetailAsset/${final}`,'_blank');
})

$('#exportAsset').on('click', function(){
    SwalLoading('Please wait ...');
    var type = $('#select_satgas').val()
    var kondisi = $('#select_filter_kondisi').val()
    let url = '/export-asset?';
    if (type) url += 'type=' + type + '&';
    if (kondisi) url += 'kondisi=' + kondisi;
    window.location.href = url;
    swal.close()
})