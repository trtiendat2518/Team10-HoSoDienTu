<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Danh sách thủ tục</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-6">
				<router-link tag="button" class="btn btn-info btn-lg mb-3 btn-3d" :to="{ name: 'procedurecreate' }">
					<li class="fa fa-plus"></li>
					Tạo mới
				</router-link>
			</div>
			<div class="col-md-6">
				<router-link tag="button" class="btn btn-indigo float-right btn-lg mb-3 btn-3d" :to="{ name: 'procedurerequire' }">
					<li class="fa fa-window-maximize"></li>
					Danh sách yêu cầu
				</router-link>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách thủ tục</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							<button class="btn-3d btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-3">
							<select class="form-control mt-2" v-model="value_category">
								<option value="" disabled selected>Lọc theo danh mục</option>
								<option disabled>----------------------------------------</option>
								<option value="0">Phòng đào tạo</option>
								<option value="1">Phòng hành chính</option>
								<option value="2">Trung tâm hỗ trợ sinh viên</option>
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
									<th class="text-white w-25 text-center">Tiêu đề</th>
									<th class="text-white w-25 text-center">Danh mục</th>
									<th class="text-white w-10 text-center">Thời gian</th>
									<th class="text-white w-10 text-center">Cách thức</th>
									<th class="text-white w-10 text-center">Phí phải trả</th>
									<th class="text-white w-5 text-center">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="procedures.length" v-for="procedure in procedures" :key="procedure.procedure_id">
									<td>
										<center><input type="checkbox" :value="procedure.procedure_id" v-model="selected"></center>
									</td>
									<td>
										<router-link tag="a" :to="{ name: 'procedureupdate', params: {idProcedure: procedure.procedure_id} }">
											<div v-if="procedure.procedure_title<40">
												{{ procedure.procedure_title }}
											</div>
											<div v-else>
												{{ procedure.procedure_title.substring(0,30)+"..." }}
											</div>
										</router-link>
									</td>
									<td class="text-center">
										<div v-if="procedure.procedure_category==0">Phòng đào tạo</div>
										<div v-else-if="procedure.procedure_category==1">Phòng hành chính</div>
										<div v-else-if="procedure.procedure_category==2">Trung tâm hỗ trợ sinh viên</div>
									</td>
									<td class="text-center">{{ procedure.procedure_time }} ngày</td>
									<td class="text-center">
										<div v-if="procedure.procedure_method==0">Nộp online</div>
										<div v-else-if="procedure.procedure_method==1">Nộp tại trường</div>
									</td>
									<td class="text-center">
										<div v-if="procedure.procedure_fee==0">Miễn phí</div>
										<div v-else>{{ procedure.procedure_fee | formatNumber}} đ</div>
									</td>
									<td class="td-styling">
										<div v-if="procedure.procedure_status==0">
											<button class="fa fa-eye btn-eye" @click="change(procedure.procedure_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(procedure.procedure_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<router-link class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" tag="button" :to="{ name: 'procedureupdate', params: {idProcedure: procedure.procedure_id} }"></router-link>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(procedure.procedure_id)"></button>
									</td>
								</tr>
								<tr v-show="!procedures.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchProcedures() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				procedures:[],
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					procedure_id:'',
					procedure_title:'',
					procedure_content:'',
					procedure_time:'',
					procedure_method: '',
					procedure_fee: '',
					procedure_category: '',
					procedure_status: '',
				}),
				selected: [],
				selectAll: false,
				error: {},
				value_category:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchProcedures();
				}else{
					this.pagination=1;
					this.fetchProcedures();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchProcedures();
				}else{
					this.value_category='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_category(value){
				if(value === ''){
					this.fetchProcedures();
				}else{
					this.query='';
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchProcedures();
		},
		methods: {
			empty() {
				return (this.procedures.length < 1);
			},
			fetchProcedures(page_url) {
				let vm = this;
				page_url = '../../api/admin/procedure/thu-tuc/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.procedures = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/procedure/thu-tuc/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.procedures = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			change(procedure_id) {
				axios.patch(`../../api/admin/procedure/thu-tuc/change/${procedure_id}`)
				.then(res => {
					this.fetchProcedures();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(procedure_id) {
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
							axios.delete(`../../api/admin/procedure/thu-tuc/${procedure_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchProcedures();
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
							axios.post('../../api/admin/procedure/thu-tuc/destroyall', { procedure_id: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchProcedures();
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
					for(let i in this.procedures){
						this.selected.push(this.procedures[i].procedure_id);
					}
				}
			},
			reload(){
				this.fetchProcedures();
				this.query='';
				this.value_category='';
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/procedure/thu-tuc/filter/'+this.value_category+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.procedures = res.data;
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
