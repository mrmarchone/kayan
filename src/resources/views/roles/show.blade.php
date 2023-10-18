@extends('layouts.app')
@section('title')
    Roles / {{$role->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Roles'])
            @can('create roles')
                <a href="{{route('roles.create')}}" class="btn btn-primary mb-2">Create role</a>
            @endcan
            @can('view roles')
                <a href="{{route('roles.index')}}" class="btn btn-info mb-2">Roles list</a>
            @endcan
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$role->name}} ) Role <a
                                href="{{route('roles.edit', $role->hashId)}}">Edit</a>
                        </div>
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'Name' => $role->name,
                                    'Guard Name' => $role->guard_name,
                                    'Type' => $role->type,
                                ]
                            ])
                        <div class="card-body">
                            <div id="permissionListCheckboxes">
                                <div class="row">
                                    @foreach($role->permissions->groupBy('group') as $key => $value)
                                        <div class="col-sm-3">
                                            <label for="guard_name"
                                                   class="col-sm-12 col-form-label">{{$key}}</label>
                                            @foreach($value as $permission)
                                                <div class="col-md-10">
                                                    <div class="form-check mb-3">
                                                        <input disabled checked class="form-check-input" type="checkbox"
                                                               id="permission{{$permission->id}}">
                                                        <label class="form-check-label"
                                                               for="permission{{$permission->id}}">
                                                            {{$permission->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @can('view users')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Users</h4>
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>CREATED AT</th>
                                        <th>OPTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->created_at}}</td>
                                            <td>
                                                @include('layouts.components.table_options', [
                                                    'model' => $user,
                                                    'modelName' => 'users'
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
