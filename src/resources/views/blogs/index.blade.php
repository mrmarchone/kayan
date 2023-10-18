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
            <div class="row">
                @can('create blogs')
                    <div class="col-12 mb-3">
                        <a href="{{route('blogs.create')}}" class="btn btn-primary">Create New Post</a>
                    </div>
                @endcan
            </div>
            <div class="row">
                @forelse($blogs as $blog)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="card" style="padding: 0;border-radius: 15px">
                            <a href="{{route('blogs.show', $blog->hashId)}}" target="_blank">
                                <img class="card-img-top img-fluid"
                                     src="{{asset('storage/posts/' . $blog->image)}}"
                                     alt="{{$blog->title}}" title="{{$blog->title}}" style="border-radius: 15px 15px 0 0">
                            </a>
                            <div class="card-body">
                                @if($blog->type == 'premium')
                                    <p><i class="bx bxs-bookmark-star" style="color: red"></i> PREMIUM</p>
                                @else
                                    <p>FREE</p>
                                @endif
                                <h5 class="card-title" style="text-overflow: ellipsis;width: 100%;white-space: nowrap;overflow: hidden"><i
                                        class="bx bx-book-alt align-middle text-muted me-1"></i> {{$blog->title}}</h5>
                                <p><a href="javascript: void(0);" class="text-muted">
                                        <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i>
                                        {{$blog->category->name}}
                                    </a></p>
                                @can('update blogs')
                                    <a href="{{route('blogs.edit', $blog->hashId)}}"
                                       class="btn btn-primary">Edit</a>
                                @endcan
                                @can('delete blogs')
                                    <a href="#"
                                       onclick="element => element.preventDefault();this.nextElementSibling.submit();"
                                       class="btn btn-danger">Remove</a>
                                    <form
                                        action="{{route('blogs.destroy', $blog->hashId)}}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <p>Empty</p>
                    </div>
                @endforelse
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
