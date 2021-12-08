<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Danh sách hệ thống đào tạo</li>
			</ol><!-- End breadcrumb -->
		</div>
		<button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách hệ thống đào tạo</h3>
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
									<th class="text-white w-20">Mã HTĐT</th>
									<th class="text-white w-60">Tên hệ thống đào tạo</th>
									<th class="text-white w-5 text-center">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="types.length" v-for="type in types" :key="type.program_type_id">
									<td>
										<center><input type="checkbox" :value="type.program_type_id" v-model="selected"></center>
									</td>
									<td>{{ type.program_type_code }}</td>
									<td>{{ type.program_type_name }}</td>
									<td class="td-styling text-center">
										<div v-if="type.program_type_status==0">
											<button class="fa fa-eye btn-eye" @click="change(type.program_type_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(type.program_type_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(type)"></button>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(type.program_type_id)"></button>
									</td>
								</tr>
								<tr v-show="!types.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchTypes() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="ProgramTypeModal" tabindex="-1" role="dialog" aria-labelledby="ProgramTypeModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="ProgramTypeModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Hệ đào tạo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Mã hệ đào tạo</label>
							<input v-model="form.program_type_code" type="text" name="program_type_code" class="form-control" placeholder="Nhập mã hệ thống đào tạo" :disabled="editMode" :class="[{'is-invalid': form.errors.has('program_type_code')}, {'not-allowed': editMode}]">
							<div class="text-danger" v-if="form.errors.has('program_type_code')" v-html="form.errors.get('program_type_code')"></div>

							<label class="mt-3">Tên môn học</label>
							<input v-model="form.program_type_name" type="text" name="program_type_name" class="form-control" placeholder="Nhập tên hệ thống đào tạo" :class="{'is-invalid': form.errors.has('program_type_name')}">
							<div class="text-danger" v-if="form.errors.has('program_type_name')" v-html="form.errors.get('program_type_name')"></div>

							<div v-if="!editMode">
								<label class="mt-3">Trạng thái</label>
								<select v-model="form.program_type_status" name="program_type_status" class="form-control select-option" :class="{'is-invalid': form.errors.has('program_type_status')}">
									<option value="" selected disabled>Chọn trạng thái</option>
									<option disabled>---------------</option>
									<option value="0">Hiển thị</option>
									<option value="1">Ẩn</option>
								</select>
								<div class="text-danger mb-3" v-if="form.errors.has('program_type_status')" v-html="form.errors.get('program_type_status')"></div>
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
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				types:[],
				query:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				editMode: false,
				form: new Form({
					program_type_id:'',
					program_type_code:'',
					program_type_name:'',
					program_type_status:''
				}),
				selected: [],
				selectAll: false,
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchTypes();
				}else{
					this.pagination=1;
					this.fetchTypes();
				}
			},
			query(keyword) {
				if(keyword === ''){
					this.fetchTypes();
				}else{
					this.pagination.current_page=1;
					this.search();
				}
			},
		},
		mounted() {
			this.fetchTypes();
		},
		methods: {
			empty() {
				return (this.types.length < 1);
			},
			fetchTypes(page_url) {
				let vm = this;
				page_url = '../../api/admin/type/he-dao-tao/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.types = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/type/he-dao-tao/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.types = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#ProgramTypeModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.post('../../api/admin/type/he-dao-tao')
				.then(res => {
					this.fetchTypes();
					$('#ProgramTypeModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			show(type) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(type);
				$('#ProgramTypeModal').modal('show');
			},
			update() {
				this.form.put('../../api/admin/type/he-dao-tao/'+this.form.program_type_id)
				.then(res => {
					this.fetchTypes();
					$('#ProgramTypeModal').modal('hide');
					if(this.form.successful){
						this.$snotify.success('Cập nhật môn học thành công!');
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			change(program_type_id) {
				axios.patch(`../../api/admin/type/he-dao-tao/change/${program_type_id}`)
				.then(res => {
					this.fetchTypes();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(program_type_id) {
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
							axios.delete(`../../api/admin/type/he-dao-tao/${program_type_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchTypes();
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
							axios.post('../../api/admin/type/he-dao-tao/destroyall', { programType: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchTypes();
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
					for(let i in this.types){
						this.selected.push(this.types[i].program_type_id);
					}
				}
			},
			reload(){
				this.fetchTypes();
				this.query='';
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
