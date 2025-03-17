getCallbackNoSwal('getSatgasType', null, function (response) {
    $('#select_satgas').empty();
    for (var i = 0; i < response.data.length; i++) {
        $('#select_satgas').append(`
            <option value="${response.data[i].type}">${response.data[i].type}</option>
        `) 
    }
})

$('#btn_change_image').on('click', function(){
    $('#editImageModal').modal('show')
})
$('#btn_change_pass').on('click', function() {
    $('#editPassModal').modal('show');
    $('#current_pass').val('')
    $('#new_pass').val('')
    $('#confirm_pass').val('')
    let locationSelect = document.getElementById('select_location');
    let satgasSelect = document.getElementById('select_satgas');

    if (locationSelect) locationSelect.style.zIndex = 0;
    if (satgasSelect) satgasSelect.style.zIndex = 0;
});

getActiveItems('getMasterSatgas', null, 'select_location', 'location');
getCallback('getUserProfile', null, function (response) {
    swal.close();
    $('#btn_save').prop('hidden', true);
    $('#btn_edit').prop('hidden', false);
    $('#btn_cancel').prop('hidden', true);
    $('#name').prop('disabled', true);
    $('#email').prop('disabled', true);
    $('#select_location').prop('disabled', true);
    $('#select_satgas').prop('disabled', true);
    $('#nrp').prop('disabled', true);
    $('#no_hp').prop('disabled', true);
    $('#btn_save').prop('hidden', true);
    $('#select_satgas').val(response.data.location_relation.type);
    $('#select_satgas').select2().trigger('change');
    $('#select_location').val(response.data.location_relation.id);
    $('#select_location').select2().trigger('change');
    $('#nrp').val(response.data.nrp);
    $('#no_hp').val(response.data.no_hp)
})

$('#btn_edit').click(function () {
    $('.message_error').html('')
    $('#btn_edit').prop('hidden', true);
    $('#btn_cancel').prop('hidden', false);
    $('#btn_save').prop('hidden', false);
   
    $('#email').prop('disabled', false);
    $('#no_hp').prop('disabled', false);
    $('#btn_save').prop('hidden', false);
})
$('#btn_cancel').click(function () {
    $('.message_error').html('')
    $('#btn_edit').prop('hidden', false);
    $('#btn_cancel').prop('hidden', true);
    $('#btn_save').prop('hidden', true);
    $('#name').prop('disabled', true);
    $('#email').prop('disabled', true);
    $('#select_location').prop('disabled', true);
    $('#select_satgas').prop('disabled', true);
    $('#nrp').prop('disabled', true);
    $('#no_hp').prop('disabled', true);
    $('#btn_save').prop('hidden', true);
})
$('#btn_save').on('click', function(){
    var data ={
        'email' : $('#email').val(),
        'no_hp' : $('#no_hp').val(),
    }
    postCallback('updateProfile', data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        setTimeout(function() {
            location.reload();
        }, 3000);
    })
})
$('#no_hp').on('input', function () {
    var noHp = $(this).val();
    var phoneRegex = /^08\d{8,11}$/; // "08" + 8 sampai 11 digit angka (total 10-13 digit)

    if (!phoneRegex.test(noHp)) {
        $('.no_hp_error').text("Nomor HP harus dimulai dari 08 dan memiliki 10-13 digit.").show();
    } else {
        $('.no_hp_error').text("").hide();
    }
});



$('#btn_save_pass').on('click', function(){
    var data = {
        'current_pass': $('#current_pass').val(),
        'new_pass': $('#new_pass').val(),
        'new_pass_confirmation': $('#new_pass_confirmation').val(), // Sesuai dengan Laravel
    };
    
    
    postCallback('updatePass', data, function(response){
        swal.close()
        toastr['success'](response.meta.message)
        $('#editPassModal').modal('hidden');
    })
})
  // Change Image 
  $(document).ready(function() {
    var cropper;
    var image = document.getElementById('cropImage');
    var input = document.getElementById('profileImageInput');

    input.addEventListener('change', function(e) {
        var files = e.target.files;
        var done = function(url) {
            input.value = '';
            image.src = url;
            $('#cropContainer').show();

            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
            });
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#cropButton').click(function() {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            if (canvas) {
                canvas.toBlob(function(blob) {
                    var formData = new FormData();
                    formData.append('profile_image', blob);

                    $.ajax({
                        url: 'changeImage',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend : function(){
                            SwalLoading('Please wait ...');
                        },
                        success: function(response) {
                            swal.close()
                            toastr['success'](response.meta.message)
                            $('#editImageModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function() {
                            console.log('Upload error');
                        }
                    });
                });
            } else {
                console.log('Canvas is null');
            }
        } else {
            console.log('Cropper instance is not initialized');
        }
    });

    $('#btn_update_profile').click(function() {
        $('#cropButton').click();
    });
});
// Change Image 