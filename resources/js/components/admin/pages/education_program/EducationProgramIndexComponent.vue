<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Danh sách Chương trình đào tạo</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-info btn-lg mb-3" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
			</div>
			<!-- <div class="col-md-3">
				<button class="btn btn-import btn-lg mb-3" @click="openImport()"><li class="fa fa-upload"></li> Import</button>
				<button class="btn btn-export btn-lg mb-3" @click="exportFile()" name="export_csv"><li class="fa fa-download"></li> Export</button>
			</div> -->
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách Chương trình đào tạo</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div>
						<div class="col-md-4">
							<select class="form-control mt-2" v-model="value_choose">
								<option value="" disabled selected>Chọn kiểu lọc</option>
								<option disabled>----------------------------------------</option>
								<option value="choose_course">Lọc theo khóa học</option>
								<option value="choose_major">Lọc theo chuyên ngành</option>
							</select>
						</div>
						<div v-show="value_choose==='choose_course'" class="col-md-4">
							<select class="form-control mt-2" v-model="value_course">
								<option value="" disabled selected>Lọc theo Khóa học</option>
								<option disabled>----------------------------------------</option>
								<option v-for="course in courses" :value="course.course_code">{{ course.course_name }}</option>
							</select>
						</div>
						<div v-show="value_choose==='choose_major'" class="col-md-4">
							<select class="form-control mt-2" v-model="value_major">
								<option value="" disabled selected>Lọc theo chuyên ngành</option>
								<option disabled>----------------------------------------</option>
								<option v-for="major in majors" :value="major.major_code" :hidden="major.major_faculty != lecturer_faculty">{{ major.major_name }}</option>
							</select>
						</div>
						<div class="col-md-3">
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
									<th class="text-white w-15">Mã CTĐT</th>
									<th class="text-white w-45">Tên chương trình đào tạo</th>
									<th class="text-white w-10 text-center">Tổng năm học</th>
									<th class="text-white w-10 text-center">Tổng tín chỉ</th>
									<th class="text-white w-5 text-center">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="programs.length" v-for="program in programs" :key="program.education_program_id">
									<td>
										<center><input type="checkbox" :value="program.education_program_id" v-model="selected"></center>
									</td>
									<td @click="detail(program)">
										<a href="javascript:void(0)">
											{{ program.education_program_code }}
										</a>
									</td>
									<td>{{ nameProgram(program) }}</td>
									<td class="text-center">{{ program.education_program_year}}</td>
									<td class="text-center">{{ program.education_program_credit}}</td>
									<td class="td-styling text-center">
										<div v-if="program.education_program_status==0">
											<button class="fa fa-eye btn-eye" @click="change(program.education_program_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(program.education_program_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(program)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(program.education_program_id)"></button>
									</td>
								</tr>
								<tr v-show="!programs.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPrograms()"></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<!-- <div class="modal fade" id="SubjectModal" tabindex="-1" role="dialog" aria-labelledby="SubjectModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="SubjectModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Môn học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<label>Mã môn học</label>
									<input v-model="form.subject_code" type="text" name="subject_code"class="form-control" placeholder="Nhập mã môn học" :disabled="editMode" :class="[{'is-invalid': form.errors.has('subject_code')}, {'not-allowed': editMode}]">
									<div class="text-danger" v-if="form.errors.has('subject_code')" v-html="form.errors.get('subject_code')"></div>
								</div>
								<div class="col-md-6">
									<label>Số tín chỉ</label>
									<input v-model="form.subject_credit" type="number" min="0" name="subject_credit"class="form-control" placeholder="Nhập tín chỉ môn học" :class="[{'is-invalid': form.errors.has('subject_credit')}]">
									<div class="text-danger" v-if="form.errors.has('subject_credit')" v-html="form.errors.get('subject_credit')"></div>
								</div>
							</div>
							
							<label class="mt-3">Tên môn học</label>
							<input v-model="form.subject_name" type="text" name="subject_name" class="form-control" placeholder="Nhập tên môn học" :class="{'is-invalid': form.errors.has('subject_name')}">
							<div class="text-danger" v-if="form.errors.has('subject_name')" v-html="form.errors.get('subject_name')"></div>

							<div class="row">
								<div class="col-md-6">
									<label class="mt-3">Số giờ lý thuyết</label>
									<input v-model="form.subject_theory_period" type="number" min="0" name="subject_theory_period"class="form-control" placeholder="Nhập số giờ học lý thuyết" :class="[{'is-invalid': form.errors.has('subject_theory_period')}]">
									<div class="text-danger" v-if="form.errors.has('subject_theory_period')" v-html="form.errors.get('subject_theory_period')"></div>
								</div>
								<div class="col-md-6">
									<label class="mt-3">Số giờ thực hành</label>
									<input v-model="form.subject_practice_period" type="number" min="0" name="subject_practice_period"class="form-control" placeholder="Nhập số giờ học thực hành" :class="[{'is-invalid': form.errors.has('subject_practice_period')}]">
									<div class="text-danger" v-if="form.errors.has('subject_practice_period')" v-html="form.errors.get('subject_practice_period')"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6" :class="{'col-md-12': editMode}">
									<label class="mt-3">Loại môn học</label>
									<select v-model="form.subject_type" name="subject_type" class="form-control select-option" :class="{'is-invalid': form.errors.has('subject_type')}">
										<option value="" selected disabled>Chọn loại</option>
										<option disabled>---------------</option>
										<option value="0">Bắt buộc</option>
										<option value="1">Tự chọn</option>
									</select>
									<div class="text-danger mb-3" v-if="form.errors.has('subject_type')" v-html="form.errors.get('subject_type')"></div>
								</div>
								<div class="col-md-6">
									<div v-if="!editMode">
										<label class="mt-3">Trạng thái</label>
										<select v-model="form.subject_status" name="subject_status" class="form-control select-option" :class="{'is-invalid': form.errors.has('subject_status')}">
											<option value="" selected disabled>Chọn trạng thái</option>
											<option disabled>---------------</option>
											<option value="0">Hiển thị</option>
											<option value="1">Ẩn</option>
										</select>
										<div class="text-danger mb-3" v-if="form.errors.has('subject_status')" v-html="form.errors.get('subject_status')"></div>
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary background-update">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
						</div>
					</div>
				</form>
			</div>
		</div> -->
		<!-- Modal end-->

		<!-- Modal -->
		<!-- <div class="modal fade bd-example-modal-lg" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header styling-modal-header-info">
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết môn học</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
								</tr>
								<tr>
									<td>Mã Môn học: <strong> {{ form.subject_code }}</strong></td>
								</tr>
								<tr>
									<td>Tên Môn học: <strong> {{ form.subject_name }}</strong></td>
								</tr>
								<tr>
									<td>Số tín chỉ: <strong> {{ form.subject_credit }}</strong></td>
								</tr>
								<tr>
									<td>Khoa: <strong> {{ subject_faculty }}</strong></td>
								</tr>
								<tr>
									<td>Loại môn học: 
										<strong v-if="form.subject_type==0"> Bắt buộc</strong>
										<strong v-else> Tự chọn</strong>
									</td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Số tiết (giờ)</strong></h3></td>
								</tr>
								<tr>
									<td>Lý thuyết: 
										<strong>{{ form.subject_theory_period }}</strong>
									</td>
								</tr>
								<tr>
									<td>Thực hành: 
										<strong>{{ form.subject_practice_period }}</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div> -->
		</div>
		<!-- Modal end-->
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				faculties:[],
				majors:[],
				courses:[],
				lecturers:[],
				lecturer_id: this.$facultyId,
				lecturer_faculty:'',
				programs:[],
				education_program_id:'',
				education_program_faculty:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				editMode: false,
				form: new Form({
					education_program_id:'',
					education_program_code:'',
					education_program_course:'',
					education_program_major:'',
					education_program_faculty:'',
					education_program_year:'',
					education_program_credit:'',
					education_program_status:''
				}),
				selected: [],
				selectAll: false,
				details:[],
				value_course:'',
				value_major:'',
				value_choose:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchPrograms();
				}else{
					this.pagination=1;
					this.fetchPrograms();
				}
			},
			value_course(course){
				if(course === ''){
					this.fetchPrograms();
				}else{
					this.value_major='';
					this.pagination.current_page=1;
					this.filterCourse();
				}
			},
			value_major(major){
				if(major === ''){
					this.fetchPrograms();
				}else{
					this.value_course='';
					this.pagination.current_page=1;
					this.filterMajor();
				}
			},
			value_choose() {
				this.value_course='';
				this.value_major='';
			}
		},
		mounted() {
			this.fetchFaculties();
			this.fetchMajors();
			this.fetchCourses();
			this.fetchPrograms();
			this.fetchLecturers();
		},
		methods: {
			empty() {
				return (this.programs.length < 1);
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
			fetchLecturers(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-gv/giang-vien/lecturer';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.lecturers.forEach((el) => {
						if(el.lecturer_code===this.lecturer_id){
							this.lecturer_faculty= el.lecturer_faculty;
						}
					});
				})
				.catch(err => console.log(err));
			},
			fetchPrograms(page_url) {
				let vm = this;
				page_url = '../../api/admin/program/chuong-trinh-dao-tao/showdata/'+this.lecturer_id+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.programs = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			nameProgram(program) {
				const major = this.majors.find((mjr) => mjr.major_code === program.education_program_major);
				const course = this.courses.find((crs) => crs.course_code === program.education_program_course);

				return course.course_code + ' - ' + major.major_name ;
			},
			// create(){
			// 	this.editMode = false;
			// 	this.form.reset();
			// 	this.form.clear();
			// 	$('#SubjectModal').modal('show');
			// },
			// store(){
			// 	this.form.busy = true;
			// 	this.form.subject_faculty = this.lecturer_faculty;
			// 	this.form.post('../../api/admin/manage/mon-hoc')
			// 	.then(res => {
			// 		this.fetchPrograms();
			// 		$('#SubjectModal').modal('hide');
			// 		if(this.form.successful){
			// 			this.$snotify.success('Thêm mới thành công!');
			// 		}else{
			// 			this.$snotify.error('Không thể thêm Môn học', 'Lỗi');
			// 		}
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// show(subject) {
			// 	this.editMode = true;
			// 	this.form.reset();
			// 	this.form.clear();
			// 	this.form.fill(subject);
			// 	$('#SubjectModal').modal('show');
			// },
			// update() {
			// 	this.form.put('../../api/admin/manage/mon-hoc/'+this.form.education_program_id)
			// 	.then(res => {
			// 		this.fetchPrograms();
			// 		$('#SubjectModal').modal('hide');
			// 		if(this.form.successful){
			// 			this.$snotify.success('Cập nhật môn học thành công!');
			// 		}else{
			// 			this.$snotify.error('Không thể chỉnh sửa');
			// 		}
			// 	})
			// 	.catch(err => console.log(err));
			// },
			change(education_program_id) {
				axios.patch(`../../api/admin/program/chuong-trinh-dao-tao/change/${education_program_id}`)
				.then(res => {
					this.fetchPrograms();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(education_program_id) {
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
							axios.delete(`../../api/admin/program/chuong-trinh-dao-tao/${education_program_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchPrograms();
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
							axios.post('../../api/admin/program/chuong-trinh-dao-tao/destroyall', { educationProgram: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchPrograms();
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
					for(let i in this.programs){
						this.selected.push(this.programs[i].education_program_id);
					}
				}
			},
			// detail(subject, page_url) {
			// 	let vm = this;
			// 	page_url = `../../api/admin/manage/mon-hoc/detail/${subject.education_program_id}`;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.details = res.data;
			// 		this.form.fill(subject);
			// 		let faculty = this.faculties.filter(function(fct){
			// 			return fct.faculty_id===subject.subject_faculty
			// 		})
			// 		this.subject_faculty = faculty[0].faculty_name;
			// 		$('#DetailModal').modal('show');
			// 	})
			// 	.catch(err => console.log(err));
			// },
			reload(){
				this.fetchPrograms();
				this.query='';
				this.value_major='';
				this.value_course='';
			},
			// exportFile() {
			// 	window.location.href =`../../api/admin/manage/mon-hoc/export/${this.lecturer_faculty}`;
			// },
			filterCourse(page_url) {
				let vm = this;
				this.value_major='';
				page_url = '../../api/admin/program/chuong-trinh-dao-tao/filter-course/'+this.value_course+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.programs = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			filterMajor(page_url) {
				let vm = this;
				this.value_course='';
				page_url = '../../api/admin/program/chuong-trinh-dao-tao/filter-major/'+this.value_major+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.programs = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
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
		background-color: #1753fc;
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
	.btn-import {
		background-color: green;
		color: white;
	}
	.btn-import:hover {
		background-color: forestgreen;
		color: white;
	}
	.btn-export {
		background-color: darkgreen;
		color: white;
	}
	.btn-export:hover {
		background-color: seagreen;
		color: white;
	}
	.styling-strong {
		word-wrap: break-word;
		white-space: pre-line;
	}
</style>
