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
 	@if (Session::get('admin_id'))
 	<slidebar-admin-component></slidebar-admin-component>
 	@endif

 	@if (Session::get('lecturer_id'))
 	@foreach ($check_role as $check)
 	@if ($check->lecturer_role==1)
 	<slidebar-lecturer-component></slidebar-lecturer-component>
 	@elseif ($check->lecturer_role==2)
 	@endif
 	@endforeach
 	@endif
 	<br>
</aside>
<!--sidemenu end