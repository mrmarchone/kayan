@extends('layouts.authentication.app')
@section('title')
    Verify Email
@endsection
@section('body')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 text-muted">
                        <a href="" class="d-block auth-logo">
                            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="130"
                                 class="auth-logo-dark mx-auto">
                            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="130"
                                 class="auth-logo-light mx-auto">
                        </a>
                        <p class="mt-3">Please verify your email to continue using our service.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body">

                            <div class="p-2">
                                <div class="text-center">

                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <h4>Verify your email</h4>
                                        <p>We have sent you verification email <span
                                                class="fw-semibold">{{auth()->user()->email}}</span>, Please check it
                                        </p>
                                        @if(session()->has('status'))
                                            <p class="text-success">{{session('status')}}</p>
                                        @endif
                                        <div class="mt-4">
                                            <a href="#" class="btn btn-success w-md" onclick="e => e.preventDefault();document.getElementById('resendForm').submit()">Resend</a>
                                            <form action="{{route('logout')}}" method="POST" id="logoutForm">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
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
