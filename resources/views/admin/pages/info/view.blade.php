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
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card card-profile  overflow-hidden">
					<div class="card-body text-center profile-bg">
						<div class=" card-profile">
							<div class="row justify-content-center">
								<div class="">
									<div class="">
										<a href="#">
											<img src="('../public/lecturer/images/vlu.ico')" class="avatar-xxl rounded-circle" alt="profile">
										</a>
									</div>
								</div>
							</div>
						</div>
						<h3 class="mt-3 text-white">Alison</h3>
						<p class="mb-2 text-white">Web Designer</p>
						<a href="#" class="btn btn-light btn-lg"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Chỉnh sửa hồ sơ</a>
					</div>
				</div>
				<div class="card">
					<div class="card-body pb-0">
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade active show" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
								<div class="table-responsive mb-3">
									<table class="table row table-borderless w-100 m-0 border">
										<tbody class="col-lg-6 p-0">
											<tr>
												<td class="h3-strong"><h3><strong>Thông tin chi tiết</strong></h3></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Họ và tên: <strong> TrJoke</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Dân tộc: <strong> Kinh</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Tôn giáo: <strong> -</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td >Giới tính: <strong> Nam</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Ngày sinh: <strong> 15/08/2000</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Nơi sinh: <strong> TP.HCM</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Quốc gia: <strong> Việt Nam</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>CMND/CCCD: <strong> 123456789</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Địa chỉ: <strong> 99/20 Nguyễn Đình chiểu, Phường 04, Quận Phú Nhuận</strong></td>
											</tr>
										</tbody>
										<tbody class="col-lg-6 p-0">
											<tr>
												<td class="h3-strong"><h3>
													<strong>Thông tin liên lạc</strong></h3></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Số điện thoại: <strong> 0703537442</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Điện thoại bàn: <strong> -</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Email trường: <strong> dat.187pm06566@vanlanguni.vn</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Email cá nhân: <strong> hoangvu.tr2518@gmail.com</strong></td>
											</tr>
											<br>
											<tr>
												<td class="h3-strong" colspan="2"><h3><strong>Thông tin Khoa</strong></h3></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Khoa: <strong> Công nghệ thông tin</strong></td>
											</tr>
											<tr class="td-borderbottom">
												<td>Chức vụ: <strong> Ban chủ nhiệm khoa</strong></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
</div>
@endsection