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
            
            
            var chart = new ApexCharts(document.querySelector("#assetsChart"), options);
            chart.render();
            
        }
    });
});
