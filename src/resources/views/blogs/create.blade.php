@extends('layouts.app')
@section('title')
    Blogs
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Blogs'])
            @can('view blogs')
                <a href="{{route('blogs.index')}}" class="btn btn-primary mb-2">Posts list</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create New Post</h4>
                            <form action="{{route('blogs.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="col-md-2 col-form-label">Title</label>
                                    <div class="col-md-12">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('title')}}"
                                               id="title"
                                               name="title" required>
                                        @error('title')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="col-md-2 col-form-label">Category</label>
                                    <div class="col-md-12">
                                        <select name="category_id" id="category_id" class="form-select">
                                            @foreach($categories as $key => $value)
                                                <option
                                                    {{old('category_id') == $value ? 'selected' : ''}} value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="col-md-2 col-form-label">Type</label>
                                    <div class="col-md-12">
                                        <select name="type" id="type" class="form-select">
                                            <option {{old('type') == 'free' ? 'selected' : ''}} value="free">Free
                                            </option>
                                            <option {{old('type') == 'paid' ? 'selected' : ''}} value="paid">Paid
                                            </option>
                                        </select>
                                        @error('type')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="col-md-2 col-form-label">Image</label>
                                    <div class="col-md-12">
                                        <input class="form-control"
                                               type="file"
                                               id="image"
                                               name="image" required>
                                        @error('image')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-12">
                                        <textarea id="elm1" name="content">{{old('content')}}</textarea>
                                        @error('content')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
@push('head_script')
    <!--tinymce js-->
    <script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/gf81ucoruuy40zgqprmz51w00q9r7ydc2mpi9u9xg8o9vpnm/tinymce/6/plugins.min.js" referrerpolicy="origin"></script>
@endpush
@push('mid_js')
    <!-- init js -->
    <script src="{{asset('assets/js/pages/form-editor.init.js')}}"></script>
@endpush
