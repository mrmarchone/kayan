@extends('layouts.app')
@section('title')
    Permissions / {{$permission->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Permissions'])
            @can('view permissions')
                <a href="{{route('permissions.index')}}" class="btn btn-primary mb-2">Permissions list</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update ( {{$permission->name}} ) permission</h4>
                            <form action="{{route('permissions.update', $permission->hashId)}}" method="POST">
                                @method('PAtCH')
                                @csrf
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('name', $permission->name)}}"
                                               id="name"
                                               name="name">
                                        @error('name')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="group" class="col-md-2 col-form-label">Group</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('group', $permission->group)}}"
                                               id="group"
                                               name="group">
                                        @error('group')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="guard_name" class="col-md-2 col-form-label">Guard Name</label>
                                    <div class="col-md-10">
                                        <select name="guard_name" class="form-control" id="guard_name">
                                            @foreach(config('auth.guards') as $key => $value)
                                                <option {{$permission->guard_name == $key ? 'selected' : ''}} value="{{$key}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('guard_name')
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
