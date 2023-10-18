<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>404 Dark Entry</title>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css"/>
</head>

<body>

<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <h1 class="display-2 fw-medium">5<i class="bx bx-buoy bx-spin text-primary display-3"></i><i
                            class="bx bx-buoy bx-spin text-primary display-3"></i></h1>
                    <h4 class="text-uppercase">Sorry, Something went wrong.</h4>
                    <div class="mt-5 text-center">
                        <a class="btn btn-primary waves-effect waves-light" href="{{route('home')}}">Take me back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-content-center align-items-center">
            <div class="col-sm-12">
                <div class="text-center">
                    <img src="{{asset('assets/images/hack.png')}}" alt="Hacking Page" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
