@extends('layouts.authentication.app')
@section('title')
    Login
@endsection
@section('body')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Sign in to continue to DarkEntry.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end pt-2">
                                    <img src="{{asset('assets/images/hack.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-dark">
                                                <img src="{{asset('assets/images/logo.png')}}" alt="DarkEntry Logo"
                                                     height="40">
                                            </span>
                                    </div>
                                </a>

                                <a href="" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.png')}}" alt="DarkEntry Logo"
                                                     height="40">
                                            </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal"
                                      action="{{route('login', request()->segment(2))}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="auth_url" value="{{request()->segment(2)}}">
                                    @error('error')
                                    <p class="text-danger mt-2">{{$message}}</p>
                                    @enderror
                                    @error('active')
                                    <p class="text-success mt-2">{{$message}}</p>
                                    @enderror
                                    @if(session()->has('status'))
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{session('status')}}
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="Email"
                                               placeholder="Enter Email" name="email">
                                        @error('email')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                   aria-label="Password" aria-describedby="password-addon" name="password">
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password')
                                        <p class="text-danger mt-2">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-check" name="remember">
                                        <label class="form-check-label" for="remember-check">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log In
                                        </button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{route('password.request')}}?l={{request()->segment(2)}}" class="text-muted"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            {{-- <p>Don't have an account ? <a href="{{route('register')}}" class="fw-medium text-primary"> Signup now </a></p> --}}
                            <p>©
                                <script>document.write(new Date().getFullYear())</script>
                                DarkEntry. Crafted with <i class="mdi mdi-heart text-danger"></i> by DarkEntry
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
