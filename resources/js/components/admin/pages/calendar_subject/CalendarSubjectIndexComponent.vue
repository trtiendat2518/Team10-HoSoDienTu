<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mở lớp học</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <router-link tag="button" class="btn btn-info btn-lg mb-3 btn-3d mr-2" :to="{ name: 'calendarsubjectcreate' }">
                    <li class="fa fa-plus"></li>
                    Tạo mới
                </router-link>
            </div>
            <div class="col-md-6">
                <router-link tag="button" class="btn btn-danger btn-lg mb-3 btn-3d float-right" :to="{ name: 'calendarsubjectschedule' }">
                    <li class="fa fa-calendar-plus-o"></li>
                    Lịch lớp môn học
                </router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h3 class="card-title">Lịch môn học</h3>
                        </div>
                    </div>

                    <div class="row ml-2 mr-2 mb-2">
                        <div class="col-md-9">
                            <input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm môn học..." />
                        </div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items float-right">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling" v-model="currentEntries">
                                        <option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-primary mt-2 float-right block" @click="reload()">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Tải lại
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row ml-2 mr-2">
                        <div class="col-md-4">
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
                                <button class="btn btn-indigo block" @click="filter()">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Lọc
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter ">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-white">Mã môn học</th>
                                    <th class="text-white">Tên môn học</th>
                                    <th class="text-white text-center">Số lượng</th>
                                    <th class="text-white text-center">Đã ĐK</th>
                                    <th class="text-white text-center">Loại</th>
                                    <th class="text-white text-center">Ngày bắt đầu</th>
                                    <th class="text-white text-center">Ngày kết thúc</th>
                                    <th class="text-white text-center">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="subjects.length" v-for="subject in subjects" :key="subject.calendar_subject_id">
                                    <td @click="detail(subject)">
                                        <a href="javascript:void(0)">{{ subject.subject_code }}</a>
                                    </td>
                                    <td>{{ subject.subject_name }}</td>
                                    <td class="text-center">{{ subject.calendar_subject_slot }}</td>
                                    <td class="text-center">{{ subject.calendar_subject_registered }}</td>
                                    <td class="text-center">
                                        <div v-if="subject.calendar_subject_type == 0">Lý thuyết</div>
                                        <div v-else-if="subject.calendar_subject_type == 1">Thực hành</div>
                                    </td>
                                    <td class="text-center">{{ subject.calendar_subject_start | formatDate }}</td>
                                    <td class="text-center">{{ subject.calendar_subject_end | formatDate }}</td>
                                    <td class="text-center">
                                        <div v-if="subject.calendar_subject_status == 0">
                                            <button class="fa fa-eye btn-eye" @click="change(subject.calendar_subject_id)"></button>
                                        </div>
                                        <div v-else>
                                            <button
                                                class="fa fa-eye-slash btn-eye-slash"
                                                @click="change(subject.calendar_subject_id)"
                                            ></button>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(subject)"></button>
                                    </td>
                                    <td>
                                        <button
                                            class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                            @click="destroy(subject.calendar_subject_id)"
                                        ></button>
                                    </td>
                                </tr>
                                <tr v-show="!subjects.length">
                                    <td colspan="8">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination
                            v-if="pagination.last_page > 1"
                            :pagination="pagination"
                            :offset="5"
                            @paginate="query === '' ? fetchCalendarSubjects() : search()"
                        ></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>

        <!-- Modal -->
        <div
            class="modal fade bd-example-modal-lg"
            id="CalendarSubjectModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="CalendarSubjectModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <form @submit.prevent="update()" @keydown="form.onKeydown($event)">
                    <span class="alert-danger" :form="form"></span>
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="CalendarSubjectModalTitle">Cập nhật Lớp môn học</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="mt-3">Lịch biểu <span class="text-danger">(*)</span></label>
                                <select
                                    v-model="form.calendar_id"
                                    name="calendar_id"
                                    class="form-control select-option"
                                    :class="{ 'is-invalid': form.errors.has('calendar_id') }"
                                >
                                    <option value="" selected disabled>Chọn lịch</option>
                                    <option disabled>---------------</option>
                                    <option v-for="schedule in schedules" :value="schedule.id" :key="schedule.id">
                                        {{ schedule.start | formatFullTime }} - {{ schedule.end | formatFullTime }} ----
                                        {{ schedule.title }}
                                    </option>
                                </select>
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('calendar_id')"
                                    v-html="form.errors.get('calendar_id')"
                                ></div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="mt-3">Môn học <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.subject_id"
                                            name="subject_id"
                                            class="form-control select-option"
                                            :class="{ 'is-invalid': form.errors.has('subject_id') }"
                                        >
                                            <option value="" selected disabled>Chọn môn học</option>
                                            <option disabled>---------------</option>
                                            <option
                                                v-for="subject in subjects_calendar"
                                                :value="subject.subject_id"
                                                :key="subject.subject_id"
                                                :hidden="subject.subject_status > 0"
                                                >{{ subject.subject_name }}
                                            </option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('subject_id')"
                                            v-html="form.errors.get('subject_id')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Loại lớp học <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.calendar_subject_type"
                                            name="calendar_subject_type"
                                            class="form-control select-option"
                                            :class="{ 'is-invalid': form.errors.has('calendar_subject_type') }"
                                        >
                                            <option value="" selected disabled>Chọn loại</option>
                                            <option disabled>---------------</option>
                                            <option value="0">Lý thuyết</option>
                                            <option value="1">Thực hành</option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendar_subject_type')"
                                            v-html="form.errors.get('calendar_subject_type')"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="mt-3">Giảng viên <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.calendar_subject_lecturer"
                                            name="calendar_subject_lecturer"
                                            class="form-control select-option"
                                            :class="{ 'is-invalid': form.errors.has('calendar_subject_lecturer') }"
                                        >
                                            <option value="" selected disabled>Chọn giảng viên</option>
                                            <option disabled>---------------</option>
                                            <option v-for="lec in lecturers" :value="lec.lecturer_id" :key="lec.lecturer_id">
                                                {{ lec.lecturer_fullname }}
                                            </option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendar_subject_lecturer')"
                                            v-html="form.errors.get('calendar_subject_lecturer')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Số lượng <span class="text-danger">(*)</span></label>
                                        <input
                                            type="number"
                                            v-model="form.calendar_subject_slot"
                                            name="calendar_subject_slot"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('calendar_subject_slot') }"
                                            placeholder="Nhập số lượng"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendar_subject_slot')"
                                            v-html="form.errors.get('calendar_subject_slot')"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Ngày bắt đầu <span class="text-danger">(*)</span></label>
                                        <input
                                            type="date"
                                            v-model="form.calendar_subject_start"
                                            name="calendar_subject_start"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('calendar_subject_start') }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendar_subject_start')"
                                            v-html="form.errors.get('calendar_subject_start')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Ngày kết thúc <span class="text-danger">(*)</span></label>
                                        <input
                                            type="date"
                                            v-model="form.calendar_subject_end"
                                            name="calendar_subject_end"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('calendar_subject_end') }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendar_subject_end')"
                                            v-html="form.errors.get('calendar_subject_end')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Ngày học / Tuần <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="dayofweek"
                                            name="day_of_week"
                                            class="form-control select-option"
                                            :class="{ 'is-invalid': check_dayofweek == false }"
                                        >
                                            <option value="0" selected disabled>Chọn số ngày</option>
                                            <option disabled>---------------</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="check_dayofweek == false">
                                            <p class="text-danger">Vui lòng chọn số ngày học trong tuần để tiếp tục</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="editMode">
                                <h4 class="mt-3" v-show="editMode"><strong>Lịch hiện tại</strong></h4>
                                <div class="form-group">
                                    <input
                                        class="form-control"
                                        :value="valueCurrent(form.calendar_subject_day, form.calendar_subject_time)"
                                        disabled
                                    />
                                </div>
                                <h4 class="mt-5"><strong>Lịch mới</strong></h4>
                            </div>

                            <div v-for="i in dayWeek(dayofweek)" :key="i">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ngày học <span class="text-danger">(*)</span></label>
                                            <select
                                                :id="'day_' + i"
                                                name="calendar_subject_day"
                                                class="form-control select-option"
                                                :class="{ 'is-invalid': check_day == false }"
                                            >
                                                <option value="" selected disabled>Chọn ngày học</option>
                                                <option disabled>---------------</option>
                                                <option value="0">Chủ nhật</option>
                                                <option value="1">Thứ Hai</option>
                                                <option value="2">Thứ Ba</option>
                                                <option value="3">Thứ Tư</option>
                                                <option value="4">Thứ Năm</option>
                                                <option value="5">Thứ Sáu</option>
                                                <option value="6">Thứ Bảy</option>
                                            </select>
                                            <div class="text-danger mb-3" v-if="check_day == false">
                                                <p class="text-danger">Vui lòng chọn các ngày học trong tuần để tiếp tục</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thời gian <span class="text-danger">(*)</span></label>
                                            <select
                                                :id="'time_' + i"
                                                name="calendar_subject_time"
                                                class="form-control select-option"
                                                :class="{ 'is-invalid': check_time == false }"
                                            >
                                                <option value="" selected disabled>Chọn thời gian học</option>
                                                <option disabled>---------------</option>
                                                <option value="123">Tiết 1,2,3 (7h-9h25)</option>
                                                <option value="456">Tiết 4,5,6 (9h35-12h)</option>
                                                <option value="789">Tiết 7,8,9 (13h00-15h25)</option>
                                                <option value="101112">Tiết 10,11,12 (15h35-18h00)</option>
                                                <option value="131415">Tiết 13,14,15 (18h00-20h25)</option>
                                            </select>
                                            <div class="text-danger mb-3" v-if="check_time == false">
                                                <p class="text-danger">Vui lòng chọn thời gian học trong tuần để tiếp tục</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal end-->

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
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết lớp môn học</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless w-100 m-0 ">
                            <tbody class="col-lg-12 p-0">
                                <tr>
                                    <td class="h3-strong">
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
                                        Mã môn học: <strong> {{ form.subject_code }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tên môn học: <strong> {{ form.subject_name }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Số tín chỉ: <strong> {{ form.subject_credit }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tên giảng viên: <strong> {{ form.lecturer_fullname }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Bắt đầu: <strong> {{ form.calendar_subject_start | formatDate }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Kết thúc: <strong> {{ form.calendar_subject_end | formatDate }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lịch học: <strong>{{ valueCurrent(form.calendar_subject_day, form.calendar_subject_time) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->
    </div>
</template>

<script>
import 'vue-snotify/styles/material.css'

export default {
    data() {
        return {
            courses: [],
            semesters: [],
            majors: [],
            subjects: [],
            schedules: [],
            lecturers: [],
            subjects_calendar: [],
            subjectPrograms: [],
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            dayofweek: 0,
            check_dayofweek: true,
            check_day: true,
            check_time: true,
            filter_course: '',
            filter_major: '',
            filter_semester: '',
            form: new Form({
                title: '',
                calendar_subject_id: '',
                calendar_id: '',
                subject_id: '',
                calendar_subject_type: '',
                calendar_subject_slot: '',
                calendar_subject_registered: '',
                calendar_subject_lecturer: '',
                calendar_subject_day: '',
                calendar_subject_time: '',
                calendar_subject_start: '',
                calendar_subject_end: '',
                calendar_subject_status: '',

                subject_code: '',
                subject_name: '',
                subject_credit: '',
                lecturer_fullname: ''
            })
        }
    },
    watch: {
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1
                this.fetchCalendarSubjects()
            } else {
                this.pagination = 1
                this.fetchCalendarSubjects()
            }
        },
        query(keyword) {
            if (keyword === '') {
                this.fetchCalendarSubjects()
            } else {
                this.pagination.current_page = 1
                this.search()
            }
        },
        'form.calendar_id'(value) {
            if (value != '') {
                this.fetchSubjectsForCalendar()
            }
        },
        dayofweek(value) {
            if (value != 0) {
                return Number(value)
            }
        },
        filter_major(value) {
            if (value != '') {
                this.fetchSemesters()
            }
        }
    },
    mounted() {
        this.fetchCalendarSubjects()
        this.fetchCourses()
        this.fetchMajors()
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
            let vm = this
            page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        fetchSubjects(page_url) {
            let vm = this
            page_url = '../../api/admin/manage/mon-hoc/subject'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjectPrograms = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSchedules(page_url) {
            let vm = this
            page_url = '../../api/admin/calendar-schedule/lich-bieu/schedule-subject'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.schedules = res.data
                })
                .catch(err => console.log(err))
        },
        fetchLecturers(page_url) {
            let vm = this
            page_url = '../../api/admin/user-gv/giang-vien/lecturer'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.lecturers = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSubjectsForCalendar(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/show-subjects/${this.form.calendar_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects_calendar = res.data
                })
                .catch(err => console.log(err))
        },
        search(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/search/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        show(subject) {
            this.dayofweek = 0
            this.editMode = true
            this.form.reset()
            this.form.clear()
            this.fetchSubjects()
            this.fetchSchedules()
            this.fetchLecturers()
            this.form.fill(subject)
            const day = subject.calendar_subject_day.split(', ')
            this.dayofweek = day.length

            $('#CalendarSubjectModal').modal('show')
        },
        update() {
            let arrayDayCur = []
            let arrayTimeCur = []
            let arrayDay = []
            let arrayTime = []

            arrayDayCur.push(this.form.calendar_subject_day)
            arrayTimeCur.push(this.form.calendar_subject_time)

            for (let i = 1; i <= Number(this.dayofweek); i++) {
                const day = document.getElementById('day_' + i).value
                const time = document.getElementById('time_' + i).value
                if (day != '') {
                    arrayDay.push(day)
                    if (arrayDay.length < Number(this.dayofweek)) {
                        this.check_day = false
                    } else {
                        this.check_day = true
                    }
                }

                if (time != '') {
                    arrayTime.push(time)
                    if (arrayTime.length < Number(this.dayofweek)) {
                        this.check_time = false
                    } else {
                        this.check_time = true
                    }
                }
            }

            if (arrayDay.length > 0) {
                this.form.calendar_subject_day = arrayDay.join(', ')
                this.form.calendar_subject_time = arrayTime.join(', ')
            } else {
                this.form.calendar_subject_day = arrayDayCur.join(', ')
                this.form.calendar_subject_time = arrayTimeCur.join(', ')
            }

            this.form
                .put(`../../api/admin/calendar-subject/lich-mo-lop-hoc/${this.form.calendar_subject_id}`)
                .then(res => {
                    this.fetchCalendarSubjects()
                    $('#CalendarSubjectModal').modal('hide')
                    if (this.form.successful) {
                        this.dayofweek = 0
                        this.$snotify.success('Cập nhật thành công!')
                    } else {
                        this.$snotify.error('Không thể chỉnh sửa')
                    }
                })
                .catch(err => console.log(err))
        },
        destroy(calendar_subject_id) {
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
                                .delete(`../../api/admin/calendar-subject/lich-mo-lop-hoc/${calendar_subject_id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchCalendarSubjects()
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
        detail(subject, page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/detail/${subject.calendar_subject_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.form.fill(subject)
                    $('#DetailModal').modal('show')
                })
                .catch(err => console.log(err))
        },
        change(calendar_subject_id) {
            axios
                .patch(`../../api/admin/calendar-subject/lich-mo-lop-hoc/change/${calendar_subject_id}`)
                .then(res => {
                    this.fetchCalendarSubjects()
                    this.$snotify.warning('Đã thay đổi trạng thái')
                })
                .catch(err => console.log(err))
        },
        dayWeek(dayofweek) {
            return Number(dayofweek)
        },
        valueCurrent(calendar_subject_day, calendar_subject_time) {
            const day = calendar_subject_day.split(', ')
            const time = calendar_subject_time.split(', ')
            let arrayDay = []
            let arrayTime = []
            let stringDay = ''
            let stringTime = ''
            let allStringDay = ''
            let allStringTime = ''

            if (day.length > 0) {
                for (let i = 0; i < day.length; i++) {
                    if (day[i] == 0) {
                        stringDay = 'Chủ nhật'
                    } else {
                        let key = Number(day[i]) + 1
                        stringDay = 'Thứ ' + key
                    }
                    arrayDay.push(stringDay)
                }
                allStringDay = arrayDay.join(', ')
            }

            if (time.length > 0) {
                for (let i = 0; i < time.length; i++) {
                    if (time[i] == 123) {
                        stringTime = 'Tiết 1-2-3'
                    } else if (time[i] == 456) {
                        stringTime = 'Tiết 4-5-6'
                    } else if (time[i] == 789) {
                        stringTime = 'Tiết 7-8-9'
                    } else if (time[i] == 101112) {
                        stringTime = 'Tiết 10-11-12'
                    } else if (time[i] == 131415) {
                        stringTime = 'Tiết 13-14-15'
                    }
                    arrayTime.push(stringTime)
                }
                allStringTime = arrayTime.join(', ')
            }
            return allStringDay + ' (' + allStringTime + ')'
        },
        filter(page_url) {
            if (this.filter_course == '' || this.filter_major == '' || this.filter_semester == '') {
                this.$snotify.error('Vui lòng chọn đầy đủ thông tin')
            } else {
                page_url = `../../api/admin/calendar-subject/lich-mo-lop-hoc/filter/${this.filter_course}/${this.filter_major}/${this.filter_semester}/${this.currentEntries}?page=${this.pagination.current_page}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subjects = res.data
                        this.pagination = res.meta
                    })
                    .catch(err => console.log(err))
            }
        },
        reload() {
            this.filter_course = ''
            this.filter_major = ''
            this.filter_semester = ''
            this.fetchCalendarSubjects()
        }
    }
}
</script>

<style lang="css" scoped>
.btn-eye {
    font-size: 18px;
    cursor: pointer;
    background: none;
    border: none;
}

.btn-eye-slash {
    font-size: 18px;
    cursor: pointer;
    background: none;
    border: none;
    color: #868e96de;
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

.btn-import {
    background-color: green;
    color: white;
}

.btn-import:hover {
    background-color: forestgreen;
    color: white;
}

.btn-export {
    background-color: darkgreen;
    color: white;
}

.btn-export:hover {
    background-color: seagreen;
    color: white;
}

.btn-import {
    background-color: green;
    color: white;
}

.btn-import:hover {
    background-color: forestgreen;
    color: white;
}

.btn-export {
    background-color: darkgreen;
    color: white;
}

.btn-export:hover {
    background-color: seagreen;
    color: white;
}

.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
</style>
