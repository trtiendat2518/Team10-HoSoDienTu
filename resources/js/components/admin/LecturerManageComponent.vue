<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Danh sách giảng viên</h3>
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
						<div class="col-md-2">
							<button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()"> Xóa nhiều</button>
						</div>
					</div>
					
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap">
							<thead  class="blue-background text-white">
								<tr>
									<th class="w-5">
										<input type="checkbox" class="form-control" :disabled="empty()" @click="select()" v-model="selectAll">
									</th>
									<th class="text-white w-30">Họ tên</th>
									<th class="text-white w-30">Địa chỉ Email</th>
									<th class="text-white w-30">Vai trò</th>
									<th class="text-white w-20">Trạng thái</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="lecturers.length" v-for="lecturer in lecturers" :key="lecturer.lecturer_id">
									<td>
										<center><input type="checkbox" :value="lecturer.lecturer_id" v-model="selected"></center>
									</td>
									<td><a href="#">{{ lecturer.lecturer_fullname }}</a></td>
									<td>{{ lecturer.lecturer_email }}</td>
									<td>
										<div v-if="lecturer.lecturer_role==2">
											Chủ nhiệm sinh viên
										</div>
										<div v-else-if="lecturer.lecturer_role==1">
											Ban chủ nhiệm khoa
										</div>
										<div v-else>
											Giảng viên mới
										</div>
									</td>
									<td class="td-styling">
										<div v-if="lecturer.lecturer_status==0">
											<button class="fa fa-eye btn-eye" @click="change(lecturer.lecturer_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(lecturer.lecturer_id)"></button>
										</div>
									</td>
									<td style="text-align: center">
										<button href="" class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" @click="show(lecturer)"></button>
									</td>
									<td>
										<button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(lecturer.lecturer_id)"></button>
									</td>
								</tr>
								<tr v-show="!lecturers.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchLecturers() : search() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="LecturerModal" tabindex="-1" role="dialog" aria-labelledby="LecturerModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="update()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="LecturerModalTitle">Cập nhật tài khoản</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Họ và tên</label>
							<input v-model="form.lecturer_fullname" type="text" name="lecturer_fullname"class="form-control not-allowed mb-3" disabled>

							<label>Địa chỉ Email</label>
							<input v-model="form.lecturer_email" type="text" name="lecturer_email" class="form-control not-allowed" disabled>

							
							<label class="mt-3">Vai trò</label>
							<select v-model="form.lecturer_role" name="lecturer_role" class="form-control select-option">
								<option value="0">Giảng viên mới</option>
								<option value="1">Ban chủ nhiệm khoa</option>
								<option value="2">Chủ nhiệm sinh viên</option>
							</select>
							<div class="text-danger mt-2" v-if="form.errors.has('category_status')" v-html="form.errors.get('category_status')"></div>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button type="submit" class="btn btn-primary">Cập nhật</button>
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
				lecturers:[],
				lecturer_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
				editMode: false,
				form: new Form({
                    lecturer_id:'',
                    lecturer_fullname:'',
                    lecturer_email:'',
                    lecturer_status: '',
                    lecturer_role: ''
                }),
                selected: [],
                selectAll: false
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.fetchLecturers();
				}else{
					this.fetchLecturers();
				}
			},
			query: function(keyword){
				if(keyword === ''){
					this.fetchLecturers();
				}else{
					this.search();
				}
			}
		},
		mounted() {
			this.fetchLecturers();
		},
		methods: {
            empty() {
            	return (this.lecturers.length < 1);
            },
			fetchLecturers(page_url) {
				let vm = this;
				page_url = 'giang-vien/list/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = 'giang-vien/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			show: function(lecturer) {
                this.editMode = true;
                this.form.reset();
                this.form.clear();
                this.form.fill(lecturer);
                $('#LecturerModal').modal('show');
            },
            update: function() {
                this.form.put('giang-vien/'+this.form.lecturer_id)
                .then(res => {
                    this.fetchLecturers();
                    $('#LecturerModal').modal('hide');
                    if(this.form.successful){
                        this.$snotify.success('Vai trò của tài khoản đã thay đổi');
                    }else{
                        this.$snotify.error('Không thể chỉnh sửa');
                    }
                })
                .catch(err => console.log(err));
            },
			change(lecturer_id) {
				axios.patch(`giang-vien/change/${lecturer_id}`)
                .then(res => {
                    this.fetchLecturers();
                    this.$snotify.warning('Đã thay đổi trạng thái');
                })
                .catch(err => console.log(err));
			},
			destroy(lecturer_id) {
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
                            axios.delete(`giang-vien/${lecturer_id}`)
                            .then(res => {
                                this.$snotify.success('Đã xóa!');
                                this.fetchLecturers();
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
                            axios.post('giang-vien/destroyall', { lecturer: this.selected })
                            .then(res => {
                                this.$snotify.success('Đã xóa!');
                                this.fetchLecturers();
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
            		for(let i in this.lecturers){
            			this.selected.push(this.lecturers[i].lecturer_id);
            		}
            	}
            }
		}
	};
</script>

<style scoped>
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
</style>
