<template>
    <div>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Thống kê số lượng đăng ký kế hoạch sinh viên</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" v-model="course">
                        <option value="" disabled selected>Chọn khoá học</option>
                        <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                            {{ course.course_code }} - {{ course.course_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" v-model="major">
                        <option value="" disabled selected>Chọn chuyên ngành</option>
                        <option v-for="major in majors" :key="major.major_id" :value="major.major_id">{{ major.major_name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" v-model="semester">
                        <option value="" disabled>Học kỳ</option>
                        <option v-for="semester in semesters" :key="semester" :value="semester">Học kỳ {{ semester }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-lg btn-block btn-primary" @click="filter()">Lọc kết quả</button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-lg btn-block background-green" @click="exportData()" :disabled="barData.length == 0">
                        Export
                    </button>
                </div>
            </div>
        </div>

        <div v-show="check() == true">
            <div class="alert alert-warning">
                Vui lòng chọn các trường thông tin trên để xem kết quả thống kê đăng ký kế hoạch học tập sinh viên
            </div>
        </div>
        <div v-show="check() == false">
            <div v-if="students.length == 0">
                <div class="alert alert-danger">
                    Chưa có thống kê cho khoá - ngành này
                </div>
            </div>
            <div v-else>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thống kê tổng quan</h3>
                            </div>
                            <div class="card-body">
                                <router-link
                                    tag="a"
                                    :to="{
                                        name: 'statisticplanstudent',
                                        params: { idCourse: course, idMajor: major, idSemester: semester }
                                    }"
                                >
                                    <donut-chart id="donut3" :data="donutData()" colors='[ "#FF99FF", "#9999FF", "#3399FF" ]'></donut-chart>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thống kê loại đăng ký</h3>
                            </div>
                            <div class="card-body">
                                <div v-show="checkDonutDataDetail()">
                                    <div class="alert alert-danger">
                                        Chưa có sinh viên nào đăng ký
                                    </div>
                                </div>
                                <div v-show="!checkDonutDataDetail()">
                                    <router-link
                                        tag="a"
                                        :to="{
                                            name: 'statisticplantype',
                                            params: { idCourse: course, idMajor: major, idSemester: semester }
                                        }"
                                    >
                                        <donut-chart
                                            id="donut2"
                                            :data="donutDataDetail()"
                                            colors='[ "#FF9999", "#996699", "#339999" ]'
                                        ></donut-chart>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Thống kế số lượng môn học được đăng ký kế hoạch</h3>
                    </div>
                    <div class="card-body">
                        <div v-show="barData.length == 0">
                            <div class="alert alert-danger text-center">
                                Chưa có môn nào được đăng ký
                            </div>
                        </div>
                        <bar-chart
                            id="bar"
                            :data="barData"
                            :bar-colors="arrayColors"
                            :xkey="xkey"
                            :ykeys="ykeys"
                            grid-text-weight="bold"
                            grid-text-size="10"
                        ></bar-chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { DonutChart, BarChart } from 'vue-morris'
import Raphael from 'raphael/raphael'
global.Raphael = Raphael
export default {
    components: {
        DonutChart,
        BarChart
    },
    data() {
        return {
            lecturer_id: this.$facultyId,
            courses: [],
            majors: [],
            semesters: [],
            students: [],
            registered: [],
            donutM: [],
            donutMDetail: [],
            suggest_all: [],
            suggest_only: [],
            plan_mine: [],
            semester: '',
            course: '',
            major: '',

            barData: [],
            xkey: 'subject_name',
            arrayColors: ['#5859f9', '#73c000', '#cc45ff'],
            ykeys: ['total']
        }
    },
    watch: {
        course(value) {
            if (value != '') {
                this.fetchSemesters()
            }
        }
    },
    mounted() {
        this.fetchCourses()
        this.fetchMajors()
    },
    methods: {
        donutData() {
            return (this.donutM = [
                { label: 'Tổng sinh viên', value: this.students.length },
                { label: 'Sinh viên đã đăng ký', value: this.registered.length },
                { label: 'Sinh viên chưa đăng ký', value: this.students.length - this.registered.length }
            ])
        },
        donutDataDetail() {
            return (this.donutMDetail = [
                { label: 'ĐK theo gợi ý cả lớp', value: this.suggest_all.length },
                { label: 'ĐK theo gợi ý cá nhân', value: this.suggest_only.length },
                { label: 'ĐK theo cá nhân', value: this.plan_mine.length }
            ])
        },
        fetchCourses(page_url) {
            let vm = this
            page_url = '../../api/admin/edu-course/khoa-hoc/course'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.courses = res.data
                    //this.course = res.data[0].course_id
                })
                .catch(err => console.log(err))
        },
        fetchMajors(page_url) {
            let vm = this
            page_url = `../../api/admin/edu-major/chuyen-nganh/lecturer_major/${this.lecturer_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                    //this.major = res.data[0].major_id
                })
                .catch(err => console.log(err))
        },
        fetchSemesters(page_url) {
            let vm = this
            page_url = `../../api/admin/program/chuong-trinh-dao-tao/theo-khoa-hoc/${this.course}/${this.lecturer_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.program_detail_semester] || []
                        semester.push(item)
                        semesters[item.program_detail_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.semesters = key
                    // if (key.length > 0) {
                    //     this.semester = key[0]
                    // } else {
                    //     this.semester = ''
                    // }
                })
                .catch(err => console.log(err))
        },
        fetchStudentCourseMajor(page_url) {
            let vm = this
            page_url = `../../api/admin/user-sv/sinh-vien/course-major/${this.course}/${this.major}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data
                })
                .catch(err => console.log(err))
        },
        fetchStudentRegistered(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const registers = res.data.reduce((registers, item) => {
                        const register = registers[item.register_plan_student] || []
                        register.push(item)
                        registers[item.register_plan_student] = register
                        return registers
                    }, {})
                    let value = Object.values(registers)
                    this.registered = value
                })
                .catch(err => console.log(err))
        },
        fetchSuggestAll(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-goi-y-tat-ca/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const registers = res.data.reduce((registers, item) => {
                        const register = registers[item.register_plan_student] || []
                        register.push(item)
                        registers[item.register_plan_student] = register
                        return registers
                    }, {})
                    let value = Object.values(registers)
                    this.suggest_all = value
                })
                .catch(err => console.log(err))
        },
        fetchSuggestOnly(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-goi-y-ca-nhan/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const registers = res.data.reduce((registers, item) => {
                        const register = registers[item.register_plan_student] || []
                        register.push(item)
                        registers[item.register_plan_student] = register
                        return registers
                    }, {})
                    let value = Object.values(registers)
                    this.suggest_only = value
                })
                .catch(err => console.log(err))
        },
        fetchPlanMine(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-ca-nhan/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const registers = res.data.reduce((registers, item) => {
                        const register = registers[item.register_plan_student] || []
                        register.push(item)
                        registers[item.register_plan_student] = register
                        return registers
                    }, {})
                    let value = Object.values(registers)
                    this.plan_mine = value
                })
                .catch(err => console.log(err))
        },
        fetchTotalSubject(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/tong-so-mon-ke-hoach/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.barData = res.data
                })
                .catch(err => console.log(err))
        },
        filter() {
            this.fetchStudentCourseMajor()
            this.fetchStudentRegistered()
            this.fetchSuggestAll()
            this.fetchSuggestOnly()
            this.fetchPlanMine()
            this.fetchTotalSubject()
        },
        check() {
            if (this.course == '' && this.major == '' && this.semester == '') {
                return true
            } else {
                return false
            }
        },
        checkDonutDataDetail() {
            if (this.suggest_all.length == 0 && this.suggest_only.length == 0 && this.plan_mine.length == 0) {
                return true
            }
        },
        exportData() {
            window.location.href = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/export/${this.course}/${this.major}/${this.semester}`
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
    font-weight: bold;
}
.background-green {
    background-color: darkgreen;
    color: white;
}
.background-green:hover {
    background-color: green;
    color: white;
}
</style>
