const table = $('#status_distribusi_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getStatusDistribusi`,
        type: 'GET',
    },
    columns: [
        {
            class: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: ''
        },
        { data: 'distribution_code', name: 'distribution_code' },
        { data: 'destination_relation.name', name: 'destination_relation.name' },
        { data: 'location_relation.name', name: 'location_relation.name' },
        { 
            data: 'status', 
            name: 'status',
            render: function(data, type, row) {
                switch(data) {
                    case 0: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-dark-subtle" >Order And Preparation</span>';
                    case 1: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-secondary" >Shipping & Tracking</span>';
                    case 2: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-success" >Delivery Confirmation</span>';
                    default: return 'Unknown';
                }
            },
            
            createdCell: function (td, cellData, rowData, row, col) {
                // Apply center alignment to the status cell
                $(td).css('text-align', 'center');
            }
        },
        
    ]
    
    
});
let selectedAssets = [];
var detailRows =[]
$('#status_distribusi_table').on('click', 'tbody td.dt-control', function (e) {
    let tr = $(this).closest('tr');
    let row = table.row(tr);
    let idx = detailRows.indexOf(tr[0].id);

    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();
        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        tr.addClass('details');
        row.child(format(row.data())).show();
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr[0].id);
        }
    }

    // Prevent the click event from bubbling up to the parent tr
    e.stopPropagation();
});
let mapInstance = null; // Global variable to store the map instance

$('#status_distribusi_table tbody').on('click', 'tr', function (e) {
    if ($(e.target).closest('td.dt-control').length) {
        return; // Do nothing if the click is on td.dt-control
    }

    const row = table.row(this).data();
    $('#detailDistribusiModal').modal('show');

    // Populate modal fields
    var attachment = row.attachment !== ""
        ? `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="storage/${row.attachment}" target="_blank">
            <i class="fa-solid fa-file-pdf"></i> Click Here
        </a>` : '-';

    var status = '';
    switch (row.status) {
        case 0: status = 'Order And Preparation'; break;
        case 1: status = 'Shipping & Tracking'; break;
        case 2: status = 'Delivery Confirmation'; break;
        default: status = 'Unknown'; break;
    }

   

    $('#distribution_code').val(row.distribution_code);
    $('#asset_table_detail').DataTable().clear().destroy();
    const tableDetail = $('#asset_table_detail').DataTable({
        processing: true,
        serverSide: false, // Disable server-side processing since we're using local data
        data: row.item_relation, // Use row.item_relation as the data source
        columns: [
            { data: 'asset_code', name: 'asset_code' },
            {
                data: 'asset_relation.kondisi',
                name: 'asset_relation.kondisi',
                render: function (data) {
                    const kondisiMap = {
                        0: '-',
                        1: 'BAIK',
                        2: 'RR OPS',
                        3: 'RB',
                        4: 'RR TDK OPS',
                        5: 'M',
                        6: 'D'
                    };
                    return kondisiMap[data] || 'Unknown';
                }
            },
            { 
                data: 'asset_relation.satgas_relation', 
                name: 'asset_relation.satgas_relation.name', 
                render: function (data) {
                    return data && data.name ? data.name : '-'; // Safely check if data and data.name exist
                }
            },
            { 
                data: 'asset_relation.no_un', 
                name: 'asset_relation.no_un', 
                render: function (data) {
                    return data ? data : '-'; // Return '-' if the value is null or undefined
                }
            },
            { 
                data: 'asset_relation.category_relation.name', 
                name: 'asset_relation.category_relation.name', 
                render: function (data) {
                    return data ? data : '-'; // Safely check for null/undefined
                }
            },
            { 
                data: 'asset_relation.sub_category_relation', // Check if sub_category_relation exists
                name: 'asset_relation.sub_category_relation.name', 
                render: function (data) {
                    return data && data.name ? data.name : '-'; // Safely check for null/undefined
                }
            },
            { 
                data: 'asset_relation.type_relation.name', 
                name: 'asset_relation.type_relation.name', 
                render: function (data) {
                    return data ? data : '-'; // Safely check for null/undefined
                }
            },
            { 
                data: 'asset_relation.merk_relation.name', 
                name: 'asset_relation.merk_relation.name', 
                render: function (data) {
                    return data ? data : '-'; // Safely check for null/undefined
                }
            },
            { 
                data: 'asset_relation.no_mesin', 
                name: 'asset_relation.no_mesin', 
                render: function (data) {
                    return data ? data : '-'; // Safely check for null/undefined
                }
            },
            { 
                data: 'asset_relation.no_rangka', 
                name: 'asset_relation.no_rangka',
                render: function (data) {
                    return data ? data : '-'; // Safely check for null/undefined
                }
            },
        ],
        initComplete: function () {
            $('#asset_table thead tr').prepend('<th><input type="checkbox" id="check-all"></th>');
            $('#asset_table tbody tr').prepend('<td></td>');
        }
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
        $('#edit_label_distribution_code').html(': ' + row.distribution_code)
        $('#edit_label_lokasi_tujuan').html(': ' + row.destination_relation.name)
        $('#edit_label_lokasi_sekarang').html(': ' + row.location_relation.name)
        $('#edit_label_reporter').html(': ' + row.reporter_relation.name)
        $('#edit_label_reporter').html(': ' + row.reporter_relation.name)
        $('#edit_label_status').html(': ' + status)
        $('#edit_label_attachment').html(' : ' + attachment)
        $('#edit_label_catatan').html(' : ' + row.keterangan)
       


    row.status == 0 ? $('#status-0').prop('hidden', false) : $('#status-0').prop('hidden', true);
    row.status == 1 ? $('#status-1').prop('hidden', false) : $('#status-1').prop('hidden', true);

    // Initialize the map when the modal is shown
    $('#detailDistribusiModal').on('shown.bs.modal', function () {
        const mapContainerId = "map"; // ID for your map container

        // Destroy the existing map instance if it exists
        if (mapInstance) {
            mapInstance.remove();
        }

        // Initialize the map
        mapInstance = L.map(mapContainerId).setView([0, 0], 10);

        // Add a tile layer (example: OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapInstance);

        // Add markers for each location in detail_relation
        if (Array.isArray(row.detail_relation)) {
            const bounds = [];
            let markerCount = 0; // Untuk menghitung jumlah marker yang ditambahkan
            const markers = []; // Untuk menyimpan referensi marker
            const lines = []; // Untuk menyimpan referensi garis penghubung
            for (let i = 0; i < row.detail_relation.length; i++) {
                // Skip the second item (index 1) but still count it in the loop
                if (i === 1) {
                    markerCount++;  // Increase the marker count manually
                    continue; // Skip processing for the second item
                }
        
                const detail = row.detail_relation[i];
        
                if (detail.location_relation && detail.location_relation.x && detail.location_relation.y) {
                    const coordinates = [detail.location_relation.x, detail.location_relation.y];
                    var proses = `Proses ${i + 1}`;
                    const marker = L.marker(coordinates).addTo(mapInstance)
                        .bindPopup(`Lokasi :  ${detail.location_relation.name || 'Unknown'}`);
        
                    // Menambahkan label nomor berdasarkan urutan dalam row.detail_relation
                    L.marker(coordinates, {
                        icon: L.divIcon({
                            className: 'label-number',
                            html: `<div class="marker-label">${i + 1}</div>`, // Menampilkan nomor berdasarkan urutan i
                            iconSize: [30, 30] // Ukuran label
                        })
                    }).addTo(mapInstance);
        
                    bounds.push(coordinates);
                    markers.push(marker); // Menyimpan marker untuk menghubungkan garis
                    markerCount++; // Increment marker count
                }
            }
        
            // Menghubungkan marker dengan garis
            if (markers.length > 1) {
                for (let i = 0; i < markers.length - 1; i++) {
                    const line = L.polyline([markers[i].getLatLng(), markers[i + 1].getLatLng()], {
                        color: 'blue', // Warna garis
                        weight: 3,
                        opacity: 0.6
                    }).addTo(mapInstance);
                    lines.push(line);
                }
            }
        
            // Fit map bounds jika lebih dari satu marker ditambahkan
            if (markerCount > 1) {
                mapInstance.fitBounds(bounds, { padding: [50, 50] });
            } else if (markerCount === 1) {
                // Jika hanya satu marker, set map view ke lokasi marker tersebut
                mapInstance.setView(bounds[0], 8); // Level zoom 15 untuk satu lokasi
            }
        }
        $('#distribusi_log_table').DataTable().clear().destroy();
        $('#distribusi_log_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `getDistribusiLog`,
                type: 'GET',
                data :{'distribution_code': row.distribution_code}
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data, type, row) {
                        if (data) {
                            const date = new Date(data);
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            const hours = String(date.getHours()).padStart(2, '0');
                            const minutes = String(date.getMinutes()).padStart(2, '0');
                            const seconds = String(date.getSeconds()).padStart(2, '0');
                            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                        }
                        return '';
                    }
                },
                { data: 'user_relation.name', name: 'user_relation.name' },
                { 
                    data: 'kondisi', 
                    name: 'kondisi',
                    render: function(data, type, row) {
                        switch(data) {
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
                    data: 'status', 
                    name: 'status',
                    render: function(data, type, row) {
                        switch(data) {
                            case 0: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-100 bg-dark-subtle" >Order And Preparation</span>';
                            case 1: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-100 bg-secondary" >Shipping & Tracking</span>';
                            case 2: return '<span style="text-align:center;font-size:10px" class="mb-1 badge w-100 bg-success" >Delivery Confirmation</span>';
                            default: return 'Unknown';
                        }
                    }
                },
                { 
                    data: 'attachment', 
                    name: 'attachment',
                    render: function(data, type, row) {
                        var attachment = row.attachment !== "" 
                            ? `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="storage/${row.attachment}" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i> Click Here
                               </a>`
                            : '-';
                        return attachment;
                    }
                },
                { data: 'keterangan', name: 'keterangan' },
            ]
            
            
        });
        
        
        
        
    });

    // Cleanup the map when the modal is closed
    $('#detailDistribusiModal').on('hidden.bs.modal', function () {
        if (mapInstance) {
            mapInstance.remove(); // Destroy the map instance
            mapInstance = null;  // Reset the map variable
        }
    });
});

// Add Distribusi
    $('#btn_add_distribusi').on('click', function(){
        selectedAssets = [];
        getCallbackNoSwal('getSatgas', null, function(response){
            $('#select_satgas_filter').empty()
            var select_satgas_filter = '<option value="">All Satgas</option>'
            for(i = 0; i < response.data.length; i++){
                select_satgas_filter += `
                    <option value="${response.data[i].name}" data-type ="${response.data[i].type}">
                        ${response.data[i].name} - ${response.data[i].type}
                    </option>
                `
            }
            $('#select_satgas_filter').html(select_satgas_filter)
        })

        // $('.container_label').prop('hidden', true)
        $("#tujuan").val('')
        $("#reporter").val('')
        $("#asset").val('')
        getActiveItems('getUser',null,'select_reporter','Reporter')
        getCallbackNoSwal('getSatgas', null, function(response){
            $('#select_tujuan').empty()
            var select_tujuan = '<option value="">Pilih Satgas</option>'
            for(i = 0; i < response.data.length; i++){
                select_tujuan += `
                    <option value="${response.data[i].id}" data-type ="${response.data[i].type}">
                        ${response.data[i].name} - ${response.data[i].type}
                    </option>
                `
            }
            $('#select_tujuan').html(select_tujuan)
        })

       var selectedAssetCodes =new Set();
        $(document).ready(function () {
            $('.asset_array_container').prop('hidden', true)
            $('#asset_array_table').DataTable().clear().destroy();
            $('#asset_table').DataTable().clear().destroy();
           // Inisialisasi DataTable
                const assetTable = $('#asset_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `getMasterAssetDistribusi`,
                        type: 'GET',
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
                            render: function (data) {
                                const kondisiMap = {
                                    0: '-',
                                    1: 'BAIK',
                                    2: 'RR OPS',
                                    3: 'RB',
                                    4: 'RR TDK OPS',
                                    5: 'M',
                                    6: 'D'
                                };
                                return kondisiMap[data] || 'Unknown';
                            }
                        },
                        { data: 'satgas_relation.name', name: 'satgas_relation.name' },
                        { data: 'no_un', name: 'no_un' },
                        { data: 'category_relation.name', name: 'category_relation.name' },
                        { data: 'sub_category_relation.name', name: 'sub_category_relation.name' },
                        { data: 'type_relation.name', name: 'type_relation.name' },
                        { data: 'merk_relation.name', name: 'merk_relation.name' },
                        { data: 'no_mesin', name: 'no_mesin' },
                        { data: 'no_rangka', name: 'no_rangka' }
                    ],
                });
                // Filter Checkbox "Check All"
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

                    // Update "Check All" Checkbox
                    const totalCheckboxes = $('#asset_table .row-checkbox').length;
                    const checkedCheckboxes = $('#asset_table .row-checkbox:checked').length;
                    $('#check-all').prop('checked', totalCheckboxes === checkedCheckboxes);
                });

                // Restore Checkbox States when Table is Redrawn
                $('#asset_table').on('draw.dt', function () {
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

                // === Filter Lokasi & Kondisi ===
                function applyFilters() {
                    let satgas = $('#select_satgas_filter').val() || ''; // Ambil nilai filter Satgas
                    let kondisi = $('#select_kondisi_filter').val() || ''; // Ambil nilai filter Kondisi  
                    // Pencarian tanpa regex
                    assetTable.column(2).search(satgas).draw();
                    assetTable.column(1).search(kondisi).draw();
                    
                }

                // Event untuk filter Satgas
                $('#select_satgas_filter').on('change', function () {
                    applyFilters();
                });

                // Event untuk filter Kondisi
                $('#select_kondisi_filter').on('change', function () {
                    applyFilters();
                });

            // Store selected assets
          
        
            // Handle checkbox click event
            $('#asset_table tbody').on('change', '.row-checkbox', function () {
                let row = $(this).closest('tr');
                let table = $('#asset_table').DataTable(); // Ensure DataTable is initialized
                let rowData = table.row(row).data();
            
                if (!rowData) {
                    console.error("Row data is undefined. Make sure DataTable is properly initialized.");
                    return;
                }
            
                console.log(rowData);
            
                if (this.checked) {
                    // Add selected row data to array
                    selectedAssets.push({
                        asset_code: rowData.asset_code || '-',
                        kondisi: rowData.kondisi || '-',
                        satgas: rowData.satgas_relation ? rowData.satgas_relation.name : '-',
                        no_un: rowData.no_un || '-',
                        kategori: rowData.category_relation ? rowData.category_relation.name : '-',
                        subkategori: rowData.sub_category_relation ? rowData.sub_category_relation.name : '-',
                        jenis: rowData.type_relation ? rowData.type_relation.name : '-',
                        merk: rowData.merk_relation ? rowData.merk_relation.name : '-',
                        no_mesin: rowData.no_mesin || '-',
                        no_rangka: rowData.no_rangka || '-'
                    });
                } else {
                    // Remove unchecked row from array
                    selectedAssets = selectedAssets.filter(item => item.asset_code !== rowData.asset_code);
                }
            
                // Update asset array table
                updateAssetArrayTable();
            
                // Show/hide elements based on selection
                $('#btn_save_distribusi').prop('hidden', selectedAssets.length === 0);
                $('.asset_array_container').prop('hidden', selectedAssets.length === 0);
            });
            
        
            // Function to update asset_array_table
            function updateAssetArrayTable() {
                let tableBody = $('#asset_array_table tbody');
                tableBody.empty(); // Clear existing rows
              
                selectedAssets.forEach(asset => {
                    var kondisi = ''
                    switch (asset.kondisi) {
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
                    tableBody.append(`
                        <tr data-asset-code="${asset.asset_code}">
                            <td>${asset.asset_code}</td>
                            <td>${kondisi}</td>
                            <td>${asset.satgas}</td>
                            <td>${asset.no_un}</td>
                            <td>${asset.kategori}</td>
                            <td>${asset.subkategori}</td>
                            <td>${asset.jenis}</td>
                            <td>${asset.merk}</td>
                            <td>${asset.no_mesin}</td>
                            <td>${asset.no_rangka}</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-asset" data-asset-code="${asset.asset_code}">Remove</button>
                            </td>
                        </tr>
                    `);
                });
            }
        
            // Handle remove button click
            $('#asset_array_table tbody').on('click', '.remove-asset', function () {
                let assetCode = $(this).data('asset-code');
        
                // Remove from selectedAssets array
                selectedAssets = selectedAssets.filter(item => item.asset_code !== assetCode);
        
                // Uncheck the corresponding checkbox in the main table
                $('#asset_table tbody')
                    .find(`.row-checkbox[value="${assetCode}"]`)
                    .prop('checked', false);
        
                // Update asset array table
                updateAssetArrayTable();
                if(selectedAssets.length == 0){
                    $('#btn_save_distribusi').prop('hidden', true)
                    $('.asset_array_container').prop('hidden', true)
                }else{
                    $('#btn_save_distribusi').prop('hidden', false)
                    $('.asset_array_container').prop('hidden', false)

                }
            });
        });
        
    })

        onChange('select_tujuan','tujuan')
        onChange('select_reporter','reporter')
        $('#btn_save_distribusi').on('click', function (e) {
            e.preventDefault();
        
            // Check if at least one item is selected
            if (selectedAssets.length === 0) {
                toastr['warning']('Please select at least one asset before submitting.');
                return;
            }else{
                var data = new FormData();
                data.append('reporter', $('#reporter').val());
                data.append('tujuan', $('#tujuan').val());
                data.append('catatan', $('#catatan').val());
                data.append('attachment', $('#attachment')[0].files[0]);
            
                // Append selected assets as JSON string
                data.append('assets', JSON.stringify(selectedAssets));
            
                postAttachment('addDistribusi', data, false, function (response) {
                    swal.close();
                    toastr['success'](response.meta.message);
                    $('#addDistribusiModal').modal('hide');
                    $('#status_distribusi_table').DataTable().ajax.reload();
                });

            }
        
        });
// Add Distribusi

    table.on('draw', () => {
        detailRows.forEach((id, i) => {
            let el = document.querySelector('#' + id + ' td.dt-control');
    
            if (el) {
                el.dispatchEvent(new Event('click', { bubbles: true }));
            }
        });
    });
    function format(d) {
        var response = d.detail_relation; // Assuming this is an array or object

        // Check if response is an array or object
        if (Array.isArray(response)) {
            let tableContent = `
            <table class="table  table-bordered table-striped">
                <thead style="backgound-color:">
                    <tr> 
                            <th>Created At</th>
                            <th>Detail Transaksi</th>
                            <th>PIC</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                           
                    </tr>
                </thead>
                <tbody>
                `;

            // Loop through each item in the response and create table rows
            for(i = 0 ; i < response.length ; i++){
                var status = '';
                switch (response[i].status) {
                    case 0: status= '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-dark-subtle" >Order And Preparation</span>';break;
                    case 1: status= '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-secondary" >Shipping & Tracking</span>';break;
                    case 2: status= '<span style="text-align:center;font-size:10px" class="mb-1 badge w-80 bg-success" >Delivery Confirmation</span>';break;
                    default: status= 'Unknown';break;
                }
            
                var kondisi = '';
                switch (response[i].kondisi) {
                    case 0: kondisi = '-'; break;
                    case 1: kondisi = 'BAIK'; break;
                    case 2: kondisi = 'RR OPS'; break;
                    case 3: kondisi = 'RB'; break;
                    case 4: kondisi = 'RR TDK OPS'; break;
                    case 5: kondisi = 'M'; break;
                    case 6: kondisi = 'D'; break;
                    default: kondisi = 'Unknown'; break;
                }
                var createdAt = new Date(response[i].created_at);
                var formattedDate = createdAt.toLocaleString(); 
                tableContent +=`
                    <tr>
                        <td>${formattedDate}</td>
                        <td>${response[i].detail_distribution_code}</td>
                        <td>${response[i].user_relation.name}</td>
                        <td>${response[i].location_relation.name}</td>
                        <td style="text-align:center">${status}</td>
                      
                    </tr>
                `
            }

            tableContent += '</tbody></table>';

            return tableContent;
        } else {
            return 'No data available.';
        }
    }


// Start Progress
    $('#start_progress').on('click', function(){
        var data = {
            'distribution_code' : $('#distribution_code').val()
        }
        postCallback('startProgressDistribution', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#detailDistribusiModal').modal('hide')
            $('#status_distribusi_table').DataTable().ajax.reload();
        })
    })
// Start Progress

// Update DIstribusi
    onChange('update_select_kondisi','update_kondisi')
    onChange('udpate_select_status','update_status')
    $('#btn_update_distribusi').on('click', function(e){
        e.preventDefault()
        var data        = new FormData();    
        data.append('distribution_code',$('#distribution_code').val())
        data.append('update_status',$('#update_status').val())
        data.append('update_catatan',$('#update_catatan').val())
        data.append('update_attachment',$('#update_attachment')[0].files[0]);
        postAttachment('updateDistribusi', data, false, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#status_distribusi_table').DataTable().ajax.reload();
        })
    })
// Update DIstribusi