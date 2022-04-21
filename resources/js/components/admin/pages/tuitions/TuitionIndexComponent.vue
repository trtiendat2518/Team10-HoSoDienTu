<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Quản lý học phí</li>
            </ol>
        </div>

        <div class="col-md-9">
            <button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()">
                <li class="fa fa-plus"></li>
                Tạo mới
            </button>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-11">
                            <h3 class="card-title">Quản lý học phí</h3>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-lg btn-primary fa fa-refresh btn-3d" @click="reload()">Tải lại</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 text-center">
                            <button
                                class="btn-3d btn btn-danger mt-3 ml-3 btn-lg fa fa-trash"
                                @click="destroyall()"
                                :disabled="!selected.length"
                            ></button>
                        </div>
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <select class="form-control" v-model="course">
                                    <option value="" selected>Tất cả khoá học</option>
                                    <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                                        {{ course.course_code }} - {{ course.course_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <select class="form-control" v-model="faculty" :disabled="course == ''">
                                    <option value="" selected>Tất cả khoa</option>
                                    <option v-for="faculty in faculties" :key="faculty.faculty_id" :value="faculty.faculty_id">
                                        {{ faculty.faculty_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <select class="form-control" v-model="major" :disabled="faculty == ''">
                                    <option value="" selected>Tất cả chuyên ngành</option>
                                    <option v-for="major in majors" :key="major.major_id" :value="major.major_id">
                                        {{ major.major_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <div class="form-group">
                                <button class="btn btn-indigo block" @click="filter()">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Lọc
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling" v-model="currentEntries">
                                        <option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5">
                                        <input
                                            type="checkbox"
                                            class="form-control"
                                            :disabled="empty()"
                                            @click="select()"
                                            v-model="selectAll"
                                        />
                                    </th>
                                    <th class="text-white">Khóa học</th>
                                    <th class="text-white">Khoa</th>
                                    <th class="text-white">Chuyên ngành</th>
                                    <th class="text-white">Học phí (1 tín chỉ)</th>
                                    <th class="text-white w-5">Giảm học phí</th>
                                    <th class="w-5"></th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="tuitions.length" v-for="tuition in tuitions" :key="tuition.tuition_id">
                                    <td>
                                        <center><input type="checkbox" :value="tuition.tuition_id" v-model="selected" /></center>
                                    </td>
                                    <td>{{ tuition.course_name }}</td>
                                    <td>{{ tuition.faculty_name }}</td>
                                    <td>{{ tuition.major_name }}</td>
                                    <td>{{ tuition.tuition_fee | formatNumber }} VNĐ</td>
                                    <td v-if="tuition.tuition_discount == 0">
                                        -
                                    </td>
                                    <td v-else>{{ tuition.tuition_discount }}%</td>
                                    <td>
                                        <button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o" @click="show(tuition)"></button>
                                    </td>
                                    <td>
                                        <button
                                            class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                            @click="destroy(tuition.tuition_id)"
                                        ></button>
                                    </td>
                                </tr>
                                <tr v-show="!tuitions.length">
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
                            @paginate="fetchTuitions()"
                        ></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="TuitionModal" tabindex="-1" role="dialog" aria-labelledby="TuitionModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
                    <span class="alert-danger" :form="form"></span>
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="TuitionModalTitle">{{ editMode ? 'Cập nhật' : 'Thêm mới' }} Học phí</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label>Khóa học <span :hidden="editMode" class="text-danger">(*)</span></label>
                            <select
                                v-model="form.tuition_course"
                                name="tuition_course"
                                class="form-control select-option"
                                :class="{ 'is-invalid': form.errors.has('tuition_course') }"
                            >
                                <option value="" selected disabled>Chọn Khoá học</option>
                                <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                                    {{ course.course_code }} - {{ course.course_name }}
                                </option>
                            </select>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('tuition_course')"
                                v-html="form.errors.get('tuition_course')"
                            ></div>

                            <label class="mt-3">Khoa <span class="text-danger">(*)</span></label>
                            <select
                                v-model="form.tuition_faculty"
                                name="tuition_faculty"
                                class="form-control select-option"
                                :class="{ 'is-invalid': form.errors.has('tuition_faculty') }"
                            >
                                <option value="" selected disabled>Chọn Khoa</option>
                                <option v-for="faculty in faculties" :key="faculty.faculty_id" :value="faculty.faculty_id">
                                    {{ faculty.faculty_name }}
                                </option>
                            </select>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('tuition_faculty')"
                                v-html="form.errors.get('tuition_faculty')"
                            ></div>

                            <label class="mt-3">Chuyên ngành <span class="text-danger">(*)</span></label>
                            <select
                                v-model="form.tuition_major"
                                name="tuition_major"
                                class="form-control select-option"
                                :class="{ 'is-invalid': form.errors.has('tuition_major') }"
                                :disabled="form.tuition_faculty == ''"
                            >
                                <option value="" selected disabled>Chọn Chuyên ngành</option>
                                <option v-for="major in majors" :key="major.major_id" :value="major.major_id">
                                    {{ major.major_name }}
                                </option>
                            </select>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('tuition_major')"
                                v-html="form.errors.get('tuition_major')"
                            ></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mt-3">Học phí <span class="text-danger">(*)</span></label>
                                    <input
                                        v-model="form.tuition_fee"
                                        type="number"
                                        name="tuition_fee"
                                        class="form-control"
                                        placeholder="Nhập học phí"
                                        min="0"
                                        :class="{ 'is-invalid': form.errors.has('tuition_fee') }"
                                    />
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('tuition_fee')"
                                        v-html="form.errors.get('tuition_fee')"
                                    ></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="mt-3">Giảm học phí <span class="text-danger">(*)</span></label>
                                    <input
                                        v-model="form.tuition_discount"
                                        type="number"
                                        name="tuition_discount"
                                        class="form-control"
                                        placeholder="Nhập % giảm học phí"
                                        min="0"
                                        max="100"
                                        :class="{ 'is-invalid': form.errors.has('tuition_discount') }"
                                    />
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('tuition_discount')"
                                        v-html="form.errors.get('tuition_discount')"
                                    ></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Đóng</button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary background-update btn-3d">
                                {{ editMode ? 'Cập nhật' : 'Thêm mới' }}
                            </button>
                        </div>
                    </div>
                </form>
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
            tuitions: [],
            courses: [],
            majors: [],
            faculties: [],
            not_in: [],
            course: '',
            major: '',
            faculty: '',
            pagination: {
                current_page: 1
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            editMode: false,
            form: new Form({
                tuition_id: '',
                tuition_course: '',
                tuition_faculty: '',
                tuition_major: '',
                tuition_fee: '',
                tuition_discount: ''
            }),
            selected: [],
            selectAll: false
        }
    },
    mounted() {
        this.fetchCourses()
        this.fetchFaculties()
        this.fetchTuitions()
    },
    watch: {
        faculty(value) {
            if (value != '') {
                this.fetchMajors()
            }
        },
        'form.tuition_faculty'(value) {
            if (value != '') {
                this.fetchMajorsForm()
            }
        },
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1
                this.fetchTuitions()
            } else {
                this.pagination = 1
                this.fetchTuitions()
            }
        }
    },
    methods: {
        empty() {
            return this.tuitions.length < 1
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
            page_url = `../../api/admin/edu-faculty/khoa/faculty`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.faculties = res.data
                })
                .catch(err => console.log(err))
        },
        fetchMajors(page_url) {
            page_url = `../../api/admin/edu-major/chuyen-nganh/major-faculty/${this.faculty}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                })
                .catch(err => console.log(err))
        },
        fetchMajorsForm(page_url) {
            page_url = `../../api/admin/edu-major/chuyen-nganh/major-faculty/${this.form.tuition_faculty}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                })
                .catch(err => console.log(err))
        },
        fetchTuitions(page_url) {
            page_url = `../../api/admin/tuition-management/quan-ly-hoc-phi/${this.currentEntries}?page=${this.pagination.current_page}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.tuitions = res.data
                    this.pagination = res.meta
                })
                .catch(err => console.log(err))
        },
        fetchNotIn(page_url) {
            page_url = `../../api/admin/tuition-management/quan-ly-hoc-phi/not-in/${this.form.tuition_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.not_in = res.data
                })
                .catch(err => console.log(err))
        },
        create() {
            this.editMode = false
            this.majors = []
            this.form.reset()
            this.form.clear()
            $('#TuitionModal').modal('show')
        },
        store() {
            let uinique = this.tuitions.filter(el => {
                if (
                    el.tuition_course == this.form.tuition_course &&
                    el.tuition_faculty == this.form.tuition_faculty &&
                    el.tuition_major == this.form.tuition_major
                ) {
                    return el
                }
            })
            if (uinique.length > 0) {
                this.$snotify.error('Học phí cho Khoá - Khoa - Chuyên ngành này đã tồn tại!')
            } else {
                this.form.busy = true
                this.form
                    .post('../../api/admin/tuition-management/quan-ly-hoc-phi')
                    .then(res => {
                        this.fetchTuitions()
                        $('#TuitionModal').modal('hide')
                        if (this.form.successful) {
                            this.$snotify.success('Thêm mới thành công!')
                        } else {
                            this.$snotify.error('Không thể thêm học phí', 'Lỗi')
                        }
                    })
                    .catch(err => console.log(err))
            }
        },
        show(tuition) {
            this.editMode = true
            this.form.reset()
            this.form.clear()
            this.form.fill(tuition)
            this.fetchNotIn()
            $('#TuitionModal').modal('show')
        },
        update() {
            let uinique = this.not_in.filter(el => {
                if (
                    el.tuition_course == this.form.tuition_course &&
                    el.tuition_faculty == this.form.tuition_faculty &&
                    el.tuition_major == this.form.tuition_major
                ) {
                    return el
                }
            })
            if (uinique.length > 0) {
                this.$snotify.error('Học phí cho Khoá - Khoa - Chuyên ngành này đã tồn tại!')
            } else {
                this.form
                    .put(`../../api/admin/tuition-management/quan-ly-hoc-phi/${this.form.tuition_id}`)
                    .then(res => {
                        this.fetchTuitions()
                        $('#TuitionModal').modal('hide')
                        if (this.form.successful) {
                            this.$snotify.success('Cập nhật thành công!')
                        } else {
                            this.$snotify.error('Không thể chỉnh sửa')
                        }
                    })
                    .catch(err => console.log(err))
            }
        },
        destroy(tuition_id) {
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
                                .delete(`../../api/admin/tuition-management/quan-ly-hoc-phi/${tuition_id}`)
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchTuitions()
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
        destroyall() {
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
                                .post('../../api/admin/tuition-management/quan-ly-hoc-phi/destroyall', { tuition: this.selected })
                                .then(res => {
                                    this.$snotify.success('Đã xóa!')
                                    this.fetchTuitions()
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
        select() {
            this.selected = []
            if (!this.selectAll) {
                for (let i in this.tuitions) {
                    this.selected.push(this.tuitions[i].tuition_id)
                }
            }
        },
        filter(page_url) {
            if (this.course != '' && this.faculty == '' && this.major == '') {
                page_url = `../../api/admin/tuition-management/quan-ly-hoc-phi/filter-course/${this.course}/${this.currentEntries}?page=${this.pagination.current_page}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.tuitions = res.data
                        this.pagination = res.meta
                    })
                    .catch(err => console.log(err))
            } else if (this.course != '' && this.faculty != '' && this.major == '') {
                page_url = `../../api/admin/tuition-management/quan-ly-hoc-phi/filter-course-faculty/${this.course}/${this.faculty}/${this.currentEntries}?page=${this.pagination.current_page}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.tuitions = res.data
                        this.pagination = res.meta
                    })
                    .catch(err => console.log(err))
            } else if (this.course != '' && this.faculty != '' && this.major != '') {
                page_url = `../../api/admin/tuition-management/quan-ly-hoc-phi/filter-course-faculty-major/${this.course}/${this.faculty}/${this.major}/${this.currentEntries}?page=${this.pagination.current_page}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.tuitions = res.data
                        this.pagination = res.meta
                    })
                    .catch(err => console.log(err))
            }
        },
        reload() {
            this.course = ''
            this.faculty = ''
            this.major = ''
            this.fetchTuitions()
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none !important;
}
</style>
