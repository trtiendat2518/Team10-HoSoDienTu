<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'calendarindex' }">Lịch biểu</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'calendarindex' }">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>
        <form @submit.prevent="update()" @keydown="form.onKeydown($event)">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cập nhật lịch biểu</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tiêu đề <span class="text-danger">(*)</span></label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    placeholder="Nhập tiêu đề"
                                    :class="{ 'is-invalid': form.errors.has('title') }"
                                />
                                <div class="text-danger" v-if="form.errors.has('title')" v-html="form.errors.get('title')"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Khoá học <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.raw"
                                            name="raw"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('raw') }"
                                        >
                                            <option value="" selected disabled>Chọn khoá học</option>
                                            <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                                                {{ course.course_code }} - {{ course.course_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger" v-if="form.errors.has('raw')" v-html="form.errors.get('raw')"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Chuyên ngành <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.body"
                                            name="body"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('body') }"
                                        >
                                            <option value="" selected disabled>Chọn chuyên ngành</option>
                                            <option v-for="major in majors" :key="major.major_id" :value="major.major_id">
                                                {{ major.major_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger" v-if="form.errors.has('body')" v-html="form.errors.get('body')"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mt-3">Thời gian bắt đầu <span class="text-danger">(*)</span></label>
                                        <input
                                            v-model="form.start"
                                            type="datetime-local"
                                            name="start"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('start') }"
                                        />
                                        <div class="text-danger" v-if="form.errors.has('start')" v-html="form.errors.get('start')"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mt-3">Thời gian kết thúc <span class="text-danger">(*)</span></label>
                                        <input
                                            v-model="form.end"
                                            type="datetime-local"
                                            name="end"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('end') }"
                                        />
                                        <div class="text-danger" v-if="form.errors.has('end')" v-html="form.errors.get('end')"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" :class="{ 'col-md-12': form.calendarId > 1 && form.calendarId < 4 }">
                                    <div class="form-group">
                                        <label class="mt-3">Loại sự kiện <span class="text-danger">(*)</span></label>
                                        <select
                                            v-model="form.calendarId"
                                            name="calendarId"
                                            class="form-control select-option"
                                            :class="{ 'is-invalid': form.errors.has('calendarId') }"
                                        >
                                            <option value="null" selected disabled>Chọn sự kiện</option>
                                            <option disabled>---------------</option>
                                            <option value="0">Đăng ký kế hoạch học tập</option>
                                            <option value="1">Đăng ký môn học</option>
                                            <option value="2">Thi học kỳ lần 1</option>
                                            <option value="3">Thi học kỳ lần 2</option>
                                            <option value="4">Đánh giá điểm rèn luyện</option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendarId')"
                                            v-html="form.errors.get('calendarId')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div v-show="form.calendarId <= 1 || form.calendarId >= 4">
                                        <div class="form-group">
                                            <label class="mt-3">Học kỳ <span class="text-danger">(*)</span></label>
                                            <select
                                                v-model="form.location"
                                                name="location"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('location') }"
                                            >
                                                <option value="" selected disabled>Chọn Học kỳ</option>
                                                <option v-for="semester in semesters" :key="semester" :value="semester">
                                                    Học kỳ {{ semester }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-danger mb-3"
                                                v-if="form.errors.has('location')"
                                                v-html="form.errors.get('location')"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div v-show="form.calendarId <= 1">
                                        <div class="form-group">
                                            <label class="mt-3">TC bắt buộc <span class="text-danger">(*)</span></label>
                                            <input
                                                type="number"
                                                v-model="form.recurrenceRule"
                                                name="recurrenceRule"
                                                class="form-control"
                                                placeholder="Nhập số TC bắt buộc"
                                                :class="{ 'is-invalid': form.errors.has('recurrenceRule') }"
                                            />
                                            <div
                                                class="text-danger mb-3"
                                                v-if="form.errors.has('recurrenceRule')"
                                                v-html="form.errors.get('recurrenceRule')"
                                            ></div>
                                        </div>
                                    </div>
                                    <div v-show="form.calendarId == 4">
                                        <div class="form-group">
                                            <label class="mt-3">Phân loại <span class="text-danger">(*)</span></label>
                                            <select
                                                v-model="form.recurrenceRule"
                                                name="recurrenceRule"
                                                class="form-control select-option"
                                                :class="{ 'is-invalid': form.errors.has('recurrenceRule') }"
                                            >
                                                <option value="" selected disabled>Chọn phân loại</option>
                                                <option disabled>---------------</option>
                                                <option value="0">Sinh viên</option>
                                                <option value="1">Giảng viên chủ nhiệm</option>
                                                <option value="2">Ban chủ nhiệm khoa</option>
                                            </select>
                                            <div
                                                class="text-danger mb-3"
                                                v-if="form.errors.has('recurrenceRule')"
                                                v-html="form.errors.get('recurrenceRule')"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3" ref="content" v-show="programs.length > 0">
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
                                            <th class="w-10 text-center" scope="col" rowspan="2">
                                                Chọn
                                            </th>
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
                                                <input
                                                    type="checkbox"
                                                    name="plansuggest_detail_program"
                                                    :value="value.subject_id"
                                                    :checked="checkValue(value)"
                                                    @change="select($event.target.checked, value.subject_id)"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update btn-block mt-1">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            id: this.$route.params.idCalendar,
            courses: [],
            majors: [],
            semesters: [],
            programs: [],
            selected: [],
            calendars: [],
            editMode: false,
            form: new Form({
                id: '',
                title: '',
                raw: '',
                body: '',
                category: '',
                start: '',
                end: '',
                calendarId: null,
                location: '',
                recurrenceRule: '',
                course_code: '',
                course_name: '',
                major_name: ''
            })
        }
    },
    mounted() {
        this.fetchMajors()
        this.fetchCourses()
        this.fetchCalendar()
    },
    watch: {
        'form.raw'(value) {
            if (value != '') {
                this.fetchSemesters()
            } else {
                this.fetchSemesters()
                this.fetchPrograms()
            }
        },
        'form.body'(value) {
            if (value != '') {
                this.fetchSemesters()
            } else {
                this.fetchSemesters()
                this.fetchPrograms()
            }
        },
        'form.location'(value) {
            if (value != '') {
                this.fetchPrograms()
            } else {
                this.fetchPrograms()
            }
        },
        'form.calendarId'(value) {
            if (value == 0) {
                this.fetchPrograms()
            } else {
                this.programs = []
            }
        },
        $route(to, from) {
            this.id = to.params.idCalendar
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
            page_url = `../../api/admin/calendar-schedule/lich-bieu/hoc-ky/${this.form.raw}/${this.form.body}`
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
        fetchPrograms(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-schedule/lich-bieu/chuong-trinh-dao-tao/${this.form.raw}/${this.form.body}/${this.form.location}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (this.form.calendarId == 0) {
                        this.programs = res.data
                    }
                })
                .catch(err => console.log(err))
        },
        fetchCalendar(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-schedule/lich-bieu/${this.id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    var time_start = new Date(res.data[0].start)
                    var time_end = new Date(res.data[0].end)

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

                    var datetime_start =
                        time_start.getFullYear() + '-' + month_start + '-' + date_start + 'T' + hour_start + ':' + minute_start
                    var datetime_end = time_end.getFullYear() + '-' + month_end + '-' + date_end + 'T' + hour_end + ':' + minute_end

                    this.form.id = this.id
                    this.form.start = datetime_start
                    this.form.end = datetime_end
                    this.form.title = res.data[0].title
                    this.form.raw = res.data[0].raw
                    this.form.body = res.data[0].body
                    this.form.calendarId = res.data[0].calendarId
                    this.form.location = res.data[0].location
                    this.form.recurrenceRule = res.data[0].recurrenceRule

                    if (this.form.calendarId == 0) {
                        this.fetchSubjectCalendar()
                    }
                })
                .catch(err => console.log(err))
        },
        fetchSubjectCalendar(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-schedule/lich-bieu/subject-plan/${this.id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.calendars = res.data
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].calendar_plan_subject)
                    }
                })
                .catch(err => console.log(err))
        },
        update() {
            if (this.form.calendarId == 0) {
                if (this.selected.length == 0) {
                    this.$snotify.error('Vui lòng chọn môn học', 'Lỗi')
                } else {
                    this.form.busy = true
                    let formData = new FormData()
                    for (let i = 0; i < this.selected.length; i++) {
                        formData.append('subject[]', this.selected[i])
                    }
                    formData.append('title', this.form.title)
                    formData.append('raw', this.form.raw)
                    formData.append('body', this.form.body)
                    formData.append('start', this.form.start)
                    formData.append('end', this.form.end)
                    formData.append('calendarId', this.form.calendarId)
                    formData.append('location', this.form.location)
                    formData.append('recurrenceRule', this.form.recurrenceRule)
                    axios
                        .post(`../../api/admin/calendar-schedule/lich-bieu/update-plan/${this.id}`, formData)
                        .then(res => {
                            this.fetchSubjectCalendar()
                            this.$snotify.confirm('Cập nhật thành công! Bạn có muốn quay lại danh sách?', {
                                timeout: 5000,
                                showProgressBar: true,
                                closeOnClick: false,
                                pauseOnHover: true,
                                buttons: [
                                    {
                                        text: 'Có',
                                        action: toast => {
                                            this.$snotify.remove(toast.id)
                                            this.$router.push({ name: 'calendarindex' })
                                        },
                                        bold: false
                                    },
                                    {
                                        text: 'Không',
                                        action: toast => {
                                            this.$snotify.remove(toast.id)
                                        },
                                        bold: true
                                    }
                                ]
                            })
                        })
                        .catch(err => console.log(err))
                }
            } else {
                this.form
                    .put(`../../api/admin/calendar-schedule/lich-bieu/${this.id}`)
                    .then(res => {
                        this.fetchSubjectCalendar()
                        this.$snotify.confirm('Cập nhật thành công! Bạn có muốn quay lại danh sách?', {
                            timeout: 5000,
                            showProgressBar: true,
                            closeOnClick: false,
                            pauseOnHover: true,
                            buttons: [
                                {
                                    text: 'Có',
                                    action: toast => {
                                        this.$snotify.remove(toast.id)
                                        this.$router.push({ name: 'calendarindex' })
                                    },
                                    bold: false
                                },
                                {
                                    text: 'Không',
                                    action: toast => {
                                        this.$snotify.remove(toast.id)
                                    },
                                    bold: true
                                }
                            ]
                        })
                    })
                    .catch(err => console.log(err))
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
        checkValue(value) {
            const check = this.calendars.find(sub => sub.calendar_plan_subject == value.subject_id)
            if (check) {
                return true
            } else {
                return false
            }
        }
    }
}
</script>

<style scoped>
.blue-background {
    background-color: darkblue;
}
</style>
