<template>
	<div>
		<vue-snotify></vue-snotify>
		<button class="btn btn-info btn-lg mb-3" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách Bài Viết</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<!-- <div class="col-md-1">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
						</div> -->
						<div class="col-md-6">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-3">
							<select class="form-control mt-2" v-model="value_author">
								<option value="" disabled selected>Lọc theo tác giả</option>
								<option disabled>----------------------------------------</option>
								<option v-for="admin in admins" :value="admin.admin_fullname">{{ admin.admin_fullname }}</option>
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
									<th class="text-white w-40">Tiêu đề</th>
									<th class="text-white w-25">Tác giả</th>
									<th class="text-white w-15">Ngày đăng</th>
									<th class="text-white w-5">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="posts.length" v-for="post in posts" :key="post.post_id">
									<td>
										<center><input type="checkbox" :value="post.post_id" v-model="selected"></center>
									</td>
									<td @click="detail(post)">
										<a href="javascript:void(0)">
											<div v-if="post.post_title<40">{{ post.post_title }}</div>
											<div v-else>{{ post.post_title.substring(0,40)+"..." }}</div>
										</a>
									</td>
									<td>{{ post.post_author }}</td>
									<td>{{ post.post_date | formatDate}}</td>
									<td class="td-styling">
										<div v-if="post.post_status==0">
											<button class="fa fa-eye btn-eye" @click="change(post.post_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(post.post_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(post)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(post.post_id)"></button>
									</td>
								</tr>
								<tr v-show="!posts.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchPosts() : search() "></pagination> -->
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchPosts() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<!-- <div class="modal fade bd-example-modal-lg" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
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
							<tbody class="col-lg-12 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
								</tr>
								<tr>
									<td>Mã Chuyên Ngành: <strong> {{ form.post_title }}</strong></td>
								</tr>
								<tr>
									<td>Tên Chuyên Ngành: <strong> {{ form.post_content }}</strong></td>
								</tr>
								<tr>
									<td>Thuộc Khoa: <strong>{{ form.post_status }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div> -->
		<!-- Modal end-->
	</div>
</template>

<script>
	import 'vue-snotify/styles/material.css'
	export default {
		data() {
			return {
				details:[],
				admins:[],
				posts:[],
				post_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					post_id:'',
					post_title:'',
					post_content:'',
					post_author:'',
					post_status:'',
					post_date: '',
				}),
				selected: [],
				selectAll: false,
				details:[],
				error: {},
				value_author:'',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.fetchPosts();
				}else{
					this.fetchPosts();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchPosts();
				}else{
					this.value_author='';
					this.search();
				}
			},
			value_author(admin){
				if(admin === ''){
					this.fetchPosts();
				}else{
					this.query='';
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchAdmins();
			this.fetchPosts();
		},
		methods: {
			empty() {
				return (this.posts.length < 1);
			},
			fetchAdmins(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-gv/giang-vien/admin';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.admins = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchPosts(page_url) {
				let vm = this;
				page_url = '../../api/admin/post-news/bai-viet/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.posts = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/post-news/bai-viet/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.posts = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			create(){
				this.$router.push( {name: 'postcreate'} );
			},
			// show(major) {
			// 	this.editMode = true;
			// 	this.form.reset();
			// 	this.form.clear();
			// 	this.form.fill(major);
			// 	$('#MajorModal').modal('show');
			// },
			// update() {
			// 	this.form.put('../../api/admin/edu-major/chuyen-nganh/'+this.form.post_id)
			// 	.then(res => {
			// 		this.fetchPosts();
			// 		$('#MajorModal').modal('hide');
			// 		if(this.form.successful){
			// 			this.$snotify.success('Cập nhật Chuyên Ngành thành công!');
			// 		}else{
			// 			this.$snotify.error('Không thể chỉnh sửa');
			// 		}
			// 	})
			// 	.catch(err => console.log(err));
			// },
			change(post_id) {
				axios.patch(`../../api/admin/post-news/bai-viet/change/${post_id}`)
				.then(res => {
					this.fetchPosts();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			// destroy(post_id) {
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
			// 				axios.delete(`../../api/admin/edu-major/chuyen-nganh/${post_id}`)
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchPosts();
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
			// 				axios.post('../../api/admin/edu-major/chuyen-nganh/destroyall', { major: this.selected })
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchPosts();
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
			// 			this.selected.push(this.posts[i].post_id);
			// 		}
			// 	}
			// },
			// detail(post, page_url) {
			// 	let vm = this;
			// 	page_url = `../../api/admin/post-news/bai-viet/detail/${post.post_id}`;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.details = res.data;
			// 		this.form.fill(post);
			// 		$('#DetailModal').modal('show');
			// 	})
			// 	.catch(err => console.log(err));
			// },
			reload(){
				this.fetchPosts();
				this.query='';
				this.value_author='';
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/post-news/bai-viet/filter/'+this.value_author+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.posts = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			// filterFaculty(major) {
			// 	const faculty = this.faculties.find((fac) => fac.faculty_code === major.major_faculty);
			// 	return faculty.faculty_name;
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
</style>
