       function saveHelper(url,data,route){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "post",
            dataType: 'json',
            async: true,
            data: data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('.message_error').html('')
                toastr['success'](response.meta.message);
                window.location = route;
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact Developer');
                }
            }
        });
    }
    function saveRepo(url,data,route){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        window.location = route;
                    }
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
    function onChange(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function onChangeSelect(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function getActiveItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                success: function(response) {
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Pilih '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    function resetSelect2(id) {
        $('#'+id).val('').trigger('change');  // Clear value and trigger change
    }
    function getActiveItemTransaction(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-max ="'+ data.max_transaction +'" data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    function getProductItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-uom="'+data.uom+'" data-buffer="'+ data.quantity_buffer +'" data-min="'+ data.min_quantity +'" data-max="'+ data.max_quantity +'"  data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    
    function postCallback(route,data,callback){
        $('.message_error').html('')
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function postCallbackNoSwal(route,data,callback){
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function getCallback(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        beforeSend: function() {
            SwalLoading('Please wait ...');
        },
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function getCallbackNoSwal(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function selectName(route, id, name){
            $.ajax({
            url: route,
            type: "get",
            dataType: 'json',
            async: true,
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function postAttachment(route, data, withFile, callback) {
        $.ajax({
            url: route,
            type: 'POST',
            dataType: 'json',
            async: true,
            processData: false,  // Important: Set to false for file uploads
            contentType: false,  // Important: Set to false for file uploads
            data: data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: callback,
            error: function(response) {
                $('.message_error').html('');
                swal.close();
                if (response.status == 500) {
                    console.log(response);
                    toastr['error'](response.responseJSON.meta.message);
                    return false;
                }
                if (response.status === 422) {
                    $.each(response.responseJSON.errors, (key, val) => {
                        $('span.' + key + '_error').text(val);
                    });
                } else {
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });
    }
    
    // Format Number
        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val =  input_val;
            
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }
        function formatRupiah(money) {
            return new Intl.NumberFormat('id-ID',
                { style: 'currency', currency: 'IDR' }
            ).format(money);
        }

        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ',';
            return rupiah.split('', rupiah.length - 1).reverse().join('');
        }
    // Format Number

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
    function autoAdjustColumns(table) {
        var container = table.table().container();
        var resizeObserver = new ResizeObserver(function () {
            table.columns.adjust();
        });
        resizeObserver.observe(container);
    }
    function findIndexByProperty(array, property, value) {
    for (let i = 0; i < array.length; i++) {
        if (array[i][property] === value) {
            return i;
        }
    }
    return -1; // Return -1 if not found
}
function convertDate(inputDate) {
    // Parse the input date string
    const dateParts = inputDate.split("-");
    const year = parseInt(dateParts[0]);
    const month = parseInt(dateParts[1]);
    const day = parseInt(dateParts[2]);

    // Create a Date object
    const date = new Date(year, month - 1, day);

    // Define month names
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Format the date
    const formattedDate = day + " " + monthNames[month - 1] + " " + year;

    return formattedDate;
}


function getHorizontalBar(response) {
    if (response.summaryChartCategory && response.summaryChartCategory.length > 0) {
        $('#horizontalBarChart').empty();
        
        let chartData = response.summaryChartCategory;

        // Get unique categories and satgas names
        let categories = [...new Set(chartData.map(item => item.category_name))];
        let satgasNames = [...new Set(chartData.map(item => item.satgas_type))];

        if (categories.length === 0 || satgasNames.length === 0) {
            console.warn("No valid data found for categories or satgas.");
            return;
        }

        let series = satgasNames.map(satgas => {
            return {
                name: satgas,
                data: categories.map(cat => {
                    let found = chartData.find(d => d.category_name === cat && d.satgas_type === satgas);
                    return found ? found.total : 0;
                }),
            };
        });

        let optionBarChart = {
            chart: {
                fontFamily: "Poppins",
                type: "bar",
                height: 400,  // Overall height of the chart
                stacked: true, // Ensure bars are stacked
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: true,  // Horizontal bars
                    borderRadius: 0,  // Ensure there is no border-radius for bars
                    barHeight: '50%', // Bar height is 100% of available space (use full height of the chart)
                    dataLabels: {
                        enabled: true,  // Enable data labels inside bars
                        style: {
                            fontSize: '5px',  // Font size for values inside bars
                            fontWeight: 'bold', // Font weight (optional)
                            colors: '#fff',    // Font color
                        },
                    }
                },
                
            },
            grid: {
                borderColor: "transparent",
            },
            colors: [
                "var(--bs-primary)",
                "var(--bs-danger)",
                "#ffae1f",
                "#499F85",
                "#39b69a",
            ],
            stroke: {
                width: 0,  // Remove any border around the bars
                colors: ["#fff"],
            },
            series: series, // Dynamic series based on satgasNames
            xaxis: {
                categories: categories, // Categories on x-axis
                labels: {
                    formatter: function (val) {
                        return val; // Format label in x-axis
                    },
                    style: {
                        colors: "#a1aab2", // Label color on x-axis
                        fontSize: 9,
                    },
                },
            },
            yaxis: {
                title: {
                    text: undefined,
                },
                labels: {
                    style: {
                        colors: "#a1aab2", // Label color on y-axis
                        fontSize: 9,
                    },
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val; // Format tooltip
                    },
                },
                theme: "dark",
            },
            fill: {
                opacity: 1, // Keep bars fully opaque
            },
            legend: {
                position: "bottom",
                horizontalAlign: "left",
                offsetX: 10,
                labels: {
                    colors: ["#a1aab2"], // Style legend text
                },
            },
            title: {
                text: "", // Chart title
                align: "center",
                style: {
                    color: "#a1aab2", // Styling title
                },
            },
        };

        // Initialize and render the chart
        let barChart = new ApexCharts(document.querySelector("#horizontalBarChart"), optionBarChart);
        barChart.render();
    } else {
        console.warn("Tidak ada data untuk chart.");
    }
}
