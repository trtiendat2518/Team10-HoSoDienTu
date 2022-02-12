<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đăng nhập</title>
    <link rel="icon" href="{{asset('public/student/img/vlu.ico')}}">

    <link rel="stylesheet" href="{{asset('public/homestudent/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/owl.carousel.min.css')}}">
    <link href="{{asset('public/homestudent/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/student/css/styles.min.css')}}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet">
</head>

<body>
    <!-- ========================= ABOUT IMAGE =========================-->
    <h2 class="text-center">
        <div class="mt-3">
            <a href="{{ url('/') }}" type="button">
                <img src="{{asset('public/homestudent/images/vlu.ico')}}" class="img-fluid" alt="logo">
            </a>
        </div>
        <div class="mt-5">
            Đăng nhập
        </div>
    </h2>
    <!--//END ABOUT IMAGE -->

    <div class="results mt-3 text-center">
        @if (Session::get('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
        @endif
    </div>

    <!--============================= Login =============================-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="login-overlay" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <a href="{{ route('connectStuMs') }}" type="button" class="btn btn-block" style="border: 3px solid #fc7f03">
                                            <img src=" {{ asset('public/homestudent/images/login.png') }}" width="30%" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--//End Login -->
    <!--============================= FOOTER =============================-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="foot-logo">
                        <a href="index.html">
                            <img src="{{asset('public/homestudent/images/vlu.ico')}}" class="img-fluid" alt="footer_logo">
                        </a>
                        <p>2021 © copyright
                            <br> All rights reserved.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sitemap">
                        <h3>Danh mục khác</h3>
                        <ul>
                            <li><a href="https://www.vanlanguni.edu.vn/" target="_blank">Trang tin chính thức</a></li>
                            <li><a href="https://www.vanlanguni.edu.vn/thu-vien-van-ban" target="_blank">Thư viện văn bản </a></li>
                            <li><a href="https://tuyendung.vanlanguni.edu.vn/" target="_blank">Thông tin tuyển dụng</a></li>
                            <li><a href="https://www.facebook.com/truongdaihocvanlang" target="_blank">Liên hệ</a></li>
                            <hr style="background-color: white;">
                            <li><a href="https://thuvien.vanlanguni.edu.vn/" target="_blank">Thư viện</a></li>
                            <li><a href="http://saudaihoc.vanlanguni.edu.vn/" target="_blank">Sau đại học</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 mt-3">
                    <div class="address">
                        <p><strong>TRƯỜNG ĐẠI HỌC VĂN LANG</strong></p>
                        <p><i class="fa fa-phone" aria-hidden="true"></i>
                            Tuyển sinh: 028.7105 9999 | Đào tạo: 028.7109 9221</p>
                        <p><i class="fa fa-headphones" aria-hidden="true"></i>
                            Hỗ trợ SV (Call Center): 028.7106 1111</p>
                        <p><i class="fa fa-envelope" aria-hidden="true"></i> info@vlu.edu.vn</p>

                        <p style="margin:0px">Cơ sở chính: 69/68 Đặng Thùy Trâm, P. 13, Q. Bình Thạnh, TP. HCM</p>
                        <p style="margin:0px">Cơ sở 1: 45 Nguyễn Khắc Nhu, P. Cô Giang, Q.1, TP. HCM</p>
                        <p style="margin:0px">Cơ sở 2: 233A Phan Văn Trị, P.11, Q. Bình Thạnh, TP. HCM</p>
                        <p style="margin:0px">Ký túc xá: 160/63A-B Phan Huy Ích, P. 12, Q. Gò Vấp, TP. HCM</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--//END FOOTER -->
    <!-- jQuery, Bootstrap JS. -->
    <script src="{{asset('public/homestudent/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/tether.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/bootstrap.min.js')}}"></script>
    <!-- Plugins -->
    <script src="{{asset('public/homestudent/js/slick.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/waypoints.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/counterup.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/instafeed.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/homestudent/js/validate.js')}}"></script>
    <script src="{{asset('public/homestudent/js/tweetie.min.js')}}"></script>
    <!-- Subscribe -->
    <script src="{{asset('public/homestudent/js/subscribe.js')}}"></script>
    <!-- Script JS -->
    <script src="{{asset('public/homestudent/js/script.js')}}"></script>
</body>

</html>
