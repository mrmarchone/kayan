@extends('layouts.app')
@section('title')
    Notifications / {{$notification->id}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Notifications'])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            Notification {{$notification->id}}
                        </div>
                        @php
                            $link = $notification->data['link'];
                            $cols = [];
                            if($notification->data['model'] == 'scans') {
                                $cols['Total Results'] = $notification->data['results_count'];
                            } elseif($notification->data['model'] == 'demo_requests') {
                                $cols['Company'] = $notification->data['company'];
                            }
                        @endphp
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'Title' => $notification->data['title'],
                                    'Message' => $notification->data['message'],
                                    'Name' => $notification->data['name'],
                                    'Email' => $notification->data['email'],
                                    ...$cols,
                                    'Date' => $notification->created_at,
                                    'Options' => '<a href="' . $link . '" class="btn btn-primary">Show</a>',
                                ],
                                'type' => [
                                    'bool' => 'Options'
]
                            ])
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
