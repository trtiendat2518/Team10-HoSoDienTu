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
        <VueSlickCarousel
            :arrows="true"
            :dots="false"
            :infinite="true"
            :slidesToShow="3"
            :slidesToScroll="1"
            :autoplay="true"
            :speed="3000"
            :autoplaySpeed="2000"
        >
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
                                    <p class="text-primary mb-1">Mã hệ đào tạo:</p>
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
                                    <p class="text-primary mb-1">Mã chương trình đào tạo:</p>
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
                                    <p class="text-primary mb-1">Tổng số tín chỉ:</p>
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
                                    <p class="text-primary mb-1">Số năm đào tạo:</p>
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
                        <table class="table table-striped table-bordered">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5" scope="col" rowspan="2">STT</th>
                                    <th class="text-center w-5" scope="col" rowspan="2">Mã môn học</th>
                                    <th class="text-center w-10" scope="col" rowspan="2">Tên môn học</th>
                                    <th class="text-center w-5" scope="col" rowspan="2">Số TC</th>
                                    <th class="text-center w-5" scope="col" rowspan="2">Bắt buộc</th>
                                    <th class="text-center w-10" scope="col" rowspan="2">Khoa/Bộ môn</th>
                                    <th class="text-center w-10" scope="col" rowspan="2">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody v-for="i in semesters" :key="i">
                                <tr>
                                    <td colspan="13">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>
                                <tr v-for="(edu, index) in value_programs[i]" :key="edu.subject_id">
                                    <td class="td-table">{{ (index += 1) }}</td>
                                    <td class="text-center td-table">
                                        <a href="javascript:void(0)" @click="detail(edu.subject_id)">
                                            {{ edu.subject_code }}
                                        </a>
                                    </td>
                                    <td class="text-center td-table">{{ edu.subject_name }}</td>
                                    <td class="text-center td-table">{{ edu.subject_credit }}</td>
                                    <td class="text-center td-table">
                                        <p v-if="edu.subject_type == 0">x</p>
                                        <p v-else></p>
                                    </td>
                                    <td class="text-center td-table">{{ edu.faculty_name }}</td>
                                    <td class="text-center td-table">{{ nameMajor(edu) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right text-require">
                                        Tổng học phần Bắt buộc:
                                    </td>
                                    <td class="text-center text-require">
                                        {{ sum_credit_require(i) }}
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <b>Tổng học phần Tự chọn:</b>
                                    </td>
                                    <td class="text-center">
                                        <b>{{ sum_credit_option(i) }}</b>
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!semesters.length">
                                    <td colspan="11">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- col end -->
        </div>

        <!-- Modal -->
        <div
            class="modal fade bd-example-modal-lg"
            id="DetailModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="DetailModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header styling-modal-header-info">
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">
                            Chi tiết môn học
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                            v-for="detail in details"
                            :key="detail.subject_id"
                        >
                            <thead class="detail-background text-white">
                                <tr>
                                    <th class="text-center">Tên thành phần</th>
                                    <th class="text-center">Trọng số</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        Điểm bài tập
                                    </td>
                                    <td class="text-center">{{ detail.subject_score_exercise }}%</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm kiểm tra
                                    </td>
                                    <td class="text-center">{{ detail.subject_score_exam }}%</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm thi
                                    </td>
                                    <td class="text-center">{{ detail.subject_score_final }}%</td>
                                </tr>
                            </tbody>

                            <thead class="detail-background text-white">
                                <tr>
                                    <th class="text-center">Số tiết thực hành</th>
                                    <th class="text-center">Số tiết lý thuyết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{ detail.subject_practice_period }} giờ</td>
                                    <td class="text-center">{{ detail.subject_theory_period }} giờ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->
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
            education: [],
            majors: [],
            value_programs: [],
            semesters: [],
            details: [],
            educa: {
                subject_code: '',
                subject_name: '',
                subject_faculty: '',
                subject_credit: '',
                subject_practice_period: '',
                subject_theory_period: '',
                subject_score_exercise: '',
                subject_score_exam: '',
                subject_score_final: '',
                subject_type: '',

                education_program_code: '',
                education_program_type: '',
                education_program_course: '',
                education_program_faculty: '',
                education_program_year: '',
                education_program_credit: '',
                program_type_name: '',
                faculty_name: ''
            }
        }
    },
    watch: {
        $route(to, from) {
            this.education_program_id = to.params.idProgram
        }
    },
    mounted() {
        this.fetchEducation()
        this.fetchPrograms()
        this.fetchMajors()
    },
    methods: {
        fetchPrograms(education_program_id, page_url) {
            let vm = this
            education_program_id = this.education_program_id
            page_url = `../../api/admin/program/chuong-trinh-dao-tao/program-one/${education_program_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data

                    this.educa.education_program_code = this.programs[0].education_program_code
                    this.educa.education_program_type = this.programs[0].program_type_code
                    this.educa.education_program_course = this.programs[0].course_code
                    this.educa.education_program_year = this.programs[0].education_program_year
                    this.educa.education_program_credit = this.programs[0].education_program_credit
                    this.educa.education_program_faculty = this.programs[0].education_program_faculty
                    this.educa.program_type_name = this.programs[0].program_type_name
                    this.educa.faculty_name = this.programs[0].faculty_name
                })
                .catch(err => console.log(err))
        },
        fetchEducation(education_program_id, page_url) {
            let vm = this
            education_program_id = this.education_program_id
            page_url = `../../api/admin/program/chuong-trinh-dao-tao/show-subject-program/${education_program_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.education = res.data
                    const semesters = this.education.reduce((semesters, item) => {
                        const semester = semesters[item.program_detail_semester] || []
                        semester.push(item)
                        semesters[item.program_detail_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.value_programs = semesters
                    this.semesters = key
                })
                .catch(err => console.log(err))
        },
        fetchMajors(page_url) {
            let vm = this
            page_url = '../../api/admin/edu-major/chuyen-nganh/major'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                })
                .catch(err => console.log(err))
        },
        nameMajor(edu) {
            if (edu.program_detail_note != 'null' && edu.program_detail_note != null) {
                const major = this.majors.find(mjr => mjr.major_code === edu.program_detail_note)
                return major.major_name
            } else {
                return ''
            }
        },
        detail(subject_id, page_url) {
            let vm = this
            page_url = `../../api/admin/manage/mon-hoc/detail/${subject_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.details = res.data
                    $('#DetailModal').modal('show')
                })
                .catch(err => console.log(err))
        },
        sum_credit_require(i) {
            let sum = 0
            for (let j = 0; j < this.value_programs[i].length; j++) {
                if (this.value_programs[i][j].subject_type == 0) {
                    sum += parseFloat(this.value_programs[i][j].subject_credit)
                }
            }
            return sum
        },
        sum_credit_option(i) {
            let sum = 0
            for (let j = 0; j < this.value_programs[i].length; j++) {
                if (this.value_programs[i][j].subject_type > 0) {
                    sum += parseFloat(this.value_programs[i][j].subject_credit)
                }
            }
            return sum
        }
    }
}
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
