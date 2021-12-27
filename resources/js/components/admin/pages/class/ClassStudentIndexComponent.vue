<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Danh sách lớp học</li>
			</ol><!-- End breadcrumb -->
		</div>
		<button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách lớp học</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<!-- <div class="col-md-1">
							<button class="btn-3d btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div> -->
						<div class="col-md-6">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-3">
							<select class="form-control mt-2" v-model="value_state">
								<option value="" disabled selected>Lọc theo tình trạng</option>
								<option disabled>----------------------------------------</option>
								<option value="0">Chưa có chủ nhiệm</option>
								<option value="1">Đã có chủ nhiệm</option>
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
									<th class="text-white w-25">Tên lớp học</th>
									<th class="text-white w-30">Chuyên ngành</th>
									<th class="text-white w-30">Tình trạng</th>
									<th class="text-white w-5">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="classes.length" v-for="clas in classes" :key="clas.class_id">
									<td>
										<center><input type="checkbox" :value="clas.class_id" v-model="selected"></center>
									</td>
									<td @click="detail(clas)">
										<a href="javascript:void(0)">
											{{ clas.course_code }}-{{ clas.class_name }}
										</a>
									</td>
									<td>{{ clas.major_name }}</td>
									<td>
										<div v-if="clas.class_state==0">Chưa có chủ nhiệm</div>
										<div v-else-if="clas.class_state==1">Đã có chủ nhiệm</div>
									</td>
									<td class="td-styling">
										<div v-if="clas.class_status==0">
											<button class="fa fa-eye btn-eye" @click="change(clas.class_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(clas.class_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(clas)"></button>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(clas.class_id)"></button>
									</td>
								</tr>
								<tr v-show="!classes.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchClasses() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="ClassModal" tabindex="-1" role="dialog" aria-labelledby="ClassModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="ClassModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Lớp học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tên lớp <span class="text-danger">(*)</span></label>
							<input v-model="form.class_name" type="text" name="class_name" class="form-control" placeholder="Nhập tên lớp học" :class="[{'is-invalid': form.errors.has('class_name')}]">
							<div class="text-danger" v-if="form.errors.has('class_name')" v-html="form.errors.get('class_name')"></div>

							<label class="mt-3">Khóa học <span class="text-danger">(*)</span></label>
							<select v-model="form.class_course" name="class_course" class="form-control select-option" :class="{'is-invalid': form.errors.has('class_course')}">
								<option value="" selected disabled>Chọn khóa học</option>
								<option disabled>---------------</option>
								<option v-for="course in courses" :key="course.course_id" :value="course.course_id" :hidden="course.course_status>0">
									{{ course.course_code }} - {{ course.course_name }}
								</option>
							</select>
							<div class="text-danger" v-if="form.errors.has('class_course')" v-html="form.errors.get('class_course')"></div>

							<label class="mt-3">Chuyên ngành <span class="text-danger">(*)</span></label>
							<select v-model="form.class_major" name="class_major" class="form-control select-option" :class="{'is-invalid': form.errors.has('class_major')}">
								<option value="" selected disabled>Chọn chuyên ngành</option>
								<option disabled>---------------</option>
								<option v-for="major in majors" :key="major.major_id" :value="major.major_id" :hidden="major.major_faculty!=lecturer_faculty">{{ major.major_name }}</option>
							</select>
							<div class="text-danger" v-if="form.errors.has('class_major')" v-html="form.errors.get('class_major')"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
						</div>
					</div>
				</form>
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
				courses:[],
				majors:[],
				lecturers:[],
				lecturer_faculty:'',
				lecturer_id: this.$facultyId,
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					class_id:'',
					class_name:'',
					class_course:'',
					class_faculty:'',
					class_major:'',
					class_status:'',
					class_state:'',
				}),
				selected: [],
				selectAll: false,
				error: {},
				value_state:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchClasses();
				}else{
					this.pagination=1;
					this.fetchClasses();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchClasses();
				}else{
					this.value_state='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_state(state){
				if(state === ''){
					this.fetchClasses();
				}else{
					this.query='';
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchCourses();
			this.fetchMajors();
			this.fetchClasses();
			this.fetchLecturers();
		},
		methods: {
			empty() {
				return (this.classes.length < 1);
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
			fetchLecturers(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-gv/giang-vien/lecturer';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.lecturers.forEach((el) => {
						if(el.lecturer_id==this.lecturer_id){
							this.lecturer_faculty = el.lecturer_faculty;
						}
					});
				})
				.catch(err => console.log(err));
			},
			fetchClasses(page_url) {
				let vm = this;
				page_url = `../../api/admin/class-sv/lop/showdata/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.classes = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = `../../api/admin/class-sv/lop/search/${this.lecturer_faculty}/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.classes = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#ClassModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.class_faculty = this.lecturer_faculty;
				this.form.post('../../api/admin/class-sv/lop')
				.then(res => {
					this.fetchClasses();
					$('#ClassModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm mới', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			show(clas) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(clas);
				$('#ClassModal').modal('show');
			},
			update() {
				this.form.put(`../../api/admin/class-sv/lop/${this.form.class_id}`)
				.then(res => {
					this.fetchClasses();
					$('#ClassModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật Khoa thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			// change(class_id) {
			// 	axios.patch(`../../api/admin/post-news/bai-viet/change/${class_id}`)
			// 	.then(res => {
			// 		this.$snotify.warning('Đã thay đổi trạng thái');
			// 		this.fetchClasses();
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// destroy(class_id) {
			// 	this.$snotify.clear();
			// 	this.$snotify.confirm('Xác nhận xóa', {
			// 		timeout: 5000,
			// 		showProgressBar: true,
			// 		closeOnClick: false,
			// 		pauseOnHover: true,
			// 		buttons: [{
			// 			text: 'Xóa', 
			// 			action: toast =>{
			// 				this.$snotify.remove(toast.id);
			// 				axios.delete(`../../api/admin/post-news/bai-viet/${class_id}`)
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchClasses();
			// 				})
			// 				.catch(err => console.log(err));
			// 			}, 
			// 			bold: false
			// 		},{
			// 			text: 'Đóng', 
			// 			action: toast => { 
			// 				this.$snotify.remove(toast.id); 
			// 			}, 
			// 			bold: true
			// 		}]
			// 	});
			// },
			// destroyall() {
			// 	this.$snotify.clear();
			// 	this.$snotify.confirm('Xác nhận xóa', {
			// 		timeout: 5000,
			// 		showProgressBar: true,
			// 		closeOnClick: false,
			// 		pauseOnHover: true,
			// 		buttons: [{
			// 			text: 'Xóa', 
			// 			action: toast =>{
			// 				this.$snotify.remove(toast.id);
			// 				axios.post('../../api/admin/post-news/bai-viet/destroyall', { post: this.selected })
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchClasses();
			// 				})
			// 				.catch(err => console.log(err));
			// 			}, 
			// 			bold: false
			// 		},{
			// 			text: 'Đóng', 
			// 			action: toast => { 
			// 				this.$snotify.remove(toast.id); 
			// 			}, 
			// 			bold: true
			// 		}]
			// 	});
			// },
			// select() {
			// 	this.selected = [];
			// 	if(!this.selectAll){
			// 		for(let i in this.posts){
			// 			this.selected.push(this.posts[i].class_id);
			// 		}
			// 	}
			// },
			reload(){
				this.fetchClasses();
				this.query='';
				this.value_state='';
			},
			filter(page_url) {
				let vm = this;
				page_url = `../../api/admin/class-sv/lop/filter/${this.lecturer_faculty}/${this.value_state}/${this.currentEntries}?page=${this.pagination.current_page}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.classes = res.data;
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
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
