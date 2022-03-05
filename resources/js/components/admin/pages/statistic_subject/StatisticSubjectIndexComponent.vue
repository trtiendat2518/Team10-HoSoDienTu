<template>
    <div>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Thống kê số lượng sinh viên đăng ký môn học</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" v-model="course">
                        <option value="" disabled selected>Chọn khoá học</option>
                        <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                            {{ course.course_code }} - {{ course.course_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" v-model="major">
                        <option value="" disabled selected>Chọn chuyên ngành</option>
                        <option v-for="major in majors" :key="major.major_id" :value="major.major_id">{{ major.major_name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" v-model="semester">
                        <option value="" disabled>Học kỳ</option>
                        <option v-for="semester in semesters" :key="semester" :value="semester">Học kỳ {{ semester }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button class="btn btn-lg btn-block btn-primary" @click="filter()">Lọc kết quả</button>
                </div>
            </div>
        </div>

        <div v-show="check() == true">
            <div class="alert alert-warning">
                Vui lòng chọn các trường thông tin trên để xem kết quả thống kê đăng ký kế môn học sinh viên
            </div>
        </div>
        <div v-show="check() == false">
            <div v-if="students.length == 0">
                <div class="alert alert-danger">
                    Chưa có thống kê cho khoá - ngành này
                </div>
            </div>
            <div v-else>
                <h4 class="text-center">Thống kê tổng quan</h4>
                <router-link
                    tag="a"
                    :to="{ name: 'statisticsubjectdetail', params: { idCourse: course, idMajor: major, idSemester: semester } }"
                >
                    <donut-chart id="donut4" :data="donutData()" colors='[ "#FF99FF", "#9999FF", "#3399FF" ]'></donut-chart>
                </router-link>
                <h4 class="text-center mt-5">Thống kê số lượng lớp ít ĐK</h4>
                <div v-show="!barData.length">
                    <div class="alert alert-danger text-center">
                        Chưa có môn nào được đăng ký
                    </div>
                </div>
                <bar-chart
                    id="bar2"
                    :data="barData"
                    :bar-colors="arrayColors"
                    :xkey="xkey"
                    :ykeys="ykeys"
                    :labels="labels"
                    grid-text-weight="bold"
                    grid-text-size="10"
                ></bar-chart>
            </div>
        </div>
    </div>
</template>

<script>
import { DonutChart, LineChart, BarChart } from 'vue-morris'
import Raphael from 'raphael/raphael'
global.Raphael = Raphael
export default {
    components: {
        DonutChart,
        LineChart,
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
            semester: '',
            course: '',
            major: '',
            donutM: [],

            barData: [],
            xkey: 'subject_name',
            arrayColors: ['#73c000', '#cc45ff'],
            ykeys: ['calendar_subject_registered', 'calendar_subject_slot'],
            labels: ['SL ĐK', 'SL Đủ']
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
        fetchCourses(page_url) {
            let vm = this
            page_url = '../../api/admin/edu-course/khoa-hoc/course'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.courses = res.data
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
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/da-dang-ky/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const registers = res.data.reduce((registers, item) => {
                        const register = registers[item.register_subject_student] || []
                        register.push(item)
                        registers[item.register_subject_student] = register
                        return registers
                    }, {})
                    let value = Object.values(registers)
                    this.registered = value
                })
                .catch(err => console.log(err))
        },
        fetchQuantitySubject(page_url) {
            let vm = this
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/so-luong-lop-it/${this.course}/${this.major}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.barData = res.data
                })
                .catch(err => console.log(err))
        },
        check() {
            if (this.course == '' && this.major == '' && this.semester == '') {
                return true
            } else {
                return false
            }
        },
        filter() {
            this.fetchStudentCourseMajor()
            this.fetchStudentRegistered()
            this.fetchQuantitySubject()
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
    font-weight: bold;
}
</style>
