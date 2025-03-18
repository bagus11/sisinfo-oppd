@extends('garage._dashboard')
@section('content')
<style>
    .select2-container {
        z-index: 500 !important; /* Sesuaikan dengan modal jika perlu */
    }
    #cropContainer {
        text-align: center;
    }
    #cropImage {
        max-width: 100%;
        margin-top: 10px;
    }
    #cropButton {
        margin-top: 10px;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<div class="row justify-content-center">
    <div class="col-10">
          <div class="card overflow-hidden">
            <div class="card-body p-0">
              <img src="../assets/images/backgrounds/profilebg.jpg" alt="matdash-img" class="img-fluid">
              <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                  <div class="d-flex align-items-center justify-content-around m-4">
                  
                  </div>
                </div>
                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                  <div class="mt-n5">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                      <div class="d-flex align-items-center justify-content-center round-110">
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">
                          <img src="{{ auth()->user()->avatar ? asset('storage/users-avatar/' . auth()->user()->avatar) : asset('assets/images/profile/user-1.jpg') }}" 
                          class="w-100 h-100"alt="user-avatar" />
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <h5 class="mb-0">{{auth()->user()->name}}</h5>
                      <p class="mb-0">{{auth()->user()->email}}</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 order-last">
                  <ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 pe-4 gap-3">
                    <li>
                        <button class="btn btn-sm btn-info" id="btn_change_image"><i class="fa-solid fa-image-portrait"></i> Ubah Profile</button>
                    </li>
                    <li>
                      <button class="btn btn-sm btn-danger" id="btn_change_pass"><i class="fa-solid fa-key"></i> Ganti Password</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
<div class="row justify-content-center">
{{-- <div class="row justify-content-center"> --}}
    <div class="col-10">
        <div class="card">
            <div class="card-header">
                <strong>Profile</strong>
            </div>
            <div class="card-body">
                <fieldset>
                    <legend>General Information</legend>
                    <div class="row">
                        <div class="col-md-2 mt-2">
                            <label for="name">Nama</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-4">
                            <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email}}" style="font-size: 12px">
                            <span class="message_error email_error text-red d-block"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 mt-2">
                            <label for="satgas">Satgas</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_satgas" class="select2" id="select_satgas"></select>
                            <input type="hidden" class="form-control" id="satgas" name="satgas">
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="lokasi">Lokasi</label>
                        </div>
                        <div class="col-md-4"> 
                            <select name="select_location" class="select2" id="select_location"></select>
                            <input type="hidden" class="form-control" id="lokasi" name="lokasi">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 mt-2">
                            <label for="nrp">NRP</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="nrp" name="nrp">
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="no_hp">No. HP</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="no_hp" name="no_hp">
                            <span class="message_error no_hp_error text-red d-block"></span>
                        </div>
                    </div>
                    <div class="row mt-2" style="float: right">
                        <div class="col-12">
                            <button class="btn btn-sm btn-danger" id="btn_cancel">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Cancel
                            </button>
                            <button class="btn btn-sm btn-success" id="btn_save">
                                <i class="fas fa-edit"></i> Save
                            </button>
                            <button class="btn btn-sm btn-warning" id="btn_edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@include('setting.general.modal.edit-image')
@include('setting.general.modal.edit-pass')
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="{{ asset('oppd/setting/setting.js') }}"></script>
@endpush
