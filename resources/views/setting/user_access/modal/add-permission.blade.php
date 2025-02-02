
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true" style="overflow-y: hidden">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <input type="hidden" id="roleIdPermissionAdd">
                        <table class="table table-striped table-bordered text-nowrap" id="rolePermissionInactiveTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center"><input type="checkbox" id="checkAllPermissionInnactiveTable" name="checkAllPermissionInnactiveTable" class="checkAllPermissionInnactiveTable" style="border-radius: 5px !important;"></th>
                                    <th style="text-align: center">Permission Name</th>
                                  
                                </tr>
                            </thead>
                        </table>
                    </div>
                
               
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btnAddRolePermission">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
