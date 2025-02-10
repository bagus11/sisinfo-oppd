
getCallbackNoSwal('getCountingAsset', null, function(response) {
    $('#select_asset_type').empty();
    $('#select_asset_type').append('<option value="">OPPD</option>');
    response.group.forEach(group => {
        $('#select_asset_type').append(`<option value="${group.type}">${group.type}</option>`);
    });
    var containerSatgas =''
    // $('#satgas_type_container').empty()
    var colors = [
        'bg-danger',
        'bg-info',
        'bg-primary',
        'bg-success',
        'bg-warning',
        'bg-dark',
        'bg-secondary'
    ];
    
    getRadialBar(response)

        for (let i = 0; i < response.countingSatgasAsset.length; i++) {
            let satgas = response.countingSatgasAsset[i];
    
            // Pastikan warna tetap dalam batas array
            let colorClass = colors[i % colors.length];
    
            containerSatgas += `
                <div class="col" style="min-width: 300px;">
                    <div class="card">
                        <div class="card-header header-info text-white p-2 bg-opacity-8 rounded-top">
                            <div class="row">
                                <div class="col-2">
                                    <strong style="font-size:14px;"><i class="fas fa-list"></i> </strong>
                                </div>
                                <div class="col-8">
                                    <strong style="font-size:16px;font-weight:bold">${satgas.type}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body rounded-2 p-0">
                            <div class="p-0" style="padding:0 !important" id="pieSatgas${i}"></div>
                        </div>
                    </div>
                </div>`;
        }
        // Hapus konten lama sebelum menambahkan elemen baru
        $('#satgas_type_container').append(containerSatgas);
        // Panggil fungsi untuk mendapatkan dan menampilkan pie chart
        for (let i = 0; i < response.countingSatgasAsset.length; i++) {
            getPieSatgas(i, response.countingSatgasAsset[i].type); // Kirim index dan type
        }
    
    
        function getPieSatgas(index, satgasType) {
            if(userHasPermission){
                getCallbackNoSwal('getSatgasPie', { type: satgasType }, function(response) {
                    const kondisiMapping = {
                        1: 'BAIK',
                        2: 'RR OPS',
                        3: 'RB',
                        4: 'RR TDK OPS',
                        5: 'M',
                        6: 'D'
                    };
                
                    // Fixed color mapping for each kondisi
                    const kondisiColors = {
                        'BAIK': "var(--bs-success)",       // Green
                        'RR OPS': "var(--bs-info)",     // Blue
                        'RB': "var(--bs-danger)",         // Red
                        'RR TDK OPS': "var(--bs-primary)", // Purple
                        'M': '#697565',          // Grey
                        'D': '#3C3D37'           // Dark Grey
                    };
                
                    let seriesData = response.data.map(item => Number(item.total));
                    let labelsData = response.data.map(item => kondisiMapping[item.kondisi] || "No Data");
                
                    // Assign colors based on kondisi mapping
                    let colorsData = labelsData.map(label => kondisiColors[label] || '#CCCCCC'); // Default color if not found
                
                    let targetElement = document.querySelector(`#pieSatgas${index}`);
                    if (!targetElement) {
                        console.error(`Element #pieSatgas${index} not found!`);
                        return;
                    }
                
                    let options = {
                        chart: {
                            type: 'donut',
                            height: 280,
                            toolbar: { show: false },
                            dropShadow: {
                                enabled: false,
                                top: 5,
                                left: 0,
                                blur: 5,
                                opacity: 0.2
                            },
                            events: {
                                dataPointSelection: function(event, chartContext, config) {
                                    let selectedKondisi = labelsData[config.dataPointIndex]; 
                                    $('#detailAssetModal').modal('show');
                                    $('#modal_title').html(satgasType + " : " + selectedKondisi);
                                    $('#asset_table').DataTable().clear().destroy();
                                    $('#asset_table').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
                                        ajax: {
                                            url: `getAssetFilter`,
                                            type: 'GET',
                                            data :{'type' : satgasType, kondisi : selectedKondisi}
                                        },
                                        columns: [
                                            { 
                                                data: 'satgas_relation', 
                                                name: 'satgas_relation.name', 
                                                render: function (data) {
                                                    return data && data.name ? data.name : '-'; // Safely check if data and data.name exist
                                                }
                                            },
                                            { 
                                                data: 'no_un', 
                                                name: 'no_un', 
                                                render: function (data) {
                                                    return data ? data : '-'; // Return '-' if the value is null or undefined
                                                }
                                            },
                                            { 
                                                data: 'category_relation', 
                                                name: 'category_relation.name', 
                                                render: function (data) {
                                                    return data ? data.name : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            { 
                                                data: 'sub_category_relation', // Check if sub_category_relation exists
                                                name: 'sub_category_relation.name', 
                                                render: function (data) {
                                                    return data && data.name ? data.name : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            { 
                                                data: 'type_relation', 
                                                name: 'type_relation.name', 
                                                render: function (data) {
                                                    return data ? data.name : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            { 
                                                data: 'merk_relation', 
                                                name: 'merk_relation.name', 
                                                render: function (data) {
                                                    console.log(data ? data.name : 'test again')
                                                    return data ? data.name : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            { 
                                                data: 'no_mesin', 
                                                name: 'no_mesin', 
                                                render: function (data) {
                                                    return data ? data : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            { 
                                                data: 'no_rangka', 
                                                name: 'no_rangka',
                                                render: function (data) {
                                                    return data ? data : '-'; // Safely check for null/undefined
                                                }
                                            },
                                            {
                                                data: 'kondisi',
                                                name: 'kondisi',
                                                render: function (data) {
                                                    return kondisiMapping[data] || '-';
                                                }
                                            }
                                        ]
                                    });
                                }
                            }
                        },
                        series: seriesData,
                        labels: labelsData,
                        colors: colorsData, // Use fixed colors based on kondisi
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '60%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            fontSize: '12px',
                                            color: '#000'
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '10px',
                                fontWeight: 'bold',
                                colors: ['#fff']
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 2,
                                opacity: 0.5
                            }
                        },
                        tooltip: {
                            enabled: true, // Enable tooltips
                            theme: "light", // Use dark theme (white font by default)
                            style: {
                                fontSize: '12px', // Adjust font size
                                color: '#fff', // Force white font color
                            },
                            y: {
                                formatter: function(value) {
                                    return value + " Assets";
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            color: '#000',
                            fontSize: '12px',
                            markers: { radius: 12 }
                        }
                    };
                
                    let chart = new ApexCharts(targetElement, options);
                    chart.render();
                });
            }else{
                getCallbackNoSwal('getSatgasPie', { type: satgasType }, function(response) {
                    const kondisiMapping = {
                        1: 'BAIK',
                        2: 'RR OPS',
                        3: 'RB',
                        4: 'RR TDK OPS',
                        5: 'M',
                        6: 'D'
                    };
                
                    // Fixed color mapping for each kondisi
                    const kondisiColors = {
                        'BAIK': "var(--bs-success)",       // Green
                        'RR OPS': "var(--bs-info)",     // Blue
                        'RB': "var(--bs-danger)",         // Red
                        'RR TDK OPS': "var(--bs-primary)", // Purple
                        'M': '#697565',          // Grey
                        'D': '#3C3D37'           // Dark Grey
                    };
                
                    let seriesData = response.data.map(item => Number(item.total));
                    let labelsData = response.data.map(item => kondisiMapping[item.kondisi] || "No Data");
                
                    // Assign colors based on kondisi mapping
                    let colorsData = labelsData.map(label => kondisiColors[label] || '#CCCCCC'); // Default color if not found
                
                    let targetElement = document.querySelector(`#pieSatgas${index}`);
                    if (!targetElement) {
                        console.error(`Element #pieSatgas${index} not found!`);
                        return;
                    }
                
                    let options = {
                        chart: {
                            type: 'donut',
                            height: 280,
                            toolbar: { show: false },
                            dropShadow: {
                                enabled: false,
                                top: 5,
                                left: 0,
                                blur: 5,
                                opacity: 0.2
                            },
                          
                        },
                        series: seriesData,
                        labels: labelsData,
                        colors: colorsData, // Use fixed colors based on kondisi
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '60%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            fontSize: '12px',
                                            color: '#000'
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '10px',
                                fontWeight: 'bold',
                                colors: ['#fff']
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 2,
                                opacity: 0.5
                            }
                        },
                        tooltip: {
                            enabled: true, // Enable tooltips
                            theme: "light", // Use dark theme (white font by default)
                            style: {
                                fontSize: '12px', // Adjust font size
                                color: '#fff', // Force white font color
                            },
                            y: {
                                formatter: function(value) {
                                    return value + " Assets";
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            color: '#000',
                            fontSize: '12px',
                            markers: { radius: 12 }
                        }
                    };
                
                    let chart = new ApexCharts(targetElement, options);
                    chart.render();
                });
            }
           
            
        }

        // Horizontal Bar
            getHorizontalBar(response)
            verticalBarChart(response)
        // Horizontal Bar
        
// Calculate total and percentages

    // Initialize the map
    const map = L.map('asset_map_track').setView([1.5074, 10.1278], 3);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // window.addEventListener("resize", function () {
    //     setTimeout(() => {
    //       if (map) {
    //         map.invalidateSize(); // Leaflet
    //         google.maps.event.trigger(map, "resize"); // Google Maps
    //       }
    //     }, 300);
    //   });
    // Add markers to the map
    const bounds = [];
    response.country.forEach(country => {
        const bounds = [];
        response.country.forEach(country => {
          const { x: lat, y: lng, type, total } = country;
          if (lat && lng) {
            const marker = L.marker([lat, lng]).addTo(map)
              .bindPopup(`
                     <b style="text-transform:uppercase; color :#344CB7">${country.country}</b>
                    <br>${type}
                    <br> <i class="fa-solid fa-box"></i> Total Asset: ${total}
                    <br> <i class="fa-solid fa-user"></i> Total Personil: -
                
                `);
            marker.openPopup(); // Open the popup immediately
            bounds.push([lat, lng]);
          }
        });
    });

});

$('#pengajuan_asset_table').DataTable().clear().destroy();
$('#pengajuan_asset_table').DataTable({
    scrollY:200,
    processing: true,
    serverSide: true,
    lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
    ajax: {
        url: `getPengajuanAsset`,
        type: 'GET',
    },
    columns: [
        { data: 'satgas', name: 'satgas' },
        { data: 'no_un', name: 'no_un' },
        { data: 'category', name: 'category' },
        { data: 'sub_category', name: 'sub_category' },
        // { data: 'type', name: 'type' },
        // { data: 'brand', name: 'brand' },
        { data: 'no_mesin', name: 'no_mesin' },
        { data: 'no_rangka', name: 'no_rangka' },
        {
            data: 'status_pengajuan',
            name: 'status_pengajuan',
            render: function(data, type, row) {
                switch (data) {
                    case 1:
                        return 'Draft';
                    case 2:
                        return 'Partially Approve';
                    case 3:
                        return 'On Progress';
                    case 4:
                        return 'Done';
                    default:
                        return 'Unknown'; // Handle unexpected values
                }
            }
        },
    ]
});

$('.pengajuan_filter').on('click', function(){
    var pengajuan = $(this).data('pengajuan')
    var data = {
        'pengajuan' : pengajuan
    }
  
    $('#pengajuan_asset_table').DataTable().clear().destroy();
    $('#pengajuan_asset_table').DataTable({
        scrollY:200,
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getPengajuanAssetFilter`,
            type: 'GET',
            data : data
        },
        columns: [
            { data: 'satgas', name: 'satgas' },
            { data: 'no_un', name: 'no_un' },
            { data: 'category', name: 'category' },
            { data: 'sub_category', name: 'sub_category' },
            // { data: 'type', name: 'type' },
            // { data: 'brand', name: 'brand' },
            { data: 'no_mesin', name: 'no_mesin' },
            { data: 'no_rangka', name: 'no_rangka' },
            {
                data: 'status_pengajuan',
                name: 'status_pengajuan',
                render: function(data, type, row) {
                    switch (data) {
                        case 1:
                            return 'Draft';
                        case 2:
                            return 'Partially Approve';
                        case 3:
                            return 'On Progress';
                        case 4:
                            return 'Done';
                        default:
                            return 'Unknown'; // Handle unexpected values
                    }
                }
            },
        ]
    });
})

function getRadialBar(response) {
    if (!response || !response.data || !Array.isArray(response.data)) {
        console.error("Invalid response data:", response);
        return;
    }
    let sumOfArray = 0;
    let kondisi = [];
    for (let i = 0; i < response.data.length; i++) {
        sumOfArray += parseInt(response.data[i].total, 10);
        let labelKondisi = '';

        switch (parseInt(response.data[i].kondisi)) {
            case 1:
                labelKondisi = 'BAIK';
                break;
            case 2:
                labelKondisi = 'RR OPS';
                break;
            case 3:
                labelKondisi = 'RB';
                break;
            case 4:
                labelKondisi = 'RR TDK OPS';
                break;
            case 5:
                labelKondisi = 'M';
                break;
            case 6:
                labelKondisi = 'D';
                break;
            default:
                labelKondisi = 'Unknown';
        }

        kondisi.push(labelKondisi);
    }
    const percentageData = response.data.map(item => ((item.total / sumOfArray) * 100).toFixed(2));

    if(userHasPermission){
        var radialBarOption = {
            series: percentageData,
            chart: {
                type: "radialBar",
                height: 600,
                fontFamily: "inherit",
                foreColor: "#c6d1e9",
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        let selectedIndex = config.dataPointIndex;
                        let selectedKondisi = kondisi[selectedIndex]; // Ambil kondisi berdasarkan index
                        let selectedValue = response.data[selectedIndex]?.total || 0; // Ambil total dari data
                        // Tampilkan modal dengan kondisi yang dipilih
                        $('#detailAssetModal').modal('show');
                        $('#modal_title').html(selectedKondisi + " : " + selectedValue);
                        $('#asset_table').DataTable().clear().destroy();
                        var kondisiMapping = {
                            1: 'BAIK',
                            2: 'RR OPS',
                            3: 'RB',
                            4: 'RR TDK OPS',
                            5: 'M',
                            6: 'D'
                        };
                        $('#asset_table').DataTable({
                            processing: true,
                            serverSide: true,
                            lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
                            ajax: {
                                url: `getAssetFilter`,
                                type: 'GET',
                                data: { kondisi: selectedKondisi }
                            },
                            columns: [
                                { 
                                    data: 'satgas_relation', 
                                    name: 'satgas_relation.name', 
                                    render: function (data) {
                                        return data?.name || '-';
                                    }
                                },
                                { 
                                    data: 'no_un', 
                                    name: 'no_un', 
                                    render: function (data) {
                                        return data || '-';
                                    }
                                },
                                { 
                                    data: 'category_relation', 
                                    name: 'category_relation.name', 
                                    render: function (data) {
                                        return data?.name || '-';
                                    }
                                },
                                { 
                                    data: 'sub_category_relation',
                                    name: 'sub_category_relation.name', 
                                    render: function (data) {
                                        return data?.name || '-';
                                    }
                                },
                                { 
                                    data: 'type_relation', 
                                    name: 'type_relation.name', 
                                    render: function (data) {
                                        return data?.name || '-';
                                    }
                                },
                                { 
                                    data: 'merk_relation', 
                                    name: 'merk_relation.name', 
                                    render: function (data) {
                                        return data?.name || '-';
                                    }
                                },
                                { 
                                    data: 'no_mesin', 
                                    name: 'no_mesin', 
                                    render: function (data) {
                                        return data || '-';
                                    }
                                },
                                { 
                                    data: 'no_rangka', 
                                    name: 'no_rangka',
                                    render: function (data) {
                                        return data || '-';
                                    }
                                },
                                {
                                    data: 'kondisi',
                                    name: 'kondisi',
                                    render: function (data) {
                                        return kondisiMapping[data] || '-';
                                    }
                                }
                            ]
                        });
                    }
                }
            },
            labels: kondisi,
            plotOptions: {
                radialBar: {
                    inverseOrder: false,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 1,
                        size: "20%",
                    },
                    track: {
                        background: '#e7e7e7',
                        strokeWidth: '100%',
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: "16px",
                            color: "#333",
                            offsetY: -10,
                        },
                        value: {
                            show: true,
                            fontSize: "12px",
                            color: "#111",
                            offsetY: 5,
                            formatter: function (val) {
                                return `${val}%`;
                            },
                        },
                        total: {
                            show: true,
                            label: "Total",
                            color: "#000",
                            style: {
                                fontSize: "18px",
                                fontWeight: "bold",
                            },
                            formatter: function () {
                                return sumOfArray;
                            },
                        },
                    },
                },
            },
            stroke: { width: 10, lineCap: "round" },
            colors: ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-danger)", "var(--bs-success)"],
            tooltip: {
                enabled: true,
                theme: "light",
                y: {
                    formatter: function (val, opts) {
                        const count = response.data[opts.seriesIndex]?.total || 0;
                        return `Total: ${count}`;
                    },
                },
            },
            legend: {
                show: true,
                position: "left",
                floating: true,
                offsetX: 0,
                offsetY: 10,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 5,
                },
                labels: {
                    colors: "#333",
                    style: { 
                        fontSize: "10px",
                        fontWeight: "bold",
                    },
                    useSeriesColors: false,
                },
                itemMargin: {
                    horizontal: 5,
                    vertical: 5,
                },
            }
        };
    }else{
        var radialBarOption = {
            series: percentageData,
            chart: {
                type: "radialBar",
                height: 600,
                fontFamily: "inherit",
                foreColor: "#c6d1e9",
            },
            labels: kondisi,
            plotOptions: {
                radialBar: {
                    inverseOrder: false,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 1,
                        size: "20%",
                    },
                    track: {
                        background: '#e7e7e7',
                        strokeWidth: '100%',
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: "16px",
                            color: "#333",
                            offsetY: -10,
                        },
                        value: {
                            show: true,
                            fontSize: "12px",
                            color: "#111",
                            offsetY: 5,
                            formatter: function (val) {
                                return `${val}%`;
                            },
                        },
                        total: {
                            show: true,
                            label: "Total",
                            color: "#000",
                            style: {
                                fontSize: "18px",
                                fontWeight: "bold",
                            },
                            formatter: function () {
                                return sumOfArray;
                            },
                        },
                    },
                },
            },
            stroke: { width: 10, lineCap: "round" },
            colors: ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-danger)", "var(--bs-success)"],
            tooltip: {
                enabled: true,
                theme: "light",
                y: {
                    formatter: function (val, opts) {
                        const count = response.data[opts.seriesIndex]?.total || 0;
                        return `Total: ${count}`;
                    },
                },
            },
            legend: {
                show: true,
                position: "left",
                floating: true,
                offsetX: 0,
                offsetY: 10,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 5,
                },
                labels: {
                    colors: "#333",
                    style: { 
                        fontSize: "10px",
                        fontWeight: "bold",
                    },
                    useSeriesColors: false,
                },
                itemMargin: {
                    horizontal: 5,
                    vertical: 5,
                },
            }
        };
    }
  
    const chart = new ApexCharts(document.querySelector("#radialChart"), radialBarOption);
    chart.render();
}

function adjustZoomForScreens() {
    const screenWidth = window.screen.width;
    // Check for screen width matching 13", 14", or 15" devices
    if(screenWidth == 1512){
        document.body.style.zoom = "70%"; // Apply 80% zoom for 13", 14", or 15" screens
    }
    else if (screenWidth >= 1240 && screenWidth <= 1600) {
        document.body.style.zoom = "85%"; // Apply 80% zoom for 13", 14", or 15" screens
        console.log('your pc width is : ' + screenWidth)
    } else {
        document.body.style.zoom = "100%"; // Default zoom for other screen sizes
    }
}

// Call this function on page load
window.onload = function() {
    adjustZoomForScreens();
};