<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Danh sách sinh viên</h3>
					</div>

					<div class="row">
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
						<div class="col-md-8">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<!-- <div class="col-md-2">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"> Xóa nhiều</button>
						</div> -->
					</div>
					
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap">
							<thead  class="blue-background text-white">
								<tr>
									<th class="w-5">
										<!-- <input type="checkbox" class="form-control" :disabled="empty()" @click="select()" v-model="selectAll"> -->
									</th>
									<th class="text-white w-30">Mã số sinh viên</th>
									<th class="text-white w-30">Họ tên</th>
									<th class="text-white w-30">Địa chỉ Email</th>
									<th class="text-white w-30">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="students.length" v-for="student in students" :key="student.student_id">
									<td>
										<center><input type="checkbox" :value="student.student_id" v-model="selected"></center>
									</td>
									<td>{{ student.student_code }}</td>
									<td @click="detail(student)"><a href="javascript:void(0)">{{ student.student_fullname }}</a></td>
									<td>{{ student.student_email }}</td>
									<td class="td-styling">
										<div v-if="student.student_status==0">
											<button class="fa fa-eye btn-eye" @click="change(student.student_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(student.student_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(student)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(student.student_id)"></button>
									</td>
								</tr>
								<tr v-show="!students.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchStudents() : search() "></pagination>
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
				students:[],
				student_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
					student_id:'',
					student_code:'',
					student_fullname:'',
					student_email:'',
					student_status: ''
				}),
				selected: [],
				selectAll: false,
				details:[]
			}
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.fetchStudents();
				}else{
					this.fetchStudents();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchStudents();
				}else{
					this.search();
				}
			},
		},
		mounted() {
			this.fetchStudents();
		},
		methods: {
			empty() {
				return (this.students.length < 1);
			},
			fetchStudents(page_url) {
				let vm = this;
				page_url = '../../api/admin/quan-ly-tai-khoan/sinh-vien/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/quan-ly-tai-khoan/sinh-vien/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			// show(student) {
			// 	this.editMode = true;
			// 	this.form.reset();
			// 	this.form.clear();
			// 	this.form.fill(student);
			// 	$('#StudentModal').modal('show');
			// },
			// update() {
			// 	this.form.put('../../api/admin/quan-ly-tai-khoan/sinh-vien/'+this.form.student_id)
			// 	.then(res => {
			// 		this.fetchStudents();
			// 		$('#StudentModal').modal('hide');
			// 		if(this.form.successful){
			// 			this.$snotify.success('Vai trò của tài khoản đã thay đổi');
			// 		}else{
			// 			this.$snotify.error('Không thể chỉnh sửa');
			// 		}
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// change(student_id) {
			// 	axios.patch(`../../api/admin/quan-ly-tai-khoan/sinh-vien/change/${student_id}`)
			// 	.then(res => {
			// 		this.fetchStudents();
			// 		this.$snotify.warning('Đã thay đổi trạng thái');
			// 	})
			// 	.catch(err => console.log(err));
			// },
			// destroy(student_id) {
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
			// 				axios.delete(`../../api/admin/quan-ly-tai-khoan/sinh-vien/${student_id}`)
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchStudents();
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
			// 				axios.post('../../api/admin/quan-ly-tai-khoan/sinh-vien/destroyall', { student: this.selected })
			// 				.then(res => {
			// 					this.$snotify.success('Đã xóa!');
			// 					this.fetchStudents();
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
			// 		for(let i in this.students){
			// 			this.selected.push(this.students[i].student_id);
			// 		}
			// 	}
			// },
			// detail(student, page_url) {
			// 	let vm = this;
			// 	page_url = `../../api/admin/quan-ly-tai-khoan/sinh-vien/detail/${student.student_id}`;
			// 	fetch(page_url)
			// 	.then(res => res.json())
			// 	.then(res => {
			// 		this.details = res.data;
			// 		this.form.fill(student);
			// 		$('#DetailModal').modal('show');
			// 	})
			// 	.catch(err => console.log(err));
			// }
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
		color: coral;
	}
</style>
