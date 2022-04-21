<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lịch biểu</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <div class="form-group">
            <router-link class="btn btn-info btn-lg mb-3 btn-3d" tag="button" :to="{ name: 'calendarcreate' }">
                <li class="fa fa-plus"></li>
                Tạo mới
            </router-link>
            <router-link class="btn btn-indigo btn-lg mb-3 btn-3d float-right" tag="button" :to="{ name: 'calendarreference' }"
                ><li class="fa fa-calendar-o"></li>
                Lịch thi
            </router-link>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><strong>Lịch biểu</strong></h2>
                    </div>

                    <span @click="onClickNavi($event)">
                        <div class="ml-2 mr-2">
                            <select v-model="selectedView" class="form-control-styling">
                                <option value="" disabled selected>Lựa chọn hiển thị</option>
                                <option value="day">Ngày</option>
                                <option value="week">Tuần</option>
                                <option value="month">Tháng</option>
                            </select>
                            <button type="button" class="btn btn-primary btn-3d btn-lg move-today ml-2 fa fa-star" data-action="move-today">
                                Hôm nay
                            </button>
                            <button
                                type="button"
                                class="btn btn-indigo btn-3d btn-lg move-day fa fa-arrow-left"
                                data-action="move-prev"
                            ></button>
                            <button
                                type="button"
                                class="btn btn-indigo btn-3d btn-lg move-day fa fa-arrow-right"
                                data-action="move-next"
                            ></button>
                            <span class="render-range font-styling">{{ dateRange }}</span>
                        </div>
                    </span>

                    <calendar
                        ref="tuiCal"
                        :taskView="false"
                        :schedules="calendars"
                        :timezones="timezones"
                        :view="selectedView"
                        :month="month"
                        :week="week"
                        :template="template"
                        :useCreationPopup="false"
                        :useDetailPopup="false"
                        @beforeCreateSchedule="onBeforeCreateSchedule"
                        @clickSchedule="onClickSchedule"
                    ></calendar>
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
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết sự kiện</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless w-100 m-0 border">
                            <tbody class="p-0">
                                <tr>
                                    <td class="h3-strong text-center">
                                        <h3><strong> Thông tin chi tiết</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tiêu đề: <strong> {{ form.title }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Khoá học: <strong> {{ form.course_code }} - {{ form.course_name }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Chuyên ngành: <strong style="word-break:break-word;"> {{ form.major_name }}</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <div v-if="form.location == 0"></div>
                                                <div v-else>
                                                    Học kỳ: <strong>{{ form.location }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Loại sự kiện:
                                                <strong v-if="form.calendarId == 0"> Đăng ký kế hoạch học tập</strong>
                                                <strong v-else-if="form.calendarId == 1"> Đăng ký môn học</strong>
                                                <strong v-else-if="form.calendarId == 2"> Lịch thi học kỳ lần 1</strong>
                                                <strong v-else-if="form.calendarId == 3"> Lịch thi học kỳ lần 2</strong>
                                                <strong v-else-if="form.calendarId == 4"> Đánh giá điểm rèn luyện</strong>
                                                <strong v-else-if="form.calendarId == 5"> Thanh toán học phí</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <div v-if="form.calendarId <= 1">
                                                    Tổng TC bắt buộc:
                                                    <strong>{{ form.recurrenceRule }}</strong>
                                                </div>
                                                <div v-else-if="form.calendarId == 4">
                                                    <div v-if="form.recurrenceRule == 0">Loại: <strong>Sinh viên tự đánh giá</strong></div>
                                                    <div v-else-if="form.recurrenceRule == 1">Loại: <strong>GVCN đánh giá</strong></div>
                                                    <div v-else-if="form.recurrenceRule == 2">Loại: <strong>BCN Khoa đánh giá</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Thời gian bắt đầu:
                                                <strong>{{ form.start }}</strong>
                                            </div>
                                            <div class="col-md-6">
                                                Thời gian kết thúc:
                                                <strong>{{ form.end }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button
                                    type="button"
                                    class="btn-3d btn btn-lg btn-block btn-success fa fa-pencil-square-o"
                                    @click="update(form.id)"
                                >
                                    Cập nhật
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn-3d btn btn-lg btn-block btn-danger fa fa-trash" @click="destroy(form.id)">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->
    </div>
</template>

<script>
import 'tui-calendar/dist/tui-calendar.css'
import { Calendar } from '@toast-ui/vue-calendar'
import 'tui-date-picker/dist/tui-date-picker.css'
import 'tui-time-picker/dist/tui-time-picker.css'

const today = new Date()

const getDate = (type, start, value, operator) => {
    start = new Date(start)
    type = type.charAt(0).toUpperCase() + type.slice(1)

    if (operator === '+') {
        start[`set${type}`](start[`get${type}`]() + value)
    } else {
        start[`set${type}`](start[`get${type}`]() - value)
    }

    return start
}

export default {
    components: {
        calendar: Calendar
    },
    data() {
        return {
            selectedView: 'month',
            dateRange: '',
            calendars: [],
            courses: [],
            majors: [],
            editMode: false,
            form: new Form({
                id: '',
                title: '',
                raw: '',
                body: '',
                category: '',
                start: '',
                end: '',
                calendarId: '',
                location: '',
                recurrenceRule: '',
                course_code: '',
                course_name: '',
                major_name: ''
            }),
            timezones: [
                {
                    timezoneName: 'Asia/Ho_Chi_Minh',
                    displayLabel: 'UTC+07:00',
                    tooltip: 'Viet Nam'
                }
            ],
            month: {
                daynames: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
                startDayOfWeek: 1
            },
            week: {
                daynames: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
                startDayOfWeek: 1
            },
            template: {
                timegridDisplayPrimayTime(time) {
                    if (time.hour < 10) {
                        return '0' + time.hour + ':00'
                    } else {
                        return time.hour + ':00'
                    }
                },
                timegridDisplayTime(time) {
                    if (time.hour < 10) {
                        return '0' + time.hour + ':00'
                    } else {
                        return time.hour + ':00'
                    }
                },
                alldayTitle() {
                    return '<span class="tui-full-calendar-left-content">Cả ngày</span>'
                }
            }
        }
    },
    mounted() {
        this.fetchCalendars()
        this.fetchMajors()
        this.fetchCourses()
        this.init()
    },
    watch: {
        selectedView(newValue) {
            this.$refs.tuiCal.invoke('changeView', newValue, true)
            this.setRenderRangeText()
        }
    },
    methods: {
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
        fetchCalendars(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-schedule/lich-bieu`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.calendars = res.data
                })
                .catch(err => console.log(err))
        },
        init() {
            this.setRenderRangeText()
        },
        setRenderRangeText() {
            const { invoke } = this.$refs.tuiCal
            const view = invoke('getViewName')
            const calDate = invoke('getDate')
            const rangeStart = invoke('getDateRangeStart')
            const rangeEnd = invoke('getDateRangeEnd')
            let year = calDate.getFullYear()
            let month = calDate.getMonth() + 1
            let date = calDate.getDate()
            let dateRangeText = ''
            let endYear, endMonth, endDate, start, end

            switch (view) {
                case 'month':
                    dateRangeText = `${month}/${year}`
                    break
                case 'week':
                    year = rangeStart.getFullYear()
                    month = rangeStart.getMonth() + 1
                    date = rangeStart.getDate()
                    endMonth = rangeEnd.getMonth() + 1
                    endDate = rangeEnd.getDate()
                    endYear = rangeEnd.getFullYear()

                    start = `${date}/${month}/${year}`
                    end = `${endDate}/${endMonth}/${endYear}`
                    dateRangeText = `${start} ~ ${end}`
                    break
                default:
                    dateRangeText = `${date}/${month}/${year}`
            }
            this.dateRange = dateRangeText
        },
        onClickNavi(event) {
            if (event.target.tagName === 'BUTTON') {
                const { target } = event
                let action = target.dataset ? target.dataset.action : target.getAttribute('data-action')
                action = action.replace('move-', '')

                this.$refs.tuiCal.invoke(action)
                this.setRenderRangeText()
            }
        },
        onBeforeCreateSchedule(e) {
            //     console.log(e)
            //     this.editMode = false
            //     this.form.clear()
            //     this.form.reset()
            //     $('#CalendarModal').modal('show')

            //     var time_start = new Date(e.start._date)
            //     var time_end = new Date(e.end._date)

            //     var month_start = time_start.getMonth() + 1
            //     var date_start = time_start.getDate()
            //     var hour_start = time_start.getHours()
            //     var minute_start = time_start.getMinutes()

            //     var month_end = time_end.getMonth() + 1
            //     var date_end = time_end.getDate()
            //     var hour_end = time_end.getHours()
            //     var minute_end = time_end.getMinutes()

            //     month_start = month_start < 10 ? `0` + month_start : month_start
            //     date_start = date_start < 10 ? `0` + date_start : date_start
            //     hour_start = hour_start < 10 ? `0` + hour_start : hour_start
            //     minute_start = minute_start < 10 ? `0` + minute_start : minute_start

            //     month_end = month_end < 10 ? `0` + month_end : month_end
            //     date_end = date_end < 10 ? `0` + date_end : date_end
            //     hour_end = hour_end < 10 ? `0` + hour_end : hour_end
            //     minute_end = minute_end < 10 ? `0` + minute_end : minute_end

            //     var datetime_start = time_start.getFullYear() + '-' + month_start + '-' + date_start + 'T' + hour_start + ':' + minute_start
            //     var datetime_end = time_end.getFullYear() + '-' + month_end + '-' + date_end + 'T' + hour_end + ':' + minute_end

            //     this.form.start = datetime_start
            //     this.form.end = datetime_end
            e.guide.clearGuideElement()
        },
        onClickSchedule(e) {
            var time_start = new Date(e.schedule.start._date)
            var time_end = new Date(e.schedule.end._date)

            var month_start = time_start.getMonth() + 1
            var date_start = time_start.getDate()
            var hour_start = time_start.getHours()
            var minute_start = time_start.getMinutes()

            var month_end = time_end.getMonth() + 1
            var date_end = time_end.getDate()
            var hour_end = time_end.getHours()
            var minute_end = time_end.getMinutes()

            month_start = month_start < 10 ? `0` + month_start : month_start
            date_start = date_start < 10 ? `0` + date_start : date_start
            hour_start = hour_start < 10 ? `0` + hour_start : hour_start
            minute_start = minute_start < 10 ? `0` + minute_start : minute_start

            month_end = month_end < 10 ? `0` + month_end : month_end
            date_end = date_end < 10 ? `0` + date_end : date_end
            hour_end = hour_end < 10 ? `0` + hour_end : hour_end
            minute_end = minute_end < 10 ? `0` + minute_end : minute_end

            var datetime_start = date_start + '/' + month_start + '/' + time_start.getFullYear() + ' ' + hour_start + ':' + minute_start
            var datetime_end = date_end + '/' + month_end + '/' + time_end.getFullYear() + ' ' + hour_end + ':' + minute_end

            this.form.id = e.schedule.id
            this.form.title = e.schedule.title
            this.form.body = e.schedule.body
            this.form.calendarId = e.schedule.calendarId
            this.form.start = datetime_start
            this.form.end = datetime_end
            this.form.location = e.schedule.location
            this.form.raw = e.schedule.raw
            this.form.recurrenceRule = e.schedule.recurrenceRule

            const course = this.courses.find(course => course.course_id == e.schedule.raw)
            this.form.course_code = course.course_code
            this.form.course_name = course.course_name
            const major = this.majors.find(major => major.major_id == e.schedule.body)
            this.form.major_name = major.major_name

            $('#DetailModal').modal('show')
        },
        destroy(id) {
            this.$snotify.clear()
            this.$snotify.confirm('Xác nhận xóa', {
                timeout: 5000,
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: 'Xóa',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                            axios
                                .delete(`../../api/admin/calendar-schedule/lich-bieu/${id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    $('#DetailModal').modal('hide')
                                    this.fetchCalendars()
                                })
                                .catch(err => console.log(err))
                        },
                        bold: false
                    },
                    {
                        text: 'Đóng',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                        },
                        bold: true
                    }
                ]
            })
        },
        update(id) {
            $('#DetailModal').modal('hide')
            this.$router.push({ name: 'calendarupdate', params: { idCalendar: id } })
        }
    }
}
</script>

<style lang="css" scoped>
.font-styling {
    font-size: 30px;
    font-weight: bold;
    color: darkblue;
    vertical-align: middle;
    margin-left: 20px;
}
.td-styling {
    text-align: center;
}
.not-allowed {
    cursor: not-allowed;
}
.select-option {
    cursor: pointer;
}
.h3-strong {
    color: #1753fc;
}
.styling-modal-header-info {
    background-color: darkblue;
    color: white;
}
.styling-font-modal-header {
    font-size: 20px;
    font-weight: bold;
}
.styling-modal-header-update {
    background-color: darkblue;
    color: white;
}
.td-borderight {
    border-right: 2px solid black;
}
.td-borderbottom {
    border-bottom: 2px solid black;
}
.background-update {
    background-color: darkblue;
    border-color: darkblue;
}
.background-update:hover {
    background-color: darkslateblue;
    border-color: darkblue;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
</style>
