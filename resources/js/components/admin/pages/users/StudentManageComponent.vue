<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Sinh viên</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-import btn-lg mb-3 btn-3d float-right" @click="openImport()"><li class="fa fa-upload"></li> Import</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-11">
							<h3 class="card-title">Danh sách sinh viên</h3>
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
							<select class="form-control mt-2" v-model="value_role">
								<option value="" disabled selected>Lọc thông tin</option>
								<option value="0">Sinh viên còn đang học</option>
								<option value="1">Sinh viên đã ra trường</option>
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
									<th class="text-white w-15 text-center">Mã số sinh viên</th>
									<th class="text-white w-25 text-center">Họ tên</th>
									<th class="text-white w-25 text-center">Địa chỉ Email</th>
									<th class="text-white w-5 text-center">Trạng thái</th>
									<th class="text-white w-15 text-center">Học tập</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="students.length" v-for="student in students" :key="student.student_id">
									<td class="text-center">
										<input type="checkbox" :value="student.student_id" v-model="selected">
									</td>
									<td @click="detail(student)">
										<a href="javascript:void(0)">
											{{ student.student_code }}
										</a>
									</td>
									<td>{{ student.student_fullname }}</td>
									<td>{{ student.student_email }}</td>
									<td class="td-styling text-center">
										<div v-if="student.student_status==0">
											<button class="fa fa-eye btn-eye" @click="change(student.student_id)"></button>
										</div>
										<div v-else>
											<button class="fa fa-eye-slash btn-eye-slash" @click="change(student.student_id)"></button>
										</div>
									</td>
									<td class="text-center">
										<select class="form-control" v-model="student.student_role" :class="[{'btn-outline-success': student.student_role==0}, {'btn-outline-danger': student.student_role==1}]" @change="patch($event, student.student_id)" name="student_role">
											<option value="0">Đang học</option>
											<option value="1">Đã ra trường</option>
										</select>
									</td>
									<td>
										<button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(student)"></button>
									</td>
									<td>
										<button class="btn-3d btn btn-danger btn-lg fa fa-trash" @click="destroy(student.student_id)"></button>
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

		<!-- Modal -->
		<div class="modal fade bd-example-modal-lg" id="StudentModal" tabindex="-1" role="dialog" aria-labelledby="StudentModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<form @submit.prevent="update()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title styling-font-modal-header" id="StudentModalTitle">Cập nhật tài khoản</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="text-center mb-2">
                                <img class="avatar-xxl" v-if="student_avatar" :src="student_avatar" alt="profile">
							</div>

							<h3>Thông tin cá nhân</h3>

							<div class="form-group">
								<label>Ảnh đại diện <span class="text-danger">(*)</span></label>
								<input class="form-control" type="file" id="student_avatar" name="student_avatar" ref="fileupload" @change="onAvatarChange">
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Họ và tên</label>
										<input v-model="form.student_fullname" type="text" name="student_fullname" class="form-control not-allowed mb-3" disabled>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Mã số sinh viên</label>
										<input v-model="form.student_code" type="text" name="student_code" class="form-control not-allowed" disabled>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Giới tính <span class="text-danger">(*)</span></label>
										<select v-model="form.student_gender" name="student_gender" class="form-control select-option" :class="{'is-invalid': form.errors.has('student_gender')}">
											<option value="0">Nam</option>
											<option value="1">Nữ</option>
										</select>
										<div class="text-danger" v-if="form.errors.has('student_gender')" v-html="form.errors.get('student_gender')"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Ngày sinh <span class="text-danger">(*)</span></label>
										<input v-model="form.student_birthday" type="date" name="student_birthday" class="form-control" :class="{'is-invalid': form.errors.has('student_birthday')}">
										<div class="text-danger" v-if="form.errors.has('student_birthday')" v-html="form.errors.get('student_birthday')"></div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nơi sinh <span class="text-danger">(*)</span></label>
										<input v-model="form.student_birth_place" type="text" name="student_birth_place" class="form-control" :class="{'is-invalid': form.errors.has('student_birth_place')}">
										<div class="text-danger" v-if="form.errors.has('student_birth_place')" v-html="form.errors.get('student_birth_place')"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Quốc gia <span class="text-danger">(*)</span></label>
										<input v-model="form.student_country" type="text" name="student_country" class="form-control" :class="{'is-invalid': form.errors.has('student_country')}">
										<div class="text-danger" v-if="form.errors.has('student_country')" v-html="form.errors.get('student_country')"></div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Dân tộc</label>
										<input v-model="form.student_ethnic" type="text" name="student_ethnic" class="form-control" :class="{'is-invalid': form.errors.has('student_ethnic')}">
										<div class="text-danger" v-if="form.errors.has('student_ethnic')" v-html="form.errors.get('student_ethnic')"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Tôn giáo</label>
										<input v-model="form.student_religion" type="text" name="student_religion" class="form-control" :class="{'is-invalid': form.errors.has('student_religion')}">
										<div class="text-danger" v-if="form.errors.has('student_religion')" v-html="form.errors.get('student_religion')"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>CMND/CCCD <span class="text-danger">(*)</span></label>
										<input v-model="form.student_identify_card" type="number" name="student_identify_card" class="form-control" :class="{'is-invalid': form.errors.has('student_identify_card')}">
										<div class="text-danger" v-if="form.errors.has('student_identify_card')" v-html="form.errors.get('student_identify_card')"></div>
									</div>
								</div>
							</div>

							<h3>Thông tin khóa học</h3>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Khóa học <span class="text-danger">(*)</span></label>
										<select v-model="form.student_course" name="student_course" class="form-control select-option" :class="{'is-invalid': form.errors.has('student_course')}">
											<option value="null" disabled selected>Chọn khóa học</option>
											<option v-for="course in courses" :key="course.course_id" :value="course.course_id" :hidden="course.course_status>0">{{ course.course_code }} - {{ course.course_name }}</option>
										</select>
										<div class="text-danger" v-if="form.errors.has('student_course')" v-html="form.errors.get('student_course')"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Khoa <span class="text-danger">(*)</span></label>
										<select v-model="form.student_faculty" name="student_faculty" class="form-control select-option" :class="{'is-invalid': form.errors.has('student_faculty')}">
											<option value="null" disabled selected>Chọn khoa</option>
											<option v-for="faculty in faculties" :key="faculty.faculty_id" :value="faculty.faculty_id" :hidden="faculty.facultystatus>0">{{ faculty.faculty_name }}</option>
										</select>
										<div class="text-danger" v-if="form.errors.has('student_faculty')" v-html="form.errors.get('student_faculty')"></div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Chuyên ngành <span class="text-danger">(*)</span></label>
										<select v-model="form.student_major" name="student_major" class="form-control select-option" :class="{'is-invalid': form.errors.has('student_major')}">
											<option value="null" disabled selected>Chọn chuyên ngành</option>
											<option v-for="major in majors" :key="major.major_id" :value="major.major_id" :hidden="major.major_status>0">{{ major.major_name }}</option>
										</select>
										<div class="text-danger" v-if="form.errors.has('student_major')" v-html="form.errors.get('student_major')"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Lớp học <span class="text-danger">(*)</span></label>
										<select v-model="form.student_class" name="student_class" class="form-control select-option" :class="{'is-invalid': form.errors.has('student_class')}">
											<option value="null" disabled selected>Chọn lớp học</option>
											<option v-for="clas in classes" :key="clas.class_id" :value="clas.class_id" :hidden="clas.class_status>0">{{ clas.class_name }}</option>
										</select>
										<div class="text-danger" v-if="form.errors.has('student_class')" v-html="form.errors.get('student_class')"></div>
									</div>
								</div>
							</div>

							<h3>Thông tin liên lạc</h3>
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label>Địa chỉ Email</label>
										<input v-model="form.student_email" type="text" name="student_email" class="form-control not-allowed mb-3" disabled>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Địa chỉ Email khác</label>
										<input v-model="form.student_other_email" type="text" name="student_other_email" class="form-control" :class="{'is-invalid': form.errors.has('student_other_email')}">
										<div class="text-danger" v-if="form.errors.has('student_other_email')" v-html="form.errors.get('student_other_email')"></div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Số điện thoại <span class="text-danger">(*)</span></label>
										<input v-model="form.student_phone" type="number" name="student_phone" class="form-control" :class="{'is-invalid': form.errors.has('student_phone')}">
										<div class="text-danger" v-if="form.errors.has('student_phone')" v-html="form.errors.get('student_phone')"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Địa chỉ <span class="text-danger">(*)</span></label>
								<textarea rows="3" v-model="form.student_address" type="number" name="student_address" class="form-control" :class="{'is-invalid': form.errors.has('student_address')}"></textarea>
								<div class="text-danger" v-if="form.errors.has('student_address')" v-html="form.errors.get('student_address')"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
							<button type="submit" class="btn btn-primary background-update btn-3d">Cập nhật</button>
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
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết tài khoản</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" v-show="details.length" v-for="info in details" :key="info.student_id">
						<center>
							<img :src="(`../public/avatar/student/${info.student_avatar}`)" class="avatar-xxl" alt="profile">
						</center>
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong td-borderight"><h3><strong>Thông tin chi tiết Sinh viên</strong></h3></td>
								</tr>
								<tr class="td-borderight">
									<td>Họ và tên:
										<strong> {{ info.student_fullname }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Dân tộc:
										<strong v-if="info.student_ethnic==null"> -</strong>
										<strong v-else> {{ info.student_ethnic }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Tôn giáo:
										<strong v-if="info.student_religion==null"> -</strong>
										<strong v-else> {{ info.student_religion }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td >Giới tính:
										<strong v-if="info.student_gender==null"> -</strong>
										<strong v-else-if="info.student_gender==0"> Nam</strong>
										<strong v-else> Nữ</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Ngày sinh:
										<strong v-if="info.student_birthday==null"> -</strong>
										<strong v-else> {{ info.student_birthday | formatDate}}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Nơi sinh:
										<strong v-if="info.student_birth_place==null"> -</strong>
										<strong v-else> {{ info.student_birth_place }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Quốc gia:
										<strong v-if="info.student_country==null"> -</strong>
										<strong v-else> {{ info.student_country }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>CMND/CCCD:
										<strong v-if="info.student_identify_card==null"> -</strong>
										<strong v-else> {{ info.student_identify_card }}</strong>
									</td>
								</tr>
								<tr class="td-borderight">
									<td>Địa chỉ:
										<strong v-if="info.student_address==null"> -</strong>
										<strong v-else> {{ info.student_address }}</strong>
									</td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0">
								<tr>
									<td class="h3-strong" colspan="2"><h3><strong>Thông tin Khoa</strong></h3></td>
								</tr>
								<tr>
									<td>Khóa học:
										<strong v-if="info.student_course==null"> -</strong>
										<strong v-else>{{ info.course_name }}</strong>
									</td>
								</tr>
								<tr>
									<td>Khoa:
										<strong v-if="info.student_faculty==null"> -</strong>
										<strong v-else>{{ info.faculty_name }}</strong>
									</td>
								</tr>
								<tr>
									<td>Chuyên ngành:
										<strong v-if="info.student_major==null"> -</strong>
										<strong v-else>{{ info.major_name }}</strong>
									</td>
								</tr>
								<tr>
									<td>Lớp học:
										<strong v-if="info.student_class==null"> -</strong>
										<strong v-else> {{ info.course_code }}-{{ info.class_name }}</strong>
									</td>
								</tr>
								<tr>
									<td>Tình trạng học:
										<strong v-if="info.student_role==1"> Đã ra trường</strong>
										<strong v-else-if="info.student_role==0"> Còn đang học</strong>
									</td>
								</tr>

								<br>
								<tr>
									<td class="h3-strong"><h3>
										<strong>Thông tin liên lạc</strong></h3>
									</td>
								</tr>
								<tr>
									<td>Số điện thoại:
										<strong v-if="info.student_phone==null"> -</strong>
										<strong v-else> {{ info.student_phone }}</strong>
									</td>
								</tr>
								<tr>
									<td>Email trường:
										<strong> {{ info.student_email }}</strong>
									</td>
								</tr>
								<tr>
									<td>Email cá nhân:
										<strong v-if="info.student_other_email==null"> -</strong>
										<strong v-else> {{ info.student_other_email }}</strong>
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
							<h5 class="modal-title" id="ImportModalTitle">Import sinh viên</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tệp Excel <span class="text-danger">(*)</span></label>
							<input type="file" class="form-control" id="fileImport" name="fileImport" ref="fileimport" @change="onFileChange">
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
				courses:[],
				faculties:[],
				majors:[],
				classes:[],
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
					student_course:'',
					student_faculty:'',
					student_major:'',
					student_class:'',
					student_birthday:'',
					student_avatar:'',
					student_gender:'',
					student_ethnic:'',
					student_religion:'',
					student_phone:'',
					student_address:'',
					student_country:'',
					student_identify_card:'',
					student_birth_place:'',
					student_other_email:'',
					student_role:'',
					student_status: ''
				}),
				selected: [],
				selectAll: false,
				details:[],
				value_role:'',
				fileImport: '',
				error: {},
				student_avatar:''
			}
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.pagination=1;
					this.fetchStudents();
				}else{
					this.pagination=1;
					this.fetchStudents();
				}
			},
			query(keyword){
				if(keyword === ''){
					this.fetchStudents();
				}else{
					this.value_role='';
					this.pagination.current_page=1;
					this.search();
				}
			},
			value_role(value){
				if(value === ''){
					this.fetchStudents();
				}else{
					this.pagination.current_page=1;
					this.filter();
				}
			},
		},
		mounted() {
			this.fetchStudents();
			this.fetchFaculties();
			this.fetchCourses();
			this.fetchMajors();
			this.fetchClasses();
		},
		methods: {
			empty() {
				return (this.students.length < 1);
			},
			fetchStudents(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			fetchCourses(page_url) {
				let vm = this;
				page_url = '../../api/admin/edu-course/khoa-hoc/course';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.courses = res.data;
				})
				.catch(err => console.log(err));
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
				page_url = '../../api/admin/edu-major/chuyen-nganh/major';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.majors = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchClasses(page_url) {
				let vm = this;
				page_url = '../../api/admin/class-sv/lop/all-class';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.classes = res.data;
				})
				.catch(err => console.log(err));
			},
			search(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/search/'+this.query+'/'+this.currentEntries+'?page=1';
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			show(student) {
				this.editMode = true;
				this.form.reset();
				this.form.clear();
				this.form.fill(student);
				this.student_avatar=`../public/avatar/student/${student.student_avatar}`;
				$('#StudentModal').modal('show');
			},
			update() {
				this.form.busy = true;
				if(document.getElementById("student_avatar").files[0]){
					this.form.student_avatar = document.getElementById("student_avatar").files[0];
					this.form.post(`../../api/admin/user-sv/sinh-vien/upgrade/${this.form.student_id}`)
					.then(res => {
						this.fetchStudents();
						$('#StudentModal').modal('hide');
						if(this.form.successful){
							this.$snotify.success('Cập nhật thông tin thành công');
						}else{
							this.$snotify.error('Không thể chỉnh sửa');
						}
					})
					.catch(err => console.log(err));
				}else {
					this.form.put(`../../api/admin/user-sv/sinh-vien/${this.form.student_id}`)
					.then(res => {
						this.fetchStudents();
						$('#StudentModal').modal('hide');
						if(this.form.successful){
							this.$snotify.success('Cập nhật thông tin thành công');
						}else{
							this.$snotify.error('Không thể chỉnh sửa');
						}
					})
					.catch(err => console.log(err));
				}
			},
			patch(event, student_id) {
				this.form.student_role = event.target.value;
				this.form.patch(`../../api/admin/user-sv/sinh-vien/patch/${student_id}`)
				.then(res => {
					this.fetchStudents();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			change(student_id) {
				axios.patch(`../../api/admin/user-sv/sing-vien/change/${student_id}`)
				.then(res => {
					this.fetchStudents();
					this.$snotify.warning('Đã thay đổi trạng thái');
				})
				.catch(err => console.log(err));
			},
			destroy(student_id) {
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
							axios.delete(`../../api/admin/user-sv/sinh-vien/${student_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchStudents();
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
							axios.post('../../api/admin/user-sv/sinh-vien/destroyall', { student: this.selected })
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchStudents();
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
					for(let i in this.students){
						this.selected.push(this.students[i].student_id);
					}
				}
			},
			detail(student, page_url) {
				let vm = this;
				page_url = `../../api/admin/user-sv/sinh-vien/detail/${student.student_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.details = res.data;
					if (res.data.length==0) {
						this.$snotify.error('Sinh viên chưa có thông tin!');
					}else {
						$('#DetailModal').modal('show');
					}
				})
				.catch(err => console.log(err));
			},
			filter(page_url) {
				let vm = this;
				page_url = '../../api/admin/user-sv/sinh-vien/filter/'+this.value_role+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.students = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			reload(){
				this.fetchStudents();
				this.query='';
				this.value_role='';
			},
			onAvatarChange(e){
				const file = e.target.files[0];
				this.student_avatar = URL.createObjectURL(file);
			},
			openImport() {
				this.$refs.fileimport.value='';
				$('#ImportModal').modal('show');
			},
			onFileChange(e) {
				if (e.target.files[0].name != 'list_of_student.xlsx') {
					this.$refs.fileimport.value='';
					this.$snotify.error('Tên tệp Excel không đúng!');
				} else {
					this.fileImport = e.target.files[0]
				}
			},
			reloadFile() {
				this.$refs.fileimport.value='';
				this.fileImport='';
			},
			importFile() {
				let formData = new FormData();
				formData.append('fileImport', this.fileImport);
				axios.post(`../../api/admin/user-sv/sinh-vien/import`, formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#ImportModal').modal('hide');
						this.fetchStudents();
						this.$snotify.success('Import thành công');
					}
				})
				.catch(err => {
					console.log(err);
					if(err.response.data.errors?.fileImport?.length > 0){
						this.error = err.response.data.errors.fileImport[0];
					}else if(err.response.data.errors[0].length > 0){
						const stringError = err.response.data.errors[0][0];
						const stringSplit = stringError.split(".");
						this.error = stringSplit[1];
					}

					this.fetchStudents();
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
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
	.btn-import {
		background-color: green;
		color: white;
	}
	.btn-import:hover {
		background-color: forestgreen;
		color: white;
	}
	.avatar-xxl {
        height: 8rem;
		width: 8rem;
	}
	strong {
		word-break:break-word;
	}
</style>
