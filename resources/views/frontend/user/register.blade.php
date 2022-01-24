<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Register</title>
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="{{route('postRegister')}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" value="{{Session::get('userResisgter') ? Session::get('userResisgter')->name : '' }}" class="form-control form-control-user"
                                        placeholder="First Name">
                                </div>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user"
                                        placeholder="Email Address" name="email" value="{{Session::get('userResisgter') ? Session::get('userResisgter')->email : '' }}">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="phone" class="form-control form-control-user" placeholder="phone"
                                        name="phone">
                                </div>
                                @if ($errors->has('phone'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" placeholder="Address"
                                        name="address">
                                </div>
                                @if ($errors->has('address'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            placeholder="Password" name="password">
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="re_password"
                                            placeholder="Repeat Password">
                                    </div>
                                </div>
                                @if ($errors->has('re_password') )
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('re_password') }}</strong>
                                    </div>
                                @endif
                                <input type="hidden" name="type" value="{{Session::get('userResisgter') ? 'Google' : 'Account' }}">
                                <input type="hidden" name="avatar" value="{{ Session::get('userResisgter') ? Session::get('userResisgter')->avatar : '' }}">
                                <button class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="{{route('login.google')}}" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                                {{-- <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> --}}
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
