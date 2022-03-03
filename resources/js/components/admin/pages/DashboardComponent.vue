<template>
    <div class="container">
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <!-- <p>Welcome to Dashboard Website</p> -->
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Khoá học</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ courses.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-primary fa fa-book"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>

                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Khoa</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ faculties.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-success fa fa-th-large"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>
                        </div>
                    </div>
                    <!-- /.section-content -->
                </div>
                <div class="col-md-12">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Chuyên ngành</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ majors.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-danger fa fa-th-list"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>

                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Môn học</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ subjects.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-warning fa fa-wpforms"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>
                        </div>
                    </div>
                    <!-- /.section-content -->
                </div>
                <div class="col-md-12">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Sinh viên</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ students.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-info fa fa-graduation-cap"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>

                            <div class="col-md-6">
                                <div class="statistic-box m-0">
                                    <h4 class="statistic-title float-left">Giảng viên</h4>
                                    <div class="statistic-details">
                                        <span class="count float-left">{{ lecturers.length }}</span>
                                        <span class="statistic-icon float-right"><i class="text-purple fa fa-users"></i></span
                                        ><!-- /.statistic-icon -->
                                    </div>
                                    <!-- /.statistic-details -->
                                </div>
                                <!-- /.statistic-box -->
                            </div>
                        </div>
                    </div>
                    <!-- /.section-content -->
                </div>
            </div>
            <div class="col-md-6">
                <h4 style="text-align: center; font-weight: bold; margin-top: 60px;">Thống kê truy cập</h4>
                <donut-chart id="donut" :data="donutData()" colors='[ "#1753fc", "#fdb901", "#28a745", "#dc3545" ]' resize="true">
                </donut-chart>
            </div>
        </div>
    </div>
</template>

<script>
import { DonutChart } from 'vue-morris'
import Raphael from 'raphael/raphael'
global.Raphael = Raphael
export default {
    components: {
        DonutChart
    },
    data() {
        return {
            courses: [],
            faculties: [],
            majors: [],
            subjects: [],
            students: [],
            lecturers: [],
            sum_lastmonth: 0,
            sum_thismonth: 0,
            sum_oneyear: 0,
            sum_allvisitors: 0,
            donutM: []
        }
    },
    mounted() {
        this.fetchCourses()
        this.fetchFaculties()
        this.fetchMajors()
        this.fetchSubjects()
        this.fetchStudents()
        this.fetchLecturers()

        this.fetchLastMonth()
        this.fetchThisMonth()
        this.fetchOneYear()
        this.fetchAllVisitors()
    },
    methods: {
        donutData() {
            return (this.donutM = [
                { label: 'Tổng tháng trước', value: this.sum_lastmonth },
                { label: 'Tổng tháng này', value: this.sum_thismonth },
                { label: 'Tổng cả năm', value: this.sum_oneyear },
                { label: 'Tổng truy cập', value: this.sum_allvisitors }
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
        fetchFaculties(page_url) {
            let vm = this
            page_url = '../../api/admin/edu-faculty/khoa/faculty'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.faculties = res.data
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
        fetchSubjects(page_url) {
            let vm = this
            page_url = '../../api/admin/manage/mon-hoc/subject'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                })
                .catch(err => console.log(err))
        },
        fetchStudents(page_url) {
            let vm = this
            page_url = '../../api/admin/user-sv/sinh-vien/allstudent'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data
                })
                .catch(err => console.log(err))
        },
        fetchLecturers(page_url) {
            let vm = this
            page_url = '../../api/admin/user-gv/giang-vien/alllecturer'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.lecturers = res.data
                })
                .catch(err => console.log(err))
        },
        fetchLastMonth(page_url) {
            let vm = this
            page_url = '../../api/admin/statistic/thong-ke-truy-cap/thang-truoc'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    //this.donutData[0].value = res.data.length
                    this.sum_lastmonth = res.data.length
                })
                .catch(err => console.log(err))
        },
        fetchThisMonth(page_url) {
            let vm = this
            page_url = '../../api/admin/statistic/thong-ke-truy-cap/thang-nay'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    //this.donutData[1].value = res.data.length
                    this.sum_thismonth = res.data.length
                })
                .catch(err => console.log(err))
        },
        fetchOneYear(page_url) {
            let vm = this
            page_url = '../../api/admin/statistic/thong-ke-truy-cap/mot-nam'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // this.donutData[2].value = res.data.length
                    this.sum_oneyear = res.data.length
                })
                .catch(err => console.log(err))
        },
        fetchAllVisitors(page_url) {
            let vm = this
            page_url = '../../api/admin/statistic/thong-ke-truy-cap/tat-ca'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // this.donutData[3].value = res.data.length
                    this.sum_allvisitors = res.data.length
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
.statistic-box {
    background-color: #fff;
    display: inline-block;
    margin: 15px 0;
    padding: 20px;
    width: 100%;
}
.statistic-box .statistic-title {
    color: #6a7074;
    font-size: 18px;
    font-weight: 400;
    text-transform: capitalize;
    font-weight: bold;
}
.statistic-box .statistic-details {
    display: inline-block;
    margin: 20px 0 -10px;
    width: 100%;
}
.statistic-box .statistic-details .statistic-icon {
    font-size: 60px;
    line-height: 1;
}
.section-content {
    margin: 15px 0;
}
.statistic-box .statistic-details .count {
    color: #6a7074;
    font-family: 'Open Sans', sans-serif;
    font-size: 30px;
    font-weight: 300;
    margin-top: 20px;
}
text,
svg,
tspan {
    font-family: 'Times New Roman' !important;
}
</style>
