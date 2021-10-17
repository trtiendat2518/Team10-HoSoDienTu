<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/student/img/vlu.ico')}}">
    <title>Xtreme admin Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="{{ asset('public/lecturer/css/style.min.css')}}" rel="stylesheet">
    <!---Font icons css-->
    <link href="{{asset('public/lecturer/plugins/iconfonts/plugin.css')}}" rel="stylesheet" />
    <link href="{{asset('public/lecturer/plugins/iconfonts/icons.css')}}" rel="stylesheet" />
    <link  href="{{asset('public/lecturer/fonts/fonts/font-awesome.min.css')}}" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center background-login">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="{{asset('public/student/img/vlu.ico')}}" alt="logo" /></span>
                        <h5 class="m-b-20 mt-3">Đăng nhập hệ thống</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" id="loginform" action="{{ url('admin/loged-in') }}" method="POST">
                                @csrf
                                <div class="results">
                                    @if (Session::get('fail'))
                                    <div class="alert alert-danger">
                                      {{ Session::get('fail') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="Tên đăng nhập" aria-label="Username" aria-describedby="basic-addon1" name="admin_username">
                                </div>
                                <span class="text-danger">@error('admin_username') {{ $message }} @enderror</span>

                                <div class="input-group mt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" placeholder="Mật khẩu" aria-label="Password" aria-describedby="basic-addon1" name="admin_password">
                                </div>
                                <span class="text-danger">@error('admin_password') {{ $message }} @enderror</span>

                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Quên mật khẩu?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Đăng nhập</button>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <p>&mdash;&mdash; <b>Cách khác</b> &mdash;&mdash;</p>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <a href="{{ route('connectMs') }}" class="btn btn-block btn-lg btn-googleplus">Đăng nhập Offcie 365</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('public/lecturer/js/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('public/lecturer/plugins/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('public/lecturer/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- ============================================================== -->
</body>

</html>