@extends('layouts.authentication.app')
@section('title')
    Forget Password
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
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p>Reset Password with DarkEntry.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end pt-2">
                                    <img src="{{asset('assets/images/hack.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-dark">
                                                <img src="{{asset('assets/images/logo.png')}}" alt="DarkEntry Logo"
                                                     height="40">
                                            </span>
                                    </div>
                                </a>
                            </div>

                            <div class="p-2">
                                @if(session()->has('status'))
                                    <div class="alert alert-success text-center mb-4" role="alert">
                                        Enter your Email and instructions will be sent to you!
                                    </div>
                                @endif
                                <form class="form-horizontal" action="{{route('password.email')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="Enter email">
                                        @error('email')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                            Reset
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        @if(request()->has('l') && !empty(request()->l))
                            <p>Remember It ? <a href="{{route('login', request()->l)}}" class="fw-medium text-primary"> Sign In here</a>
                            </p>
                        @endif
                        <p>©
                            <script>document.write(new Date().getFullYear())</script>
                            DarkEntry. Crafted with <i class="mdi mdi-heart text-danger"></i> by DarkEntry
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
