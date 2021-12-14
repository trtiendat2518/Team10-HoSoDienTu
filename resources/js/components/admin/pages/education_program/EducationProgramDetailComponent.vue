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
		<router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'educationprogramindex' }">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
		</router-link>
		<VueSlickCarousel :arrows="true" :dots="false" :infinite="true" :slidesToShow="3" :slidesToScroll="1" :autoplay="true" :speed="3000" :autoplaySpeed="2000">
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-primary-transparent">
									<i class="fa fa-info-circle fa-stack-1x text-primary"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Mã hệ đào tạo: </p>
									<h4 class="mb-0 text-dark">{{ educa.education_program_type }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-success-transparent">
									<i class="fa fa-suitcase fa-stack-1x text-success"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Hệ đào tạo:</p>
									<h4 class="mb-0 text-dark">{{ educa.program_type_name }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-pink-transparent">
									<i class="fa fa-barcode fa-stack-1x text-pink"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Mã chương trình đào tạo: </p>
									<h4 class="mb-0 text-dark">{{ educa.education_program_code }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-warning-transparent">
									<i class="fa fa-university fa-stack-1x text-warning"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Chương trình đào tạo:</p>
									<h4 class="mb-0 text-dark">{{ educa.education_program_course }} - {{ educa.faculty_name }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-danger-transparent">
									<i class="fa fa-binoculars fa-stack-1x text-danger"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Tổng số tín chỉ: </p>
									<h4 class="mb-0 text-dark">{{ educa.education_program_credit }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="card mb-0">
					<div class="row">
						<div class="col-3">
							<div class="feature">
								<div class="fa-stack fa-lg fa-2x icon bg-info-transparent">
									<i class="fa fa-archive fa-stack-1x text-dark"></i>
								</div>
							</div>
						</div>
						<div class="col-9">
							<div class="card-body p-3 d-flex">
								<div>
									<p class="text-primary mb-1">Số năm đào tạo: </p>
									<h4 class="mb-0 text-dark">{{ educa.education_program_year }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</VueSlickCarousel>
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
									<td class="text-center td-table">{{ edu.subject_code }}</td>
									<td class="text-center td-table">{{ edu.subject_name }}</td>
									<td class="text-center td-table">{{ edu.subject_credit }}</td>
									<td class="text-center td-table">{{ edu.subject_theory_period }}</td>
									<td class="text-center td-table">{{ edu.subject_practice_period }}</td>
									<td class="text-center td-table">{{ edu.subject_score_exercise }}</td>
									<td class="text-center td-table">{{ edu.subject_score_exam }}</td>
									<td class="text-center td-table">{{ edu.subject_score_final }}</td>
									<td class="text-center td-table">
										<p v-if="edu.subject_type == 0">x</p>
										<p v-else></p>
									</td>
									<td class="text-center td-table">{{ edu.faculty_name }}</td>
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
	import VueSlickCarousel from 'vue-slick-carousel'
	import 'vue-slick-carousel/dist/vue-slick-carousel.css'
	import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
	export default {
		components: { VueSlickCarousel },
		data() {
			return {
				education_program_id: this.$route.params.idProgram,
				education:[],
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
					program_type_name: "",
					faculty_name:"",
				}
			};
		},
		watch: {
			'$route'(to, from) {
				this.education_program_id = to.params.idProgram;
			}
		},
		mounted() {
			this.fetchEducation();
			this.fetchPrograms();
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
					this.educa.program_type_name = this.programs[0].program_type_name;
					this.educa.faculty_name = this.programs[0].faculty_name;
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
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
