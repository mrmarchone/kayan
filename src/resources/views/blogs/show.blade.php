@extends('layouts.app')
@section('title')
    Blogs / {{$blog->slug}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Blog Details</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Blog</a></li>
                                <li class="breadcrumb-item active">Blog Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pt-3">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div>
                                            <div class="text-center">
                                                @can('update blogs')
                                                    <div class="edit mb-3">
                                                        <a href="{{route('blogs.edit', $blog->hashId)}}" class="btn btn-primary">Edit</a>
                                                    </div>
                                                @endcan
                                                <div class="mb-4">
                                                    <a href="javascript: void(0);" class="badge bg-light font-size-12">
                                                        <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{$blog->category->name}}
                                                    </a>
                                                </div>
                                                <h4>{{$blog->title}}</h4>
                                                <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i> {{$blog->created_at->format('d M, Y')}}</p>
                                            </div>

                                            <hr>
                                            <div class="text-center">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <p class="text-muted mb-2">Categories</p>
                                                            <h5 class="font-size-15">{{$blog->category->name}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="text-muted mb-2">Date</p>
                                                            <h5 class="font-size-15">{{$blog->created_at->format('d M, Y')}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="text-muted mb-2">Post by</p>
                                                            <h5 class="font-size-15">{{$blog->user->name}}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="my-5">
                                                <img src="{{asset('storage/posts/' . $blog->image)}}" alt="" class="img-thumbnail mx-auto d-block">
                                            </div>

                                            <hr>

                                            <div class="mt-4">
                                                {!! $blog->content !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
@push('end_css')
    <link href="{{asset('assets/css/prism.css')}}" rel="stylesheet"/>
@endpush
@push('mid_js')
    <script src="{{asset('assets/js/prism.js')}}"></script>
@endpush
