@extends('layouts.app')
@section('title')
    Users
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Users'])
            @can('create users')
                <a href="{{route('users.create')}}" class="btn btn-info mb-2">Create new users</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title">Users</h4>
                    <table id="datatable" class="table users" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>TYPE</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>TOKEN</th>
                            <th>COMPANY</th>
                            <th>PHONE</th>
                            <th>COUNTRY</th>
                            <th>ROLE</th>
                            <th>INDUSTRY</th>
                            <th>STATUS</th>
                            @can('activate users')
                                <th>Activate</th>
                            @endcan
                            @can('deactivate users')
                                <th>DeActivate</th>
                            @endcan
                            @can('createToken users')
                                <th>CREATE TOKEN</th>
                            @endcan
                            <th>OPTIONS</th>
                        </tr>
                        </thead>
                    </table>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
@push('start_css')
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <style type="text/css">

    </style>
@endpush
@push('end_js')
    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <script type="text/javascript">
        const table = $("#datatable").DataTable({
            columnDefs: [{className: "copyable", targets: [3, 4]}],
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            ajax: "{{route('users.data')}}",
            columns: [
                {data: "id", name: "id"},
                {data: "type", name: "type"},
                {data: "name", name: "name"},
                {data: "email", name: "email"},
                {data: "api_token", name: "api_token", orderable: false, searchable: false},
                {data: "company", name: "company"},
                {data: "phone", name: "phone"},
                {data: "country", name: "country"},
                {data: "role", name: "role", orderable: false, searchable: false},
                {data: "industry", name: "industry"},
                {data: "status", name: "status", orderable: false, searchable: false},
                    @can('activate users')
                {
                    data: "activate", name: "activate", orderable: false, searchable: false
                },
                    @endcan
                    @can('deactivate users')
                {
                    data: "deactivate", name: "deactivate", orderable: false, searchable: false
                },
                    @endcan
                    @can('createToken users')
                {
                    data: "create_token", name: "create_token", orderable: false, searchable: false
                },
                    @endcan
                {
                    data: "options", name: "options", orderable: false, searchable: false
                }
            ]
        })
        table
            .on('order.dt search.dt', function () {
                let i = 1;
                table
                    .cells(null, 0, {search: 'applied', order: 'applied'})
                    .every(function (cell) {
                        this.data(i++);
                    });
            })
            .draw();
    </script>
@endpush
