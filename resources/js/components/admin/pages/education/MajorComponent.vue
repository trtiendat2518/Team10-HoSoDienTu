<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Chuyên ngành</li>
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
							<h3 class="card-title">Danh sách Chuyên Ngành</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()"> Tải lại</button>
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
							<select class="form-control mt-2" v-model="value_faculty">
								<option value="" disabled selected>Lọc theo khoa</option>
								<option disabled>----------------------------------------</option>
								<option v-for="faculty in faculties" :key="faculty.faculty_id" :value="faculty.faculty_id">{{ faculty.faculty_code }} - {{ faculty.faculty_name }}</option>
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
									<th class="text-white w-15">Mã chuyên ngành</th>
									<th class="text-white w-30">Tên chuyên ngành</th>
									<th class="text-white w-30">Thuộc khoa</th>
									<th class="text-white w-10">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="majors.length" v-for="major in majors" :key="major.major_id">
									<td>
										<center><input type="checkbox" :value="major.major_id" v-model="selected"></center>
									</td>
									<td @click="detail(major)"><a href="javascript:void(0)">{{ major.major_code }}</a></td>
									<td>{{ major.major_name }}</td>
									<td>{{ major.faculty_name }}</td>
									<td class="td-styling">
										<div v-if="major.major_status==0">
											<button class="fa fa-eye btn-eye" @click="change(major.major_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(major.major_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(major)"></button>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(major.major_id)"></button>
									</td>
								</tr>
								<tr v-show="!majors.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchMajors() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="MajorModal" tabindex="-1" role="dialog" aria-labelledby="MajorModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="MajorModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Chuyên Ngành</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Mã Chuyên Ngành <span :hidden="editMode" class="text-danger">(*)</span></label>
							<input v-model="form.major_code" type="text" name="major_code" class="form-control" placeholder="Nhập mã Chuyên Ngành" :disabled="editMode" :class="[{'is-invalid': form.errors.has('major_code')}, {'not-allowed': editMode}]">
							<div class="text-danger" v-if="form.errors.has('major_code')" v-html="form.errors.get('major_code')"></div>

							<label class="mt-3">Tên Chuyên Ngành <span class="text-danger">(*)</span></label>
							<input v-model="form.major_name" type="text" name="major_name" class="form-control" placeholder="Nhập tên Chuyên Ngành" :class="{'is-invalid': form.errors.has('major_name')}">
							<div class="text-danger" v-if="form.errors.has('major_name')" v-html="form.errors.get('major_name')"></div>

							<label class="mt-3">Thuộc Khoa <span class="text-danger">(*)</span></label>
							<select v-model="form.major_faculty" name="major_faculty" class="form-control select-option" :class="{'is-invalid': form.errors.has('major_faculty')}">
								<option value="" selected disabled>Chọn Khoa</option>
								<option disabled>---------------</option>
								<option v-for="faculty in faculties" :key="faculty.faculty_id" :value="faculty.faculty_id" :hidden="faculty.faculty_status>0">{{ faculty.faculty_code }} - {{ faculty.faculty_name }}</option>
							</select>
							<div class="text-danger mb-3" v-if="form.errors.has('major_faculty')" v-html="form.errors.get('major_faculty')"></div>

							<div v-if="!editMode">
								<label class="mt-3">Trạng thái <span class="text-danger">(*)</span></label>
								<select v-model="form.major_status" name="major_status" class="form-control select-option" :class="{'is-invalid': form.errors.has('major_status')}">
									<option value="" selected disabled>Chọn trạng thái:</option>
									<option disabled>---------------</option>
									<option value="0">Hiển thị</option>
									<option value="1">Không hiển thị</option>
								</select>
								<div class="text-danger mb-3" v-if="form.errors.has('major_status')" v-html="form.errors.get('major_status')"></div>
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
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết Chuyên Ngành</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-12 p-0" v-for="detail in details" :key="detail.major_id">
								<tr>
									<td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
								</tr>
								<tr>
									<td>Mã Chuyên Ngành: <strong> {{ detail.major_code }}</strong></td>
								</tr>
								<tr>
									<td>Tên Chuyên Ngành: <strong> {{ detail.major_name }}</strong></td>
								</tr>
								<tr>
									<td>Thuộc Khoa: <strong>{{ detail.faculty_name }}</strong></td>
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
							<h5 class="modal-title" id="ImportModalTitle">Import Chuyên Ngành</h5>
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
				majors:[],
				faculties:[],
				major_id:'',
				major_faculty:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					major_id:'',
					major_code:'',
					major_name:'',
					major_faculty:'',
					major_status: '',
				}),
				selected: [],
				selectAll: false,
				details:[],
				fileImport: '',
				error: {},
				value_faculty:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchMajors();
				}else{
					this.pagination.current_page=1;
					this.fetchMajors();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchMajors();
				}else{
					this.value_faculty='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_faculty(faculty){
				if(faculty === ''){
					this.fetchMajors();
				}else{
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchFaculties();
			this.fetchMajors();
		},
		methods: {
			empty() {
				return (this.majors.length < 1);
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
				page_url = '../../api/admin/edu-major/chuyen-nganh/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.majors = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-major/chuyen-nganh/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.majors = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#MajorModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.post('../../api/admin/edu-major/chuyen-nganh')
				.then(res => {
					this.fetchMajors();
					$('#MajorModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm Chuyên Ngành', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			show(major) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(major);
				$('#MajorModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/edu-major/chuyen-nganh/'+this.form.major_id)
				.then(res => {
					this.fetchMajors();
					$('#MajorModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật Chuyên Ngành thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(major_id) {
				axios.patch(`../../api/admin/edu-major/chuyen-nganh/change/${major_id}`)
				.then(res => {
					this.fetchMajors();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(major_id) {
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
							axios.delete(`../../api/admin/edu-major/chuyen-nganh/${major_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchMajors();
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
							axios.post('../../api/admin/edu-major/chuyen-nganh/destroyall', { major: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchMajors();
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
					for(let i in this.majors){
						this.selected.push(this.majors[i].major_id);
					}
				}
			},
			detail(major, page_url) {
				let vm = this;
				page_url = `../../api/admin/edu-major/chuyen-nganh/detail/${major.major_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					this.form.fill(major);
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchMajors();
				this.query='';
				this.value_faculty='';
				this.$refs.fileupload.value='';
				this.fileImport='';
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-major/chuyen-nganh/filter/'+this.value_faculty+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.majors = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			exportFile() {
				window.location.href ="../../api/admin/edu-major/chuyen-nganh/export";
			},
			openImport() {
				this.$refs.fileupload.value='';
				$('#ImportModal').modal('show');
			},
			onFileChange(e) {
				if (e.target.files[0].name != 'list_of_major.xlsx') {
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
				axios.post('../../api/admin/edu-major/chuyen-nganh/import', formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#ImportModal').modal('hide');
						this.fetchMajors();
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
					
					this.fetchMajors();
					this.$snotify.error(this.error);
				});
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
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
