<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb">
				<!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">
						Dashboard
					</router-link>
				</li>
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'educationprogramindex' }">
						Danh sách Chương trình đào tạo
					</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					Cập nhật Chương trình đào tạo
				</li>
			</ol>
			<!-- End breadcrumb -->
		</div>
		<router-link tag="button" class="btn btn-lg btn-primary mb-3" :to="{ name: 'educationprogramindex' }">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
		</router-link>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Chương trình đào tạo</h3>
			</div>
			<div class="card-body">
				<form @submit.prevent="update()" enctype="multipart/form-data" @keydown="form.onKeydown($event)">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-label">
									Mã chương trình đào tạo
								</label>
								<input type="text" name="education_program_code" class="form-control not-allow" v-model="form.education_program_code" :class="{'is-invalid': form.errors.has('education_program_code')}" disabled />
								<div class="text-danger" v-if="form.errors.has('education_program_code')" v-html="form.errors.get('education_program_code')"></div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Khóa học</label>
								<select class="form-control not-allow" name="education_program_course" v-model="form.education_program_course" :class="{'is-invalid': form.errors.has('education_program_course')}" disabled>
									<option value="" disabled selected="">
										Chọn khóa học
									</option>
									<option value="" disabled>-------</option>
									<option v-for="course in courses" :key="course.course_code" :value="course.course_code">{{ course.course_name }}</option>
								</select>
								<div class="text-danger" v-if="form.errors.has('education_program_course')" v-html="form.errors.get('education_program_course')"></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-label">Hệ đào tạo</label>
								<select class="form-control" name="education_program_type" v-model="form.education_program_type" :class="{'is-invalid': form.errors.has('education_program_type')}">
									<option value="" disabled selected="">Chọn hệ đào tạo</option>
									<option value="" disabled>-------</option>
									<option v-for="type in types" :key="type.program_type_code" :value="type.program_type_code">{{ type.program_type_name }}</option>
								</select>
								<div class="text-danger" v-if="form.errors.has('education_program_type')" v-html="form.errors.get('education_program_type')"></div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label"> Tổng năm đào tạo </label>
								<input type="number" name="education_program_year" class="form-control" v-model="form.education_program_year" :class="{'is-invalid': form.errors.has('education_program_year')}"/>
								<div class="text-danger" v-if="form.errors.has('education_program_year')" v-html="form.errors.get('education_program_year')"></div>
							</div>
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-md-12 col-lg-12">
							<div class="card">
								<div class="col-md-12">
									<h2 class="text-center mt-3">
										<strong>Chương trình đào tạo {{ this.form.education_program_course }}</strong>
									</h2>
								</div>

								
								<div class="text-center">
									<h4>Tổng số tín chỉ: {{ this.form.education_program_credit }}</h4>
								</div>

								<div class="row">
									<div class="col-md-12">
										<button type="button" class="btn btn-outline-success btn-lg mt-2 mr-3 fa fa-upload" style="float: right;" @click="openImport()"> Import</button>
									</div>
								</div>
								
								<div class="table-responsive">
									<table class="table card-table table-vcenter text-nowrap table-nowrap table-striped">
										<thead class="blue-background text-white">
											<tr>
												<th class="w-5" scope="col" rowspan="2">STT</th>
												<th class="text-center w-15" scope="col" rowspan="2">Mã môn học</th>
												<th class="text-center w-20" scope="col" rowspan="2">Tên môn học</th>
												<th class="text-center w-5" scope="col" rowspan="2">Số tín chỉ</th>
												<th class="text-center" scope="col" colspan="2">Số tiết (giờ)</th>
												<th class="text-center" scope="col" colspan="3">Trọng số (%)</th>
												<th class="text-center w-5" scope="col" rowspan="2">Bắt buộc</th>
												<th class="text-center w-15" scope="col" rowspan="2">Khoa/Bộ môn</th>
												<th class="text-center w-5" scope="col" rowspan="2" colspan="2"></th>
											</tr>
											<tr>
												<th class="text-center w-5" scope="col">Lý thuyết</th>
												<th class="text-center w-5" scope="col">Thực hành</th>
												<th class="text-center w-5" scope="col">Bài tập</th>
												<th class="text-center w-5" scope="col">Kiểm tra</th>
												<th class="text-center w-5" scope="col">Cuối kỳ</th>
											</tr>
										</thead>
										<tbody>
											<tr v-show="education.length" v-for="(edu, index) in education" :key="edu.program_detail_id">
												<td class="td-table">{{ index += 1 }}</td>
												<td hidden>{{ getCode(edu) }}</td>
												<td class="text-center td-table">
													<a href="javascript:void(0)" @click="detailEducation(edu.program_detail_id)">{{ subject_code }}</a>
												</td>
												<td class="text-center td-table">{{ subject_name }}</td>
												<td class="text-center td-table">{{ subject_credit }}</td>
												<td class="text-center td-table">{{ subject_theory_period }}</td>
												<td class="text-center td-table">{{ subject_practice_period }}</td>
												<td class="text-center td-table">{{ subject_score_exercise }}</td>
												<td class="text-center td-table">{{ subject_score_exam }}</td>
												<td class="text-center td-table">{{ subject_score_final }}</td>
												<td class="text-center td-table">
													<p v-if="subject_type == 0">x</p>
													<p v-else></p>
												</td>
												<td class="text-center td-table">{{ subject_faculty }}</td>
												<td style="text-align: center">
													<button type="button" class="active btn btn-success btn-lg fa fa-pencil" @click="show(edu.program_detail_id)"></button>
												</td>
												<td>
													<button type="button" class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(edu.program_detail_id)"></button>
												</td>
											</tr>
											<tr v-show="!education.length">
												<td colspan="14">
													<div class="alert alert-danger">
														Không tìm thấy kết quả phù hợp!
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="text-right">
						<button :disabled="form.busy" class="btn btn-success btn-lg mt-1" type="submit">Lưu</button>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header styling-modal-header-info">
						<h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết môn học</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table row table-borderless w-100 m-0 border">
							<tbody class="col-lg-6 p-0 br-styling" v-for="detail in details" :key="detail.subject_id">
								<tr>
									<td class="h3-strong"><h3><strong><u> Thông tin chi tiết</u></strong></h3></td>
								</tr>
								<tr>
									<td>Mã Môn học: <strong> {{ detail.subject_code }}</strong></td>
								</tr>
								<tr>
									<td>Tên Môn học: <strong> {{ detail.subject_name }}</strong></td>
								</tr>
								<tr>
									<td>Số tín chỉ: <strong> {{ detail.subject_credit }}</strong></td>
								</tr>
								<tr>
									<td>Khoa: <strong> {{ detail.subject_faculty }}</strong></td>
								</tr>
								<tr>
									<td>Loại môn học: 
										<strong v-if="detail.subject_type==0"> Bắt buộc</strong>
										<strong v-else> Tự chọn</strong>
									</td>
								</tr>
								<tr>
									<td>Lý thuyết: 
										<strong>{{ detail.subject_theory_period }} giờ</strong>
									</td>
								</tr>
								<tr>
									<td>Thực hành: 
										<strong>{{ detail.subject_practice_period }} giờ</strong>
									</td>
								</tr>
								<tr>
									<td>Điểm bài tập: 
										<strong>{{ detail.subject_score_exercise }}%</strong>
									</td>
								</tr>
								<tr>
									<td>Điểm kiểm tra: 
										<strong>{{ detail.subject_score_exam }}%</strong>
									</td>
								</tr>
								<tr>
									<td>Điểm thi: 
										<strong>{{ detail.subject_score_final }}%</strong>
									</td>
								</tr>
							</tbody>
							<tbody class="col-lg-6 p-0" v-for="detailpro in detailpros" :key="detailpro.program_detail_id">
								<tr>
									<td class="h3-strong"><h3><strong><u> Chi tiết đào tạo</u></strong></h3></td>
								</tr>
								<tr>
									<td>Mã chương trình đào tạo: 
										<strong>{{ detailpro.program_detail_code }}</strong>
									</td>
								</tr>
								<tr>
									<td>Học kỳ: 
										<strong>{{ detailpro.program_detail_semester }}</strong>
									</td>
								</tr>
								<tr>
									<td>Ghi chú: 
										<strong>{{ majorSubject(detailpro) }}</strong>
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

		<!-- Modal -->
		<div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="ImportModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="importFile()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="ImportModalTitle">Import Môn học</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label>Tệp Excel</label>
							<input type="file" class="form-control" id="fileImport" name="fileImport" ref="importupload" @change="onFileChange">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" @click="reloadFile()" >Tải lại</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal end-->

		<!-- Modal -->
		<div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="UpdateModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="updatePro()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="UpdateModalTitle">Cập nhật môn học trong CTĐT</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Mã môn học</label>
								<input v-model="updatedata.subject_code" class="form-control not-allow" name="subject_code" disabled>
							</div>
							<div class="form-group">
								<label>Học kỳ</label>
								<input v-model="updatedata.subject_semester" type="number" class="form-control" name="subject_semester">
							</div>
							<div class="form-group">
								<label>Dành cho chuyên ngành</label>
								<select v-model="updatedata.subject_major" class="form-control" name="subject_major">
									<option value="">Không có</option>
									<option v-for="major in majors" :key="major.major_code" :value="major.major_code" :hidden="major.major_faculty!=form.education_program_faculty">{{ major.major_name }}</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn btn-primary">Cập nhật</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal end-->

	</div>
</template>

<script>
	import XLSX from "xlsx";
	export default {
		data() {
			return {
				programs:[],
				education_program_id: this.$route.params.idProgram,
				education:[],
				lecturers:[],
				lecturer_faculty: "",
				lecturer_id: this.$facultyId,
				faculties: [],
				subjects: [],
				majors: [],
				courses: [],
				types: [],
				form: new Form({
					education_program_id: "",
					education_program_code: "",
					education_program_type: "",
					education_program_course: "",
					education_program_faculty: "",
					education_program_year: "",
					education_program_credit: "",
					education_program_status: "",
					file_data:'',
				}),
				updatedata: {
					subject_id: '',
					subject_code: '',
					subject_semester: '',
					subject_major: ''
				},
				displayData: [],
				subject_code: "",
				subject_name: "",
				subject_faculty: "",
				subject_credit: "",
				subject_practice_period: "",
				subject_theory_period: "",
				subject_score_exercise: "",
				subject_score_exam: "",
				subject_score_final: "",
				subject_type: "",
				details:[],
				detailpros:[],
				error: {},
				fileImport: '',
			};
		},
		mounted() {
			this.fetchCourses();
			this.fetchFaculties();
			this.fetchMajors();
			this.fetchSubjects();
			this.fetchTypes();
			this.fetchLecturers();
			this.fetchPrograms();
			this.fetchEducation();
		},
		watch: {
			'$route'(to, from) {
				this.education_program_id = to.params.idProgram;
			}
		},
		methods: {
			empty() {
				return (this.education.length < 1);
			},
			fetchPrograms(education_program_id, page_url) {
				let vm = this;
				education_program_id = this.education_program_id;
				page_url = `../../api/admin/program/chuong-trinh-dao-tao/program-one/${education_program_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.programs = res.data;
					this.form.fill(this.programs[0]);
				})
				.catch(err => console.log(err));
			},
			fetchCourses(page_url) {
				let vm = this;
				page_url = "../../api/admin/edu-course/khoa-hoc/course";
				fetch(page_url)
				.then((res) => res.json())
				.then((res) => {
					this.courses = res.data;
				})
				.catch((err) => console.log(err));
			},
			fetchFaculties(page_url) {
				let vm = this;
				page_url = "../../api/admin/edu-faculty/khoa/faculty";
				fetch(page_url)
				.then((res) => res.json())
				.then((res) => {
					this.faculties = res.data;
				})
				.catch((err) => console.log(err));
			},
			fetchMajors(page_url) {
				let vm = this;
				page_url = "../../api/admin/edu-major/chuyen-nganh/major";
				fetch(page_url)
				.then((res) => res.json())
				.then((res) => {
					this.majors = res.data;
				})
				.catch((err) => console.log(err));
			},
			fetchSubjects(page_url) {
				let vm = this;
				page_url = "../../api/admin/manage/mon-hoc/subject";
				fetch(page_url)
				.then((res) => res.json())
				.then((res) => {
					this.subjects = res.data;
				})
				.catch((err) => console.log(err));
			},
			fetchTypes(page_url) {
				let vm = this;
				page_url = "../../api/admin/type/he-dao-tao/program-type";
				fetch(page_url)
				.then((res) => res.json())
				.then((res) => {
					this.types = res.data;
				})
				.catch((err) => console.log(err));
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
			fetchEducation(education_program_id, page_url) {
				let vm = this;
				education_program_id = this.education_program_id;
				page_url = `../../api/admin/program/chuong-trinh-dao-tao/show-subject-program/${education_program_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.education = res.data;
				})
				.catch(err => console.log(err));
			},
			getCode(edu) {
				this.subjects.forEach((sbj) => {
					if (sbj.subject_code === edu.program_detail_subject) {
						this.subject_code = sbj.subject_code;
						this.subject_name = sbj.subject_name;
						this.subject_credit = sbj.subject_credit;
						this.subject_practice_period = sbj.subject_practice_period;
						this.subject_theory_period = sbj.subject_theory_period;
						this.subject_score_exercise = sbj.subject_score_exercise;
						this.subject_score_exam = sbj.subject_score_exam;
						this.subject_score_final = sbj.subject_score_final;
						this.subject_type = sbj.subject_type;
						this.subject_faculty = sbj.subject_faculty;
					}
				});
				const faculty = this.faculties.find(
					(fac) => fac.faculty_code === this.subject_faculty
					);
				this.subject_faculty = faculty.faculty_name;
			},
			majorSubject(detailpro) {
				if (detailpro.program_detail_note != null) {
					const major = this.majors.find((mjr) => mjr.major_code === detailpro.program_detail_note);
					return major.major_name;
				}
			},
			facultySubject(subject) {
				const faculty = this.faculties.find((fac) => fac.faculty_code === subject.subject_faculty);
				return faculty.faculty_name;
			},
			update() {
				this.form.put(`../../api/admin/program/chuong-trinh-dao-tao/${this.education_program_id}`)
				.then(res => {
					if(this.form.successful){
						this.$snotify.success('Cập nhật Khoa thành công!');
						this.$snotify.confirm('Bạn có muốn đi đến danh sách không?', {
							timeout: 5000,
							showProgressBar: true,
							closeOnClick: false,
							pauseOnHover: true,
							buttons: [{
								text: 'Có', 
								action: toast =>{
									this.$snotify.remove(toast.id);
									this.$router.push( { name: 'educationprogramindex' } );
								}, 
								bold: false
							},{
								text: 'Không', 
								action: toast => { 
									this.$snotify.remove(toast.id); 
								}, 
								bold: true
							}]
						});
					}else{
						this.$snotify.error('Không thể chỉnh sửa');
					}
				})
				.catch(err => console.log(err));
			},
			show(program_detail_id) {
				let detailpro = this.education.filter(function(edu){
					return edu.program_detail_id===program_detail_id
				})
				this.updatedata.subject_id = detailpro[0].program_detail_id
				this.updatedata.subject_code = detailpro[0].program_detail_subject;
				this.updatedata.subject_semester = detailpro[0].program_detail_semester;
				this.updatedata.subject_major = detailpro[0].program_detail_note;
				$('#UpdateModal').modal('show');
			},
			updatePro() {
				let formData = new FormData();
				formData.append('subject_semester', this.updatedata.subject_semester);
				formData.append('subject_major', this.updatedata.subject_major);
				axios.post(`../../api/admin/program/chuong-trinh-dao-tao/update-subject-program/${this.updatedata.subject_id}`, formData)
				.then(res => {
					this.$snotify.success('Cập nhật Khoa thành công!');
					$('#UpdateModal').modal('hide');
				})
				.catch(err => {
					this.$snotify.error(err.response.data.errors.subject_semester[0]);
				});
			},
			detailEducation(program_detail_id, page_url) {
				let vm = this;
				page_url = `../../api/admin/program/chuong-trinh-dao-tao/detail-subject-program/${program_detail_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.detailpros = res.data;
					let subject = this.subjects.filter(function(sbj){
						return sbj.subject_code===res.data[0].program_detail_subject;
					})
					this.details = subject;
					$('#DetailModal').modal('show');
				})
				.catch(err => console.log(err));
			},
			destroy(program_detail_id) {
				this.$snotify.clear();
				this.$snotify.confirm('Bạn muốn xóa môn học khỏi chương trình đào tạo?', {
					timeout: 5000,
					showProgressBar: true,
					closeOnClick: false,
					pauseOnHover: true,
					buttons: [{
						text: 'Xóa', 
						action: toast =>{
							this.$snotify.remove(toast.id);
							axios.post(`../../api/admin/program/chuong-trinh-dao-tao/destroy-subject-program/${program_detail_id}`)
							.then(res => {
								this.$snotify.success('Đã xóa!');
								this.fetchEducation();
								this.fetchPrograms();
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
			openImport() {
				this.$refs.importupload.value='';
				$('#ImportModal').modal('show');
			},
			onFileChange(e) {
				this.fileImport = e.target.files[0];
			},
			reloadFile() {
				this.$refs.importupload.value='';
				this.fileImport='';
			},
			importFile(education_program_id) {
				education_program_id = this.education_program_id;
				let formData = new FormData();
				formData.append('fileImport', this.fileImport);
				axios.post(`../../api/admin/program/chuong-trinh-dao-tao/import/${education_program_id}`, formData, {
					headers: { 'content-type': 'multipart/form-data' }
				})
				.then(res => {
					if(res.status === 200) {
						$('#SubjectModal').modal('hide');
						this.fetchEducation();
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
					
					this.fetchEducation();
					this.$snotify.error(this.error);
				});
			},
			create() {
				$('#SubjectModal').modal('show');
			},
		},
	};
</script>

<style lang="css" scoped>
	.thead-styling {
		background-color: darkblue;
		color: white;
		font-weight: bold;
	}
	.text-center {
		vertical-align: middle;
		border: 0.5px solid white;
	}
	.td-table {
		vertical-align: middle;
		border: 0.5px solid black !important;
	}
	.not-allow {
		cursor: not-allowed;
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
	.br-styling {
		border-right: 1px solid;
	}
	.modal-lg {
		max-width: 1500px;
	}
</style>
