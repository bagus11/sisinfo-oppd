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
                    height: 400,
                    width: '120%', // Lebarkan sedikit agar bisa di-scroll
                    toolbar: { show: false }
                },
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
                        barHeight: '80%', // Biarkan lebih lebar agar mudah dibaca
                        dataLabels: { position: 'right' }
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
