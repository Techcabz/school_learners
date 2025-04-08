@extends('layouts.index')
@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>


    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="admin?p=users">Users Management</a></li>
                </ol>
            </div>
            <div class="row">
                <!-- column -->
                <div class="col-12">
                    <div class="card shadow mt-3 mb-5">
                        <div class="card-body">
                            <h4 class="card-title m-0 p-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="m-0 font-weight-bold">Users Management</h5>
                                    <button class="btn btn-re" data-bs-toggle="modal" data-bs-target="#insertUsertModal"><i
                                            class="fa fa-plus-square"></i>&nbsp;Add new users</button>
                                </div>
                            </h4>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="container1-tab" data-bs-toggle="tab"
                                        data-bs-target="#container1" type="button" role="tab"
                                        aria-controls="container1" aria-selected="true">Users</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="container2-tab" data-bs-toggle="tab"
                                        data-bs-target="#container2" type="button" role="tab"
                                        aria-controls="container2" aria-selected="false">Blocked</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="container1" role="tabpanel"
                                    aria-labelledby="container1-tab">
                                    <div class="table-responsive">
                                        <table id="table3" class="table table-bordered" width="100%">
                                            <thead class="thead-custom text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Created At</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th></th>
                                                    <th>User Type</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="container2" role="tabpanel" aria-labelledby="container2-tab">
                                    <div class="table-responsive">
                                        <table id="table" class="table table-bordered" width="100%">
                                            <thead class="thead-custom text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Created At</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>x</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- <div class="row hv-100 m-3">
        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <h4 class="card-title">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0 font-weight-bold text-muted">USERS MANAGEMENT</h5>

                        </div>
                    </h4>
                    @livewire('admin.user.management')
                </div>
            </div>
        </div>
    </div> --}}
@endsection
