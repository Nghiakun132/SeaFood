<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trang đăng nhập</title>
    <link href="../backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../backend/img/2.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../backend/css/sb-admin-2.min.css" rel="stylesheet">


</head>
<style>
    .mt-5,
    .my-5 {
        margin-top: 11rem !important;
    }

</style>

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
                                        <h1 class="h4 text-gray-900 mb-4">Xin chào</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                value="{{ $cookie ? $cookie : '' }}"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" placeholder="Password">
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Đăng
                                            nhập</button>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../backend/vendor/jquery/jquery.min.js"></script>
    <script src="../backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../backend/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../backend/js/sb-admin-2.min.js"></script>

</body>
<?php
$errors = Session::get('error');
if ($errors) {
    echo "<script>alert('" . $errors . "')</script>";
}
?>

</html>
