
const table = $('#laporan_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: 'getMaintenance',
        type: 'GET',
        dataSrc: function (json) {
            return json.data || []; // Return an empty array if no data
        }
    },
    columns: [
        {
            data: 'created_at',
            name: 'created_at',
            render: function (data) {
                if (data) {
                    const date = new Date(data);
                    const format = (num) => String(num).padStart(2, '0');
                    return `${date.getFullYear()}-${format(date.getMonth() + 1)}-${format(date.getDate())} ` +
                           `${format(date.getHours())}:${format(date.getMinutes())}:${format(date.getSeconds())}`;
                }
                return '-'; // Default fallback for missing or null dates
            }
        },
        { 
            data: 'request_code', 
            name: 'request_code',
            render: function (data) {
                return data || '-'; // Default fallback for missing request codes
            }
        },
        { 
            data: 'type', 
            name: 'type',
            render: function(data) {
                switch (data) {
                    case 1: return 'Pengajuan Perbaikan';
                    case 2: return 'Pengajuan Penggantian';
                    default: return 'Unknown'; // Default for undefined or unexpected types
                }
            }
        },
        { 
            data: 'reporter_relation.name', 
            name: 'reporter_relation.name',
            render: function (data) {
                return data || '-'; // Default for missing reporter names
            }
        },
        { 
            data: 'status', 
            name: 'status',
            render: function(data) {
                switch (data) {
                    case 0: return `<span style="text-align:center" class="mb-1 badge w-100 bg-info-subtle text-info">Draft</span>`;
                    case 1: return '<span style="text-align:center" class="mb-1 badge w-100 bg-warning-subtle text-warning">On Progress</span>';
                    case 2: return '<span style="text-align:center" class="mb-1 badge w-100 bg-success-subtle text-success">DONE</span>';
                    case 3: return '<span style="text-align:center" class="mb-1 badge w-100 bg-dark-subtle text-dark">Reject</span>';
                    default: return 'Unknown'; // Default for undefined or unexpected statuses
                }
            }
        },
    ]
});
// Nested Modal
$(document).ready(function () {
    $('#updateRequestModal').on('hidden.bs.modal', function () {
        $('#editRequestModal').modal('show');
    });
})

$('#btn_update_asset').on('click', function(e){
    e.preventDefault()
    var data = new FormData();
    data.append('request_code',$('#edit_request_code').val())
    data.append('update_catatan',$('#update_catatan').val())
    data.append('update_asset_code',$('#update_asset_code').val())
    data.append('update_attachment',$('#update_attachment')[0].files[0]);
    postAttachment('updateMaintenanceUpdate', data, false, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#laporan_table').DataTable().ajax.reload();
        $('#edit_asset_table').DataTable().ajax.reload();
    })
})
// Nested Modal
$(document).on('click', '.openTab', function () {
    var asset =$(this).data('asset')
    getCallbackNoSwal('getDetailAsset',{'asset_code':asset},function(response){
        console.log(response)
        var kondisi = '';
        switch (response.detail.kondisi) {
            case 0:
                kondisi = '-';
                break;
            case 1:
                kondisi = 'BAIK';
                break;
            case 2:
                kondisi = 'RR OPS';
                break;
            case 3:
                kondisi = 'RB';
                break;
            case 4:
                kondisi = 'RR TDK OPS';
                break;
            case 5:
                kondisi = 'M';
                break;
            case 6:
                kondisi = 'D';
                break;
        }
        $('#update_label_no_un').html(': ' + response.detail.no_un);
        $('#update_label_no_rangka').html(': ' + response.detail.no_rangka);
        $('#update_label_no_mesin').html(': ' + response.detail.no_mesin);
        $('#update_label_kategori').html(': ' + response.detail.category_relation.name);
        $('#update_label_sub_kategori').html(': ' + response.detail.sub_category_relation.name);
        $('#update_label_merk').html(': ' + response.detail.merk_relation.name);
        $('#update_label_jenis').html(': ' + response.detail.type_relation.name);
        $('#update_label_kondisi').html(': ' + kondisi);
      
    
    })
    $('#update_labelasset_code').html(': ' + asset)
    $('#update_asset_code').val(asset)
});

$('#laporan_table tbody').on('click', 'tr', function () {
    const row = table.row(this).data();

    $('#edit_request_code').prop('disabled', true)
    $('#edit_select_type').prop('disabled', true)
    $('#edit_select_reporter').prop('disabled', true)
    $('#edit_catatan').prop('disabled', true)
    $('#edit_request_code').val(row.request_code)
    $('#edit_select_type').val(row.type)
    $('#edit_select_reporter').val(row.reporter)
    $('#edit_select_type').select2().trigger('change')
    $('#edit_select_reporter').select2().trigger('change')
    $('#edit_catatan').val(row.remark)
    $("#edit_attachment").html(`: <a style="color:#76ABAE !important;font-size:10px !important" 
                                        title="Click Here For Attachment" 
                                        href="storage/${row.attachment}" 
                                        target="_blank" class="mt-2">
                                        <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>`)


    $('#editRequestModal').modal('show')
    var data_test ={
        'request_code' : row.request_code
    }
    $('#edit_asset_table').DataTable().clear().destroy();
    $('#edit_asset_table').DataTable({
        responsive: true, 
        scrollX: true,    
        autoWidth: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `getDetailMaintenance`,
            type: 'GET',
            data : data_test 
        },
        columns: [
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    switch (data) {
                        case 0: return `<span style="text-align:center;font-size:10px" class="mb-1 badge w-100 bg-info-subtle text-info" >On Progress</span>`;
                        case 1: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-100 bg-warning-subtle text-warning" >DONE</span>';
                   
                    }
                }
            },
            {
                data: 'asset_relation.kondisi',
                name: 'asset_relation.kondisi',
                render: function (data) {
                    switch (data) {
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
        
            {
                data: 'asset_code', // Explicitly set to `null` for custom rendering
                name: 'asset_code',
                className: 'nowrap',
                // width: '300px',
                render: function (data) {
                    return `
                    <button class="btn btn-sm btn-secondary openTab" data-bs-toggle="modal" style="font-size:10px" data-bs-target="#updateRequestModal" title="Update kondisi asset" data-asset="${data}">
                        <i class="fa-solid fa-file-pen"></i> Update Kondisi
                    </button>
                    `;
                },
            },
            { data: 'asset_relation.satgas_relation.name', name: 'asset_relation.satgas_relation.name' },
            { data: 'asset_relation.no_un', name: 'asset_relation.no_un' },
            { data: 'asset_relation.category_relation.name', name: 'asset_relation.category_relation.name' },
            { data: 'asset_relation.sub_category_relation.name', name: 'asset_relation.sub_category_relation.name' },
            { data: 'asset_relation.type_relation.name', name: 'asset_relation.type_relation.name' },
            { data: 'asset_relation.merk_relation.name', name: 'asset_relation.merk_relation.name' },
            { data: 'asset_relation.no_mesin', name: 'asset_relation.no_mesin' },
            { data: 'asset_relation.no_rangka', name: 'asset_relation.no_rangka' },
        ], 
    });
    
});

getActiveItems('getUser', null, 'edit_select_reporter', 'Reporter');
$(document).ready(function() {
    $('#btn_add_request').on('click', function() {
        // Reset form and hide container labels
        $('#form_serialize')[0].reset(); // Use [0] to access the DOM element for reset
        $('.container_label').prop('hidden', true);
        getActiveItems('getUser', null, 'select_reporter', 'Reporter');
        getCallbackNoSwal('getMasterAsset', null, function(response) {
            if (response && response.data) {
                var selectAssetOptions = '<option value="">Pilih Asset</option>';
                response.data.forEach(function(item) {
                    selectAssetOptions += `
                        <option value="${item.asset_code}">
                            ${item.no_un} - ${item.category_relation.name}
                        </option>
                    `;
                });
                $('#select_asset').html(selectAssetOptions);
            } else {
                console.error('Invalid response for getMasterAsset:', response);
            }
        });
        $('#asset_table').DataTable().clear().destroy();
        $('#asset_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `getAssetMaintenance`,
                type: 'GET',
            },
            columns: [
                {
                    data: null, // No data binding for checkbox column
                    orderable: false, // Disable ordering for this column
                    searchable: false, // Disable searching for this column
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="row-checkbox" value="${row.asset_code}">`; // Replace `row.id` with the appropriate unique identifier
                    }
                },
                {
                    data: 'kondisi',
                    name: 'kondisi',
                    render: function (data) {
                        switch (data) {
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
                { data: 'satgas_relation.name', name: 'satgas_relation.name' },
                { data: 'no_un', name: 'no_un' },
                { data: 'category_relation.name', name: 'category_relation.name' },
                { data: 'sub_category_relation.name', name: 'sub_category_relation.name' },
                { data: 'type_relation.name', name: 'type_relation.name' },
                { data: 'merk_relation.name', name: 'merk_relation.name' },
                { data: 'no_mesin', name: 'no_mesin' },
                { data: 'no_rangka', name: 'no_rangka' },
                {
                    data: 'inventaris_relation.attachment',
                    name: 'inventaris_relation.attachment',
                    render: function (data, type, row) {
                        if (data) {
                            return `<a style="color:#76ABAE !important;font-size:10px !important" 
                                        title="Click Here For Attachment" 
                                        href="storage/${data}" 
                                        target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>`;
                        }
                        return '-';
                    }
                },
              
            ]
        });
    });
});
$(document).ready(function () {
    const tableArray = $('#asset_array_table').DataTable({
        columns: [
            { data: 'asset_code', title: 'Asset Code' },
            { data: 'satgas_name', title: 'Satgas' },
            {
                data: 'kondisi',
                name: 'kondisi',
                render: function (data) {
                    switch (data) {
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
            {
                data: null,
                title: 'Action',
                orderable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-danger btn-sm remove-row" style="text-align:center" data-id="${row.asset_code}">
                       <i class="fa-solid fa-circle-xmark"></i>
                    </button>`;
                }
            }
        ]
    });
    function toggleAssetArrayTableVisibility() {
        const tableArrayData = $('#asset_array_table').DataTable().rows().data();
        if (tableArrayData.length > 0) {
            $('#array_table_request').show(); // Replace with the container ID or class
        } else {
            $('#array_table_request').hide();
        }
    }
    $(document).ready(function () {
        toggleAssetArrayTableVisibility();
    });
    // Add row to table_array when checkbox is checked
    $('#asset_table').on('change', '.row-checkbox', function () {
        const isChecked = $(this).is(':checked');
        const row = $(this).closest('tr');
        const rowData = $('#asset_table').DataTable().row(row).data();
    
        if (isChecked) {
            tableArray.row.add({
                asset_code: rowData.asset_code,
                satgas_name: rowData.satgas_relation.name,
                kondisi: rowData.kondisi,
            }).draw();
        } else {
            tableArray.rows((idx, data) => data.asset_code === rowData.asset_code).remove().draw();
        }
    
        toggleAssetArrayTableVisibility(); // Check visibility after data change
    });

    // Remove row from tableArray when "Remove" button is clicked
    $('#asset_array_table').on('click', '.remove-row', function () {
        const assetCode = $(this).data('id');
        tableArray.rows((idx, data) => data.asset_code === assetCode).remove().draw();
    
        // Uncheck the corresponding checkbox in the main table
        $(`.row-checkbox[value="${assetCode}"]`).prop('checked', false);
    
        toggleAssetArrayTableVisibility(); // Check visibility after data change
    });
});
onChange('select_type','type')
onChange('select_reporter','reporter')
$('#btn_save_request').on('click', function(e){
    e.preventDefault()
    var data        = new FormData();    
    
    data.append('type',$('#type').val())
    data.append('reporter',$('#reporter').val())
    data.append('catatan',$('#catatan').val())
    data.append('attachment',$('#attachment')[0].files[0]);
    var assetArray = [];
    const tableArrayData = $('#asset_array_table').DataTable().rows().data();
    tableArrayData.each(function (value) {
        assetArray.push({
            'asset_code': value.asset_code,
            'satgas_name': value.satgas_name,
            'kondisi': value.kondisi,
        });
    });

    // Append asset array as JSON string
    data.append('assets', JSON.stringify(assetArray));
    postAttachment('addLaporanHeader', data, false, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#status_distribusi_table').DataTable().ajax.reload();
    })
})