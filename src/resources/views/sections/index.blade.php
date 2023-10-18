@extends('layouts.app')
@section('title')
    Industries
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Industries'])
            @can('create sections')
                <a href="{{route('sections.create')}}" class="btn btn-info mb-2">Create new Industry</a>
            @endcan

            <div class="row">
                <div class="col-12">
                    <h4 class="card-title">Industries</h4>
                    <table id="datatable" class="table table-bordered nowrap dataTables_scrollBody">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
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
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            ajax: "{{route('sections.data')}}",
            columns: [
                {data: "id", name: "id"},
                {data: "name", name: "name"},
                {data: "options", name: "options", orderable: false, searchable: false}
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
