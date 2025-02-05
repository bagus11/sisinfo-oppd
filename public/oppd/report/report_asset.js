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
                document.getElementById("chartImage").src = imgURI;
                document.getElementById("chartImageInput").value = imgURI;
            });
        });
        chart.render();
        
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

