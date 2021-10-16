<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar toggle-sidebar">
	<div class="app-sidebar__user pb-0">
		<div class="user-body">
			<span class="avatar avatar-xxl brround text-center cover-image" data-image-src="{{asset('public/lecturer/images/users/female/33.png')}}""></span>
		</div>
		<div class="user-info mt-3">
			<a href="#" class="ml-2">
				<span class="text-dark app-sidebar__user-name font-weight-semibold">
					@php
            			echo Session::get('admin_fullname')
            		@endphp
				</span>
				<br>
				@if (Session::get('admin_id'))
					<span class="text-muted app-sidebar__user-name text-sm"> Administrator</span>
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
					<li class="slide">
						<a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon typcn typcn-info-outline"></i><span class="side-menu__label">Error Pages</span><i class="angle fa fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a href="400.html" class="slide-item"> 400 Error</a></li>
							<li><a href="401.html" class="slide-item"> 401 Error</a></li>
							<li><a href="403.html" class="slide-item"> 403 Error</a></li>
							<li><a href="404.html" class="slide-item"> 404 Error</a></li>
							<li><a href="500.html" class="slide-item"> 500 Error</a></li>
							<li><a href="503.html" class="slide-item"> 503 Error</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</aside>
<!--sidemenu end-->