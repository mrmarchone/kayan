@extends('layouts.app')
@section('title')
    Industries - {{$section->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Industries ' . $section->name])
            @can('view sections')
                <a href="{{route('sections.index')}}" class="btn btn-primary mb-2">Industries list</a>
            @endcan
            @can('create sections')
                <a href="{{route('sections.create')}}" class="btn btn-info mb-2">Create new Industry</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit ( {{$section->name}} ) Industry</h4>
                            <form action="{{route('sections.update', $section->hashId)}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('name', $section->name)}}"
                                               id="name"
                                               name="name" required>
                                        @error('name')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" value="Update">
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
