<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Kế hoạch học tập</p>
        </div>

        <div class="grid">
            <div class="alert alert-info">
                <div class="mb-2">
                    <p>
                        <i><u>Kết quả đăng ký:</u></i>
                    </p>
                    <div>
                        Tổng số tín chỉ theo kế hoạch đăng ký: <b class="text-red">{{ sum_credit }}/{{ credit_ref }}</b> (tín chỉ)
                    </div>
                </div>
                <div>
                    <p>
                        <i><u>Chú ý:</u></i>
                    </p>
                    <div>
                        <p class="fa fa-check"></p>
                        : Môn học đã đậu
                    </div>
                    <div>
                        <p class="fa fa-times"></p>
                        : Môn học đã rớt
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-select">
                        <select class="form-control" v-model="select_type">
                            <option value="1">Đăng ký kế hoạch theo gợi ý của chủ nhiệm (cả lớp)</option>
                            <option value="2">Đăng ký kế hoạch theo gợi ý của chủ nhiệm (cá nhân)</option>
                            <option value="3">Đăng ký kế hoạch theo cá nhân</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-lg btn-primary" @click="store()">Đăng ký</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-lg btn-info" @click="print()">In PDF</button>
                </div>
                <div class="col-md-2">
                    <router-link tag="button" class="btn btn-block btn-lg btn-secondary" :to="{ name: 'studyplanhistory' }">
                        Lịch sử ĐK
                    </router-link>
                </div>
            </div>

            <div class="table-responsive" ref="content" v-if="plans.length > 0">
                <table class="table table-nowrap">
                    <thead class="result-background text-white">
                        <tr>
                            <th class="text-center w-5" scope="col" rowspan="2">
                                STT
                            </th>
                            <th class="text-center w-15" scope="col" rowspan="2">
                                Mã môn học
                            </th>
                            <th class="text-center w-50" scope="col" rowspan="2">
                                Tên môn học
                            </th>
                            <th class="text-center w-10" scope="col" rowspan="2">
                                Số TC
                            </th>
                            <th class="w-10 text-center" scope="col" rowspan="2">
                                Kế hoạch
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in plans" :key="value.subject_id">
                            <td class="td-table text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_code }}
                            </td>
                            <td class="td-table">
                                {{ value.subject_name }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_credit }}
                            </td>
                            <td class="text-center">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-show="show_type == 1" class="table-responsive">
                <div v-if="suggest_all.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5" scope="col" rowspan="2">
                                    STT
                                </th>
                                <th class="text-center w-15" scope="col" rowspan="2">
                                    Mã môn học
                                </th>
                                <th class="text-center w-50" scope="col" rowspan="2">
                                    Tên môn học
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Số TC
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Đã học
                                </th>
                                <th class="w-10 text-center">Kế hoạch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in programs" :key="value.subject_id">
                                <td class="td-table text-center">
                                    {{ (index += 1) }}
                                </td>
                                <td class="text-center td-table">
                                    {{ value.subject_code }}
                                </td>
                                <td class="td-table">
                                    {{ value.subject_name }}
                                </td>
                                <td class="text-center td-table">
                                    {{ value.subject_credit }}
                                </td>
                                <td class="text-center">
                                    <div v-if="scoreSum(value) == false"></div>
                                    <div v-else-if="scoreSum(value) == true">
                                        <div v-if="checkSum(value) < 4">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div v-else-if="checkSum(value) >= 4">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input
                                        type="checkbox"
                                        name="plansuggest_detail_program"
                                        :value="value.subject_id"
                                        :checked="checkValue(value)"
                                        @change="select($event.target.checked, value.subject_id)"
                                        disabled
                                    />
                                </td>
                            </tr>
                            <tr v-show="!programs.length">
                                <td colspan="9">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <div class="alert alert-danger">
                        Không tìm thấy kết quả phù hợp!
                    </div>
                </div>
            </div>

            <div v-show="show_type == 2" class="table-responsive">
                <div v-if="suggest_only.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5" scope="col" rowspan="2">
                                    STT
                                </th>
                                <th class="text-center w-15" scope="col" rowspan="2">
                                    Mã môn học
                                </th>
                                <th class="text-center w-50" scope="col" rowspan="2">
                                    Tên môn học
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Số TC
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Đã học
                                </th>
                                <th class="w-10 text-center">Kế hoạch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in programs" :key="value.subject_id">
                                <td class="td-table text-center">
                                    {{ (index += 1) }}
                                </td>
                                <td class="text-center td-table">
                                    {{ value.subject_code }}
                                </td>
                                <td class="td-table">
                                    {{ value.subject_name }}
                                </td>
                                <td class="text-center td-table">
                                    {{ value.subject_credit }}
                                </td>
                                <td class="text-center">
                                    <div v-if="scoreSum(value) == false"></div>
                                    <div v-else-if="scoreSum(value) == true">
                                        <div v-if="checkSum(value) < 4">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div v-else-if="checkSum(value) >= 4">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input
                                        type="checkbox"
                                        name="plansuggest_detail_program"
                                        :value="value.subject_id"
                                        :checked="checkValue(value)"
                                        @change="select($event.target.checked, value.subject_id)"
                                        disabled
                                    />
                                </td>
                            </tr>
                            <tr v-show="!programs.length">
                                <td colspan="9">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <div class="alert alert-danger">
                        Không tìm thấy kết quả phù hợp!
                    </div>
                </div>
            </div>

            <div v-show="show_type == 3" class="table-responsive">
                <table class="table table-nowrap">
                    <thead class="blue-background text-white">
                        <tr>
                            <th class="text-center w-5" scope="col" rowspan="2">
                                STT
                            </th>
                            <th class="text-center w-15" scope="col" rowspan="2">
                                Mã môn học
                            </th>
                            <th class="text-center w-50" scope="col" rowspan="2">
                                Tên môn học
                            </th>
                            <th class="text-center w-10" scope="col" rowspan="2">
                                Số TC
                            </th>
                            <th class="text-center w-10" scope="col" rowspan="2">
                                Đã học
                            </th>
                            <th class="w-10 text-center">Kế hoạch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in programs" :key="value.subject_id">
                            <td class="td-table text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_code }}
                            </td>
                            <td class="td-table">
                                {{ value.subject_name }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_credit }}
                            </td>
                            <td class="text-center">
                                <div v-if="scoreSum(value) == false"></div>
                                <div v-else-if="scoreSum(value) == true">
                                    <div v-if="checkSum(value) < 4">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div v-else-if="checkSum(value) >= 4">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <input
                                    type="checkbox"
                                    name="plansuggest_detail_program"
                                    :value="value.subject_id"
                                    :checked="checkValue(value)"
                                    @change="select($event.target.checked, value.subject_id)"
                                />
                            </td>
                        </tr>
                        <tr v-show="!programs.length">
                            <td colspan="9">
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <VueHtml2pdf
                :manual-pagination="true"
                :enable-download="true"
                ref="DownloadComp"
                filename="ket-qua-dang-ky-ke-hoach-hoc-tap"
                pdf-format="a3"
                pdf-content-width="100%"
                hidden
            >
                <section slot="pdf-content">
                    <div class="center-style">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6 class="text-center text-black">BỘ GIÁO DỤC VÀ ĐÀO TẠO</h6>
                                <h6 class="text-center text-black">TRƯỜNG ĐẠI HỌC VĂN LANG</h6>
                                <img :src="`../public/student/img/vlu.png`" alt="vlu" class="img-style" />
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-center text-black">CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                                <h6 class="text-center text-black">Độc lập - Tự do - Hạnh phúc</h6>
                            </div>
                        </div>
                        <h3 class="text-center mt-3">KẾT QUẢ ĐĂNG KÝ KẾ HOẠCH HỌC TẬP</h3>
                        <h6 class="text-center mt-3">Năm học: {{ yearstart }}-{{ yearstart + 1 }} - HK{{ semester }}</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                Họ tên: <b>{{ student_info.student_fullname }}</b>
                            </div>
                            <div class="col-md-6">MSSV: {{ student_info.student_code }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Khoa: {{ student_info.student_faculty }}</div>
                            <div class="col-md-6">Khoá học: {{ student_info.student_course }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">Chuyên ngành: {{ student_info.student_major }}</div>
                            <div class="col-md-6">Lớp: {{ student_info.student_course_code }}-{{ student_info.student_class }}</div>
                        </div>
                        <div class="table-responsive mt-3" ref="content">
                            <div v-if="plans.length > 0">
                                <table class="table table-nowrap">
                                    <thead class="result-background text-white">
                                        <tr>
                                            <th class="text-center w-5" scope="col" rowspan="2">
                                                STT
                                            </th>
                                            <th class="text-center w-15" scope="col" rowspan="2">
                                                Mã môn học
                                            </th>
                                            <th class="text-center w-40" scope="col" rowspan="2">
                                                Tên môn học
                                            </th>
                                            <th class="text-center w-10" scope="col" rowspan="2">
                                                Số TC
                                            </th>
                                            <th class="text-center w-10" scope="col" rowspan="2">
                                                Ngày ĐK
                                            </th>
                                            <th class="w-10 text-center" scope="col" rowspan="2">
                                                Kế hoạch
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(value, index) in plans" :key="value.subject_id">
                                            <td class="td-table text-center">
                                                {{ (index += 1) }}
                                            </td>
                                            <td class="text-center td-table">
                                                {{ value.subject_code }}
                                            </td>
                                            <td class="td-table">
                                                {{ value.subject_name }}
                                            </td>
                                            <td class="text-center td-table">
                                                {{ value.subject_credit }}
                                            </td>
                                            <td class="text-center td-table">
                                                {{ value.register_plan_date || formatFullTime }}
                                            </td>
                                            <td class="text-center">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                Ngày in: <i>{{ print_date }}</i>
                            </div>
                            <div class="col-md-6 text-right">
                                Tổng số TC đăng ký: <i>{{ sum_credit }}</i>
                            </div>
                        </div>
                    </div>
                </section>
            </VueHtml2pdf>
        </div>
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import 'sweetalert2/dist/sweetalert2.min.css'
export default {
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            student_id: this.$studentId,
            scores: [],
            programs: [],
            suggest_all: [],
            suggest_only: [],
            plans: [],
            select_type: 1,
            show_type: 1,
            semester: '',
            yearstart: '',
            sum_credit: 0,
            print_date: '',
            credit_ref: 0,
            form: new Form({
                register_plan_id: '',
                register_plan_student: '',
                register_plan_program: '',
                register_plan_semester: '',
                register_plan_yearstart: '',
                register_plan_yearend: ''
            }),
            student_info: {
                student_fullname: '',
                student_code: '',
                student_class: '',
                student_course: '',
                student_course_code: '',
                student_major: '',
                student_faculty: ''
            },
            selected: []
        }
    },
    mounted() {
        this.fetchPrograms()
        this.fetchScore()
        this.fetchSuggestAll()
        this.fetchCalendarPlan()
        this.fetchTimePlan()
    },
    watch: {
        select_type(value) {
            if (value == 1) {
                this.show_type = 1
                this.selected = []
                this.fetchSuggestAll()
            } else if (value == 2) {
                this.show_type = 2
                this.selected = []
                this.fetchSuggestOnly()
            } else if (value == 3) {
                this.show_type = 3
                this.selected = []
                this.fetchMyPlan()
            }
        }
    },
    methods: {
        fetchPrograms(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSuggestAll(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/goi-y-ca-lop/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggest_all = res.data
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].plansuggest_detail_program)
                    }
                })
                .catch(err => console.log(err))
        },
        fetchSuggestOnly(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/goi-y-ca-nhan/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.suggest_only = res.data
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].plansuggest_detail_program)
                    }
                })
                .catch(err => console.log(err))
        },
        fetchCalendarPlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/lich-ke-hoach/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    let plan = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            return el
                        }
                    })
                    this.plans = plan

                    const start = new Date(plan[0].start)
                    this.yearstart = start.getFullYear()
                    this.credit_ref = plan[0].recurrenceRule
                    this.student_info.student_fullname = plan[0].student_fullname
                    this.student_info.student_code = plan[0].student_code
                    this.student_info.student_course = plan[0].course_name
                    this.student_info.student_course_code = plan[0].course_code
                    this.student_info.student_faculty = plan[0].faculty_name
                    this.student_info.student_major = plan[0].major_name
                    this.student_info.student_class = plan[0].class_name

                    this.sum_credit = 0
                    for (let i = 0; i < plan.length; i++) {
                        this.sum_credit = plan[i].subject_credit + this.sum_credit
                    }
                })
                .catch(err => console.log(err))
        },
        fetchTimePlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/thoi-gian-dang-ky/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.forEach(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.semester = el.location
                        }
                    })
                })
                .catch(err => console.log(err))
        },
        fetchMyPlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/my-plan/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].register_plan_program)
                    }
                })
                .catch(err => console.log(err))
        },
        fetchScore(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/score/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.scores = res.data
                })
                .catch(err => console.log(err))
        },
        scoreSum(value) {
            let check = false
            this.scores.filter(el => {
                if (el.subject_id == value.subject_id) {
                    check = true
                }
            })
            return check
        },
        checkSum(value) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            this.scores.filter(el => {
                if (el.subject_id == value.subject_id) {
                    scoreExercise = (el.register_subject_exercise * el.subject_score_exercise) / 100
                    scoreExam = (el.register_subject_exam * el.subject_score_exam) / 100

                    if (el.register_subject_final >= el.register_subject_second) {
                        scoreFinal = (el.register_subject_final * el.subject_score_final) / 100
                    } else {
                        scoreFinal = (el.register_subject_second * el.subject_score_final) / 100
                    }
                }
            })
            return scoreExercise + scoreExam + scoreFinal
        },
        checkValue(value) {
            if (this.show_type == 1) {
                const check = this.suggest_all.find(sub => sub.plansuggest_detail_program == value.subject_id)
                if (check) {
                    return true
                } else {
                    return false
                }
            } else if (this.show_type == 2) {
                const check = this.suggest_only.find(sub => sub.plansuggest_detail_program == value.subject_id)
                if (check) {
                    return true
                } else {
                    return false
                }
            } else if (this.show_type == 3) {
                const check = this.plans.find(
                    sub => sub.register_plan_program == value.subject_id && sub.register_plan_student == this.student_id
                )
                if (check) {
                    return true
                } else {
                    return false
                }
            }
        },
        select(e, value) {
            if (e === true) {
                this.selected.push(value)
            } else {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
            }
        },
        store() {
            this.sum_credit = 0
            for (let i = 0; i < this.programs.length; i++) {
                for (let j = 0; j < this.selected.length; j++) {
                    if (this.programs[i].subject_id == this.selected[j]) {
                        this.sum_credit = this.programs[i].subject_credit + this.sum_credit
                    }
                }
            }
            if (this.sum_credit < this.credit_ref) {
                this.$swal({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Vui lòng đăng ký đủ TC yêu cầu!',
                    timer: 2000
                })
            } else {
                let formData = new FormData()
                formData.append('semester', this.semester)
                formData.append('yearstart', this.yearstart)
                formData.append('student_id', this.student_id)
                formData.append('type', this.select_type)
                for (let i = 0; i < this.selected.length; i++) {
                    formData.append('subject[]', this.selected[i])
                }
                axios
                    .post('../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap', formData)
                    .then(res => {
                        this.fetchCalendarPlan()
                        this.$swal({
                            title: 'Đăng ký thành công!',
                            icon: 'success',
                            text: 'Bạn sẽ nhận được Email kết quả đăng ký sau vài phút!',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                        this.sendMail()
                    })
                    .catch(err => {
                        const null_subject = err.response.data.errors?.subject?.length
                        if (null_subject > 0) {
                            this.$swal({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: err.response.data.errors.subject[0],
                                timer: 2000
                            })
                        } else {
                            this.$swal({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Lỗi định dạng!',
                                timer: 2000
                            })
                        }
                    })
            }
        },
        print() {
            const date = new Date()
            const day = date.getDate()
            const month = date.getMonth() + 1
            const year = date.getFullYear()
            this.print_date = 'Ngày ' + day + ' tháng ' + month + ' năm ' + year
            this.$refs.DownloadComp.generatePdf()
        },
        sendMail() {
            axios.get(`../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/send-mail/${this.student_id}/${this.semester}`).catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style scope>
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
.blue-background {
    background-color: darkblue;
}
.result-background {
    background-color: #495057;
}
.fa-check {
    color: rgb(15, 233, 15);
}
.fa-times {
    color: red;
}
.text-red {
    color: red;
}
.img-style {
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10%;
    margin-bottom: 10%;
    width: 40%;
    height: 60%;
}
.center-style {
    display: block;
    margin-left: 10%;
    margin-right: 10%;
}
</style>
