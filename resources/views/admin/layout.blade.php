<!doctype html>
	<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="{{$meta_desc}}">
		<link rel="canonical" href="{{$url_canonical}}">
		<meta content="CAP - Team 10" name="author">
		<meta name="keywords" content=""/>
		@if (Session::get('admin_fullname'))
		<meta name="user-fullname" content="{{ Session::get('admin_fullname') }}">
		@elseif (Session::get('lecturer_id'))
		@foreach ($check_role as $check)
		@if ($check->lecturer_role==1 || $check->lecturer_role==2)
		<meta name="user-fullname" content="{{ Session::get('lecturer_id') }}">
		@endif
		@endforeach
		@endif

		<!-- Favicon -->
		<link rel="icon" type="image/ico" sizes="16x16" href="{{asset('public/student/img/vlu.ico')}}">
		<!-- Title -->
		<title>{{$meta_title}}</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="{{asset('public/lecturer/plugins/bootstrap/css/bootstrap.min.css')}}">
		<!-- Dashboard css -->
		<link href="{{asset('public/lecturer/css/style.css')}}" rel="stylesheet" />
		<!-- Sidemenu css -->
		<link href="{{asset('public/lecturer/plugins/toggle-sidebar/sidemenu.css')}}" rel="stylesheet" />
		<!--Daterangepicker css-->
		<link href="{{asset('public/lecturer/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
		<!-- Rightsidebar css -->
		<link href="{{asset('public/lecturer/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
		<!-- Sidebar Accordions css -->
		<link href="{{asset('public/lecturer/plugins/accordion1/css/easy-responsive-tabs.css')}}" rel="stylesheet">
		<!---Font icons css-->
		<link href="{{asset('public/lecturer/plugins/iconfonts/plugin.css')}}" rel="stylesheet" />
		<link href="{{asset('public/lecturer/plugins/iconfonts/icons.css')}}" rel="stylesheet" />
		<link  href="{{asset('public/lecturer/fonts/fonts/font-awesome.min.css')}}" rel="stylesheet">

	</head>

	<body class="app sidebar-mini rtl">

		<!--Global-Loader-->
		<div id="global-loader">
			<img src="{{asset('public/lecturer/images/icons/loader.svg')}}" alt="loader">
		</div>

		<div class="page" id="app">
			<div class="page-main">
				@include('admin.panels.header');
				
				@include('admin.panels.slidebar');
				
				@yield('admin-content');

				@include('admin.panels.footer');
			</div>
		</div>
		<!-- End Page -->

		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- Jquery js-->
		<script src="{{asset('public/lecturer/js/vendors/jquery-3.2.1.min.js')}}"></script>
		<!--Bootstrap.min js-->
		<script src="{{asset('public/lecturer/plugins/bootstrap/popper.min.js')}}"></script>
		<script src="{{asset('public/lecturer/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
		<!-- Star Rating js-->
		<script src="{{asset('public/lecturer/plugins/rating/jquery.rating-stars.js')}}"></script>
		<!--Moment js-->
		<script src="{{asset('public/lecturer/plugins/moment/moment.min.js')}}"></script>
		<!-- Daterangepicker js-->
		<script src="{{asset('public/lecturer/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
		<!--Side-menu js-->
		<script src="{{asset('public/lecturer/plugins/toggle-sidebar/sidemenu.js')}}"></script>
		<!-- Sidebar Accordions js -->
		<script src="{{asset('public/lecturer/plugins/accordion1/js/easyResponsiveTabs.js')}}"></script>
		<!-- Custom scroll bar js-->
		<script src="{{asset('public/lecturer/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
		<!-- Rightsidebar js -->
		<script src="{{asset('public/lecturer/plugins/sidebar/sidebar.js')}}"></script>
		<!-- Custom js-->
		<script src="{{asset('public/lecturer/js/custom.js')}}"></script>
		<script src="{{ asset('public/js/app.js') }}"></script>
	</body>
	</html>