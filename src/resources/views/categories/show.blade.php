@extends('layouts.app')
@section('title')
    Categories / {{$category->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Categories ' . $category->name])
            @can('create categories')
                <a href="{{route('categories.create')}}" class="btn btn-primary mb-2">Create category</a>
            @endcan
            @can('view categories')
                <a href="{{route('categories.index')}}" class="btn btn-info mb-2">Categories list</a>
            @endcan
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$category->name}} ) Category <a
                                href="{{route('categories.edit', $category->hashId)}}">Edit</a>
                        </div>
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'Category Name' => $category->name,
                                    'Category Slug' => $category->slug,
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
