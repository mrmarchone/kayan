@extends('layouts.app')
@section('title')
    Users - {{$user->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Users'])
            @can('view users')
                <a href="{{route('users.index')}}" class="btn btn-primary mb-2">Users list</a>
            @endcan
            @can('create users')
                <a href="{{route('users.create')}}" class="btn btn-info mb-2">Create new users</a>
            @endcan
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit ( {{$user->name}} ) User</h4>
                            <form action="{{route('users.update', $user->hashId)}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('name', $user->name)}}"
                                               id="name"
                                               name="name">
                                        @error('name')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="email" class="col-md-2 col-form-label">Email</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('email', $user->email)}}"
                                               id="email"
                                               name="email">
                                        @error('email')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="company" class="col-md-2 col-form-label">Company</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('company', $user->company)}}"
                                               id="company"
                                               name="company">
                                        @error('company')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="phone" class="col-md-2 col-form-label">Phone</label>
                                    <div class="col-md-10">
                                        <input class="form-control"
                                               type="text"
                                               value="{{old('phone', $user->phone)}}"
                                               id="phone"
                                               name="phone">
                                        @error('phone')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="countries" class="col-md-2 col-form-label">Country</label>
                                    <div class="col-md-10">
                                        <select name="country_id" class="form-control" id="countries">
                                            @foreach($countries as $key => $value)
                                                <option
                                                    {{old('country_id', $user->country_id) == $value ? 'selected' : ''}} value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="roles" class="col-md-2 col-form-label">Role</label>
                                    <div class="col-md-10">
                                        <select name="role_id" class="form-control" id="roles">
                                            @foreach($roles as $key => $value)
                                                <option
                                                    {{old('role_id', $user->roles->first()?->id) == $value ? 'selected' : ''}} value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="sections" class="col-md-2 col-form-label">Industry</label>
                                    <div class="col-md-10">
                                        <select name="section_id" class="form-control" id="sections">
                                            @foreach($sections as $key => $value)
                                                <option
                                                    {{old('section_id', $user->section_id) == $value ? 'selected' : ''}} value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if(auth()->user()->type == 'admin')
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="type" class="col-md-2 col-form-label">Type</label>
                                        <div class="col-md-10">
                                            <select name="type" class="form-control" id="type">
                                                <option
                                                    {{old('type', $user->type) == 'admin' ? 'selected' : ''}} value="admin">
                                                    Admin
                                                </option>
                                                <option
                                                    {{old('type', $user->type) == 'client' ? 'selected' : ''}} value="client">
                                                    Client
                                                </option>
                                                <option
                                                    {{old('type', $user->type) == 'demo' ? 'selected' : ''}} value="demo">
                                                    Demo
                                                </option>
                                            </select>
                                            @error('type')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="results_count" class="col-md-2 col-form-label">Results Count</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number"
                                                   value="{{old('results_count', $user->settings->results_count)}}"
                                                   id="results_count" name="results_count">
                                            @error('results_count')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="breaches_limit" class="col-md-2 col-form-label">Breaches Search
                                            Limit</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number"
                                                   value="{{old('breaches_limit', $user->settings->breaches_limit)}}"
                                                   id="breaches_limit" name="breaches_limit">
                                            @error('breaches_limit')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if(auth()->user()->type == 'admin')
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="domains_limit" class="col-md-2 col-form-label">Domains Limit</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number"
                                                   value="{{old('domains_limit', $user->settings->domains_limit)}}"
                                                   id="domains_limit" name="domains_limit">
                                            @error('domains_limit')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="show_password" class="col-md-2 col-form-label">Show Password</label>
                                        <div class="col-md-10">
                                            <input class="form-check-input" type="checkbox"
                                                   id="show_password"
                                                   {{old('show_password', $user->settings->show_scan_results_password) ? 'checked' : ''}} name="show_password">
                                            @error('show_password')
                                            <p class="text-danger mt-2">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
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
