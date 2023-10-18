@extends('layouts.app')
@section('title')
    Permissions / {{$permission->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Permissions'])
            @can('create permissions')
                <a href="{{route('permissions.create')}}" class="btn btn-primary mb-2">Create permission</a>
            @endcan
            @can('view permissions')
                <a href="{{route('permissions.index')}}" class="btn btn-info mb-2">Permissions List</a>
            @endcan
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$permission->name}} ) Permission <a
                                href="{{route('permissions.edit', $permission->hashId)}}">Edit</a>
                        </div>
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'Name' => $permission->name,
                                    'Group' => $permission->group,
                                    'Guard Name' => $permission->guard_name
                                ]
                            ])
                    </div>
                </div>

            </div>
            @can('view roles')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Roles</h4>
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>GUARD</th>
                                        <th>Users Count</th>
                                        <th>CREATED AT</th>
                                        <th>OPTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i= 1;
                                    @endphp
                                    @foreach($permission->roles as $role)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$role->name}}</td>
                                            <td>{{$role->guard_name}}</td>
                                            <td><span
                                                    class="badge rounded-pill bg-primary float-start">{{$role->users->count()}}</span>
                                            </td>
                                            <td>{{$role->created_at}}</td>
                                            <td>
                                                @include('layouts.components.table_options', [
                                                    'model' => $role,
                                                    'modelName' => 'roles'
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            @endcan
        </div>
        <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
@push('start_css')
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}"
          rel="stylesheet" type="text/css"/>
@endpush
@push('end_js')
    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
@endpush
