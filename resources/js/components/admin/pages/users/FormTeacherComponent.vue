<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Giảng viên</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách chủ nhiệm sinh viên</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row ml-2">
						<div class="col-md-10">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-2 float-right">
							<div class="between:flex bottom:margin-3 ml-2">
								<div class="center:flex-items">
									<span class="right:marign-1">Hiển thị</span>
									<select class="select form-control-styling" v-model="currentEntries">
										<option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap">
							<thead  class="blue-background text-white">
								<tr>
									<th class="text-white w-40">Họ tên</th>
									<th class="text-white w-35">Địa chỉ Email</th>
									<th class="text-white w-25">Đảm nhiệm lớp học</th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="formteachers.length" v-for="formteacher in formteachers" :key="formteacher.lecturer_id">
									<td @click="detail(formteacher)"><a href="javascript:void(0)">{{ formteacher.lecturer_fullname }}</a></td>
									<td>{{ formteacher.lecturer_email }}</td>
									<td>
										<div v-if="classCount(formteacher).length == 0">
											Chưa đảm nhiệm lớp nào
										</div>
										<div v-else>
											<span v-for="cls in classCount(formteacher)" :key="cls.class_id">
												{{ cls.course_code }}-{{ cls.class_name }};
											</span>
										</div>
									</td>
								</tr>
								<tr v-show="!formteachers.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchFormTeachers() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade bd-example-modal-lg" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header styling-modal-header-info">
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết tài khoản</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" v-show="details.length" v-for="info in details" :key="info.lecturer_info_id">
						<center>
							<img src="('public/lecturer/images/vlu.ico')" class="avatar-xxl rounded-circle" alt="profile">
							{{ info.lecturer_avatar }}
						</center>
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong td-borderight"><h3><strong> Thông tin chi tiết Giảng viên</strong></h3></td>
								</tr>
								<tr class="td-borderight">
									<td>Họ và tên: <strong> {{ info.lecturer_fullname }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Dân tộc: <strong> {{ info.lecturer_ethnic }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Tôn giáo: <strong> {{ info.lecturer_religion }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td >Giới tính: 
										<strong v-if="info.lecturer_gender==0"> Nam</strong>
										<strong v-else> Nữ</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Ngày sinh: <strong> {{ info.lecturer_birthday | formatDate }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Nơi sinh: <strong> {{ info.lecturer_birth_place }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Quốc gia: <strong> {{ info.lecturer_country }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>CMND/CCCD: <strong> {{ info.lecturer_identify_card }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Địa chỉ: <strong> {{ info.lecturer_address }}</strong></td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong" colspan="2"><h3><strong>Thông tin Khoa</strong></h3></td>
								</tr>
								<tr>
									<td>Khoa: <strong> {{ info.faculty_name }}</strong></td>
								</tr>
								<tr>
									<td>Chức vụ: 
										<strong v-if="info.lecturer_role==2"> Chủ nhiệm sinh viên</strong>
										<strong v-else-if="info.lecturer_role==1"> Ban chủ nhiệm khoa</strong>
										<strong v-else> Giảng viên</strong>
									</td>
								</tr>

								<tr class="td-borderbottom">
									<td>Cấp bậc: 
										<strong v-if="info.lecturer_level==2"> Phó Khoa</strong>
										<strong v-else-if="info.lecturer_level==1"> Trưởng khoa</strong>
										<strong v-else> Không có</strong>
									</td>
								</tr>
								
								<br>
								<tr>
									<td class="h3-strong"><h3>
										<strong>Thông tin liên lạc</strong></h3>
									</td>
								</tr>
								<tr>
									<td>Số điện thoại: <strong> {{ info.lecturer_phone }}</strong></td>
								</tr>
								<tr>
									<td>Điện thoại bàn: <strong> {{ info.lecturer_deskphone }}</strong></td>
								</tr>
								<tr>
									<td>Email trường: <strong> {{ info.lecturer_email }}</strong></td>
								</tr>
								<tr>
									<td>Email cá nhân: <strong> {{ info.lecturer_other_email }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal end-->
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				classes:[],
				formteachers:[],
				lecturer_id: this.$facultyId,
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				selected: [],
				selectAll: false,
				details:[],
			};
		},
		mounted() {
			this.fetchFormTeachers();
			this.fetchClasses();
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchFormTeachers();
				}else{
					this.pagination=1;
					this.fetchFormTeachers();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchFormTeachers();
				}else{
					this.value_class='';
					this.pagination.current_page=1;
					this.search();
				}
			},
		},
		methods: {
			empty() {
				return (this.formteachers.length < 1);
			},
			fetchFormTeachers(page_url) {
				let vm = this;
				page_url = `../../api/admin/user-gv/giang-vien/show-formteacher/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.formteachers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			fetchClasses(page_url) {
				let vm = this;
				page_url = `../../api/admin/class-sv/lop/class-student/${this.lecturer_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.classes = res.data;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = `../../api/admin/user-gv/giang-vien/search-formteacher/${this.lecturer_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.formteachers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			detail(formteacher, page_url) {
				let vm = this;
				page_url = `../../api/admin/user-gv/giang-vien/detail/${formteacher.lecturer_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					if (res.data.length===0) {
						this.$snotify.error('Giảng viên chưa cập nhật thông tin');
					}else {
						$('#DetailModal').modal('show');
					}
				})
				.catch(err => this.$snotify.error('Giảng viên chưa cập nhật thông tin'));
			},
			classCount(formteacher) {
			    const count = this.classes.filter(cls => cls.class_form_teacher==formteacher.lecturer_id);
			    return count;
			},
			reload(){
				this.fetchFormTeachers();
				this.query='';
			},
		}
	};
</script>

<style scoped>
	.btn-eye {
		font-size: 18px;
		cursor: pointer;
		background: none;
		border: none;
	}
	.btn-eye-slash {
		font-size: 18px;
		cursor: pointer; 
		background: none;
		border: none;
		color: #868e96de;
	}
	.td-styling {
		text-align: center;
	}
	.not-allowed {
		cursor: not-allowed;
	}
	.select-option {
		cursor: pointer;
	}
	.h3-strong {
		color: #1753fc;
	}
	.styling-modal-header-info {
		background-color: darkblue;
		color: white;
	}
	.styling-font-modal-header {
		font-size: 20px;
		font-weight: bold;
	}
	.styling-modal-header-update {
		background-color: darkblue;
		color: white;
	}
	.td-borderight {
		border-right: 2px solid black;
	}
	.td-borderbottom {
		border-bottom: 2px solid black;
	}
	.background-update {
		background-color: darkblue;
		border-color: darkblue;
	}
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
