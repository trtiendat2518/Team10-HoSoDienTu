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
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'calendarindex' }">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>
        <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tạo mới lịch biểu</h3>
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
                                <div class="col-md-6" :class="{ 'col-md-12': form.calendarId == 2 || form.calendarId == 3 }">
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
                                            <option value="5">Thanh toán học phí</option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="form.errors.has('calendarId')"
                                            v-html="form.errors.get('calendarId')"
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-md-2" :class="{ 'col-md-6': form.calendarId == 5 }">
                                    <div :hidden="form.calendarId == 2 || form.calendarId == 3">
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
                                Thêm mới
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
        this.fetchCalendars()
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
                this.selected = []
            } else {
                this.fetchPrograms()
            }
        },
        'form.calendarId'(value) {
            if (value == 0) {
                this.fetchPrograms()
            } else if (value == 2 || value == 3) {
                this.form.location = 0
                this.form.recurrenceRule = 0
                this.programs = []
            } else {
                this.form.location = ''
                this.form.recurrenceRule = ''
                this.programs = []
            }
        }
    },
    methods: {
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
        store() {
            let exist = this.calendars.filter(el => {
                if (this.form.calendarId == 2 || this.form.calendarId == 3) {
                    if (el.body == this.form.body && el.raw == this.form.raw && el.calendarId == this.form.calendarId) {
                        return el
                    }
                } else {
                    if (
                        el.body == this.form.body &&
                        el.raw == this.form.raw &&
                        el.location == this.form.location &&
                        el.calendarId == this.form.calendarId
                    ) {
                        return el
                    }
                }
            })
            if (exist.length > 0) {
                this.$snotify.error('Lịch này đã tồn tại', 'Lỗi')
            } else if (exist.length == 0) {
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
                            .post('../../api/admin/calendar-schedule/lich-bieu', formData)
                            .then(res => {
                                this.sendMail(this.form.raw, this.form.body, this.form.location, this.form.calendarId)
                                this.form.clear()
                                this.form.reset()
                                this.$snotify.confirm('Thêm mới thành công! Bạn có muốn quay lại danh sách?', {
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
                        .post('../../api/admin/calendar-schedule/lich-bieu')
                        .then(res => {
                            this.sendMail(this.form.raw, this.form.body, this.form.location, this.form.calendarId)
                            this.form.clear()
                            this.form.reset()
                            this.$snotify.confirm('Thêm mới thành công! Bạn có muốn quay lại danh sách?', {
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
        sendMail(course, major, location, calendarId) {
            axios.get(`../../api/admin/calendar-schedule/lich-bieu/send-mail/${course}/${major}/${location}/${calendarId}`).catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style scoped>
.blue-background {
    background-color: darkblue;
}
</style>
