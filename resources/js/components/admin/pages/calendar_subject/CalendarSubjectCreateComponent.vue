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
                    <router-link tag="a" :to="{ name: 'calendarsubjectindex' }">Mở lớp học </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <router-link tag="button" class="btn btn-lg btn-primary mb-3 btn-3d" :to="{ name: 'calendarsubjectindex' }">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>

        <div class="card">
            <div class="card-header styling">
                <h3 class="card-title">Tạo mới</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
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
                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_id')" v-html="form.errors.get('calendar_id')"></div>
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
                        <div class="col-md-4">
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
                                <label class="mt-3">Số lượng sinh viên <span class="text-danger">(*)</span></label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mt-3">Số lượng lớp <span class="text-danger">(*)</span></label>
                                <input
                                    type="number"
                                    v-model="quantity_class"
                                    name="quantity_class"
                                    class="form-control"
                                    :class="{ 'is-invalid': check_quantity_class == false }"
                                    placeholder="Nhập số lượng"
                                />
                                <div class="text-danger mb-3" v-if="check_quantity_class == false">
                                    <p class="text-danger">Vui lòng chọn số lượng lớp môn học muốn tạo</p>
                                </div>
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
                    <br />

                    <div v-show="quantity_class > 0 && dayofweek > 0" v-for="j in quantityClass(quantity_class)" :key="j">
                        <h4>Lớp môn học {{ j }}</h4>
                        <div v-for="i in dayWeek(dayofweek)" :key="i">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ngày học <span class="text-danger">(*)</span></label>
                                        <select
                                            :id="'day_' + j + '_' + i"
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
                                            :id="'time_' + j + '_' + i"
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
                        <br />
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-lg btn-success mt-1 btn-3d">Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import 'vue-snotify/styles/material.css'
export default {
    data() {
        return {
            schedules: [],
            lecturers: [],
            subjects_calendar: [],
            editMode: false,
            dayofweek: 0,
            quantity_class: 0,
            check_dayofweek: true,
            check_day: true,
            check_time: true,
            check_quantity_class: true,
            form: new Form({
                title: '',
                calendar_subject_id: '',
                calendar_id: '',
                subject_id: '',
                calendar_subject_type: '',
                calendar_subject_slot: 0,
                calendar_subject_registered: '',
                calendar_subject_lecturer: '',
                calendar_subject_day: '',
                calendar_subject_time: '',
                calendar_subject_daytime: [],
                calendar_subject_start: '',
                calendar_subject_end: '',
                calendar_subject_status: ''
            })
        }
    },
    mounted() {
        this.fetchSchedules()
        this.fetchLecturers()
    },
    watch: {
        'form.calendar_id'(value) {
            if (value != '') {
                this.fetchSubjectsForCalendar()
            }
        }
    },
    methods: {
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
        dayWeek(dayofweek) {
            return Number(dayofweek)
        },
        quantityClass(quantity_class) {
            return Number(quantity_class)
        },
        store() {
            if (this.quantity_class == 0 && this.dayofweek == 0) {
                this.check_quantity_class = false
                this.check_dayofweek = false
            } else if (this.quantity_class == 0) {
                this.check_quantity_class = false
            } else if (this.dayofweek == 0) {
                this.check_dayofweek = false
            } else {
                this.check_quantity_class = true
                this.check_dayofweek = true
                let arrayDay = []
                let arrayTime = []
                let arrayDayTime = []
                let objectDayTime = {}
                let numberLength = Number(this.dayofweek)
                let numberClass = Number(this.quantity_class)

                for (let j = 1; j <= numberClass; j++) {
                    for (let i = 1; i <= numberLength; i++) {
                        const day = document.getElementById('day_' + j + '_' + i).value
                        const time = document.getElementById('time_' + j + '_' + i).value
                        if (day == '') {
                            this.check_day = false
                        } else {
                            arrayDay.push(day)
                            if (arrayDay.length < numberLength) {
                                this.check_day = false
                            } else {
                                this.check_day = true
                            }
                        }

                        if (time == '') {
                            this.check_time = false
                        } else {
                            arrayTime.push(time)
                            if (arrayTime.length < numberLength) {
                                this.check_time = false
                            } else {
                                this.check_time = true
                            }
                        }
                    }
                }

                // tach mang
                while (arrayDay.length) {
                    objectDayTime = {
                        calendar_subject_day: arrayDay.splice(0, numberLength).join(', '),
                        calendar_subject_time: arrayTime.splice(0, numberLength).join(', ')
                    }
                    arrayDayTime.push(objectDayTime)
                }
                this.form.calendar_subject_daytime = arrayDayTime
            }
            this.form.busy = true
            this.form
                .post('../../api/admin/calendar-subject/lich-mo-lop-hoc')
                .then(res => {
                    if (this.form.successful) {
                        this.form.clear()
                        this.form.reset()
                        this.dayofweek = 0
                        this.$snotify.success('Thêm mới thành công!')
                    } else {
                        this.$snotify.error('Không thể tạo mới', 'Lỗi')
                    }
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
