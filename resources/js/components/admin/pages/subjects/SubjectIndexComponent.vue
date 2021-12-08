<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Danh sách môn học</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-9">
				<button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
				<router-link class="btn btn-outline-dark btn-lg mb-3 btn-3d" tag="button" :to="{ name: 'subjectother' }"><li class="fa fa-info"></li> Xem môn học của khoa khác</router-link>
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
							<h3 class="card-title">Danh sách Môn học</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary btn-3d fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="btn btn-danger mt-3 ml-3 btn-lg fa fa-trash btn-3d" @click="destroyall()" :disabled="!selected.length"></button>
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
									<th class="text-white w-15">Mã môn học</th>
									<th class="text-white w-45">Tên môn học</th>
									<th class="text-white w-15 text-center">Số tín chỉ</th>
									<th class="text-white w-5 text-center">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="subjects.length" v-for="subject in subjects" :key="subject.subject_id">
									<td>
										<center><input type="checkbox" :value="subject.subject_id" v-model="selected"></center>
									</td>
									<td @click="detail(subject)">
										<a href="javascript:void(0)">
											{{ subject.subject_code }}
										</a>
									</td>
									<td>{{ subject.subject_name }}</td>
									<td class="text-center">{{ subject.subject_credit}}</td>
									<td class="td-styling text-center">
										<div v-if="subject.subject_status==0">
											<button class="fa fa-eye btn-eye" @click="change(subject.subject_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(subject.subject_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn btn-success btn-lg fa fa-pencil-square-o btn-3d" @click="show(subject)"></button>
									</td>
									<td>
										<button class="btn btn-danger btn-lg fa fa-trash btn-3d" @click="destroy(subject.subject_id)"></button>
									</td>
								</tr>
								<tr v-show="!subjects.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchSubjects() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade bd-example-modal-lg" id="SubjectModal" tabindex="-1" role="dialog" aria-labelledby="SubjectModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
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
									<input v-model="form.subject_code" type="text" name="subject_code" class="form-control" placeholder="Nhập mã môn học" :disabled="editMode" :class="[{'is-invalid': form.errors.has('subject_code')}, {'not-allowed': editMode}]">
									<div class="text-danger" v-if="form.errors.has('subject_code')" v-html="form.errors.get('subject_code')"></div>
								</div>
								<div class="col-md-3">
									<label>Số tín chỉ</label>
									<input v-model="form.subject_credit" type="number" min="0" name="subject_credit" class="form-control" placeholder="Nhập sô tín chỉ" :class="[{'is-invalid': form.errors.has('subject_credit')}]">
									<div class="text-danger" v-if="form.errors.has('subject_credit')" v-html="form.errors.get('subject_credit')"></div>
								</div>
								<div class="col-md-3">
									<label>Loại môn học</label>
									<select v-model="form.subject_type" name="subject_type" class="form-control select-option" :class="{'is-invalid': form.errors.has('subject_type')}">
										<option value="" selected disabled>Chọn loại</option>
										<option disabled>---------------</option>
										<option value="0">Bắt buộc</option>
										<option value="1">Tự chọn</option>
									</select>
									<div class="text-danger mb-3" v-if="form.errors.has('subject_type')" v-html="form.errors.get('subject_type')"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label class="mt-3">Tên môn học</label>
									<input v-model="form.subject_name" type="text" name="subject_name" class="form-control" placeholder="Nhập tên môn học" :class="{'is-invalid': form.errors.has('subject_name')}">
									<div class="text-danger" v-if="form.errors.has('subject_name')" v-html="form.errors.get('subject_name')"></div>
								</div>
								<div class="col-md-3">
									<label class="mt-3">Số giờ lý thuyết</label>
									<input v-model="form.subject_theory_period" type="number" min="0" name="subject_theory_period" class="form-control" placeholder="Nhập số giờ" :class="[{'is-invalid': form.errors.has('subject_theory_period')}]">
									<div class="text-danger" v-if="form.errors.has('subject_theory_period')" v-html="form.errors.get('subject_theory_period')"></div>
								</div>
								<div class="col-md-3">
									<label class="mt-3">Số giờ thực hành</label>
									<input v-model="form.subject_practice_period" type="number" min="0" name="subject_practice_period" class="form-control" placeholder="Nhập số giờ" :class="[{'is-invalid': form.errors.has('subject_practice_period')}]">
									<div class="text-danger" v-if="form.errors.has('subject_practice_period')" v-html="form.errors.get('subject_practice_period')"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3" :class="{'col-md-4': editMode}">
									<label class="mt-3">Điểm bài tập</label>
									<input v-model="form.subject_score_exercise" type="number" min="0" name="subject_score_exercise" class="form-control" placeholder="Nhập số phần trăm" :class="[{'is-invalid': form.errors.has('subject_score_exercise')}]">
									<div class="text-danger" v-if="form.errors.has('subject_score_exercise')" v-html="form.errors.get('subject_score_exercise')"></div>
								</div>
								<div class="col-md-3" :class="{'col-md-4': editMode}">
									<label class="mt-3">Điểm kiểm tra</label>
									<input v-model="form.subject_score_exam" type="number" min="0" name="subject_score_exam" class="form-control" placeholder="Nhập số phần trăm" :class="[{'is-invalid': form.errors.has('subject_score_exam')}]">
									<div class="text-danger" v-if="form.errors.has('subject_score_exam')" v-html="form.errors.get('subject_score_exam')"></div>
								</div>
								<div class="col-md-3" :class="{'col-md-4': editMode}">
									<label class="mt-3">Điểm thi</label>
									<input v-model="form.subject_score_final" type="number" min="0" name="subject_score_final" class="form-control" placeholder="Nhập số phần trăm" :class="[{'is-invalid': form.errors.has('subject_score_final')}]">
									<div class="text-danger" v-if="form.errors.has('subject_score_final')" v-html="form.errors.get('subject_score_final')"></div>
								</div>

								<div class="col-md-3">
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
							<button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary background-update btn-3d">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
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
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết môn học</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong"><h3><strong><u> Thông tin chi tiết</u></strong></h3></td>
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
							<tbody class="col-lg-3 p-0">
								<tr>
									<td class="h3-strong"><h3><strong><u> Số tiết</u></strong></h3></td>
								</tr>
								<tr>
									<td>Lý thuyết: 
										<strong>{{ form.subject_theory_period }} giờ</strong>
									</td>
								</tr>
								<tr>
									<td>Thực hành: 
										<strong>{{ form.subject_practice_period }} giờ</strong>
									</td>
								</tr>
							</tbody>
							<tbody class="col-lg-3 p-0">
								<tr>
									<td class="h3-strong"><h3><strong><u> Trọng số</u></strong></h3></td>
								</tr>
								<tr>
									<td>Điểm bài tập: 
										<strong>{{ form.subject_score_exercise }}%</strong>
									</td>
								</tr>
								<tr>
									<td>Điểm kiểm tra: 
										<strong>{{ form.subject_score_exam }}%</strong>
									</td>
								</tr>
								<tr>
									<td>Điểm thi: 
										<strong>{{ form.subject_score_final }}%</strong>
									</td>
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

		<!-- Modal -->
		<div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="ImportModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="importFile()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="ImportModalTitle">Import môn học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tệp Excel</label>
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
				faculties:[],
				lecturers:[],
				lecturer_id: this.$facultyId,
				lecturer_faculty:'',
				subjects:[],
				subject_id:'',
				subject_faculty:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					subject_id:'',
					subject_code:'',
					subject_name:'',
					subject_faculty:'',
					subject_credit:'',
					subject_practice_period:'',
					subject_theory_period:'',
					subject_score_exercise:'',
					subject_score_exam:'',
					subject_score_final:'',
					subject_type: '',
					subject_status:''
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
					this.fetchSubjects();
				}else{
					this.pagination=1;
					this.fetchSubjects();
				}
			},
			query(keyword) {
				if(keyword === ''){
					this.fetchSubjects();
				}else{
					this.value_author='';
					this.pagination.current_page=1;
					this.search();
				}
			},
		},
		mounted() {
			this.fetchFaculties();
			this.fetchSubjects();
			this.fetchLecturers();
		},
		methods: {
			empty() {
				return (this.subjects.length < 1);
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
			fetchSubjects(page_url) {
				let vm = this;
				page_url = '../../api/admin/manage/mon-hoc/showdata/'+this.lecturer_id+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.subjects = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/manage/mon-hoc/search/'+this.lecturer_faculty+'/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.subjects = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#SubjectModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.subject_faculty = this.lecturer_faculty;
				this.form.post('../../api/admin/manage/mon-hoc')
				.then(res => {
					this.fetchSubjects();
					if(this.form.successful){
						$('#SubjectModal').modal('hide');
						this.$snotify.success('Thêm mới thành công!');
					}
				})
				.catch(err => console.log(err));
			},
			show(subject) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(subject);
				$('#SubjectModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/manage/mon-hoc/'+this.form.subject_id)
				.then(res => {
					this.fetchSubjects();
					$('#SubjectModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật môn học thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(subject_id) {
				axios.patch(`../../api/admin/manage/mon-hoc/change/${subject_id}`)
				.then(res => {
					this.fetchSubjects();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(subject_id) {
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
							axios.delete(`../../api/admin/manage/mon-hoc/${subject_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchSubjects();
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
							axios.post('../../api/admin/manage/mon-hoc/destroyall', { subject: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchSubjects();
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
					for(let i in this.subjects){
						this.selected.push(this.subjects[i].subject_id);
					}
				}
			},
			detail(subject, page_url) {
				let vm = this;
				page_url = `../../api/admin/manage/mon-hoc/detail/${subject.subject_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					this.form.fill(subject);
					let faculty = this.faculties.filter(function(fct){
						return fct.faculty_code===subject.subject_faculty
					})
					this.subject_faculty = faculty[0].faculty_name;
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchSubjects();
				this.query='';
			},
			exportFile() {
				window.location.href =`../../api/admin/manage/mon-hoc/export/${this.lecturer_faculty}`;
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
				axios.post(`../../api/admin/manage/mon-hoc/import/${this.lecturer_faculty}`, formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#ImportModal').modal('hide');
						this.fetchSubjects();
						this.$snotify.success('Import thành công');
					}
				})
				.catch(err => {
					console.log(err);
					if(err.response.data.errors?.fileImport?.length > 0){
						this.error = err.response.data.errors.fileImport[0];
					}else if(err.response.data.errors[0].length > 0){
						const  stringError = err.response.data.errors[0][0];
						const  stringSplit = stringError.split(".");
						this.error = stringSplit[1];
					}
					
					this.fetchSubjects();
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
		border-bottom: 3px solid #6c757d;
		border-right: 3px solid #6c757d;
	}
</style>
