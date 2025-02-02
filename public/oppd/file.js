$(document).ready(function() {
    // Panggil getFile saat halaman dimuat
    getFile();
    $('#type').on('change', function () {
        if ($(this).val() === 'file') {
            $('#file-upload-container').show();
        } else {
            $('#file-upload-container').hide();
        }
    });

    // Mengatur form submit untuk menambah file/folder
    $('#btn_save_file').on('click', function(e) {
        e.preventDefault();
    
        var formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('type', $('#type').val());
        var parentId = parseInt($('#parent_id').val(), 10); // Mengonversi parent_id ke integer
        formData.append('parent_id', parentId);

        // Pastikan file diunggah jika tipe adalah file
        if ($('#type').val() === 'file') {
            var file = $('#file_upload_asset')[0].files[0];  // Pastikan menggunakan ID yang benar
            if (file) {
                formData.append('file_upload_asset', file);  // Pastikan nama input sama
            }
        }

        // Kirim data ke server (menggunakan fungsi addFile atau uploadFile berdasarkan tipe)
        if ($('#type').val() === 'file') {
            // Kirim ke fungsi uploadFile untuk file
            postAttachment('uploadFile', formData, false, function(response) {
                swal.close();
                toastr['success'](response.message);
                $('#addFileModal').modal('hide');
                getFile();  // Memperbarui daftar file/folder
            });
        } else {
            // Kirim ke fungsi addFile untuk folder
            postAttachment('addFile', formData, false, function(response) {
                swal.close();
                toastr['success'](response.message);
                $('#addFileModal').modal('hide');
                getFile();  // Memperbarui daftar file/folder
            });
        }
    });

    // Function to fetch and display file/folder list
    function getFile() {
        getCallback('getFile', null, function(response) {
            swal.close(); // Menutup SweetAlert loading
            $('#file-list').empty(); // Kosongkan list file sebelumnya
    
            // Menampilkan file/folder yang diterima dari response
            response.data.forEach(file => {
                let listItem = `
                <li data-id="${file.id}" class="${file.type === 'folder' ? 'folder-item' : 'file-item'}">
                    ${file.type === 'folder' ? '<i class="fas fa-folder"></i>' : '<i class="fas fa-file"></i>'} 
                    ${file.type === 'file' ? `<a href="/storage/${file.path}" download="${file.name}" target="_blank">${file.name}</a>` : file.name}
                    ${file.type === 'folder' ? `<button class="btn btn-sm ml-6 btn-add-folder" data-parent-id="${file.id}">+</button>` : ''}
                    <ul class="child-list" style="display: none;"></ul> <!-- Hidden child list -->
                </li>`;
                $('#file-list').append(listItem);
            });
    
            // Hapus event listener sebelumnya untuk mencegah duplikasi
            $('#file-list').off('click', '.folder-item').on('click', '.folder-item', function(e) {
                e.stopPropagation(); // Mencegah event bubbling ke parent
    
                let fileId = $(this).data('id');
                let childList = $(this).children('.child-list'); // Cari child list dalam folder
    
                // Cek apakah child sudah dimuat
                if (childList.children().length === 0) {
                    // Jika belum ada child, ambil dari server
                    getCallbackNoSwal('getFile', { parent_id: fileId }, function(response) {
                        response.data.forEach(child => {
                            let childItem = `<li data-id="${child.id}" class="${child.type === 'folder' ? 'folder-item' : 'file-item'}">
                                ${child.type === 'folder' ? '<i class="fas fa-folder"></i>' : '<i class="fas fa-file"></i>'} 
                                ${child.type === 'folder' ? `${child.name} <button class="btn btn-sm ml-6 btn-add-folder" data-parent-id="${child.id}">+</button>` : ''}`;
                    
                            if (child.type == 'file') {
                                // Ganti tampilan untuk file
                                childItem = `
                                    <li data-id="${child.id}" class="file-item">
                                        <a style="color:#76ABAE !important;" 
                                           title="Click Here For Attachment" 
                                           href="/storage/${child.path}" target="_blank">
                                           <i class="fa-solid fa-file-pdf"></i> ${child.name}
                                        </a>
                                        <ul class="child-list" style="display: none;"></ul> <!-- Hidden child list -->
                                    </li>`;
                            }
                            
                            // Menambahkan item anak (folder atau file)
                            childList.append(childItem);
                        });
                    
                        // Tampilkan child list setelah dimuat
                        childList.slideDown(); 
                    });
                } else {
                    // Toggle visibility jika child sudah ada
                    childList.slideToggle();
                }
            });
    
            // Hapus event listener sebelumnya untuk mencegah duplikasi
            $('#file-list').off('click', '.file-item').on('click', '.file-item', function(e) {
                e.stopPropagation(); // Mencegah file menutup folder saat diklik
            });
    
            // Menangani klik tombol "+" untuk membuka modal
            $('#file-list').off('click', '.btn-add-folder').on('click', '.btn-add-folder', function(e) {
                e.stopPropagation(); // Mencegah klik ke li item
    
                var parentId = $(this).data('parent-id');
                $('#parent_id').val(parentId);
                $('#addFileModal').modal('show');
            });
        });
    }
    
    

    
});
