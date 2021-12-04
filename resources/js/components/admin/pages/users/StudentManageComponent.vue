<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Sinh viên</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách sinh viên</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-3">
							<select class="form-control mt-2" v-model="value_role">
								<option value="" disabled selected>Lọc thông tin</option>
								<option value="0">Sinh viên còn đang học</option>
								<option value="1">Sinh viên đã ra trường</option>
							</select>
						</div>
						<div class="col-md-2">
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
									<th class="w-5">
										<input type="checkbox" class="form-control" :disabled="empty()" @click="select()" v-model="selectAll">
									</th>
									<th class="text-white w-15">Mã số sinh viên</th>
									<th class="text-white w-25">Họ tên</th>
									<th class="text-white w-25">Địa chỉ Email</th>
									<th class="text-white w-15">Học tập</th>
									<th class="text-white w-5">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="students.length" v-for="student in students" :key="student.student_id">
									<td>
										<center><input type="checkbox" :value="student.student_id" v-model="selected"></center>
									</td>
									<td @click="detail(student)">
										<a href="javascript:void(0)">
											{{ student.student_code }}
										</a>
									</td>
									<td>{{ student.student_fullname }}</td>
									<td>{{ student.student_email }}</td>
									<td>
										<div v-if="student.student_role==1">
											Đã ra trường
										</div>
										<div v-else>
											Còn đang học
										</div>
									</td>
									<td class="td-styling">
										<div v-if="student.student_status==0">
											<button class="fa fa-eye btn-eye" @click="change(student.student_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(student.student_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(student)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(student.student_id)"></button>
									</td>
								</tr>
								<tr v-show="!students.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchStudents() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="StudentModal" tabindex="-1" role="dialog" aria-labelledby="StudentModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="update()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title styling-font-modal-header" id="StudentModalTitle">Cập nhật tài khoản</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Họ và tên</label>
							<input v-model="form.student_fullname" type="text" name="student_fullname" class="form-control not-allowed mb-3" disabled>

							<label>Địa chỉ Email</label>
							<input v-model="form.student_email" type="text" name="student_email" class="form-control not-allowed" disabled>

							
							<label class="mt-3">Vai trò</label>
							<select v-model="form.student_role" name="student_role" class="form-control select-option">
								<option value="0">Còn đang học</option>
								<option value="1">Đã ra trường</option>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button type="submit" class="btn btn-primary background-update">Cập nhật</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal end-->

		<div class="modal fade bd-example-modal-lg" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header styling-modal-header-info">
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết tài khoản</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" v-show="details.length" v-for="info in details" :key="info.student_info_id">
						<center>
							<img src="('../public/lecturer/images/vlu.ico')" class="avatar-xxl rounded-circle" alt="profile">
							{{ info.student_avatar }}
						</center>
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong td-borderight"><h3><strong>Thông tin chi tiết Sinh viên</strong></h3></td>
								</tr>
								<tr class="td-borderight">
									<td>Họ và tên: <strong> {{ form.student_fullname }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Dân tộc: <strong> {{ info.student_ethnic }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Tôn giáo: <strong> {{ info.student_religion }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td >Giới tính: 
										<strong v-if="info.student_gender==0"> Nam</strong>
										<strong v-else> Nữ</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Ngày sinh: <strong> {{ info.student_birthday | formatDate}}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Nơi sinh: <strong> {{ info.student_birth_place }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Quốc gia: <strong> {{ info.student_country }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>CMND/CCCD: <strong> {{ info.student_identify_card }}</strong></td>
								</tr>
								<tr class="td-borderight">
									<td>Địa chỉ: <strong> {{ info.student_address }}</strong></td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong" colspan="2"><h3><strong>Thông tin Khoa</strong></h3></td>
								</tr>
								<tr>
									<td>Khóa học: 
										<strong>{{ studentCourse(info) }}</strong>
									</td>
								</tr>
								<tr>
									<td>Khoa: 
										<strong>{{ studentFaculty(info) }}</strong>
									</td>
								</tr>
								<tr>
									<td>Chuyên ngành: 
										<strong>{{ studentMajor(info) }}</strong>
									</td>
								</tr>
								<tr>
									<td>Chức vụ: 
										<strong v-if="form.student_role==1"> Đã ra trường</strong>
										<strong v-else> Còn đang học</strong>
									</td>
								</tr>
								
								<br>
								<tr>
									<td class="h3-strong"><h3>
										<strong>Thông tin liên lạc</strong></h3>
									</td>
								</tr>
								<tr>
									<td>Số điện thoại: <strong> {{ info.student_phone }}</strong></td>
								</tr>
								<tr>
									<td>Điện thoại bàn: <strong> {{ info.student_deskphone }}</strong></td>
								</tr>
								<tr>
									<td>Email trường: <strong> {{ form.student_email }}</strong></td>
								</tr>
								<tr>
									<td>Email cá nhân: <strong> {{ info.student_other_email }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-body" v-show="!details.length">
						<div class="alert alert-danger">
							Giảng viên này chưa cập nhật thông tin!
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				courses:[],
				faculties:[],
				majors:[],
				students:[],
				student_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					student_id:'',
					student_code:'',
					student_fullname:'',
					student_email:'',
					student_role:'',
					student_status: ''
				}),
				selected: [],
				selectAll: false,
				details:[],
				value_role:'',
			}
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchStudents();
				}else{
					this.pagination=1;
					this.fetchStudents();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchStudents();
				}else{
					this.value_role='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_role(value){
				if(value === ''){
					this.fetchStudents();
				}else{
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchStudents();
			this.fetchCourses();
			this.fetchFaculties();
			this.fetchMajors();
		},
		methods: {
			empty() {
				return (this.students.length < 1);
			},
			fetchCourses(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-course/khoa-hoc/course';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.courses = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchFaculties(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-faculty/khoa/faculty';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.faculties = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchMajors(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-major/chuyen-nganh/major';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.majors = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchStudents(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/search/'+this.query+'/'+this.currentEntries+'?page=1';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			show(student) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(student);
				$('#StudentModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/user-sv/sinh-vien/'+this.form.student_id)
				.then(res => {
					this.fetchStudents();
					$('#StudentModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Vai trò của tài khoản đã thay đổi');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(student_id) {
				axios.patch(`../../api/admin/user-sv/sing-vien/change/${student_id}`)
				.then(res => {
					this.fetchStudents();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(student_id) {
				this.$snotify.clear();
				this.$snotify.confirm('Xác nhận xóa', {
					timeout: 5000,
					showProgressBar: true,
					closeOnClick: false,
					pauseOnHover: true,
					buttons: [{
						text: 'Xóa', 
						action: toast =>{
							this.$snotify.remove(toast.id);
							axios.delete(`../../api/admin/user-sv/sinh-vien/${student_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchStudents();
							})
							.catch(err => console.log(err));
						}, 
						bold: false
					},{
						text: 'Đóng', 
						action: toast => { 
							this.$snotify.remove(toast.id); 
						}, 
						bold: true
					}]
				});
			},
			destroyall() {
				this.$snotify.clear();
				this.$snotify.confirm('Xác nhận xóa', {
					timeout: 5000,
					showProgressBar: true,
					closeOnClick: false,
					pauseOnHover: true,
					buttons: [{
						text: 'Xóa', 
						action: toast =>{
							this.$snotify.remove(toast.id);
							axios.post('../../api/admin/user-sv/sinh-vien/destroyall', { student: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchStudents();
							})
							.catch(err => console.log(err));
						}, 
						bold: false
					},{
						text: 'Đóng', 
						action: toast => { 
							this.$snotify.remove(toast.id); 
						}, 
						bold: true
					}]
				});
			},
			select() {
				this.selected = [];
				if(!this.selectAll){
					for(let i in this.students){
						this.selected.push(this.students[i].student_id);
					}
				}
			},
			detail(student, page_url) {
				let vm = this;
				page_url = `../../api/admin/user-sv/sinh-vien/detail/${student.student_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					this.form.fill(student);
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/filter/'+this.value_role+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchStudents();
				this.query='';
				this.value_role='';
			},
			studentCourse(info) {
				const course = this.courses.find((crs) => crs.course_code === info.student_course);
				return course.course_code;
			},
			studentFaculty(info) {
				const faculty = this.faculties.find((fac) => fac.faculty_code === info.student_faculty);
				return faculty.faculty_name;
			},
			studentMajor(info) {
				const major = this.majors.find((mjr) => mjr.major_code === info.student_major);
				return major.major_name;
			},
		}
	};
</script>

<style lang="css" scoped>
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
</style>
