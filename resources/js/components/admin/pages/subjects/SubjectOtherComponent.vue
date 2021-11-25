<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					<router-link tag="a" :to="{ name: 'subjectindex' }">Danh sách môn học</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Khoa khác</li>
			</ol><!-- End breadcrumb -->
		</div>
		<router-link class="btn btn-primary btn-lg mb-3" tag="button" :to="{ name: 'subjectindex' }"><li class="fa fa-arrow-left"></li> Quay lại</router-link>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Tổng hợp các môn học của khoa khác</h3>
						</div>
						<div class="col-md-1">
							<button class="btn btn-lg btn-primary fa fa-refresh" @click="reload()"> Tải lại</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-7">
							<input type="text" class="form-control mt-2 ml-3" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-3">
							<select class="form-control mt-2" v-model="value_faculty">
								<option value="" disabled selected>Lọc theo khoa</option>
								<option disabled>----------------------------------------</option>
								<option v-for="faculty in faculties" :value="faculty.faculty_id" :hidden="faculty.faculty_id==lecturer_faculty">{{ faculty.faculty_name }}</option>
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
									<th class="text-white w-30">Mã môn học</th>
									<th class="text-white w-30">Tên môn học</th>
									<th class="text-white w-10 text-center">Số tín chỉ</th>
									<th class="text-white w-30">Khoa</th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="subjects.length" v-for="subject in subjects" :key="subject.subject_id">
									<td @click="detail(subject)">
										<a href="javascript:void(0)">
											{{ subject.subject_code }}
										</a>
									</td>
									<td>{{ subject.subject_name }}</td>
									<td class="text-center">{{ subject.subject_credit}}</td>
									<td>{{ getFacultyName(subject) }}</td>
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
									<td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
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
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong"><h3><strong> Số tiết (giờ)</strong></h3></td>
								</tr>
								<tr>
									<td>Lý thuyết: 
										<strong>{{ form.subject_theory_period }}</strong>
									</td>
								</tr>
								<tr>
									<td>Thực hành: 
										<strong>{{ form.subject_practice_period }}</strong>
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
				lecturer_id: this.$userId,
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
				form: new Form({
					subject_id:'',
					subject_code:'',
					subject_name:'',
					subject_faculty:'',
					subject_credit:'',
					subject_practice_period:'',
					subject_theory_period:'',
					subject_type: '',
					subject_status:''
				}),
				details:[],
				value_faculty:''
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
			query(keyword){
				if(keyword === ''){
					this.fetchSubjects();
				}else{
					this.value_author='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_faculty(faculty){
				if(faculty === ''){
					this.fetchSubjects();
				}else{
					this.pagination.current_page=1;
					this.filter();
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
				page_url = '../../api/admin/manage/mon-hoc/showother/'+this.lecturer_id+'/'+this.currentEntries+'?page='+this.pagination.current_page;
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
				page_url = '../../api/admin/manage/mon-hoc/searchother/'+this.lecturer_faculty+'/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.subjects = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
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
						return fct.faculty_id===subject.subject_faculty
					})
					this.subject_faculty = faculty[0].faculty_name;
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchSubjects();
				this.query='';
				this.value_faculty='';
			},
			getFacultyName(subject) {
				const faculty = this.faculties.find((fac) => fac.faculty_id === subject.subject_faculty);
				return faculty.faculty_name;
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/manage/mon-hoc/filter/'+this.value_faculty+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.subjects = res.data;
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
</style>
