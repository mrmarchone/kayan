@extends('layouts.authentication.app')
@section('title')
    Register
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
                                        <h5 class="text-primary">Free Register</h5>
                                        <p>Get your free DarkEntry account now.</p>
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
                                <form action="{{route('register')}}" method="POST">
                                    @csrf
                                    @if($errors->any())
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li class="text-danger">{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name"
                                               placeholder="Enter name" required name="name" value="{{old('name')}}">
                                        @error('name')
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                               placeholder="Enter email" required name="email" value="{{old('email')}}">
                                        @error('email')
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label for="Company" class="form-label">Company</label>
                                        <input type="text" class="form-control" id="Company"
                                               placeholder="Enter company" required name="company" value="{{old('company')}}">
                                        @error('company')
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone"
                                               placeholder="Enter phone" required name="phone" value="{{old('phone')}}">
                                        @error('phone')
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="country">Country</label>
                                        <select class="form-select" id="country" name="country">
                                            @foreach($countries as $key => $value)
                                                <option {{old('country') == $value ? 'selected' : ''}} value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
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

                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            Register
                                        </button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">By registering you agree to the DarkEntry <a href="#" class="text-primary">Terms of Use</a></p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Already have an account ? <a href="{{route('login')}}" class="fw-medium text-primary"> Login</a></p>
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
