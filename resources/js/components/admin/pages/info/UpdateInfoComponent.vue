<template>
	<div>
		<div class="row">
			<div class="col-lg-12 col-xl-4 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Cập nhật hình ảnh</h3>
						<div class="card-options">
							<a href="profile.html" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>Xem hồ sơ</a>
						</div>
					</div>
					<div class="card-body">
						<div class="text-center">
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 userprofile">
									<div class="userpic mb-2">
										<img src="'../public/lecturer/images/vlu.ico'">
									</div>
									<p class="text-center">Web Designer, USA</p>
									<div class="text-center">
										<a href="#" class="btn btn-primary mt-1"><i class="fe fe-camera  mr-1"></i>Thay đổi hình ảnh</a><br>
										<a href="#" class="btn btn-info mt-1 mb-3 mb-xl-0"><i class="fe fe-camera-off mr-1 mb-2"></i>Xóa hình ảnh</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-xl-8 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Cập nhật hồ sơ</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Họ và tên</label>
									<input type="text" class="form-control" placeholder="Nhập đầy đủ họ tên">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Địa chỉ Email</label>
									<input type="email" class="form-control" placeholder="Nhập địa chỉ email trường học">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Dân tộc</label>
									<select class="form-control">
										<option value="" disabled selected="">---</option>
										<option value="0">Kinh</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Tôn giáo</label>
									<select class="form-control">
										<option value="" disabled selected="">---</option>
										<option value="0">Bla blad</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-4 col-md-12">
								<div class="form-group">
									<label class="form-label">Ngày sinh</label>
									<input type="date" class="form-control">
								</div>
							</div>
							<div class="col-lg-2 col-md-12">
								<div class="form-group">
									<label class="form-label">Giới tính</label>
									<select class="form-control">
										<option value="" disabled selected="">---</option>
										<option value="0">Nam</option>
										<option value="1">Nữ</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Nơi sinh</label>
									<input type="text" class="form-control" placeholder="Nhập nơi sinh">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">CMND/CCCD</label>
									<input type="number" class="form-control" placeholder="Nhập CMND hoặc CCCD">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Quốc gia</label>
									<select class="form-control">
										<option value="" disabled selected="">---</option>
										<option value="0">Việt Nam</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Số điện thoại</label>
									<input type="number" class="form-control" placeholder="Nhập số điện thoại liên lạc">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Điện thoại bàn</label>
									<input type="number" class="form-control" placeholder="Nhập số điện thoại bàn">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Khoa</label>
									<select class="form-control">
										<option>aaa</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<label class="form-label">Địa chỉ Email cá nhân</label>
									<input type="email" class="form-control" placeholder="Nhập địa chỉ email cá nhân">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="form-label">Địa chỉ</label>
							<textarea class="form-control" rows="3" placeholder="Địa chỉ thường trú"></textarea>
						</div>
					</div>
					<div class="card-footer text-right">
						<a href="#" class="btn btn-success mt-1">Lưu</a>
						<a href="#" class="btn btn-warning mt-1">Hủy bỏ</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

	};	
</script>

<style lang="css" scoped>
</style>
