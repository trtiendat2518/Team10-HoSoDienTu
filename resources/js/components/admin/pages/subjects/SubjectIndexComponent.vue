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
		<button class="btn btn-info btn-lg mb-3" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách Môn học</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<!-- <div class="col-md-1">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div> -->
						<!-- <div class="col-md-6">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div> -->
						<!-- <div class="col-md-3">
							<select class="form-control mt-2" v-model="value_author">
								<option value="" disabled selected>Lọc theo tác giả</option>
								<option disabled>----------------------------------------</option>
								<option v-for="admin in admins" :value="admin.admin_fullname">{{ admin.admin_fullname }}</option>
							</select>
						</div> -->
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
										<router-link class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" tag="button" :to="{ name: 'subjectupdate', params: {idsubject: subject.subject_id} }"></router-link>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(subject.subject_id)"></button>
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
						<!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchSubjects() : search() "></pagination> -->
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchSubjects()"></pagination>
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
				subjects:[],
				subject_id:'',
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
					subject_credit:'',
					subject_practice_period:'',
					subject_theory_period:'',
					subject_type: '',
				}),
				selected: [],
				selectAll: false,
				details:[],
				value_faculty:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.fetchSubjects();
				}else{
					this.fetchSubjects();
				}
			},
			// query(keyword){
			// 	if(keyword === ''){
			// 		this.fetchSubjects();
			// 	}else{
			// 		this.value_author='';
			// 		this.search();
			// 	}
			// },
			// value_author(admin){
			// 	if(admin === ''){
			// 		this.fetchSubjects();
			// 	}else{
			// 		this.query='';
			// 		this.filter();
			// 	}
			// },
		},
		mounted() {
			this.fetchSubjects();
		},
		methods: {
			empty() {
				return (this.subjects.length < 1);
			},
			fetchSubjects(page_url) {
				let vm = this;
				page_url = '../../api/admin/manage/mon-hoc/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.subjects = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			// search(page_url) {
			// 	let vm = this;
			// 	page_url = '../../api/admin/subject-news/bai-viet/search/'+this.query+'/'+this.currentEntries+'?page=1';
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.subjects = res.data;
			// 		this.pagination = res.meta;
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// create(){
			// 	this.$router.push( {name: 'subjectcreate'} );
			// },
			// change(subject_id) {
			// 	axios.patch(`../../api/admin/subject-news/bai-viet/change/${subject_id}`)
			// 	.then(res => {
			// 		this.fetchSubjects();
			// 		this.$snotify.warning('Đã thay đổi trạng thái');
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// destroy(subject_id) {
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
			// 				axios.delete(`../../api/admin/subject-news/bai-viet/${subject_id}`)
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchSubjects();
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
			// 				axios.subject('../../api/admin/subject-news/bai-viet/destroyall', { subject: this.selected })
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchSubjects();
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
			// 		for(let i in this.subjects){
			// 			this.selected.push(this.subjects[i].subject_id);
			// 		}
			// 	}
			// },
			// detail(subject, page_url) {
			// 	let vm = this;
			// 	page_url = `../../api/admin/subject-news/bai-viet/detail/${subject.subject_id}`;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.details = res.data;
			// 		this.form.fill(subject);
			// 		$('#DetailModal').modal('show');
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// reload(){
			// 	this.fetchSubjects();
			// 	this.query='';
			// 	this.value_faculty='';
			// },
			// filter(page_url) {
			// 	let vm = this;
			// 	page_url = '../../api/admin/subject-news/bai-viet/filter/'+this.value_author+'/'+this.currentEntries+'?page='+this.pagination.current_page;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.subjects = res.data;
			// 		this.pagination = res.meta;
			// 	})
			// 	.catch(err => console.log(err));
			// },
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
