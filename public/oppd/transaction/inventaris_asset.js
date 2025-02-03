const table = $('#inventaris_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getInventaris`,
        type: 'GET',
    },
    columns: [
        {
            data: 'created_at',
            name: 'created_at',
            render: function (data) {
                if (data) {
                    const date = new Date(data);
                    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                }
                return '-';
            }
        },
        { data: 'satgas_relation.name', name: 'satgas_relation.name' },
        { data: 'detail_relation.length', name: 'detail_relation.length' },
        { data: 'kondisi', name: 'kondisi',class:'d-flex justify-content-start', orderable: false, searchable: false }, // Kondisi column
    ]
});

getActiveItems('getSatgasType',null,'select_filter_asset','Satgas')
getActiveItems('getUser',null,'edit_select_reporter','Reporter')
getCallbackNoSwal('getSatgas', null, function(response){
    $('#edit_select_satgas').empty()
    var edit_select_satgas = '<option value="">Pilih Satgas</option>'
    for(i = 0; i < response.data.length; i++){
        edit_select_satgas += `
            <option value="${response.data[i].id}" data-type ="${response.data[i].type}">
                ${response.data[i].name} - ${response.data[i].type}
            </option>
        `
    }
    $('#edit_select_satgas').html(edit_select_satgas)
})

getCallbackNoSwal('getMasterAssetInventaris', null, function(response){
    var edit_select_asset = '<option value="">Pilh Asset</option>'
    $("#edit_select_asset").empty()
    $("#edit_select_asset").html()
    for(i = 0; i < response.data.length; i++){
        edit_select_asset += `
            <option value ="${response.data[i].asset_code}">
                ${response.data[i].no_un} - ${response.data[i].category_relation.name}
            </option>
        `
    }
    $('#edit_select_asset').html(edit_select_asset)
})
$('#inventaris_table tbody').on('click', 'tr', function () {
    $('.general_asset').prop('hidden', true);
    $('#editAssetModal').modal('show');
    const data = table.row(this).data();
    var response = data.detail_relation;
    $('#update_inventaris_code').val(response[0].inventaris_code)
    // Check if `response` contains data
    if (response && Array.isArray(response)) {
        // Destroy any existing DataTable instance
        $('#detailTableAsset').DataTable().clear().destroy();
        // Populate the DataTable with the response data
        $('#detailTableAsset').DataTable({
            data: response,
            columns: [
                { 
                        data: 'asset_code',
                        name: 'asset_code',
                        render: function (data) {
                            if (data) {
                                return `
                                <button class="btn btn-sm btn-warning btn-edit-row" data-asset_code="${data}">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                `;
                            }
                            return '-';
                        }  
                 },
                {
                    data: 'kondisi',
                    name: 'kondisi',
                    render: function (data) {

                        switch (parseInt(data)) {
                            case 0: return '-';
                            case 1: return `<span class="badge badge-primary w-15 mx-1" style="background-color:#16C47F;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">BAIK</span>`;
                            case 2: return `<span class="badge badge-primary w-15 mx-1" style="background-color:#40A2E3;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">RR OPS</span>`;
                            case 3: return `
                            <span class="badge badge-primary w-15 mx-1" style="background-color:#E82561;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">RB</span>`;
                            case 4: return `<span class="badge badge-primary w-15 mx-1" style="background-color:#500073;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">RR TDK OPS</span>`;
                            case 5: return `<span class="badge badge-primary w-15 mx-1" style="background-color:#697565;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">M</span>`;
                            case 6: return `<span class="badge badge-primary w-15 mx-1" style="background-color:#3C3D37;color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">D</span>`;
                            default: return 'Unknown';
                        }
                    }
                },
                { data: 'asset_relation.satgas_relation.type', name: 'asset_relation.satgas_relation.type'},
                { data: 'asset_relation.no_un', name: 'asset_relation.no_un' },
                { data: 'asset_relation.category_relation.name', name: 'asset_relation.category_relation.name' },
                { data: 'asset_relation.sub_category_relation.name', name: 'asset_relation.sub_category_relation.name' },
                { data: 'asset_relation.type_relation.name', name: 'asset_relation.type_relation.name' },
                { data: 'asset_relation.merk_relation.name', name: 'asset_relation.merk_relation.name' },
                { data: 'asset_relation.no_mesin', name: 'asset_relation.no_mesin' },
                { data: 'asset_relation.no_rangka', name: 'asset_relation.no_rangka' },
                { data: 'catatan', name: 'catatan' },
                {
                    data: 'attachment',
                    name: 'attachment',
                    render: function (data) {
                        if (data) {
                            return `
                            <button class="btn btn-sm btn-info btn-view-attachment" data-attachment-url="${data}" style="font-size:10px">
                                <i class="fas fa-file pr-2"></i> View Attachment
                            </button>
                            `;
                        }
                        return '-';
                    }
                },
            ],
            paging: true,
            searching: true,
            ordering: true,
        });
    } else {
        console.error('Response is not valid or does not contain data');
    }
});
$('#detailTableAsset').on('click', '.btn-edit-row', function (e) {
    e.preventDefault();
    $('.general_asset').prop('hidden', false)
    const asset_code = $(this).data('asset_code');
    getCallbackNoSwal('getInventarisDetail', { 'asset_code' :asset_code, 'inventaris_code' : $('#update_inventaris_code').val() }, function (response) {
        $('#update_label_asset_code').html(': ' + response.detail.asset_code)
        $('#update_label_no_un').html(': ' + response.detail.asset_relation.no_un)
        $('#update_label_no_rangka').html(': ' + response.detail.asset_relation.no_rangka)
        $('#update_label_no_mesin').html(': ' + response.detail.asset_relation.no_mesin)
        $('#update_label_kategori').html(': ' + response.detail.asset_relation.category_relation.name)
        $('#update_label_sub_kategori').html(': ' + response.detail.asset_relation.sub_category_relation.name)
        $('#update_label_jenis').html(': ' + response.detail.asset_relation.type_relation.name)
        $('#update_label_merk').html(': ' + response.detail.asset_relation.merk_relation.name)
        $('#select_update_kondisi').val(response.detail.kondisi)
        $('#select_update_kondisi').select2().trigger('change');
        $('#update_asset_code').val(response.detail.asset_code)
    })
})
$('#imageModal').on('hidden.bs.modal', function () {
    // Reset the image source when the modal is closed
    $('#imageModal img').attr('src', '');
    $('#editAssetModal').modal('show');
    // $('#detailTableAsset').DataTable().ajax.reload();
    $('.general_asset').prop('hidden', true);
    $('#update_catatan').val('')
    $('#update_attachment').val('')
    $('#update_attachment').next('.custom-file-label').html('Choose file...');

});
$('#imageModal').on('shown.bs.modal', function () {
    $('#editAssetModal').modal('hide');
})
$('#detailTableAsset').on('click', '.btn-view-attachment', function (e) {
    e.preventDefault();
    const imageUrl ='storage/'+ $(this).data('attachment-url');

    if (imageUrl) {
        // Set the image source in the modal
        $('#imageModal img').attr('src', imageUrl);

        // Show the modal
        $('#imageModal').modal('show');
    }
});
onChange('select_type','type')
$('#btn_add_asset').on('click', function(){

    $('#asset_table').DataTable().clear().destroy();
    $('#asset_array_table').DataTable().clear().destroy();
    $('.update_container').prop('hidden', true)
    $('#asset_array_table').prop('hidden', true)
    $('#array_table_asset').prop('hidden', true)

        $('#asset_table').DataTable().clear().destroy();
        $(document).ready(function () {
            const assetTable = $('#asset_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `getMasterAssetInventarisTable`,
                    type: 'GET',
                    data: function (d) {
                        d.satgas = $('#select_satgas').val(); // Kirim filter Satgas
                        d.kondisi = $('#select_kondisi_filter').val(); // Kirim filter Kondisi
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${row.asset_code}">`;
                        }
                    },
                    { 
                        data: 'kondisi', 
                        name: 'kondisi',
                        render: function(data, type, row) {
                            let kondisi = '-'; // Default value
                        
                            console.log("Kondisi Data:", data, "Type:", typeof data); // Debugging
                        
                            switch (parseInt(data)) {  // Konversi data ke integer sekali di awal
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
                        
                            return kondisi;
                        }
                        
                    },
                    { 
                        data: 'satgas_relation', 
                        name: 'satgas_relation.name', 
                        render: function (data) {
                            return data && data.name ? data.name : '-';
                        }
                    },
                    { data: 'no_un', name: 'no_un' },
                    { 
                        data: 'category_relation', 
                        name: 'category_relation.name', 
                        render: function (data) {
                            return data ? data.name : '-';
                        }
                    },
                    { 
                        data: 'sub_category_relation', 
                        name: 'sub_category_relation.name', 
                        render: function (data) {
                            return data && data.name ? data.name : '-';
                        }
                    },
                    { 
                        data: 'type_relation', 
                        name: 'type_relation.name', 
                        render: function (data) {
                            return data ? data.name : '-';
                        }
                    },
                    { 
                        data: 'merk_relation', 
                        name: 'merk_relation.name', 
                        render: function (data) {
                            return data ? data.name : '-';
                        }
                    },
                    { data: 'no_mesin', name: 'no_mesin' },
                    { data: 'no_rangka', name: 'no_rangka' },
                ]
            });
            
            
            const selectedAssetCodes = new Set();
            $(document).on('change', '#check-all', function () {
                const isChecked = $(this).is(':checked');
                $('#asset_table .row-checkbox').each(function () {
                    const assetCode = $(this).val();
                    $(this).prop('checked', isChecked);
            
                    if (isChecked) {
                        selectedAssetCodes.add(assetCode);
                    } else {
                        selectedAssetCodes.delete(assetCode);
                    }
                });
            });
            
            $(document).on('change', '#asset_table .row-checkbox', function () {
                const assetCode = $(this).val();
            
                if ($(this).is(':checked')) {
                    selectedAssetCodes.add(assetCode);
                } else {
                    selectedAssetCodes.delete(assetCode);
                }
            
                // Update the "check all" checkbox state
                const totalCheckboxes = $('#asset_table .row-checkbox').length;
                const checkedCheckboxes = $('#asset_table .row-checkbox:checked').length;
                $('#check-all').prop('checked', totalCheckboxes === checkedCheckboxes);
            });
            

            $('#asset_table').on('draw.dt', function () {
                // Restore the "check all" checkbox state
                const totalCheckboxes = $('#asset_table .row-checkbox').length;
                const checkedCheckboxes = $('#asset_table .row-checkbox').filter(function () {
                    return selectedAssetCodes.has($(this).val());
                }).length;
                $('#check-all').prop('checked', totalCheckboxes === checkedCheckboxes);
            
                // Restore individual row checkbox states
                $('#asset_table .row-checkbox').each(function () {
                    const assetCode = $(this).val();
                    $(this).prop('checked', selectedAssetCodes.has(assetCode));
                });
            });
                      
            // filter lokasi satgas
                function applyFilters() {
                    let satgas = $('#select_satgas').val(); // Ambil nilai Satgas
                    let kondisi = $('#select_kondisi_filter').val(); // Ambil nilai Kondisi
                    
                    assetTable.column(2).search(satgas || ''); // Kolom 2 untuk Satgas
                    assetTable.column(1).search(kondisi || ''); // Kolom 1 untuk Kondisi
                    assetTable.draw();
                }
                
                // Event untuk filter Satgas
                $('#select_satgas').on('change', function () {
                    applyFilters();
                });
                
                // Event untuk filter Kondisi
                $('#select_kondisi_filter').on('change', function () {
                    applyFilters();
                });
            // filter lokasi satgas
        
            const addedAssetCodes = new Set();
            $('#btn_add_array_item').on('click', function (e) {
                e.preventDefault();
                $('#asset_array_table').prop('hidden', false)
                let hasSelected = false;
                $('#asset_table .row-checkbox:checked').each(function () {
                    const rowElement = $(this).closest('tr');
                    const rowData = assetTable.row(rowElement).data();
                    var test_case = $('#select_kondisi').val()
                    if (addedAssetCodes.has(rowData.asset_code)) {
                        console.warn(`Asset ${rowData.asset_code} is already added.`);
                        return;
                    }
            
                    hasSelected = true;
                    addedAssetCodes.add(rowData.asset_code);
            
                    // Get the values of Catatan and Attachment
                    const catatan = $('#catatan').val(); // Value from the Catatan textarea
                    const attachmentFile = test_case == 1 ? '': $('#attachment')[0].files[0]; // File from the Attachment input
                    const attachmentName = attachmentFile ? attachmentFile.name : 'No file selected';
            
                    // Sanitize the asset_code to create a safe ID
                    const sanitizedAssetCode = rowData.asset_code.replace(/[^\w-]/g, '_');
                    const attachmentInputId = `attachment-${sanitizedAssetCode}`;
            
                    let kodisi = $('#select_kondisi').val();
                    switch (kodisi) {
                        case 1:
                            kodisi = 'BAIK';
                            break;
                        case 2:
                            kodisi = 'RR OPS';
                            break;
                        case 3:
                            kodisi = 'RB';
                            break;
                        case 4:
                            kodisi = 'RR TDK OPS';
                            break;
                        case 5:
                            kodisi = 'M';
                            break;
                        case 6:
                            kodisi = 'D';
                            break;
                    }
            
                    // Add the row to asset_array_table with Catatan and Attachment values
                    const newRow = `
                        <tr data-id="${rowData.asset_code}">
                            <td>${rowData.asset_code}</td>
                            <td>${kodisi}</td>
                            <td>${rowData.satgas_relation ? rowData.satgas_relation.name : '-'}</td>
                            <td>${rowData.no_un}</td>
                            <td>${rowData.category_relation ? rowData.category_relation.name : '-'}</td>
                            <td>${rowData.sub_category_relation ? rowData.sub_category_relation.name : '-'}</td>
                            <td>${rowData.type_relation ? rowData.type_relation.name : '-'}</td>
                            <td>${rowData.merk_relation ? rowData.merk_relation.name : '-'}</td>
                            <td>${rowData.no_mesin}</td>
                            <td>${rowData.no_rangka}</td>
                            <td>${catatan}</td>
                            <td>
                                ${attachmentName}
                                <input type="file" name="attachments[]" class="d-none" id="${attachmentInputId}">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-remove-row">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
            
                    // Append the new row to the table
                    $('#asset_array_table tbody').append(newRow);
            
                    // Clone the file input and assign it to the newly added row
                    if (attachmentFile) {
                        const clonedFileInput = $('#attachment').clone();
                        clonedFileInput.attr('id', attachmentInputId);
                        clonedFileInput[0].files = $('#attachment')[0].files;
                        $(`#${attachmentInputId}`).replaceWith(clonedFileInput);
                    }
                });
            
                if (!hasSelected) {
                    alert('Please select at least one row or ensure you are not re-adding the same asset.');
                }
            
                // Reset the Catatan and Kondisi fields
                $('#catatan').val('');
                $('#select_kondisi').val('');
                $('#select_kondisi').select2().trigger('change');
                // $('#attachment').val('');
                $('#attachment').next('.custom-file-label').html('Choose file...');
            });
           
            $('#asset_array_table').on('click', '.btn-remove-row', function () {
                const rowElement = $(this).closest('tr');
                const rowId = rowElement.data('id'); // Get the asset code of the row

                // Remove row from asset_array_table
                rowElement.remove();

                // Find the corresponding row in the asset_table
                const assetRow = $('#asset_table tbody').find(`input.row-checkbox[value="${rowId}"]`).closest('tr');

                // Uncheck the checkbox in the asset_table
                assetRow.find('input.row-checkbox').prop('checked', false);
            });

        });
        
        
        
        $('#btn_save_inventaris').on('click', function (e) {
            e.preventDefault();
        
            const formData = new FormData();
            const dataToSave = [];
        
            $('#asset_array_table tbody tr').each(function () {
                const row = $(this).find('td');
                const attachmentInput = $(this).find('input[type="file"]')[0]; // Improved selector
                
                const rowData = {
                    asset_code: $(row[0]).text(),
                    kondisi: $(row[1]).text(),
                    satgas: $(row[2]).text(),
                    no_un: $(row[3]).text(),
                    category: $(row[4]).text(),
                    sub_category: $(row[5]).text(),
                    type: $(row[6]).text(),
                    merk: $(row[7]).text(),
                    no_mesin: $(row[8]).text(),
                    no_rangka: $(row[9]).text(),
                    catatan: $(row[10]).text(),
                };
                dataToSave.push(rowData);
                // Append the file to the formData object if it exists
                if (attachmentInput && attachmentInput.files.length > 0) {
                    formData.append('attachments[]', attachmentInput.files[0]); // Attach file
                } else {
                    console.log(`No file attached for: ${rowData.asset_code}`);
                }
                console.log(dataToSave)
            });
        
            formData.append('data', JSON.stringify(dataToSave));
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF token
        
            postAttachment('addInventaris', formData, false, function (response) {
                swal.close();
                toastr['success'](response.meta.message);
                $('#addAssetModal').modal('hide');
                $('#inventaris_table').DataTable().ajax.reload();
            });
        });

    $("#type").val('')
    $("#asset").val('')
    $("#reporter").val('')
    $("#satgas").val('')
    getActiveItems('getUser',null,'select_reporter','Reporter')
    getCallbackNoSwal('getSatgas', null, function(response){
        $('#select_satgas').empty()
        var select_satgas = '<option value="">All Satgas</option>'
        for(i = 0; i < response.data.length; i++){
            select_satgas += `
                <option value="${response.data[i].name}" data-type ="${response.data[i].type}">
                    ${response.data[i].name} - ${response.data[i].type}
                </option>
            `
        }
        $('#select_satgas').html(select_satgas)
    })
})
    onChange('select_reporter','reporter')
    onChange('select_asset','asset')
    onChange('select_satgas','satgas')
    onChange('select_kondisi','kondisi')


    // Update Kondisi Asset
    onChange('select_update_kondisi','update_kondisi')
    $('#btn_update_kondisi').on('click', function (e) {
        e.preventDefault();
        formData = new FormData();
        formData.append('inventaris_code', $('#update_inventaris_code').val());
        formData.append('asset_code', $('#update_asset_code').val());
        formData.append('update_kondisi', $('#update_kondisi').val());
        formData.append('update_catatan', $('#update_catatan').val());
        formData.append('update_attachment',$('#update_attachment')[0].files[0]); 

        postAttachment('updateInventaris', formData, false, function (response) {
            swal.close();
            toastr['success'](response.meta.message);
            $('#detailTableAsset').DataTable().ajax.reload();
        })
    })
    // Update Kondisi Asset
    

    // Export To PDF    
        $('#btn_print_pdf').on('click', function(){
            var detail = $('#update_inventaris_code').val()
            var final = detail.replaceAll('/','_')
            window.open(`printInventarisDetail/${final}`,'_blank');
        })
    // Export To PDF