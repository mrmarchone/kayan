@extends('layouts.authentication.app')
@section('title')
    Reset Password
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
                                <form class="form-horizontal" action="{{route('password.update')}}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="token" value="{{request()->segment(2)}}">
                                    <input type="hidden" name="email" value="{{request()->get('email')}}">
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

                                    <div class="mb-3">
                                        <label class="form-label">Password Confirmation</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password confirmation"
                                                   aria-label="password_confirmation" aria-describedby="password-addon" name="password_confirmation">
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password_confirmation')
                                        <p class="text-danger mt-2">{{$message}}</p>
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
