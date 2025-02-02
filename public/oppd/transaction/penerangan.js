const table = $('#news_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getNews`,
        type: 'GET',
    },
    columns: [
        { data: 'news_code', name: 'news_code' },
        {    data: 'created_at',
            name: 'created_at',
            render: function (data) {
                if (data) {
                    const date = new Date(data);
                    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')} `;
                }
                return '-';
            }
        },
        { data: 'reporter_relation.name', name: 'reporter_relation.name' },
        { data: 'judul', name: 'judul' },
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
        { 
            data: 'status', 
            name: 'status',
            render: function(data, type, row) {
                switch(data) {
                    case 0: return 'NEW';
                    case 1: return 'On Progress';
                    case 2: return 'DONE';
                    case 3: return 'Reject';
                    default: return 'Unknown';
                }
            }
        },
   
    ]
    
});


onChange('select_reporter','reporter')

$('#btn_add_news').on('click', function(){
    getActiveItems('getUser',null,'select_reporter','Reporter')    
    $(document).ready(function() {
        // Initialize Summernote
        $('#news_content').summernote({
            placeholder: 'Tuliskan berita di sini...',
            height: 200, // Set height for the editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Poppins', 'Arial', 'Courier New', 'Helvetica', 'Times New Roman']
            
        });
    });
})