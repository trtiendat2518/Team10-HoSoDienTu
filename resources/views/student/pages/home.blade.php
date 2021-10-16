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
    <header class="header">
        <div class="header-actions">
            <div class="header-brand">
                <div class="logo">
                    <img src="{{asset('public/student/img/vlu.ico')}}" alt="">
                </div>
                <h1 class="header-brand-text">Student E-Profile</h1>
            </div>
        </div>

        <div class="action-item dark header-settings-dropdown-trigger" data-toggle="modal" data-target="#loginModal">
            <a>
                <svg class="action-item-icon icon-login">
                    <use xlink:href="#svg-login"></use>
                </svg>
            </a>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 10%;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <button type="button" style="cursor: pointer; border: 3px solid #fc7f03">
                            <img src="{{ asset('public/homestudent/images/login.png') }}" width="30%" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--//END HEADER -->

<!-- SLIDER -->
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
                        <h1>Creative Thinking &amp; Innovation</h1>
                        <h4>Proactively utilize open-source users for process-centric total linkage.
                            <br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.
                        </h4>
                        <div class="slider-btn">
                            <a href="#" class="btn btn-default">SEE Programs</a>
                            <a href="#" class="btn btn-default">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block" src="{{asset('public/homestudent/images/slider-5.jpg')}}" alt="Second slide">
                <div class="carousel-caption d-md-block">
                    <div class="slider_title bg-text">
                        <h1>We foster wisdom</h1>
                        <h4>Proactively utilize open-source users for process-centric total linkage.<br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.</h4>
                        <div class="slider-btn">
                            <a href="#" class="btn btn-default">SEE Programs</a>
                            <a href="#" class="btn btn-default">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block" src="{{asset('public/homestudent/images/slider-4.jpg')}}" alt="Third slide">
                <div class="carousel-caption d-md-block">
                    <div class="slider_title bg-text">
                        <h1>Campus life @ Unisco</h1>
                        <h4>Proactively utilize open-source users for process-centric total linkage.<br> Energistically reinvent web-enabled initiatives with premium <br>processes. Proactively drive.</h4>
                        <div class="slider-btn">
                            <a href="campus-life.html" class="btn btn-default">Campus Life</a>
                        </div>
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
<!-- /SLIDER -->

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
                <p>Chúng tôi đảm nhiệm sự giáo dục và đào tạo các bạn trở thành công dân toàn cầu, với kinh nghiệm trong việc đào tạo hơn 50 nghành nghề khác nhau trong hơn 20 năm, chúng tôi tự tin về sứ mệnh này. 
                    <br>Đạo đức - Ý chí - Sáng tạo
                </p>
                <img src="{{asset('public/homestudent/images/vlu.png')}}" class="img-fluid" alt="welcom-img">
            </div>
        </div>
    </div>
</section>
<!--//END ABOUT -->
<!--============================= OUR COURSES =============================-->
<section class="our_courses">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Thông báo chung</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="courses_box mb-5">
                    <div class="course-img-wrap">
                        <img src="{{asset('public/homestudent/images/courses_1.jpg')}}" class="img-fluid" alt="courses-img">
                        <div class="courses_box-img">
                            <div class="courses-link-wrap">
                                <a href="course-detail.html" class="course-link"><span>course Details </span></a>
                                <a href="admission-form.html" class="course-link"><span>Join today </span></a>
                            </div>
                            <!-- // end .courses-link-wrap -->
                        </div>
                    </div>
                    <!-- // end .course-img-wrap -->
                    <div class="courses_icon">
                        <img src="{{asset('public/homestudent/images/plus-icon.png')}}" class="img-fluid close-icon" alt="plus-icon">
                    </div>
                    <a href="course-detail.html" class="course-box-content">
                        <h3>Sử dụng email</h3>
                        <p>Với mong muốn cung cấp thông tin đầy đủ, kịp thời đến sinh viên,...</p>
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="courses_box mb-5">
                    <div class="course-img-wrap">
                        <img src="{{asset('public/homestudent/images/courses_2.jpg')}}" class="img-fluid" alt="courses-img">
                        <div class="courses_box-img">
                            <div class="courses-link-wrap">
                                <a href="course-detail.html" class="course-link"><span>course Details </span></a>
                                <a href="admission-form.html" class="course-link"><span>Join today </span></a>
                            </div>
                            <!-- // end .courses-link-wrap -->
                        </div>
                    </div>
                    <!-- // end .course-img-wrap -->
                    <div class="courses_icon">
                        <img src="{{asset('public/homestudent/images/plus-icon.png')}}" class="img-fluid close-icon" alt="plus-icon">
                    </div>
                    <a href="course-detail.html" class="course-box-content">
                        <h3>Học phí</h3>
                        <p>Cách thức đóng học phí như thế nào?...</p>
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="courses_box mb-5">
                    <div class="course-img-wrap">
                        <img src="{{asset('public/homestudent/images/courses_3.jpg')}}" class="img-fluid" alt="courses-img">
                        <div class="courses_box-img">
                            <div class="courses-link-wrap">
                                <a href="course-detail.html" class="course-link"><span>course Details </span></a>
                                <a href="admission-form.html" class="course-link"><span>Join today </span></a>
                            </div>
                            <!-- // end .courses-link-wrap -->
                        </div>
                    </div>
                    <!-- // end .course-img-wrap -->
                    <div class="courses_icon">
                        <img src="{{asset('public/homestudent/images/plus-icon.png')}}" class="img-fluid close-icon" alt="plus-icon">
                    </div>
                    <a href="course-detail.html" class="course-box-content">
                        <h3>Đăng ký môn</h3>
                        <p>Hướng dẫn sinh viên đăng ký môn học...</p>
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="courses_box mb-5">
                    <div class="course-img-wrap">
                        <img src="{{asset('public/homestudent/images/courses_4.jpg')}}" class="img-fluid" alt="courses-img">
                        <div class="courses_box-img">
                            <div class="courses-link-wrap">
                                <a href="course-detail.html" class="course-link"><span>course Details </span></a>
                                <a href="admission-form.html" class="course-link"><span>Join today </span></a>
                            </div>
                            <!-- // end .courses-link-wrap -->
                        </div>
                    </div>
                    <!-- // end .course-img-wrap -->
                    <div class="courses_icon">
                        <img src="{{asset('public/homestudent/images/plus-icon.png')}}" class="img-fluid close-icon" alt="plus-icon">
                    </div>
                    <a href="course-detail.html" class="course-box-content">
                        <h3>Anh văn đầu vào</h3>
                        <p>Trường sẽ tổ chức thi anh văn đầu vào cho khóa mới...</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-default btn-courses">Xem tất cả</a>
            </div>
        </div>
    </div>
</section>
<!--//END OUR COURSES -->
<!--============================= EVENTS =============================-->
<section class="event">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Upcoming Events</h2>
                <div class="event-img">
                    <span class="event-img_date">06-Nov-17</span>
                    <img src="{{asset('public/homestudent/images/upcoming-event-img.jpg')}}" class="img-fluid" alt="event-img">
                    <div class="event-img_title">
                        <h3>Event Heading</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the ...</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Important Dates</h2>
                <div class="event-date-slide">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>06</p>
                                    <span>Nov.17</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Eestibulum sodales metus.</h3>
                                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book ...</p>
                                <hr class="event_line">
                            </div>
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>10</p>
                                    <span>Nov.17</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Integer faucibus nulla a ligula.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever...</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>05</p>
                                    <span>Oct.17</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Eestibulum sodales metus.</h3>
                                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book ...</p>
                                <hr class="event_line">
                            </div>
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>06</p>
                                    <span>Nov.17</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Integer faucibus nulla a ligula.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever...</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>06</p>
                                    <span>Sep.18</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Eestibulum sodales metus.</h3>
                                <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book ...</p>
                                <hr class="event_line">
                            </div>
                            <div class="event_date">
                                <div class="event-date-wrap">
                                    <p>06</p>
                                    <span>Mar.17</span>
                                </div>
                            </div>
                            <div class="date-description">
                                <h3>Integer faucibus nulla a ligula.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--//END EVENTS -->
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
<!--//END DETAILED CHART -->
<!--============================= OUR BLOG =============================-->
<section class="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Bản tin Văn Lang</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <a href="blog-post.html" class="home_blog_link">
                    <div class="blog-img_box">
                        <img src="{{asset('public/homestudent/images/blog-img_1.jpg')}}" class="img-fluid blog_display" alt="blog-img">
                        <div class="blogtitle">
                            <h3>Eestibulum sodales</h3>
                            <i class="icon-user fa-common" aria-hidden="true"></i>
                            <p>by: admin</p>
                            <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                            <p>9- Nov-2016</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="blog-post.html" class="home_blog_link">
                    <div class="blog-img_box">
                        <img src="{{asset('public/homestudent/images/blog-img_2.jpg')}}" class="img-fluid blog_display" alt="blog-img">
                        <div class="blogtitle">
                            <h3>Variations of passages</h3>
                            <i class="icon-user fa-common" aria-hidden="true"></i>
                            <p>by: admin</p>
                            <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                            <p>9- Nov-2016</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="blog-post.html" class="home_blog_link">
                    <div class="blog-img_box">
                        <img src="{{asset('public/homestudent/images/blog-img_3.jpg')}}" class="img-fluid blog_display" alt="blog-img">
                        <div class="blogtitle">
                            <h3>Lorem Ipsum passage</h3>
                            <i class="icon-user fa-common" aria-hidden="true"></i>
                            <p>by: admin</p>
                            <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                            <p>9- Nov-2016</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="blog-post.html" class="home_blog_link">
                    <div class="blog_hide">
                        <i class="icon-link" aria-hidden="true"></i>
                        <p class="m-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been dummy...</p>
                        <div class="blogtitle-link">
                            <i class="icon-user fa-common" aria-hidden="true"></i>
                            <p>by: admin</p>
                            <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                            <p>9- Nov-2016</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="blog-post.html" class="home_blog_link">
                    <div class="blog-img_box">
                        <div class="blog-video">
                            <div class="blog-play_btn"> <img src="{{asset('public/homestudent/images/play-btn.png')}}" alt="play-btn"> </div>
                            <img src="{{asset('public/homestudent/images/blog-img_4.jpg')}}" class="img-fluid blog_display" alt="blog-img">
                        </div>
                        <!-- // end .blog-video -->
                        <div class="blogtitle">
                            <h3>Nam libero tempore</h3>
                            <i class="icon-user fa-common" aria-hidden="true"></i>
                            <p>by: admin</p>
                            <i class="icon-speedometer fa-common" aria-hidden="true"></i>
                            <p>9- Nov-2016</p>
                        </div>
                    </div>
                </a>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-default btn-courses">Xem tất cả</a>
            </div>
        </div>
    </div>
</section>
<!--//END OUR BLOG -->

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
                    Tuyển sinh: 028.7105 9999   |   Đào tạo: 028.7109 9221</p>
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

<script src="{{asset('public/student/js/header/header.js')}}"></script>
<script src="{{asset('public/student/js/utils/svg-loader.js')}}"></script>
</body>
</html>
