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
                <li class="breadcrumb-item active" aria-current="page">Lịch mở lớp học</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'calendarindex' }">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
                </router-link>
            </div>
            <div class="col-md-6">
                <button class="btn btn-info btn-lg mb-3 btn-3d float-right" @click="create()">
                    <li class="fa fa-plus"></li>
                    Tạo mới
                </button>
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

                    <div class="row ml-2 mr-2">
                        <div class="col-md-10">
                            <input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm môn học..." />
                        </div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling" v-model="currentEntries">
                                        <option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter ">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-white">Mã môn học</th>
                                    <th class="text-white">Tên môn học</th>
                                    <th class="text-white">Số lượng</th>
                                    <th class="text-white">Đã ĐK</th>
                                    <th class="text-white">Loại</th>
                                    <th class="text-white">Ngày bắt đầu</th>
                                    <th class="text-white">Ngày kết thúc</th>
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
                                    <td>{{ subject.calendar_subject_slot }}</td>
                                    <td>{{ subject.calendar_subject_registered }}</td>
                                    <td>
                                        <div v-if="subject.calendar_subject_type == 0">Lý thuyết</div>
                                        <div v-else-if="subject.calendar_subject_type == 1">Thực hành</div>
                                    </td>
                                    <td>{{ subject.calendar_subject_start | formatDate }}</td>
                                    <td>{{ subject.calendar_subject_end | formatDate }}</td>
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
                <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
                    <span class="alert-danger" :form="form"></span>
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="CalendarSubjectModalTitle">{{ editMode ? 'Cập nhật' : 'Thêm mới' }} Lớp môn học</h5>
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
                                                v-for="subject in subjectPrograms"
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                            </div>

                            <div class="form-group">
                                <label class="mt-3">Lịch học <span class="text-danger">(*)</span></label>
                                <textarea
                                    type="number"
                                    v-model="form.calendar_subject_schedule"
                                    name="calendar_subject_schedule"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('calendar_subject_schedule') }"
                                    rows="3"
                                    placeholder="...."
                                ></textarea>
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('calendar_subject_schedule')"
                                    v-html="form.errors.get('calendar_subject_schedule')"
                                ></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">
                                {{ editMode ? 'Cập nhật' : 'Thêm mới' }}
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
                                        Lịch học: <strong> {{ form.calendar_subject_schedule }}</strong>
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
            lecturer_id: this.$facultyId,
            subjects: [],
            schedules: [],
            lecturers: [],
            subjectPrograms: [],
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            form: new Form({
                calendar_subject_id: '',
                calendar_id: '',
                subject_id: '',
                calendar_subject_type: '',
                calendar_subject_slot: '',
                calendar_subject_registered: '',
                calendar_subject_lecturer: '',
                calendar_subject_schedule: '',
                calendar_subject_start: '',
                calendar_subject_end: '',

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
        }
    },
    mounted() {
        this.fetchCalendarSubjects()
    },
    methods: {
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
        create() {
            this.editMode = false
            this.form.reset()
            this.form.clear()
            this.fetchSubjects()
            this.fetchSchedules()
            this.fetchLecturers()
            $('#CalendarSubjectModal').modal('show')
        },
        store() {
            this.form.busy = true
            this.form
                .post('../../api/admin/calendar-subject/lich-mo-lop-hoc')
                .then(res => {
                    this.fetchCalendarSubjects()
                    $('#CalendarSubjectModal').modal('hide')
                    if (this.form.successful) {
                        this.$snotify.success('Thêm mới thành công!')
                    } else {
                        this.$snotify.error('Không thể thêm Khoa', 'Lỗi')
                    }
                })
                .catch(err => console.log(err))
        },
        show(subject) {
            this.editMode = true
            this.form.reset()
            this.form.clear()
            this.fetchSubjects()
            this.fetchSchedules()
            this.fetchLecturers()
            this.form.fill(subject)
            $('#CalendarSubjectModal').modal('show')
        },
        update() {
            this.form
                .put(`../../api/admin/calendar-subject/lich-mo-lop-hoc/${this.form.calendar_subject_id}`)
                .then(res => {
                    this.fetchCalendarSubjects()
                    $('#CalendarSubjectModal').modal('hide')
                    if (this.form.successful) {
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
