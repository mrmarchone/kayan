@extends('layouts.app')
@section('title')
    Notifications
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Notifications'])
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title">Notifications</h4>
                    <table id="datatable" class="table table-bordered nowrap dataTables_scrollBody">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>TYPE</th>
                            <th>NAME</th>
                            <th>Email</th>
                            <th>OPTIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($notifications as $notification)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$notification->data['model']}}</td>
                                <td>{{$notification->data['name']}}</td>
                                <td>{{$notification->data['email']}}</td>
                                <td>
                                    @include('layouts.components.table_options', [
                                        'model' => $notification,
                                        'modelName' => 'notifications',
                                        'validOptions' => ['s', 'd']
                                    ])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
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
