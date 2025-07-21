  <div class="tab-pane p-3" id="tab_chart_3">
    <div class="row mx-2 my-2">
    <div class="col-2 mt-2">
        <p>Category</p>
    </div>
    <div class="col-4 mb-2">
        <select class="select2" name="select_category" id="select_category"></select>
    </div>
    <div class="col-2 mt-2">
        <p>Sub Category</p>
    </div>
    <div class="col-4 mb-2">
        <select class="select2" name="select_sub_category" id="select_sub_category"></select>
    </div>
    <div class="col-2 mt-2">
        <p>Jenis</p>
    </div>
    <div class="col-4 mb-2">
        <select class="select2" name="select_type" id="select_type"></select>
    </div>
    <div class="col-2 mt-2">
        <p>Merk</p>
    </div>
    <div class="col-4 mb-2">
        <select class="select2" name="select_brand" id="select_brand"></select>
    </div>
</div>
<div class="row justify-item-end mx-2 my-2">
    <div class="col-2 offset-10">
        <button class="btn btn-sm btn-danger" style="float: right;" id="btn_filter_custom">
            <i class="fas fa-filter"></i> Filter
        </button>
    </div>
</div>

<div class="row my-2" id="custom_table_container">
    <div class="table-responsive mt-2">
        <table id="pivot_table_custom" class="table table-striped">
           <thead>
                <tr></tr>
            </thead>
        </table>
    </div>
</div>
  </div>