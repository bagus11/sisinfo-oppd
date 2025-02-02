const table = $('#personalia_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getPersonalia`,
        type: 'GET',
    },
    columns: [
        { data: 'nik', name: 'nik' },
        { data: 'nama', name: 'nama' },
        { data: 'satgas', name: 'satgas' },
        { data: 'jabatan', name: 'Jabatan' },
        { data: 'join_date', name: 'join_date' },
        { 
            data: 'status', 
            name: 'status',
            render: function(data, type, row) {
                switch(data) {
                    case 0: return 'Order And Preparation';
                    case 1: return 'Shipping & Tracking';
                    case 2: return 'Delivery Confirmation';
                    default: return 'Unknown';
                }
            }
        },
    ]
    
});