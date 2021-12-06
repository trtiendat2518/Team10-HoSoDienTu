<template>
	<div>
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
					Chi tiết chương trình đào tạo
				</li>
			</ol>
			<!-- End breadcrumb -->
		</div>
		<router-link tag="button" class="btn btn-lg btn-primary mb-3" :to="{ name: 'educationprogramindex' }">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
		</router-link>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-12">
							<h1 class="card-title text-center font-weight-bold">
								Chương trình đào tạo
							</h1>
						</div>
					</div>
					<div class="row mt-3 item">
						<carousel :per-page="1" :mouse-drag="false" :loop="true" :autoplay="true" :perPageCustom="[[320, 2], [1199, 2]]" :paginationActiveColor="'#1753fc'" :paginationColor="'#868e96'">
							<slide>
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">Mã hệ đào tạo: <strong>{{ educa.education_program_type }}</strong></div>
											<div class="col-md-12" v-for="type in types.slice(0, 1)" :key="type.program_type_code">Hệ đào tạo: 
												<div hidden>{{ nameType(type) }}</div>
												<strong>{{ educa.type_name }}</strong>
											</div>
										</div>
									</div>
								</div>
							</slide>
							<slide>
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">Mã chương trình đào tạo: <strong>{{ educa.education_program_code }}</strong></div>
											<div class="col-md-12" v-for="faculty in faculties.slice(0, 1)" :key="faculty.faculty_code">Chương trình đào tạo: 
												<div hidden>{{ nameFaculty(faculty) }}</div>
												<strong>{{ educa.education_program_course }} - {{ educa.faculty_name }}</strong>
											</div>
										</div>
									</div>
								</div>
							</slide>
							<slide>
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">Tổng số tín chỉ: <strong>{{ educa.education_program_credit }}</strong></div>
											<div class="col-md-12">Số năm đào tạo: <strong>{{ educa.education_program_year }}</strong></div>
										</div>
									</div>
								</div>
							</slide>
						</carousel>
					</div>

					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap table-striped">
							<thead class="blue-background text-white">
								<tr>
									<th class="w-5" scope="col" rowspan="2">STT</th>
									<th class="text-center w-10" scope="col" rowspan="2">Mã môn học</th>
									<th class="text-center w-15" scope="col" rowspan="2">Tên môn học</th>
									<th class="text-center w-5" scope="col" rowspan="2">Số tín chỉ</th>
									<th class="text-center" scope="col" colspan="2">Số tiết (giờ)</th>
									<th class="text-center" scope="col" colspan="3">Trọng số (%)</th>
									<th class="text-center w-5" scope="col" rowspan="2">Bắt buộc</th>
									<th class="text-center w-10" scope="col" rowspan="2">Khoa/Bộ môn</th>
									<th class="text-center w-5" scope="col" rowspan="2">Học kỳ</th>
									<th class="text-center w-10" scope="col" rowspan="2">Ghi chú</th>
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
									<td class="text-center td-table">{{ educa.subject_code }}</td>
									<td class="text-center td-table">{{ educa.subject_name }}</td>
									<td class="text-center td-table">{{ educa.subject_credit }}</td>
									<td class="text-center td-table">{{ educa.subject_theory_period }}</td>
									<td class="text-center td-table">{{ educa.subject_practice_period }}</td>
									<td class="text-center td-table">{{ educa.subject_score_exercise }}</td>
									<td class="text-center td-table">{{ educa.subject_score_exam }}</td>
									<td class="text-center td-table">{{ educa.subject_score_final }}</td>
									<td class="text-center td-table">
										<p v-if="educa.subject_type == 0">x</p>
										<p v-else></p>
									</td>
									<td class="text-center td-table">{{ educa.subject_faculty }}</td>
									<td class="text-center td-table">{{ edu.program_detail_semester }}</td>
									<td class="text-center td-table">{{ nameMajor(edu) }}</td>
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
			<!-- col end -->
		</div>
	</div>
</template>

<script>
	import { Carousel, Slide } from 'vue-carousel';
	export default {
		components: {
			Carousel,
			Slide
		},
		data() {
			return {
				education_program_id: this.$route.params.idProgram,
				education:[],
				subjects:[],
				faculties:[],
				types:[],
				majors:[],
				educa: {
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

					education_program_code: "",
					education_program_type: "",
					education_program_course: "",
					education_program_faculty: "",
					education_program_year: "",
					education_program_credit: "",
					type_name: "",
					faculty_name:"",
					program_note:""
				}
			};
		},
		watch: {
			'$route'(to, from) {
				this.education_program_id = to.params.idProgram;
			}
		},
		mounted() {
			this.fetchFaculties();
			this.fetchSubjects();
			this.fetchEducation();
			this.fetchPrograms();
			this.fetchTypes();
			this.fetchMajors();
		},
		methods: {
			fetchPrograms(education_program_id, page_url) {
				let vm = this;
				education_program_id = this.education_program_id;
				page_url = `../../api/admin/program/chuong-trinh-dao-tao/program-one/${education_program_id}`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.programs = res.data;

					this.educa.education_program_code = this.programs[0].education_program_code;
					this.educa.education_program_type = this.programs[0].education_program_type;
					this.educa.education_program_course = this.programs[0].education_program_course;
					this.educa.education_program_year = this.programs[0].education_program_year;
					this.educa.education_program_credit = this.programs[0].education_program_credit;
					this.educa.education_program_faculty = this.programs[0].education_program_faculty;
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
			getCode(edu) {
				this.subjects.forEach((sbj) => {
					if (sbj.subject_code === edu.program_detail_subject) {
						this.educa.subject_code = sbj.subject_code;
						this.educa.subject_name = sbj.subject_name;
						this.educa.subject_credit = sbj.subject_credit;
						this.educa.subject_practice_period = sbj.subject_practice_period;
						this.educa.subject_theory_period = sbj.subject_theory_period;
						this.educa.subject_score_exercise = sbj.subject_score_exercise;
						this.educa.subject_score_exam = sbj.subject_score_exam;
						this.educa.subject_score_final = sbj.subject_score_final;
						this.educa.subject_type = sbj.subject_type;
						this.educa.subject_faculty = sbj.subject_faculty;
					}
				});
				const faculty = this.faculties.find((fac) => fac.faculty_code === this.educa.subject_faculty);
				this.educa.subject_faculty = faculty.faculty_name;
			},
			nameType(type) {
				this.programs.forEach((pro) => {
					if(pro.education_program_id == this.education_program_id) {
						this.types.forEach((typ) => {
							if (typ.program_type_code==pro.education_program_type) {
								this.educa.type_name = typ.program_type_name;
							}
						})
					}
				})
			},
			nameFaculty(faculty) {
				this.programs.forEach((pro) => {
					if(pro.education_program_id == this.education_program_id) {
						this.faculties.forEach((fac) => {
							if (fac.faculty_code==pro.education_program_faculty) {
								this.educa.faculty_name = fac.faculty_name;
							}
						})
					}
				})
			},
			nameMajor(edu) {
				if (edu.program_detail_note!=null) {
					const major = this.majors.find((mjr) => mjr.major_code === edu.program_detail_note);
					return major.major_name;
				} else {
					return '';
				}
			}
		}
	};
</script>

<style lang="css" scoped>
	.item {
		width: 100%;
		padding: 20px;
	}
	.card-body {
		background-color: #f8f9fa;
	}
</style>
