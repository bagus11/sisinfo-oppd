$(document).ready(function() {
    $.ajax({
        url: "/assets-pivot", // Adjust to match your route
        type: "GET",
        success: function(response) {
            let columns = [
                { data: "category", title: "Category" } // First column
            ];

            // Dynamically add category columns
            response.columns.forEach(category => {
                console.log(category)
                columns.push({ data: category, title: category });
            });

            // Generate table headers dynamically
            $('#dynamic-header').html(columns.map(col => `<th>${col.title}</th>`).join(""));

            // Initialize DataTables
            $('#assetsTable').DataTable({
                processing: true,
                serverSide: false, // Client-side processing
                data: response.data,
                columns: columns
            });
            horizontalBarChart(response,'assetsChart')
        }
    });

    function horizontalBarChart(response,chart_id){
        var categories = response.data.map(item => item.category); // Extract categories
        var seriesData = response.columns.map(satgas => ({
            name: satgas,
            data: response.data.map(item => item[satgas] || 0) // Fill empty values with 0
        }));

        var options = {
            chart: {
                type: 'bar',
                height: '200%', // Biarkan tinggi otomatis
                width: '150%',  // Biarkan lebar otomatis
                toolbar: { show: false } // Hilangkan toolbar di mobile
            },
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 400 // Tambah tinggi di mobile
                        },
                        legend: { position: 'bottom' }
                    }
                }
            ],
            series: seriesData,
            xaxis: {
                categories: categories,
                title: { text: 'Jumlah Asset' }
            },
            yaxis: {
                title: { text: 'Kategori Asset' }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: { position: 'right' }
                }
            }, dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val; // Menampilkan nilai
                },
                textAnchor: 'start', // Memastikan teks sejajar ke kiri
                offsetX: 10, // Geser ke kanan
                style: {
                    colors: ['#000'],
                    fontSize: '10px'
                }
            },
            legend: {
                position: 'bottom'
            }
        };
        
        
        var chart = new ApexCharts(document.querySelector(`#${chart_id}`), options);
        chart.render().then(() => {
            chart.dataURI().then(({ imgURI }) => {
                // document.getElementById("chartImage").src = imgURI;
                document.getElementById("chartImageInput").value = imgURI;
            });
        });
        
    }

    $('#btn_print_pdf').on('click', function () {
        // Ambil elemen chart
        let chart = document.querySelector("#assetsChart svg");
    
        if (chart) {
            // Konversi SVG ke Canvas untuk mendapatkan gambar
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");
            let svgData = new XMLSerializer().serializeToString(chart);
            let img = new Image();
    
            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                let chartBase64 = canvas.toDataURL("image/png"); // Konversi ke Base64
    
                // Kirim ke server menggunakan AJAX
                $.ajax({
                    url: "/exportAssetCategoryPDF",
                    type: "post",
                    data: { chart: chartBase64 },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: { responseType: 'blob' },
                    success: function (data) {
                        let blob = new Blob([data], { type: "application/pdf" });
                        let link = document.createElement("a");
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "Report.pdf";
                        link.click();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                    }
                });
            };
    
            img.src = "data:image/svg+xml;base64," + btoa(svgData);
        } else {
            alert("Chart tidak ditemukan!");
        }
    });
    
    
    $('#btn_export_excel').on('click', function(){
        SwalLoading('Please wait ...');
        let url = '/exportAssetCategory?';
        window.location.href = url;
        swal.close()
    })
});
var kondisiMapping = {
    1: 'BAIK',
    2: 'RR OPS',
    3: 'RB',
    4: 'RR TDK OPS',
    5: 'M',
    6: 'D'
};
$('#tab_2').on('click', function() {
    $('#assetsChartKondisi').empty()
   
    getCallback('getAssetKondisi', null, function(response) {
        // Tutup swal loading
        swal.close();
        if (response && response.chart) {
          kondisiChart(response)

                    // Inisialisasi array kolom
            let columns = [
                { data: 'category', title: 'Category' } // Kolom pertama, kategori
            ];

            // Loop untuk menambahkan kolom lainnya dari response.columns
            response.columns.forEach(column => {
                columns.push({ data: column, title: column });  // Menambahkan kolom baru
            });

            // Generate table headers secara dinamis
            $('#dynamic-header_kondisi').html(columns.map(col => `<th>${col.title}</th>`).join(''));

            // Initialize DataTables
            $('#assetsTableKondisi').DataTable().clear().destroy();
            $('#assetsTableKondisi').DataTable({
                processing: true,
                serverSide: false, // Client-side processing
                data: response.data,
                columns: columns
            });

        }
        
    });
});

function kondisiChart(response){
    var satgas = [];
    var kondisiData = {};
    // Organisir data berdasarkan satgas dan kondisi
    response.chart.forEach(function(item) {
        var kondisiLabel = kondisiMapping[item.kondisi] || 'Unknown';  // Default 'Unknown' jika tidak ada mapping

        if (!kondisiData[kondisiLabel]) {
            kondisiData[kondisiLabel] = {};
        }
        kondisiData[kondisiLabel][item.satgas] = item.total;
        if (!satgas.includes(item.satgas)) {
            satgas.push(item.satgas);  // Menyimpan satgas yang unik
        }
    });

    // Setup data untuk chart
    var kondisi = Object.keys(kondisiData);  // Ambil kondisi sebagai kategori sumbu X
    var seriesData = satgas.map(function(satgasName) {
        // Untuk setiap satgas, ambil total berdasarkan kondisi
        return {
            name: satgasName,
            data: kondisi.map(function(kondisiName) {
                return kondisiData[kondisiName][satgasName] || 0; // Jika data tidak ada, set 0
            })
        };
    });

    // Setup ApexCharts
    var options = {
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%'
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: kondisi,  // Data kondisi (yang sudah di-mapping) untuk sumbu X
        },
        series: seriesData,  // Data series berdasarkan satgas
    };
    // Render chart
    var chart = new ApexCharts(document.querySelector("#assetsChartKondisi"), options);
    chart.render().then(() => {
        chart.dataURI().then(({ imgURI }) => {
            // document.getElementById("chartImageKondisi").src = imgURI;
            document.getElementById("chartImageInputKondisi").value = imgURI;
        });
    });
}

$('#btn_print_kondisi_pdf').on('click', function () {
    // Ambil elemen chart
    let chart = document.querySelector("#assetsChartKondisi svg");

    if (chart) {
        // Konversi SVG ke Canvas untuk mendapatkan gambar
        let canvas = document.createElement("canvas");
        let ctx = canvas.getContext("2d");
        let svgData = new XMLSerializer().serializeToString(chart);
        let img = new Image();

        img.onload = function () {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            let chartBase64 = canvas.toDataURL("image/png"); // Konversi ke Base64

            // Kirim ke server menggunakan AJAX
            $.ajax({
                url: "/exportAssetKondisiPDF",
                type: "post",
                data: { chart: chartBase64 },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                xhrFields: { responseType: 'blob' },
                success: function (data) {
                    let blob = new Blob([data], { type: "application/pdf" });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Report.pdf";
                    link.click();
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                }
            });
        };

        img.src = "data:image/svg+xml;base64," + btoa(svgData);
    } else {
        alert("Chart tidak ditemukan!");
    }
});

$('#btn_export_kondisi_excel').on('click', function(){
    SwalLoading('Please wait ...');
    let url = '/exportAssetKondisi?';
    window.location.href = url;
    swal.close()
})