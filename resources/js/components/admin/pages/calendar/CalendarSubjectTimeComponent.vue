<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'calendarindex' }">Lịch biểu </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'calendarsubjectslot' }">Mở lớp môn học </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lịch mở lớp học</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Lọc thông tin</h3>
                                </div>
                                <div class="col-md-6">
                                    <router-link
                                        tag="button"
                                        class="btn btn-lg btn-primary mb-3 btn-3d float-right"
                                        :to="{ name: 'calendarsubjectslot' }"
                                    >
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-2 mr-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" v-model="filter_course">
                                    <option value="" disabled selected>Chọn khoá học</option>
                                    <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                                        {{ course.course_code }} - {{ course.course_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" v-model="filter_major" :disabled="filter_course == ''">
                                    <option value="" disabled selected>Chọn chuyên ngành</option>
                                    <option v-for="major in majors" :key="major.major_id" :value="major.major_id">
                                        {{ major.major_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" v-model="filter_semester" :disabled="filter_major == ''">
                                    <option value="" disabled selected>Chọn học kỳ</option>
                                    <option v-for="semester in semesters" :key="semester" :value="semester"> Học kỳ {{ semester }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-indigo block float-right" @click="filterData()">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Lọc
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-warning block float-right" @click="reload()">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Tải lại
                            </button>
                        </div>
                    </div>

                    <Fullcalendar ref="fullCalendar" :options="calendarPlugins"></Fullcalendar>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '@fullcalendar/core/vdom'
import vieLocale from '@fullcalendar/core/locales/vi.js'
import Fullcalendar from '@fullcalendar/vue'
import DayGridPlugin from '@fullcalendar/daygrid'
import TimeGridPlugin from '@fullcalendar/timegrid'
import InteractionPlugin from '@fullcalendar/interaction'
import ListPlugin from '@fullcalendar/list'

export default {
    components: {
        Fullcalendar
    },
    data() {
        return {
            subjects: [],
            majors: [],
            courses: [],
            semesters: [],
            filter_major: '',
            filter_course: '',
            filter_semester: '',
            calendarPlugins: {
                plugins: [DayGridPlugin, TimeGridPlugin, InteractionPlugin, ListPlugin],
                initialView: 'timeGridWeek',
                locale: vieLocale,
                allDaySlot: false,
                headerToolbar: {
                    start: 'title',
                    center: 'today',
                    end: 'prev,next'
                },
                dayHeaderFormat: { weekday: 'long', month: 'numeric', day: 'numeric' },
                slotLabelFormat: [
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                slotDuration: '00:30:00',
                slotMinTime: '07:00:00',
                slotMaxTime: '23:00:00',
                events: []
            }
        }
    },
    mounted() {
        this.fetchCalendarSubjects()
        this.fetchCourses()
    },
    watch: {
        filter_major(value) {
            if (value != '') {
                this.fetchSemesters()
            }
        },
        filter_course(value) {
            if (value != '') {
                this.fetchMajors()
            }
        }
    },
    methods: {
        fetchMajors(page_url) {
            let vm = this
            page_url = `../../api/admin/edu-major/chuyen-nganh/major`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                })
                .catch(err => console.log(err))
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
        fetchSemesters(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-schedule/lich-bieu/hoc-ky/${this.filter_course}/${this.filter_major}`
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
        fetchCalendarSubjects(page_url) {
            page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.calendarPlugins.events = []
                    let startTime = ''
                    let endTime = ''
                    for (let i = 0; i < res.data.length; i++) {
                        let timeSplit = res.data[i].calendar_subject_time.split(', ')
                        let daySplit = res.data[i].calendar_subject_day.split(', ')
                        for (let j = 0; j < timeSplit.length; j++) {
                            if (timeSplit[j] == 123) {
                                startTime = '7:00:00'
                                endTime = '9:25:00'
                            } else if (timeSplit[j] == 456) {
                                startTime = '9:35:00'
                                endTime = '12:00:00'
                            } else if (timeSplit[j] == 789) {
                                startTime = '13:00:00'
                                endTime = '15:25:00'
                            } else if (timeSplit[j] == 101112) {
                                startTime = '15:35:00'
                                endTime = '18:00:00'
                            } else if (timeSplit[j] == 131415) {
                                startTime = '18:00:00'
                                endTime = '20:25:00'
                            }

                            let obj = {
                                dow: 1,
                                title: res.data[i].subject_name,
                                daysOfWeek: [daySplit[j]],
                                startTime: startTime,
                                endTime: endTime,
                                startRecur: res.data[i].calendar_subject_start,
                                endRecur: res.data[i].calendar_subject_end,
                                color: 'darkblue'
                            }
                            this.calendarPlugins.events.push(obj)
                        }
                    }
                })
                .catch(err => console.log(err))
        },
        filterData(page_url) {
            if (this.filter_course == '' || this.filter_major == '' || this.filter_semester == '') {
                this.$snotify.error('Vui lòng chọn đầy đủ thông tin')
            } else {
                page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/filter-in-calendar/${this.filter_course}/${this.filter_major}/${this.filter_semester}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subjects = res.data
                        let calendarApi = this.$refs.fullCalendar.getApi()
                        calendarApi.gotoDate(this.subjects[0].calendar_subject_start)
                    })
                    .catch(err => console.log(err))
            }
        },
        reload() {
            this.filter_course = ''
            this.filter_major = ''
            this.filter_semester = ''
            this.fetchCalendarSubjects()
            let calendarApi = this.$refs.fullCalendar.getApi()
            let today = new Date()
            calendarApi.gotoDate(today)
        }
    }
}
</script>

<style></style>
