@extends('layouts.app')
@section('title')
    Industries / {{$section->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Sections ' . $section->name])
            @can('create sections')
                <a href="{{route('sections.create')}}" class="btn btn-primary mb-2">Create industry</a>
            @endcan
            @can('view sections')
                <a href="{{route('sections.index')}}" class="btn btn-info mb-2">Industries list</a>
            @endcan
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$section->name}} ) Industry <a
                                href="{{route('sections.edit', $section->hashId)}}">Edit</a>
                        </div>
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'Industry Name' => $section->name
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
