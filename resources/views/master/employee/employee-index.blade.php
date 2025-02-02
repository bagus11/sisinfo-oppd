@extends('garage._dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>Employee Information</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_employee" data-bs-toggle="modal" data-bs-target="#addEmployee">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-header p-0 mx-1">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="employee_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                  <th>Status</th>
                                  <th>Employee ID</th>
                                  <th>Name</th>
                                  <th>Location</th>
                                  <th>Department</th>
                                  <th>Division</th>
                                  <th>Position</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('hris/master/employee.js') }}"></script>
@endpush
