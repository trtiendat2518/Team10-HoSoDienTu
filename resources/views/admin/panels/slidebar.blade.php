<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar toggle-sidebar">
	<div class="app-sidebar__user pb-0">
		<div class="user-body">
			<span class="avatar avatar-xxl brround text-center cover-image" data-image-src="{{asset('public/lecturer/images/users/female/33.png')}}"></span>
		</div>
		<div class="user-info mt-3">
			<a href="#" class="ml-2">
				<span class="text-dark app-sidebar__user-name font-weight-semibold">
					@php
					if(Session::get('admin_id')){
						echo Session::get('admin_fullname');
					}
					else if(Session::get('lecturer_id')){
						echo Session::get('lecturer_fullname');
					}
					@endphp
				</span>
				<br>
				@if (Session::get('admin_id'))
				<span class="app-sidebar__user-name text-sm"> Quản trị viên</span>
				@elseif (Session::get('lecturer_id'))
				@foreach ($check_role as $check)
				@if ($check->lecturer_role==1)
				<span class="app-sidebar__user-name text-sm"> BCN Khoa</span>
				@elseif ($check->lecturer_role==2)
				<span class="app-sidebar__user-name text-sm"> Chủ nhiệm sinh viên</span>
				@else
				<span class="app-sidebar__user-name text-sm"> Giảng viên mới</span>
				@endif
				@endforeach
				@endif
			</a>
		</div>
	</div>

	<div class="tab-menu-heading siderbar-tabs border-0  p-0">
		<div class="tabs-menu ">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
				<li class=""><a href="#index1" class="active" data-toggle="tab"><i class="fa fa-home fs-17"></i></a></li>
				<li><a href="#index3" data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
			</ul>
		</div>
	</div>

	<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
		<div class="tab-content">
			<div class="tab-pane active " id="index1">
				<ul class="side-menu toggle-menu">

					<li class="mb-2 ml-4"><span class="side-menu__label"><strong style="color: darkblue;">TRANG CHỦ</strong></span></li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('dashboard.index') }}">
							<i class="side-menu__icon typcn typcn-device-desktop"></i>
							<span class="side-menu__label">Dashboard</span>
						</a>
					</li>

					<li class="mt-5 mb-2 ml-4"><span class="side-menu__label"><strong style="color: darkblue;">QUẢN LÝ TÀI KHOẢN</strong></span></li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('lecturer.index') }}">
							<i class="side-menu__icon fa fa-users"></i>
							<span class="side-menu__label">Giảng viên</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('student.index') }}">
							<i class="side-menu__icon fa fa-graduation-cap"></i>
							<span class="side-menu__label">Sinh viên</span>
						</a>
					</li>

					<li class="mt-5 mb-2 ml-4"><span class="side-menu__label"><strong style="color: darkblue;">QUẢN LÝ CHUNG</strong></span></li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('faculty.index') }}">
							<i class="side-menu__icon fa fa-th-large"></i>
							<span class="side-menu__label">Khoa</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('major.index') }}">
							<i class="side-menu__icon fa fa-th-list"></i>
							<span class="side-menu__label">Chuyên ngành</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('course.index') }}">
							<i class="side-menu__icon fa fa-book"></i>
							<span class="side-menu__label">Khóa học</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="#">
							<i class="side-menu__icon fa fa-file-text"></i>
							<span class="side-menu__label">Thủ tục sinh viên</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="#">
							<i class="side-menu__icon fa fa-money"></i>
							<span class="side-menu__label">Học phí sinh viên</span>
						</a>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="#">
							<i class="side-menu__icon fa fa-newspaper-o"></i>
							<span class="side-menu__label">Bài viết - Tin tức</span>
						</a>
					</li>
					<br>
				</ul>
			</div>
		</div>
	</div>
</aside>
<!--sidemenu end-->