@extends('layouts.app')
@section('title')
    Profile / {{$user->name}}
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('layouts.page_title', ['title' => 'Profile ' . $user->name])
            @error('password_need_to_change')
            <div class="row mb-3">
                <div aria-live="polite" aria-atomic="true">
                    <div class="toast fade show align-items-center text-white bg-danger border-0" role="alert"
                         aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{$message}}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            @enderror
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$user->name}} )
                        </div>
                        @include('layouts.components.show_card', [
                                'results' => [
                                    'User Name' => $user->name,
                                    'User Email' => $user->email,
                                    'User Company' => $user->company,
                                    'User Phone' => $user->phone,
                                    'Section' => $user->section?->name,
                                    'Country' => $user->country?->name,
                                    'Domains Limit' => $user->domains_limit,
                                    'Domains you inserted' => $user->domains_inserted_count,
                                    'User Type' => $user->type,
                                ]
                            ])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom">
                            ( {{$user->name}} )
                        </div>
                        <div class="card-body">
                            <form action="{{route('profile.change_password')}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="old_password"
                                           placeholder="Enter Old Password" name="old_password" required>
                                    @error('old_password')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="text-danger">
                                        password must add upper, lower letters, numbers and special characters
                                    </div>
                                    <label for="Password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="Password"
                                           placeholder="Enter Password" name="password" required>
                                    @error('password')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Password
                                        Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           placeholder="Enter password confirmation" required
                                           name="password_confirmation">
                                    @error('password_confirmation')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- end main content-->
@endsection
