@extends('lecturer.layout');
@section('lecturer-content')
<div class="app-content  my-3 my-md-5 toggle-content" id="app">
	<div class="side-app" style="padding-top: 0px;">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page" style="font-size: 30px">{{ $meta_title }}</li>
			</ol>
		</div>
		<!-- End page-header -->

		{{-- <div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Danh sách giảng viên</h3>
					</div>
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap" >
							<thead  class="blue-background text-white">
								<tr >
									<th class="text-white">ID</th>
									<th class="text-white">Họ tên</th>
									<th class="text-white">Địa chỉ Email</th>
									<th class="text-white">Vai trò</th>
									<th style="width: 10px;"></th>
									<th style="width: 10px;"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td><a href="#">Giảng viên 1</a></td>
									<td>giangvien1@vlu.edu.vn</td>
									<td>BCN Khoa</td>
									<td style="text-align: center">
										<a href="" class="active styling-edit" ui-toggle-class="">
											<i class="fa fa-pencil-square-o text-success text-active"></i>
										</a>
									</td>
									<td>
										<a href="" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
											<i class="fa fa-trash text-danger text"></i>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div> --}}
		<lecturer-manage-component></lecturer-manage-component>
	</div>
</div>
@endsection