<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <div class="container mt-2">
                        <fieldset class="mb-2">
                            <legend>General Information</legend>
                            <div class="row">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Judul</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-10">
                                    <input type="text" class="form-control" id="judul">
                                    <span class="message_error judul_error text-red d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Reporter</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <select name="select_reporter" class="select2" id="select_reporter"></select>
                                    <input type="hidden" class="form-control" id="reporter">
                                    <span class="message_error reporter_error text-red d-block"></span>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Attachment</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="file" class="form-control" id="attachment">
                                    <span class="message_error attachment_error text-red d-block"></span>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset class="mt-4 container_label">
                            <legend>News</legend>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <textarea id="news_content" class="form-control"></textarea>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
                <div class="modal-footer container_label">
                    <button class="btn btn-sm btn-success" type="submit" id="btn_save_inventaris">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
