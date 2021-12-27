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
						<!-- <div class="col-md-3">
							<select class="form-control mt-2" v-model="value_class">
								<option value="" disabled selected>Lọc theo chuyên ngành</option>
								<option :value="">Chưa có lớp</option>
							</select>
						</div> -->
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
									<th class="text-white w-20">Đảm nhiệm lớp</th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="formteachers.length" v-for="formteacher in formteachers" :key="formteacher.form_teacher_id">
									<td @click="detail(formteacher)"><a href="javascript:void(0)">{{ formteacher.lecturer_fullname }}</a></td>
									<td>{{ formteacher.lecturer_email }}</td>
									<td>
										<div v-if="formteacher.form_teacher_class==null ">
											Chưa có
										</div>
										<div v-else>
											{{ nameClass(formteacher) }}
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(formteacher)"></button>
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
		<div class="modal fade" id="LecturerModal" tabindex="-1" role="dialog" aria-labelledby="LecturerModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="update()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="LecturerModalTitle">Cập nhật tài khoản</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Họ và tên</label>
							<input v-model="form.lecturer_fullname" type="text" name="lecturer_fullname" class="form-control not-allowed mb-3" disabled>

							<label>Địa chỉ Email</label>
							<input v-model="form.lecturer_email" type="text" name="lecturer_email" class="form-control not-allowed" disabled>

							<label class="mt-3">Lớp đảm nhiệm</label>
							<select v-model="form.form_teacher_class" name="form_teacher_class" class="form-control select-option">
								<option :value="null" disabled>Chưa có lớp đảm nhiệm</option>
								<option v-for="classt in classes" :key="classt.class_id" :value="classt.class_id" :hidden="classt.class_state>0">{{ classt.course_name }} - Lớp {{ classt.class_name }}</option>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
							<button type="submit" class="btn btn-primary background-update btn-3d">Cập nhật</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal end-->

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
				lecturers:[],
				lecturer_id: this.$facultyId,
				lecturer_faculty:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					lecturer_fullname:'',
					lecturer_email: '',
					form_teacher_id:'',
					form_teacher_code:'',
					form_teacher_class:'',
					form_teacher_status: '',
				}),
				selected: [],
				selectAll: false,
				details:[],
				value_class:'',
			};
		},
		mounted() {
			this.fetchFormTeachers();
			this.fetchLecturers();
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
			value_class(value){
				if(value === ''){
					this.fetchFormTeachers();
				}else{
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		methods: {
			empty() {
				return (this.formteachers.length < 1);
			},
			fetchFormTeachers(page_url) {
				let vm = this;
				page_url = `../../api/admin/user-cn/chu-nhiem-sinh-vien/showdata/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.formteachers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			fetchLecturers(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-gv/giang-vien/lecturer';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.lecturers.forEach((el) => {
						if(el.lecturer_id==this.lecturer_id){
							this.lecturer_faculty= el.lecturer_faculty;
						}
					});
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
				page_url = `../../api/admin/user-cn/chu-nhiem-sinh-vien/search/${this.lecturer_id}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.formteachers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			show(formteacher) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(formteacher);
				$('#LecturerModal').modal('show');
			},
			update() {
				this.form.put(`../../api/admin/user-cn/chu-nhiem-sinh-vien/${this.form.form_teacher_id}`)
				.then(res => {
					this.fetchFormTeachers();
					this.fetchClasses();
					$('#LecturerModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật thành công');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			detail(formteacher, page_url) {
				let vm = this;
				page_url = `../../api/admin/user-cn/chu-nhiem-sinh-vien/detail/${formteacher.form_teacher_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					if (res.data.length===0) {
						this.$snotify.error('Chủ nhiệm sinh viên này chưa có thông tin!');
					}else {
						$('#DetailModal').modal('show');
					}
				})
				.catch(err => this.$snotify.error('Giảng viên chưa cập nhật thông tin'));
			},
			// filter(page_url) {
			// 	let vm = this;
			// 	page_url = `../../api/admin/user-cn/chu-nhiem-sinh-vien/filter/${this.lecturer_id}/${this.value_class}/${this.currentEntries}?page=${this.pagination.current_page}`;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.formteachers = res.data;
			// 		this.pagination = res.meta;
			// 	})
			// 	.catch(err => console.log(err));
			// },
			nameClass(formteacher) {
				const name = this.classes.find((cls) => cls.class_id === formteacher.form_teacher_class);
			    return name.course_code + ' - ' + name.class_name;
			},
			reload(){
				this.fetchFormTeachers();
				this.query='';
				this.value_class='';
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
