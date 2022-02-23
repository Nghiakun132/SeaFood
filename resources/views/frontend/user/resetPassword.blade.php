<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    <form class="user" action="{{route('postResetPassword',$token)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Email">
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Nhập mật khẩu" name="password">
                                        </div>
                                        @if ($errors->has('password'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Nhập lại mật khẩu" name="Repassword">
                                        </div>
                                        @if ($errors->has('password'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif

                                        <button  class="btn btn-primary btn-user btn-block">
                                            Đăng nhập
                                        </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>
</body>
<?php
    $success = Session::get('success');
    $error = Session::get('error');
    if($success){
        echo "<script>alert('$success')</script>";
    }elseif($error) {
         echo "<script>alert('$error')</script>";
    }
    Session::forget('success');
?>
</html>
