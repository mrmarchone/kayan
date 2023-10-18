@extends('layouts.app')
@section('title')
    Users / {{$user->name}}
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
            @can('view users')
                <a href="{{route('users.index')}}" class="btn btn-info mb-2">Users list</a>
            @endcan
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$user->name}} ) User <a
                                    href="{{route('users.edit', $user->hashId)}}">Edit</a>
                        </div>
                        @php
                            $results_count = $user->type == 'demo' ? ['User Results Count' => $user->settings->results_count, 'User Breaches Limit' => $user->settings->breaches_limit] : [];
                        @endphp
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'User Name' => $user->name,
                                    'User Email' => $user->email,
                                    'User Phone' => $user->phone,
                                    'User Company' => $user->company,
                                    'User Country' => $user->country?->name,
                                    'User Industry' => $user->section?->name,
                                    'User Token' => $user->api_token,
                                    'User Domains Limit' => $user->settings->domains_limit,
                                    'User Breaches Limit Used' => $user->settings->breaches_limit_used,
                                    'Showing Scan Results Password' => $user->settings->show_scan_results_password ? 'True' : 'False',
                                    ...$results_count
                                ]
                            ])
                        <div class="card-body">
                            <div id="permissionListCheckboxes">
                                <div class="row">
                                    @foreach($user->roles->first()?->permissions->groupBy('group') as $key => $value)
                                        <div class="col-sm-3">
                                            <label for="guard_name"
                                                   class="col-sm-12 col-form-label">{{$key}}</label>
                                            @foreach($value as $permission)
                                                <div class="col-md-10">
                                                    <div class="form-check mb-3">
                                                        <input disabled checked class="form-check-input" type="checkbox"
                                                               id="permission{{$permission->hashId}}">
                                                        <label class="form-check-label"
                                                               for="permission{{$permission->hashId}}">
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
