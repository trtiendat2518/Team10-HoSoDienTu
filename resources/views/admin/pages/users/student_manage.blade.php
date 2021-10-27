@extends('admin.layout');
@section('admin-content')
<div class="app-content  my-3 my-md-5 toggle-content" id="app">
	<div class="side-app" style="padding-top: 0px;">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page" style="font-size: 30px">{{ $meta_title }}</li>
			</ol>
		</div>
		<!-- End page-header -->
		<student-manage-component></student-manage-component>
	</div>
</div>
@endsection