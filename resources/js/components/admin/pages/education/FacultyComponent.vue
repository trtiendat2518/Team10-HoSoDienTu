<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Khoa</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-9">
				<button class="btn btn-info btn-lg mb-3" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
			</div>
			<div class="col-md-3">
				<button class="btn btn-import btn-lg mb-3" @click="openImport()"><li class="fa fa-upload"></li> Import</button>
				<button class="btn btn-export btn-lg mb-3" @click="exportFile()" name="export_csv"><li class="fa fa-download"></li> Export</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách Khoa</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
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
									<th class="text-white w-15">Mã khoa</th>
									<th class="text-white w-60">Tên khoa</th>
									<th class="text-white w-10">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="faculties.length" v-for="faculty in faculties" :key="faculty.faculty_id">
									<td>
										<center><input type="checkbox" :value="faculty.faculty_id" v-model="selected"></center>
									</td>
									<td @click="detail(faculty)"><a href="javascript:void(0)">{{ faculty.faculty_code }}</a></td>
									<td>{{ faculty.faculty_name }}</td>
									<td class="td-styling">
										<div v-if="faculty.faculty_status==0">
											<button class="fa fa-eye btn-eye" @click="change(faculty.faculty_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(faculty.faculty_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(faculty)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(faculty.faculty_id)"></button>
									</td>
								</tr>
								<tr v-show="!faculties.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchFaculties() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="FacultyModal" tabindex="-1" role="dialog" aria-labelledby="FacultyModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="FacultyModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Khoa</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Mã khoa</label>
							<input v-model="form.faculty_code" type="text" name="faculty_code"class="form-control" placeholder="Nhập mã Khoa" :disabled="editMode" :class="[{'is-invalid': form.errors.has('faculty_code')}, {'not-allowed': editMode}]">
							<div class="text-danger" v-if="form.errors.has('faculty_code')" v-html="form.errors.get('faculty_code')"></div>

							<label class="mt-3">Tên Khoa</label>
							<input v-model="form.faculty_name" type="text" name="faculty_name" class="form-control" placeholder="Nhập tên Khoa" :class="{'is-invalid': form.errors.has('faculty_name')}">
							<div class="text-danger" v-if="form.errors.has('faculty_name')" v-html="form.errors.get('faculty_name')"></div>

							<div v-if="!editMode">
								<label class="mt-3">Trạng thái</label>
								<select v-model="form.faculty_status" name="faculty_status" class="form-control select-option" :class="{'is-invalid': form.errors.has('faculty_status')}">
									<option value="" selected disabled>Chọn trạng thái:</option>
									<option disabled>---------------</option>
									<option value="0">Hiển thị</option>
									<option value="1">Không hiển thị</option>
								</select>
								<div class="text-danger mb-3" v-if="form.errors.has('faculty_status')" v-html="form.errors.get('faculty_status')"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary background-update">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
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
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết Khoa</h5>
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
									<td>Mã Khoa: <strong> {{ form.faculty_code }}</strong></td>
								</tr>
								<tr>
									<td>Tên Khoa: <strong> {{ form.faculty_name }}</strong></td>
								</tr>
								<tr>
									<td>Tổng số Chuyên Ngành: <strong > {{ countMajor.length }}</strong></td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Ban chủ nhiệm Khoa</strong></h3></td>
								</tr>
								<tr>
									<td>Trưởng Khoa: 
										<strong>{{ head_lecturer }}</strong>
									</td>
								</tr>
								<tr>
									<td>Phó Khoa: 
										<strong>{{ vice_lecturer }}</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
							<h5 class="modal-title" id="ImportModalTitle">Import Khoa</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tệp Excel</label>
							<input type="file" class="form-control" id="fileImport" name="fileImport" ref="fileupload" @change="onFileChange">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" @click="reloadFile()" >Tải lại</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary">Import</button>
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
				faculties:[],
				majors:[],
				lecturers:[],
				head_lecturer:'',
				vice_lecturer:'',
				faculty_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					faculty_id:'',
					faculty_code:'',
					faculty_name:'',
					faculty_status: '',
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
					this.fetchFaculties();
				}else{
					this.pagination=1;
					this.fetchFaculties();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchFaculties();
				}else{
					this.pagination.current_page=1;
					this.search();
				}
			},
		},
		computed: {
			countMajor() {
				return this.majors.filter(major => major.major_faculty==this.form.faculty_code);
			}
		},
		mounted() {
			this.fetchMajors();
			this.fetchFaculties();
			this.fetchLecturers();
		},
		methods: {
			empty() {
				return (this.faculties.length < 1);
			},
			fetchFaculties(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-faculty/khoa/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.faculties = res.data;
					this.pagination = res.meta;
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
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-faculty/khoa/search/'+this.query+'/'+this.currentEntries+'?page=1';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.faculties = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#FacultyModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.post('../../api/admin/edu-faculty/khoa')
				.then(res => {
					this.fetchFaculties();
					$('#FacultyModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm Khoa', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			show(faculty) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(faculty);
				$('#FacultyModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/edu-faculty/khoa/'+this.form.faculty_id)
				.then(res => {
					this.fetchFaculties();
					$('#FacultyModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật Khoa thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(faculty_id) {
				axios.patch(`../../api/admin/edu-faculty/khoa/change/${faculty_id}`)
				.then(res => {
					this.fetchFaculties();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(faculty_id) {
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
							axios.delete(`../../api/admin/edu-faculty/khoa/${faculty_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchFaculties();
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
							axios.post('../../api/admin/edu-faculty/khoa/destroyall', { faculty: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchFaculties();
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
					for(let i in this.faculties){
						this.selected.push(this.faculties[i].faculty_id);
					}
				}
			},
			detail(faculty, page_url) {
				let vm = this;
				page_url = `../../api/admin/edu-faculty/khoa/detail/${faculty.faculty_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					this.form.fill(faculty);
					let head = this.lecturers.filter(function(lec){
						return lec.lecturer_faculty===faculty.faculty_code && lec.lecturer_level===1
					})
					this.head_lecturer = head[0].lecturer_fullname;

					let vice = this.lecturers.filter(function(lec){
						return lec.lecturer_faculty===faculty.faculty_code && lec.lecturer_level===2
					})
					this.vice_lecturer = vice[0].lecturer_fullname;

					$('#DetailModal').modal('show');
				})
				.catch(err => this.$snotify.error('Khoa này chưa có thông tin chi tiết'));
			},
			reload(){
				this.fetchFaculties();
				this.query='';
				this.$refs.fileupload.value='';
				this.fileImport='';
			},
			exportFile() {
				window.location.href ="../../api/admin/edu-faculty/khoa/export";
			},
			openImport() {
				this.$refs.fileupload.value='';
				$('#ImportModal').modal('show');
			},
			onFileChange(e) {
				this.fileImport = e.target.files[0];
			},
			reloadFile() {
				this.$refs.fileupload.value='';
				this.fileImport='';
			},
			importFile() {
				let formData = new FormData();
				formData.append('fileImport', this.fileImport);
				axios.post('../../api/admin/edu-faculty/khoa/import', formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#ImportModal').modal('hide');
						this.fetchFaculties();
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
					
					this.fetchFaculties();
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
</style>
