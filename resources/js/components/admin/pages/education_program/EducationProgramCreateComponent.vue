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
					Tạo mới Chương trình đào tạo
				</li>
			</ol>
			<!-- End breadcrumb -->
		</div>
		<router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'educationprogramindex' }">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
		</router-link>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Chương trình đào tạo</h3>
			</div>
			<div class="card-body">
				<form @submit.prevent="store()" enctype="multipart/form-data" @keydown="form.onKeydown($event)">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-label">Hệ đào tạo <span class="text-danger">(*)</span></label>
								<select class="form-control" name="education_program_type" v-model="form.education_program_type" :class="{'is-invalid': form.errors.has('education_program_type')}">
									<option value="" disabled selected="">Chọn hệ đào tạo</option>
									<option value="" disabled>-------</option>
									<option v-for="type in types" :key="type.program_type_id" :value="type.program_type_id" :hidden="type.program_type_status>0">{{ type.program_type_code }} - {{ type.program_type_name }}</option>
								</select>
								<div class="text-danger" v-if="form.errors.has('education_program_type')" v-html="form.errors.get('education_program_type')"></div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Khóa học <span class="text-danger">(*)</span></label>
								<select class="form-control" name="education_program_course" v-model="form.education_program_course" :class="{'is-invalid': form.errors.has('education_program_course')}">
									<option value="" disabled selected="">
										Chọn khóa học
									</option>
									<option value="" disabled>-------</option>
									<option v-for="course in courses" :key="course.course_id" :value="course.course_id">{{ course.course_code }} - {{ course.course_name }}</option>
								</select>
								<div class="text-danger" v-if="form.errors.has('education_program_course')" v-html="form.errors.get('education_program_course')"></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Mã chương trình đào tạo <span class="text-danger">(*)</span></label>
								<input type="text" name="education_program_code" class="form-control" v-model="form.education_program_code" :class="{'is-invalid': form.errors.has('education_program_code')}" placeholder="Nhập mã cho CTĐT"/>
								<div class="text-danger" v-if="form.errors.has('education_program_code')" v-html="form.errors.get('education_program_code')"></div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label"> Tổng năm đào tạo <span class="text-danger">(*)</span></label>
								<input type="number" name="education_program_year" class="form-control" v-model="form.education_program_year" :class="{'is-invalid': form.errors.has('education_program_year')}" placeholder="Nhập số năm"/>
								<div class="text-danger" v-if="form.errors.has('education_program_year')" v-html="form.errors.get('education_program_year')"></div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Trạng thái <span class="text-danger">(*)</span></label>
								<select class="form-control" name="education_program_status" v-model="form.education_program_status" :class="{'is-invalid': form.errors.has('education_program_status')}">
									<option value="" disabled selected="">
										Chọn Trạng thái
									</option>
									<option value="" disabled>-------</option>
									<option value="0">Hiển thị</option>
									<option value="0">Ẩn</option>
								</select>
								<div class="text-danger" v-if="form.errors.has('education_program_status')" v-html="form.errors.get('education_program_status')"></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label">Tệp Excel <span class="text-danger">(*)</span></label>
						<input type="file" class="form-control" id="file_data" name="file_data" ref="fileupload" @change="onFileChange">
					</div>

					<div v-show="displayData.length">
						<h3 class="text-center"><strong>Chương trình đào tạo</strong></h3>
						<table class="table table-striped">
							<thead class="thead-styling">
								<tr>
									<th class="text-center w-5" scope="col" rowspan="2">#</th>
									<th class="text-center w-5" scope="col" rowspan="2">Mã môn học</th>
									<th class="text-center w-20" scope="col" rowspan="2">Tên môn học</th>
									<th class="text-center w-5" scope="col" rowspan="2">Số tín chỉ</th>
									<th class="text-center" scope="col" colspan="2">Số tiết (giờ)</th>
									<th class="text-center" scope="col" colspan="3">Trọng số (%)</th>
									<th class="text-center w-5" scope="col" rowspan="2">Bắt buộc</th>
									<th class="text-center w-20" scope="col" rowspan="2">Khoa/Bộ môn</th>
									<th class="text-center w-15" scope="col" rowspan="2">Ghi chú</th>
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
								<tr v-for="(data, index) in displayData" :key="data.program_detail_subject">
									<td hidden>{{ getCode(data) }}</td>
									<td class="text-center" scope="row">
										{{ index += 1 }}
									</td>
									<td class="text-center">{{ subject_code }}</td>
									<td class="text-center">{{ subject_name }}</td>
									<td class="text-center">{{ subject_credit }}</td>
									<td class="text-center">
										{{ subject_theory_period }}
									</td>
									<td class="text-center">
										{{ subject_practice_period }}
									</td>
									<td class="text-center">
										{{ subject_score_exercise }}
									</td>
									<td class="text-center">
										{{ subject_score_exam }}
									</td>
									<td class="text-center">
										{{ subject_score_final }}
									</td>
									<td class="text-center">
										<p v-if="subject_type == 0">x</p>
										<p v-else></p>
									</td>
									<td class="text-center">{{ subject_faculty }}</td>
									<td class="text-center">
										{{ majorSubject(data) }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="card-footer text-right">
						<button :disabled="form.busy" class="btn btn-success btn-lg mt-1 btn-3d" type="submit">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import XLSX from "xlsx";
	export default {
		data() {
			return {
				lecturers:[],
				lecturer_faculty: "",
				lecturer_id: this.$facultyId,
				faculties: [],
				subjects: [],
				majors: [],
				courses: [],
				types: [],
				form: new Form({
					education_program_code: "",
					education_program_type: "",
					education_program_course: "",
					education_program_faculty: "",
					education_program_year: "",
					education_program_credit: "",
					education_program_status: "",
					file_data:'',
				}),
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
				error: {},
				number_no: 1
			};
		},
		mounted() {
			this.fetchCourses();
			this.fetchFaculties();
			this.fetchMajors();
			this.fetchSubjects();
			this.fetchTypes();
			this.fetchLecturers();
		},
		methods: {
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
						if(el.lecturer_id==this.lecturer_id){
							this.lecturer_faculty= el.lecturer_faculty;
						}
					});
				})
				.catch(err => console.log(err));
			},
			onFileChange(e) {
				this.form.file_data = e.target.files[0];
				if (this.form.file_data) {
					let fileReader = new FileReader();
					fileReader.readAsBinaryString(this.form.file_data);
					fileReader.onload = (e) => {
						let data = e.target.result;
						let workbook = XLSX.read(data, { type: "binary" });
						workbook.SheetNames.forEach((sheet) => {
							let rowObject = XLSX.utils.sheet_to_json(workbook.Sheets[sheet]);
            				//this.displayData = JSON.stringify(rowObject, undefined, 4);
            				this.displayData = rowObject;
            				//console.log(this.displayData);
            			});
					};
				}
			},
			getCode(data) {
				this.subjects.forEach((sbj) => {
					if (sbj.subject_code === data.program_detail_subject) {
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
					(fac) => fac.faculty_id === this.subject_faculty
					);
				this.subject_faculty = faculty.faculty_name;
			},
			majorSubject(data) {
				if (data?.ghi_chu) {
					const major = this.majors.find((mjr) => mjr.major_code === data.ghi_chu);
					return major.major_name;
				}
			},
			store() {
				this.form.busy = true;
				if(document.getElementById("file_data").files[0]){
					this.form.file_data = document.getElementById("file_data").files[0];
				}
				this.form.education_program_faculty = this.lecturer_faculty;
				this.form.post('../../api/admin/program/chuong-trinh-dao-tao')
				.then(res => {
					if(this.form.successful){
						this.$snotify.success('Thêm mới thành công!');
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
						this.form.clear();
						this.form.reset();
						this.displayData=[];
						this.$refs.fileupload.value='';
						this.form.file_data='';
					}
				})
				.catch(err => {
					if(err.response.data.errors?.file_data?.length > 0){
						this.error = err.response.data.errors.file_data[0];
					}else if(err.response.data.errors[0].length > 0){
						const  stringError = err.response.data.errors[0][0];
						const  stringSplit = stringError.split(".");
						this.error = stringSplit[1];
					}
                    this.form.file_data ='';
                    this.$refs.fileupload.value='';
					this.form.file_data='';
					this.$snotify.error(this.error);
				});
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
	td {
		vertical-align: middle;
		border: 0.5px solid black !important;
	}
	.btn-3d {
		border-bottom: 3px solid #6c757d;
		border-right: 3px solid #6c757d;
	}
</style>
