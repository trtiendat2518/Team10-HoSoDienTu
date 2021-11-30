@extends('admin.layout');
@section('admin-content')
<!-- app-content-->
<div class="app-content toggle-content" >
	@if (Session::get('admin_id'))
	<div class="side-app" style="padding-top: 0px;">
		<main-component></main-component>
	</div>
	@elseif (Session::get('lecturer_id'))
	@foreach ($check_role as $check)
	@if ($check->lecturer_role==1 || $check->lecturer_role==2)
	<div class="side-app" style="padding-top: 0px;">
		<main-component></main-component>
	</div>
	@else
	<div class="side-app" style="padding-top: 0px;">
		<img src="{{ asset('public/lecturer/images/notice.png') }}" alt="">
	</div>
	@endif
	@endforeach
	@endif
	<!-- page-header -->
</div>
<!-- End app-content-->
@endsection