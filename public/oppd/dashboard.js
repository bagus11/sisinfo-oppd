
getCallbackNoSwal('getCountingAsset', null, function (response) {
    $('#select_asset_type').empty();
    $('#select_asset_type').append('<option value="">OPPD</option>');
    response.group.forEach(group => {
        $('#select_asset_type').append(`<option value="${group.type}">${group.type}</option>`);
    });
    var containerSatgas = ''
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

    // Fungsi untuk membuat regex pencarian
    function getUmurAssetRegex(value) {
        let currentYear = new Date().getFullYear();
        if (value == 1) return `^(${currentYear - 4}|${currentYear - 3}|${currentYear - 2}|${currentYear - 1}|${currentYear})$`; // < 5 Tahun
        if (value == 2) return `^(${currentYear - 9}|${currentYear - 8}|${currentYear - 7}|${currentYear - 6}|${currentYear - 5})$`; // 5 - 10 Tahun
        if (value == 3) return `^([0-9]{1,3})$`; // > 10 Tahun
        return ''; // Jika tidak ada filter
    }
    getRadialBar(response)
    assetChart(response.countingAssetYear)
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
    const kondisiMapping = {
        1: 'BAIK',
        2: 'RR OPS',
        3: 'RB',
        4: 'RR TDK OPS',
        5: 'M',
        6: 'D'
    };

    const kondisiColors = {
        'BAIK': "#CFF7FF",
        'RR OPS': "#D8FCD2",
        'RB': "#FF6A00",
        'RR TDK OPS': "#FFD66B",
        'M': '#FF9898',
        'D': '#333446'
    };

    getCallbackNoSwal('getSatgasPie', { type: satgasType }, function (response) {
        let seriesData = response.data.map(item => Number(item.total));
        let labelsData = response.data.map(item => kondisiMapping[item.kondisi] || "No Data");
        let colorsData = labelsData.map(label => kondisiColors[label] || '#CCCCCC');
        let targetElement = document.querySelector(`#pieSatgas${index}`);

        if (!targetElement) {
            console.error(`Element #pieSatgas${index} not found!`);
            return;
        }

        const donutBgId = `donutCenterBg${index}`;
        const overlayId = `donutCenterOverlay${index}`;
        const donutLabelId = `donutCenterLabel${index}`;
        const donutTotalId = `donutCenterTotal${index}`;

        const totalValue = seriesData.reduce((sum, val) => sum + val, 0);

        let options = {
            chart: {
                type: 'donut',
                height: 280,
                toolbar: { show: false },
                events: userHasPermission ? {
                    dataPointSelection: function (event, chartContext, config) {
                        const selectedColor = colorsData[config.dataPointIndex];
                        const donutBg = document.getElementById(donutBgId);
                        if (donutBg) donutBg.style.backgroundColor = selectedColor;

                        const selectedKondisi = labelsData[config.dataPointIndex];
                        showAssetModal(satgasType, selectedKondisi);
                    }
                } : {}
            },
            series: seriesData,
            labels: labelsData,
            colors: colorsData,
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%',
                        labels: {
                            show: true,
                            total: { show: false }
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
                }
            },
            tooltip: {
                enabled: true,
                theme: "light",
                y: {
                    formatter: value => value + " Assets"
                }
            },
            legend: {
                position: 'top',
                fontSize: '8px',
                markers: { radius: 8 }
            }
        };

        let chart = new ApexCharts(targetElement, options);
        chart.render().then(() => {
            const container = targetElement.parentNode;
            container.style.position = "relative";

            // Background warna tengah (berubah saat klik)
            const donutBg = document.createElement("div");
            donutBg.id = donutBgId;
            Object.assign(donutBg.style, {
                position: "absolute",
                top: "50%",
                left: "50%",
                transform: "translate(-50%, -50%)",
                width: "125px",
                height: "125px",
                borderRadius: "50%",
                backgroundColor: "#B2C3D0",
                zIndex: 1,
                transition: "background-color 0.3s"
            });

            // Label "TOTAL"
            const donutLabel = document.createElement("div");
            donutLabel.id = donutLabelId;
            Object.assign(donutLabel.style, {
                position: "absolute",
                top: "45%",
                left: "50%",
                transform: "translate(-50%, -50%)",
                fontWeight: "bold",
                fontSize: "12px",
                color: "black",
                zIndex: 5,
                pointerEvents: "none"
            });
            donutLabel.innerText = "TOTAL";

            // Angka total
            const donutTotal = document.createElement("div");
            donutTotal.id = donutTotalId;
            Object.assign(donutTotal.style, {
                position: "absolute",
                top: "58%",
                left: "50%",
                transform: "translate(-50%, -50%)",
                fontWeight: "bold",
                fontSize: "18px",
                color: "black",
                zIndex: 5,
                pointerEvents: "none"
            });
            donutTotal.innerText = totalValue.toLocaleString();

            container.appendChild(donutBg);
            container.appendChild(donutLabel);
            container.appendChild(donutTotal);

            // Overlay klik tengah (untuk reset warna + buka ALL kondisi)
            if (userHasPermission) {
                const overlay = document.createElement("div");
                overlay.id = overlayId;
                Object.assign(overlay.style, {
                    position: "absolute",
                    top: "50%",
                    left: "50%",
                    transform: "translate(-50%, -50%)",
                    width: "100px",
                    height: "100px",
                    borderRadius: "50%",
                    cursor: "pointer",
                    zIndex: 10,
                    backgroundColor: "transparent"
                });

                overlay.addEventListener("click", function () {
                    const donutBg = document.getElementById(donutBgId);
                    if (donutBg) donutBg.style.backgroundColor = "#D9D9D9";
                    showAssetModal(satgasType, '');
                });

                container.appendChild(overlay);
            }
        });
    });

    function showAssetModal(satgasType, selectedKondisi) {
        $('#detailAssetModal').modal('show');
        $('#satgasTypeFilter').val(satgasType);
        $('#selectedKondisi').val(selectedKondisi);
        $('#select_th_pembuatan').val('');
        $('#select_th_operasi').val('');
        $('#select_th_pembuatan').select2().trigger('change');
        $('#select_th_operasi').select2().trigger('change');

        const kondisiLabel = selectedKondisi || "ALL KONDISI";
        $('#modal_title').html(`${satgasType} : ${kondisiLabel}`);

        $('#asset_table').DataTable().clear().destroy();
        $('#asset_table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
            ajax: {
                url: `getAssetFilter`,
                type: 'GET',
                data: {
                    'type': satgasType,
                    'kondisi': selectedKondisi,
                    'th_operasi': $('#select_th_operasi').val(),
                    'th_pembuatan': $('#select_th_pembuatan').val()
                }
            },
            columns: [
                { data: 'asset_code' },
                { data: 'satgas_type', render: d => d || '-' },
                { data: 'satgas_name', render: d => d || '-' },
                { data: 'no_un', render: d => d || '-' },
                { data: 'category_name', render: d => d || '-' },
                { data: 'subcategory_name', render: d => d || '-' },
                { data: 'type_name', render: d => d || '-' },
                { data: 'merk_name', render: d => d || '-' },
                { data: 'no_mesin', render: d => d || '-' },
                { data: 'no_rangka', render: d => d || '-' },
                { data: 'th_pembuatan', render: d => d || '-' },
                { data: 'th_operasi', render: d => d || '-' },
                {
                    data: 'kondisi',
                    render: d => kondisiMapping[d] || '-'
                },
                { data: 'latest_remark', render: d => d || '-' },
                { data: 'latest_update', render: d => d || '-' }
            ],
            drawCallback: function (settings) {
                $('#totalItemAsset').text(settings.json.recordsFiltered);
            }
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
    scrollY: 200,
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
            render: function (data, type, row) {
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

$('.pengajuan_filter').on('click', function () {
    var pengajuan = $(this).data('pengajuan')
    var data = {
        'pengajuan': pengajuan
    }

    $('#pengajuan_asset_table').DataTable().clear().destroy();
    $('#pengajuan_asset_table').DataTable({
        scrollY: 200,
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getPengajuanAssetFilter`,
            type: 'GET',
            data: data
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
                render: function (data, type, row) {
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
    let colors = [];

    const colorMapping = {
        1: '#CFF7FF',   // BAIK
        2: '#D8FCD2',   // RR OPS
        3: '#FF6A00',   // RB
        4: '#FFD66B',   // RR TDK OPS
        5: '#FF9898',   // M
        6: '#333446'    // D
    };

    const kondisiMapping = {
        1: 'BAIK',
        2: 'RR OPS',
        3: 'RB',
        4: 'RR TDK OPS',
        5: 'M',
        6: 'D'
    };

    for (let i = 0; i < response.data.length; i++) {
        let kondisiVal = parseInt(response.data[i].kondisi, 10);
        let labelKondisi = kondisiMapping[kondisiVal] || 'Unknown';

        sumOfArray += parseInt(response.data[i].total, 10);
        kondisi.push(labelKondisi);
        colors.push(colorMapping[kondisiVal] || '#999999'); // fallback warna default jika kondisi tidak dikenali
    }
    const percentageData = response.data.map(item => parseFloat(((item.total / sumOfArray) * 100).toFixed(2)));
    // const percentageData = response.data.map(item => ((item.total / sumOfArray) * 100).toFixed(2));

    const chartConfig = {
        series: percentageData,
        chart: {
            type: "radialBar",
            height: 600,
            width: '100%',
            fontFamily: "inherit",
            foreColor: "#c6d1e9",
            ...(userHasPermission && {
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        let selectedIndex = config.dataPointIndex;
                        let selectedKondisi = kondisi[selectedIndex];
                        let selectedValue = response.data[selectedIndex]?.total || 0;

                        $('#detailAssetModal').modal('show');
                        $('#modal_title').html(selectedKondisi + " : " + selectedValue);
                        $('#selectedKondisi').val(selectedKondisi);
                        $('#select_th_operasi').val('');
                        $('#select_th_pembuatan').val('');
                        $('#select_th_operasi').select2().trigger('change');
                        $('#select_th_pembuatan').select2().trigger('change');
                        $('#satgasTypeFilter').val('');
                        $('#asset_table').DataTable().clear().destroy();

                        $('#asset_table').DataTable({
                            processing: true,
                            serverSide: true,
                            lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
                            ajax: {
                                url: `getAssetFilter`,
                                type: 'GET',
                                data: {
                                    'type': $('#satgasTypeFilter').val(),
                                    'kondisi': $('#selectedKondisi').val(),
                                    'th_operasi': $('#select_th_operasi').val(),
                                    'th_pembuatan': $('#select_th_pembuatan').val()
                                }
                            },
                            columns: [
                                { data:'asset_code', name:'asset_code' },
                                { data: 'satgas_type', name: 'master_satgas.type', render: d => d || '-' },
                                { data: 'satgas_name', name: 'master_satgas.name', render: d => d || '-' },
                                { data: 'no_un', name: 'assets.no_un', render: d => d || '-' },
                                { data: 'category_name', name: 'inventory_categories.name', render: d => d || '-' },
                                { data: 'subcategory_name', name: 'inventory_sub_categories.name', render: d => d || '-' },
                                { data: 'type_name', name: 'inventory_types.name', render: d => d || '-' },
                                { data: 'merk_name', name: 'inventory_brands.name', render: d => d || '-' },
                                { data: 'no_mesin', name: 'assets.no_mesin', render: d => d || '-' },
                                { data: 'no_rangka', name: 'assets.no_rangka', render: d => d || '-' },
                                { data: 'th_pembuatan', name: 'assets.th_pembuatan', render: d => d || '-' },
                                { data: 'th_operasi', name: 'assets.th_operasi', render: d => d || '-' },
                                { data: 'kondisi', name: 'assets.kondisi', render: d => kondisiMapping[d] || '-' },
                                { data: 'latest_remark', name: 'latest_remark', orderable: false, searchable: false, render: d => d || '-' },
                                { data: 'latest_update', name: 'latest_update', orderable: false, searchable: false, render: d => d || '-' },
                            ],
                            drawCallback: function (settings) {
                                $('#totalItemAsset').text(settings.json.recordsFiltered);
                            }
                        });
                    }
                }
            })
        },
        labels: kondisi,
        colors: colors,
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
                        formatter: val => `${val}%`,
                    },
                    total: {
                        show: true,
                        label: "Total",
                        color: "#000",
                        style: {
                            fontSize: "18px",
                            fontWeight: "bold",
                        },
                        formatter: () => sumOfArray,
                    },
                },
            },
        },
        stroke: { width: 10, lineCap: "round" },
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
            offsetX: -30,
            offsetY: -10,
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
    const chart = new ApexCharts(document.querySelector("#radialChart"), chartConfig);
    chart.render();
}


function adjustZoomForScreens() {
    const screenWidth = window.screen.width;
    // Check for screen width matching 13", 14", or 15" devices
    if (screenWidth == 1512 || screenWidth === 1366) {

        document.body.style.zoom = "70%"; // Apply 80% zoom for 13", 14", or 15" screens
    }
    else if (screenWidth >= 1240 && screenWidth <= 1367) {
        document.body.style.zoom = "85%"; // Apply 80% zoom for 13", 14", or 15" screens
        console.log('your pc width is : ' + screenWidth)
    } else {
        document.body.style.zoom = "100%"; // Default zoom for other screen sizes
    }
}

// Call this function on page load
window.onload = function () {
    // adjustZoomForScreens();
};

function assetChart(response) {
    var options = {
        series: [
            {
                name: "< 5 Tahun",
                data: [
                    response.pembuatan_kurang_5,
                    response.operasi_kurang_5
                ]
            },
            {
                name: "5 - 10 Tahun",
                data: [
                    response.pembuatan_5_10,
                    response.operasi_5_10
                ]
            },
            {
                name: "> 10 Tahun",
                data: [
                    response.pembuatan_lebih_10,
                    response.operasi_lebih_10
                ]
            }
        ],
        chart: {
            type: "bar",
            height: 200,
            width: '100%',
            stacked: true
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        xaxis: {
            categories: ["Th Pembuatan", "Th Operasi"]
        },
        yaxis: {
            // title: {
            //     text: "Jumlah Aset"
            // }
        },
        colors: ["#008FFB", "#00E396", "#FF4560"]
    };

    var chart = new ApexCharts(document.querySelector("#asset_bar_chart"), options);
    chart.render();
}
$('#btn_filter_asset').on('click', function () {
    const kondisiMapping = {
        1: 'BAIK',
        2: 'RR OPS',
        3: 'RB',
        4: 'RR TDK OPS',
        5: 'M',
        6: 'D'
    };
    let thOperasi = $('#select_th_operasi').val();
    let thPembuatan = $('#select_th_pembuatan').val();
    $('#asset_table').DataTable().clear().destroy();

    let table = $('#asset_table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "All"]],
        ajax: {
            url: `getAssetFilter`,
            type: 'GET',
            data: {
                'type': $('#satgasTypeFilter').val(),
                'kondisi': $('#selectedKondisi').val(),
                'th_operasi': thOperasi,
                'th_pembuatan': thPembuatan
            }
        },
        columns: [
            {
                data:'asset_code',
                name:'asset_code'
            },
            {
                data: 'satgas_type',
                name: 'master_satgas.type',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'satgas_name',
                name: 'master_satgas.name',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'no_un',
                name: 'assets.no_un',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'category_name',
                name: 'inventory_categories.name',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'subcategory_name',
                name: 'inventory_sub_categories.name',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'type_name',
                name: 'inventory_types.name',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'merk_name',
                name: 'inventory_brands.name',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'no_mesin',
                name: 'assets.no_mesin',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'no_rangka',
                name: 'assets.no_rangka',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'th_pembuatan',
                name: 'assets.th_pembuatan',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'th_operasi',
                name: 'assets.th_operasi',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'kondisi',
                name: 'assets.kondisi',
                render: function (data) {
                    return kondisiMapping[data] || '-';
                }
            },
            {
                data: 'latest_remark',
                name: 'latest_remark',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'latest_update',
                name: 'latest_update',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return data || '-';
                }
            }
        ],        
        "drawCallback": function (settings) {
            // This function will be called after each draw (after the data is refreshed)
            let totalItems = settings.json.recordsFiltered;
            $('#totalItemAsset').text(totalItems);
        }
    });
});

$('#btn_export_asset').on('click', function () {

    var type = $('#satgasTypeFilter').val()
    var kondisi = $('#selectedKondisi').val()
    var th_operasi = $('#select_th_operasi').val()
    var th_pembuatan = $('#select_th_pembuatan').val()

    Swal.fire({
        title: 'Export Data',
        text: 'Pilih format export yang kamu mau:',
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'PDF',
        denyButtonText: 'Excel',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.open(`printAssetDashboard/${type ? type : '*'}/${kondisi ? kondisi : '*'}/${th_operasi ? th_operasi : '*'}/${th_pembuatan ? th_pembuatan : '*'}/pdf`, '_blank');

        } else if (result.isDenied) {
            window.open(`printAssetDashboard/${type ? type : '*'}/${kondisi ? kondisi : '*'}/${th_operasi ? th_operasi : '*'}/${th_pembuatan ? th_pembuatan : '*'}/excel`, '_blank');
        }
    });
});