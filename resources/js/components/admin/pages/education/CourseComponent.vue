<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Khóa học</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-9">
				<button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
			</div>
			<div class="col-md-3">
				<button class="btn btn-import btn-lg mb-3 btn-3d" @click="openImport()"><li class="fa fa-upload"></li> Import</button>
				<button class="btn btn-export btn-lg mb-3 btn-3d" @click="exportFile()" name="export_csv"><li class="fa fa-download"></li> Export</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách Khóa Học</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="btn-3d btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
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
									<th class="text-white w-35">Mã Khóa học</th>
									<th class="text-white w-40">Tên khóa học</th>
									<th class="text-white w-10">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="courses.length" v-for="course in courses" :key="course.course_id">
									<td>
										<center><input type="checkbox" :value="course.course_id" v-model="selected"></center>
									</td>
									<td @click="detail(course)"><a href="javascript:void(0)">{{ course.course_code }}</a></td>
									<td>{{ course.course_name }}</td>
									<td class="td-styling">
										<div v-if="course.course_status==0">
											<button class="fa fa-eye btn-eye" @click="change(course.course_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(course.course_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(course)"></button>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(course.course_id)"></button>
									</td>
								</tr>
								<tr v-show="!courses.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchCourses() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="CourseModal" tabindex="-1" role="dialog" aria-labelledby="CourseModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="CourseModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Khóa học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Mã khóa học <span :hidden="editMode" class="text-danger">(*)</span></label>
							<input v-model="form.course_code" type="text" name="course_code" class="form-control" placeholder="Nhập mã khóa học" :disabled="editMode" :class="[{'is-invalid': form.errors.has('course_code')}, {'not-allowed': editMode}]">
							<div class="text-danger" v-if="form.errors.has('course_code')" v-html="form.errors.get('course_code')"></div>

							<label class="mt-3">Tên khóa học <span class="text-danger">(*)</span></label>
							<input v-model="form.course_name" type="text" name="course_name" class="form-control" placeholder="Nhập tên khóa học" :class="{'is-invalid': form.errors.has('course_name')}">
							<div class="text-danger" v-if="form.errors.has('course_name')" v-html="form.errors.get('course_name')"></div>

							<div v-if="!editMode">
								<label class="mt-3">Trạng thái <span class="text-danger">(*)</span></label>
								<select v-model="form.course_status" name="course_status" class="form-control select-option" :class="{'is-invalid': form.errors.has('course_status')}">
									<option value="" selected disabled>Chọn trạng thái</option>
									<option disabled>---------------</option>
									<option value="0">Hiển thị</option>
									<option value="1">Không hiển thị</option>
								</select>
								<div class="text-danger mb-3" v-if="form.errors.has('course_status')" v-html="form.errors.get('course_status')"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary background-update btn-3d">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
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
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết khóa học</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-12 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
								</tr>
								<tr>
									<td>Mã khóa học: <strong> {{ form.course_code }}</strong></td>
								</tr>
								<tr>
									<td>Tên khóa học: <strong> {{ form.course_name }}</strong></td>
								</tr>
								<tr>
									<td>Tổng số sinh viên: <strong> {{ countStudent.length }}</strong></td>
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

		<!-- Modal -->
		<div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="ImportModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="importFile()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="ImportModalTitle">Import Khóa học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tệp Excel <span class="text-danger">(*)</span></label>
							<input type="file" class="form-control" id="fileImport" name="fileImport" ref="fileupload" @change="onFileChange">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-3d" @click="reloadFile()" >Tải lại</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary btn-3d">Import</button>
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
				students:[],
				courses:[],
				course_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					course_id:'',
					course_code:'',
					course_name:'',
					course_status: '',
				}),
				selected: [],
				selectAll: false,
				details:[],
				fileImport: '',
				error: {},
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchCourses();
				}else{
					this.pagination=1;
					this.fetchCourses();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchCourses();
				}else{
					this.pagination.current_page=1;
					this.search();
				}
			},
		},
		computed: {
			countStudent() {
				return this.students.filter(student => student.student_course==this.form.course_id);
			}
		},
		mounted() {
			this.fetchCourses();
			this.fetchStudents();
		},
		methods: {
			empty() {
				return (this.courses.length < 1);
			},
			fetchStudents(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/studentinfo';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchCourses(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-course/khoa-hoc/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.courses = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-course/khoa-hoc/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.courses = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#CourseModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.post('../../api/admin/edu-course/khoa-hoc')
				.then(res => {
					this.fetchCourses();
					$('#CourseModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm khóa học', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			show(course) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(course);
				$('#CourseModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/edu-course/khoa-hoc/'+this.form.course_id)
				.then(res => {
					this.fetchCourses();
					$('#CourseModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật Khóa Học thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(course_id) {
				axios.patch(`../../api/admin/edu-course/khoa-hoc/change/${course_id}`)
				.then(res => {
					this.fetchCourses();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(course_id) {
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
							axios.delete(`../../api/admin/edu-course/khoa-hoc/${course_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchCourses();
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
							axios.post('../../api/admin/edu-course/khoa-hoc/destroyall', { course: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchCourses();
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
					for(let i in this.courses){
						this.selected.push(this.courses[i].course_id);
					}
				}
			},
			detail(course, page_url) {
				let vm = this;
				page_url = `../../api/admin/edu-course/khoa-hoc/detail/${course.course_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					this.form.fill(course);
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchCourses();
				this.query='';
				this.$refs.fileupload.value='';
				this.fileImport='';
			},
			exportFile() {
				window.location.href ="../../api/admin/edu-course/khoa-hoc/export";
			},
			openImport() {
				this.$refs.fileupload.value='';
				$('#ImportModal').modal('show');
			},
			onFileChange(e) {
				if (e.target.files[0].name != 'list_of_course.xlsx') {
					this.$refs.fileupload.value='';
					this.$snotify.error('Tên tệp Excel không đúng!');
				} else {
					this.fileImport = e.target.files[0]
				}
			},
			reloadFile() {
				this.$refs.fileupload.value='';
				this.fileImport='';
			},
			importFile() {
				let formData = new FormData();
				formData.append('fileImport', this.fileImport);
				axios.post('../../api/admin/edu-course/khoa-hoc/import', formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#ImportModal').modal('hide');
						this.fetchCourses();
						this.$snotify.success('Import thành công');
					}
				})
				.catch(err => {
					if(err.response.data.errors?.fileImport?.length > 0){
						this.error = err.response.data.errors.fileImport[0];
					}else if(err.response.data.errors[0].length > 0){
						const  stringError = err.response.data.errors[0][0];
						const  stringSplit = stringError.split(".");
						this.error = stringSplit[1];
					}
					
					this.fetchCourses();
					this.$snotify.error(this.error);
				});
			}
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
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
