<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thời khoá biểu</p>
        </div>
        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-select">
                            <select class="form-control" v-model="filter">
                                <option value="" disabled>Chưa có lịch</option>
                                <option v-for="i in semesters" :key="i" :value="i">Học kỳ {{ i }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <router-link tag="button" class="btn btn-primary btn-calendar" :to="{ name: 'timetableindex' }">
                                Xem TKB Thứ - Tiết
                            </router-link>
                        </div>
                    </div>
                </div>
                <Fullcalendar ref="fullCalendar" :options="calendarPlugins"></Fullcalendar>
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
            student_id: this.$studentId,
            subjects: [],
            semesters: [],
            filter: '',
            semester: '',
            year_start: '',
            year_end: '',
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
                slotMaxTime: '22:00:00',
                events: []
            }
        }
    },
    mounted() {
        this.fetchSubjects()
    },
    watch: {
        filter(value) {
            if (value != this.semester) {
                this.filterData()
            } else {
                this.filterData()
            }
        }
    },
    methods: {
        fetchSubjects(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/${this.student_id}`
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
                    const today = new Date()
                    let data = res.data.filter(el => {
                        const start = new Date(el.calendar_subject_start)
                        const end = new Date(el.calendar_subject_end)
                        if (today >= start && today <= end) {
                            return el
                        }
                    })
                    this.semester = data[0].register_subject_semester
                    this.filter = data[0].register_subject_semester
                    this.year_start = data[0].register_subject_yearstart
                    this.year_end = data[0].register_subject_yearend
                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.register_subject_semester] || []
                        semester.push(item)
                        semesters[item.register_subject_semester] = semester
                        return semesters
                    }, {})
                    this.subjects = semesters
                    this.semesters = Object.keys(semesters)
                })
                .catch(err => console.log(err))
        },
        filterData() {
            // console.log(this.$refs.fullCalendar.getApi())
            // console.log(this.subjects[this.filter][0].calendar_subject_start)
            let calendarApi = this.$refs.fullCalendar.getApi()
            if (this.filter != this.semester) {
                calendarApi.gotoDate(this.subjects[this.filter][0].calendar_subject_start)
            } else {
                let today = new Date()
                calendarApi.gotoDate(today)
            }
        }
    }
}
</script>

<style scoped>
.btn-calendar {
    width: 35%;
    float: right;
    margin-bottom: 20px;
}
</style>
