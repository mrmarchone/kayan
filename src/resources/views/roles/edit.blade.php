@extends('layouts.app')
@section('title')
    Roles - {{$role->name}} -  Edit
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Roles'])
            @can('create roles')
                <a href="{{route('roles.create')}}" class="btn btn-primary mb-2">Create role</a>
            @endcan
            @can('view roles')
                <a href="{{route('roles.index')}}" class="btn btn-info mb-2">Roles list</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit ( <span class="text-primary">{{$role->name}}</span> ) Role</h4>
                            <form action="{{route('roles.update', $role->hashId)}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('name', $role->name)}}"
                                               id="name"
                                               name="name">
                                        @error('name')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
{{--                                <div class="mb-3 row">--}}
{{--                                    <label for="guard_name" class="col-md-2 col-form-label">Guard Name</label>--}}
{{--                                    <div class="col-md-10">--}}
{{--                                        <select name="guard_name" class="form-control" id="guard_name">--}}
{{--                                            <option value="web">web</option>--}}
                                            {{--                                            @foreach(config('auth.guards') as $key => $value)--}}
                                            {{--                                                <option--}}
                                            {{--                                                    {{$role->guard_name == $key ? 'selected' : ''}} value="{{$key}}">{{$key}}</option>--}}
                                            {{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('guard_name')--}}
{{--                                        <p class="text-danger mt-2">{{$message}}</p>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                @if(auth()->user()->type == 'admin')
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="type" class="col-md-2 col-form-label">Type</label>
                                        <div class="col-md-10">
                                            <select name="type" class="form-control" id="type">
                                                <option
                                                    {{old('type', $role->type) == 'admin' ? 'selected' : ''}} value="admin">
                                                    Admin
                                                </option>
                                                <option
                                                    {{old('type', $role->type) == 'client' ? 'selected' : ''}} value="client">
                                                    Client
                                                </option>
                                                <option
                                                    {{old('type', $role->type) == 'demo' ? 'selected' : ''}} value="demo">
                                                    Demo
                                                </option>
                                            </select>
                                            @error('type')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div id="permissionListCheckboxes">
                                    <div class="buttons" id="buttons">
                                        <button id="selectAll">Select All</button>
                                        <button id="deselectAll">Deselect All</button>
                                    </div>
                                    <div class="row">
                                        @error('permissions')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                        @foreach($permissions as $key => $value)
                                            <div class="col-sm-3">
                                                <label for="guard_name"
                                                       class="col-sm-12 col-form-label">{{$key}}</label>
                                                @foreach($value as $permission)
                                                    <div class="col-md-10">
                                                        <div class="form-check mb-3">
                                                            <input
                                                                {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}} class="form-check-input"
                                                                type="checkbox"
                                                                id="permission{{$permission->id}}"
                                                                value="{{$permission->id}}" name="permissions[]">
                                                            <label class="form-check-label"
                                                                   for="permission{{$permission->id}}">
                                                                {{$permission->name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
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
@push('end_js')
    <script>
        let permissions = $('#permissionListCheckboxes').find('input[type=checkbox]');
        $('#selectAll').click(function (e) {
            e.preventDefault();
            permissions.attr('checked', 'checked');
        });
        $('#deselectAll').click(function (e) {
            e.preventDefault();
            permissions.removeAttr('checked');
        });
    </script>
@endpush
