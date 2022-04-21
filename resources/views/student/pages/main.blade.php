<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang chủ</title>
    <link rel="icon" href="{{asset('public/student/img/vlu.ico')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('public/homestudent/css/bootstrap.min.css')}}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/homestudent/css/font-awesome.min.css')}}">
    <!-- Simple Line Font -->
    <link rel="stylesheet" href="{{asset('public/homestudent/css/simple-line-icons.css')}}">
    <!-- Slider / Carousel -->
    <link rel="stylesheet" href="{{asset('public/homestudent/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('public/homestudent/css/owl.carousel.min.css')}}">
    <!-- Main CSS -->
    <link href="{{asset('public/homestudent/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/student/css/styles.min.css')}}">
</head>

<body>
    <!--============================= HEADER =============================-->
    <header class="header" style="justify-content: space-between;">
        <div class="header-actions">
            <div class="header-brand">
                <div class="logo">
                    <img src="{{asset('public/student/img/vlu.ico')}}" alt="">
                </div>
                <h1 class="header-brand-text">Student E-Profile</h1>
            </div>
        </div>

        @if (Session::get('student_id'))
        <div class="action-item dark header-settings-dropdown-trigger">
            <a href="javascript:void(0)" class="nav-link siderbar-link" style="color: #fff;">
                <span style="color: #000;">
                    <strong>
                        @php
                        echo Session::get('student_fullname')
                        @endphp
                    </strong>
                </span>
            </a>
            <div class="dropdown">
                <a href="{{ url('student/logout-student') }}" class="nav-link icon siderbar-link" data-toggle="sidebar-right"
                    data-target=".sidebar-right" style="color: #fff;">
                    <i class="fa fa-sign-out"></i>
                </a>
            </div><!-- Right-siebar-->
        </div>
        @else
        <div class="action-item dark header-settings-dropdown-trigger" data-toggle="modal" data-target="#loginModal" style="margin-right: 20px">
            <a href="{{ url('/dang-nhap') }}">
                <svg class="action-item-icon icon-login">
                    <use xlink:href="#svg-login"></use>
                </svg>
            </a>
        </div>
        @endif

    </header>

    <!--============================= SLIDER =============================-->
    <div class="slider_img">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="d-block" src="{{asset('public/homestudent/images/slider-2.jpg')}}" alt="First slide">
                    <div class="carousel-caption d-md-block">
                        <div class="slider_title bg-text">
                            <h1>Đạo đức - Ý chí - Sáng tạo</h1>
                            <h4>Trường Đại học Văn Lang là cơ sở đào tạo nguồn nhân lực có chất lượng cao, đáp ứng yêu cầu của thị trường lao động và
                                đóng góp tích cực vào sự thay đổi lối sống, cách suy nghĩ và làm việc của con người thông qua giáo dục, nghiên cứu và
                                phục vụ cộng đồng..
                            </h4>
                            <div class="slider-btn">
                                <a href="{{ url('/home') }}" class="btn btn-default">Trang sinh viên</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block" src="{{asset('public/homestudent/images/slider-5.jpg')}}" alt="Second slide">
                    <div class="carousel-caption d-md-block">
                        <div class="slider_title bg-text">
                            <h1>Cẩm nang sinh viên</h1>
                            <h4>Nhà trường sẽ gửi Cẩm nang Sinh viên đến sinh viên vào đầu năm nhất, để các bạn sử dụng trong toàn khóa học. Mỗi năm,
                                cuốn sổ nhỏ này được biên tập, bổ sung những nội dung mới..</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block" src="{{asset('public/homestudent/images/slider-4.jpg')}}" alt="Third slide">
                    <div class="carousel-caption d-md-block">
                        <div class="slider_title bg-text">
                            <h1>Ký kết hợp tác quốc tế</h1>
                            <h4>Với mục tiêu cung cấp các chương trình đào tạo chất lượng, đạt tiêu chuẩn quốc tế cho người học, Trường Đại học Văn
                                Lang chủ động đẩy mạnh ký kết các biên bản ghi nhớ hợp tác với các trường đại học, viện nghiên cứu và doanh nghiệp
                                hàng đầu trên thế giới.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <i class="icon-arrow-left fa-slider" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <i class="icon-arrow-right fa-slider" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!--============================= ABOUT =============================-->
    <section class="clearfix about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Chào mừng bạn đến với Trường Đại học Văn Lang!</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Chúng tôi đảm nhiệm sự giáo dục và đào tạo các bạn trở thành công dân toàn cầu, với kinh nghiệm trong việc đào tạo hơn 50
                        nghành nghề khác nhau trong hơn 20 năm, chúng tôi tự tin về sứ mệnh này.
                        <br>Đạo đức - Ý chí - Sáng tạo
                    </p>
                    <img src="{{asset('public/homestudent/images/vlu.png')}}" class="img-fluid" alt="welcom-img">
                </div>
            </div>
        </div>
    </section>

    <!--============================= COMMON NOTIFICATION =============================-->
    <section class="our_courses">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Thông báo chung</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($post_noti as $post)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="courses_box mb-5">
                        <div class="course-img-wrap">
                            <img src="{{ asset('public/avatar/post/'.$post->post_avatar) }}" class="img-fluid" alt="courses-img"
                                style="height: 20vh" />
                            <div class="courses_box-img">
                                <div class="courses-link-wrap"></div>
                            </div>
                        </div>
                        <div class="courses_icon">
                            <img src="{{ asset('public/homestudent/images/plus-icon.png') }}" class="img-fluid close-icon" alt="plus-icon" />
                        </div>
                        <a href="{{ url('/home#/thong-bao-chung/'.$post->post_id) }}" class="course-box-content">
                            <h3>{{ Str::limit($post->post_title, 30) }}</h3>
                            <p class="mt-2">{!! Str::limit($post->post_content, 20) !!}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ url('/home#/thong-bao-chung') }}" class="btn btn-default btn-courses">Xem tất cả</a>
                </div>
            </div>
        </div>
    </section>

    <!--============================= DETAILED CHART =============================-->
    <div class="detailed_chart">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 chart_bottom">
                    <div class="chart-img">
                        <img src="{{asset('public/homestudent/images/chart-icon_1.png')}}" class="img-fluid" alt="chart_icon">
                    </div>
                    <div class="chart-text">
                        <p><span class="counter">9.000</span> Nhân viên
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 chart_bottom chart_top">
                    <div class="chart-img">
                        <img src="{{asset('public/homestudent/images/chart-icon_2.png')}}" class="img-fluid" alt="chart_icon">
                    </div>
                    <div class="chart-text">
                        <p><span class="counter">20.000</span> Sinh viên
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 chart_top">
                    <div class="chart-img">
                        <img src="{{asset('public/homestudent/images/chart-icon_3.png')}}" class="img-fluid" alt="chart_icon">
                    </div>
                    <div class="chart-text">
                        <p><span class="counter">50</span> Chuyên ngành
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="chart-img">
                        <img src="{{asset('public/homestudent/images/chart-icon_4.png')}}" class="img-fluid" alt="chart_icon">
                    </div>
                    <div class="chart-text">
                        <p><span class="counter">27</span> năm thành lập</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--============================= POST NEWS =============================-->
    <section class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Bản tin Văn Lang</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($post_news as $post)
                <div class="col-md-4">
                    <a href="{{ url('/home#/ban-tin-van-lang/'.$post->post_id) }}" class="home_blog_link">
                        <div class="blog-img_box">
                            <img src="{{ asset('public/avatar/post/'.$post->post_avatar) }}" class="img-fluid blog_display" alt="blog-img"
                                style="height: 30vh" />
                            <div class="blogtitle">
                                <h4>{{ Str::limit($post->post_title, 50) }}</h4>
                                <p class="mt-2">
                                    <i class="icon-user fa-common" aria-hidden="true"></i>
                                    Người đăng: {{ $post->post_author }}
                                </p>
                                <p>
                                    <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                                    Ngày đăng: {{ date('d-m-Y', strtotime($post->post_date)) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                <br />
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ url('/home#/ban-tin-van-lang') }}" class="btn btn-default btn-courses">
                        Xem tất cả
                    </a>
                </div>
            </div>
        </div>
    </section>


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
    <script src="{{asset('public/student/js/header/header.js')}}"></script>
    <script src="{{asset('public/student/js/utils/svg-loader.js')}}"></script>
    <script src="{{ asset('public/lecturer/js/vendors/jquery-3.2.1.min.js') }}"></script>
</body>

</html>
