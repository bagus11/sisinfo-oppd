let map, marker,mapEdit, markerEdit;
let typingTimer; // Timer untuk debounce
const typingDelay = 500; // Waktu delay dalam milidetik (500ms)

// Function untuk melakukan pencarian lokasi
function searchLocation(query) {
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

    // Tampilkan loading
    SwalLoading('Please wait ...');

    fetch(url)
        .then(response => {
            if (!response.ok) {
               
                toastr['warning']('Terjadi kesalahan saat mencari lokasi.')
            }
            return response.json();
        })
        .then(data => {
            // Sembunyikan loading
          swal.close()

            if (data.length === 0) {
                toastr['warning']('Lokasi tidak ditemukan')
                return;
            }

            const location = data[0]; // Ambil lokasi pertama dari hasil pencarian
            const lat = parseFloat(location.lat);
            const lon = parseFloat(location.lon);

            // Update posisi marker di peta
            marker.setLatLng([lat, lon]);
            map.setView([lat, lon], 13); // Zoom in ke lokasi yang ditemukan

            // Update nilai input koordinat
            document.getElementById('x').value = lat.toFixed(6);
            document.getElementById('y').value = lon.toFixed(6);
        })
        .catch(error => {
          swal.close()
            alert('Terjadi kesalahan: ' + error.message);
        });
}

// Event listener untuk input pencarian
document.getElementById('map_search').addEventListener('input', function () {
    const query = this.value;
    clearTimeout(typingTimer); // Reset timer saat mengetik
    if (query.length > 2) {
        typingTimer = setTimeout(() => {
            searchLocation(query); // Panggil pencarian setelah selesai mengetik
        }, typingDelay);
    }
});
document.getElementById('map_search_edit').addEventListener('input', function () {
    const query = this.value;
    clearTimeout(typingTimer); // Reset timer saat mengetik
    if (query.length > 2) {
        typingTimer = setTimeout(() => {
            searchLocation(query); // Panggil pencarian setelah selesai mengetik
        }, typingDelay);
    }
});

// Initialize DataTable
const table = $('#satgas_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `getSatgasTable`,
        type: 'GET',
    },
    columns: [
        { data: 'name', name: 'name' },
        { data: 'type', name: 'type' },
        { data: 'country', name: 'country' },
        { data: 'x', name: 'x' },
        { data: 'y', name: 'y' },
    ]
});

// Add Satgas (Open Modal)
$('#btn_add_satgas').on('click', function () {
    // Reset form inputs
    $('#name').val('');
    $('#country').val('');
    $('#type').val('');
    $('#select_type').val('');
    $('#select_type').select2().trigger('change');
    $('#x').val('');
    $('#y').val('');

    // Show the modal
    $('#addSatgasModal').modal('show');

    // Initialize map only once
    if (!map) {
        map = L.map('map').setView([0, 0], 2); // Default view

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Add a draggable marker
        marker = L.marker([0, 0], { draggable: true }).addTo(map);

        // Update inputs when marker is dragged
        marker.on('dragend', function (e) {
            const latlng = e.target.getLatLng();
            $('#x').val(latlng.lat.toFixed(6));
            $('#y').val(latlng.lng.toFixed(6));
        });

        // Update marker position on map click
        map.on('click', function (e) {
            const latlng = e.latlng;
            marker.setLatLng(latlng);
            $('#x').val(latlng.lat.toFixed(6));
            $('#y').val(latlng.lng.toFixed(6));
        });
    }

    // Adjust map size when modal is shown
    $('#addSatgasModal').on('shown.bs.modal', function () {
        map.invalidateSize();
    });
});

// Edit Satgas (Fill in form)
$('#satgas_table tbody').on('click', 'tr', function () {
    $('#btn_cacel_edit').prop('hidden', true)
    const row = table.row(this).data();
    if (row) {
        // Populate modal with existing data
        $('#nama_edit').val(row.name);
        $('#negara_edit').val(row.country);
        $('#tipe_edit').val(row.type);
        $('#select_tipe_edit').val(row.type).trigger('change');
        $('#x_edit').val(row.x);
        $('#y_edit').val(row.y);

        $('#nama_edit').prop('readOnly', true);
        $('#negara_edit').prop('readOnly', true);
        $('#tipe_edit').prop('readOnly', true);
        $('#select_tipe_edit').prop('disabled', true)
        $('#map_edit').prop('readOnly', true)
        $('#x_edit').prop('readOnly', true);
        $('#y_edit').prop('readOnly', true);

        // Show modal
        $('#editSatgasModal').modal('show');

        // Initialize map only once
        if (!mapEdit) {
            mapEdit = L.map('map_edit').setView([0, 0], 2); // Default view

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mapEdit);

            // Add a draggable marker
            markerEdit = L.marker([0, 0], { draggable: true }).addTo(mapEdit);

            // Update inputs when marker is dragged
            markerEdit.on('dragend', function (e) {
                const latlngEdit = e.target.getLatLng();
                $('#x_edit').val(latlngEdit.lat.toFixed(6));
                $('#y_edit').val(latlngEdit.lng.toFixed(6));
            });

            // Update marker position on map click
            mapEdit.on('click', function (e) {
                const latlngEdit = e.latlng;
                markerEdit.setLatLng(latlngEdit);
                $('#x_edit').val(latlngEdit.lat.toFixed(6));
                $('#y_edit').val(latlngEdit.lng.toFixed(6));
            });
        }

        // Set map and marker position based on row data
        const lat = parseFloat(row.x);
        const lng = parseFloat(row.y);

        if (!isNaN(lat) && !isNaN(lng)) {
            // Update marker position
            markerEdit.setLatLng([lat, lng]);

            // Center map on the marker's position
            mapEdit.setView([lat, lng], 13); // Adjust zoom level as needed
        } else {
            // Handle case where coordinates are invalid or empty
            console.error('Invalid coordinates: ', row.x, row.y);
        }

        // Adjust map size when modal is shown
        $('#editSatgasModal').on('shown.bs.modal', function () {
            mapEdit.invalidateSize();
        });
    }
});

$('#btn_edit').on('click', function(){
    $('#btn_cacel_edit').prop('hidden', false)
    $('#btn_edit').prop('hidden', true)
    $('#nama_edit').prop('readOnly', false);
    $('#negara_edit').prop('readOnly', false);
    $('#tipe_edit').prop('readOnly', false);
    $('#select_tipe_edit').prop('disabled', false)
    $('#map_edit').prop('readOnly', false)
    $('#x_edit').prop('readOnly', false);
    $('#y_edit').prop('readOnly', false);
})

$('#btn_cacel_edit').on('click', function(){
    $('#btn_edit').prop('hidden', false)
    $('#btn_cacel_edit').prop('hidden', true)
    $('#nama_edit').prop('readOnly', true);
    $('#negara_edit').prop('readOnly', true);
    $('#tipe_edit').prop('readOnly', true);
    $('#select_tipe_edit').prop('disabled', true)
    $('#map_edit').prop('readOnly', true)
    $('#x_edit').prop('readOnly', true);
    $('#y_edit').prop('readOnly', true);
})

// Save Satgas
onChange('select_tipe','tipe')
    $('#btn_save_satgas').on('click', function(){
        var data = {
            'nama' : $('#nama').val(),
            'tipe' : $('#tipe').val(),
            'negara' : $('#negara').val(),
            'x' : $('#x').val(),
            'y' : $('#y').val(),
        }
        postCallback('addSatgas', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#addSatgasModal').modal('hide')
            $('#satgas_table').DataTable().ajax.reload();

        })
    })
// Save Satgas