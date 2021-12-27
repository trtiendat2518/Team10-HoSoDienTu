<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb"><!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a"
                                 :to="{ name: 'dashboard' }">Dashboard
                    </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a"
                                 :to="{ name: 'calendarindex' }">Lịch biểu
                    </router-link>
                </li>
                <li class="breadcrumb-item active"
                    aria-current="page">Sự kiện
                </li>
            </ol><!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <router-link tag="button"
                             class="btn btn-lg btn-primary mb-3 btn-3d"
                             :to="{ name: 'calendarindex' }">
                    <i class="fa fa-arrow-left"
                       aria-hidden="true"></i> Quay lại
                </router-link>
            </div>
            <div class="col-md-6">
                <button class="btn btn-info btn-lg mb-3 btn-3d float-right"
                        @click="create()">
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
                            <h3 class="card-title">Lịch thi</h3>
                        </div>
                    </div>

                    <div class="row ml-2 mr-2">
                        <div class="col-md-10">
                            <input type="text"
                                   class="form-control mt-2"
                                   v-model="query"
                                   placeholder="Tìm kiếm môn học...">
                        </div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling"
                                            v-model="currentEntries">
                                        <option v-for="entry in showEntries"
                                                :key="entry"
                                                :value="entry">{{ entry }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-nowrap">
                            <thead class="blue-background text-white">
                            <tr>
                                <th class="text-white w-30">Tiêu đề</th>
                                <th class="text-white w-30">Môn học</th>
                                <th class="text-white w-15">Ngày bắt đầu</th>
                                <th class="text-white w-15">Ngày kết thúc</th>
                                <th class="w-5"></th>
                                <th class="w-5"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-show="exams.length" v-for="exam in exams" :key="exam.calendar_exam_id">
                                <td @click="detail(exam)"><a href="javascript:void(0)">{{ exam.title }}</a></td>
                                <td>{{ exam.subject_name }}</td>
                                <td>{{ exam.start | formatDate }}</td>
                                <td>{{ exam.end | formatDate }}</td>
                                <td style="text-align: center">
                                    <button class="btn-3d btn btn-success btn-lg fa fa-pencil-square-o"
                                            @click="show(exam)"></button>
                                </td>
                                <td>
                                    <button class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                            @click="destroy(exam.calendar_exam_id)"></button>
                                </td>
                            </tr>
                            <tr v-show="!exams.length">
                                <td colspan="8">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5"
                                    @paginate="query === '' ? fetchExams() : search() "></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div><!-- col end -->
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="ExamModal" tabindex="-1" role="dialog"
             aria-labelledby="ExamModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
                    <span class="alert-danger" :form="form"></span>
                    <div class="modal-content">
                        <div class="modal-header styling-modal-header-update">
                            <h5 class="modal-title" id="ExamModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Lịch
                                thi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Khóa học <span class="text-danger">(*)</span></label>
                                        <select v-model="form.calendar_exam_course" name="calendar_exam_course"
                                                class="form-control select-option"
                                                :class="{'is-invalid': form.errors.has('calendar_exam_course')}">
                                            <option value="" selected disabled>Chọn khóa học</option>
                                            <option disabled>---------------</option>
                                            <option v-for="course in courses" :value="course.course_id"
                                                    :hidden="course.course_status>0">{{ course.course_code }} -
                                                {{ course.course_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_course')"
                                             v-html="form.errors.get('calendar_exam_course')"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Khoa <span class="text-danger">(*)</span></label>
                                        <select v-model="form.calendar_exam_faculty" name="calendar_exam_faculty"
                                                class="form-control select-option"
                                                :class="{'is-invalid': form.errors.has('calendar_exam_faculty')}">
                                            <option value="" selected disabled>Chọn khoa</option>
                                            <option disabled>---------------</option>
                                            <option v-for="faculty in faculties" :value="faculty.faculty_id"
                                                    :hidden="faculty.faculty_status>0">{{ faculty.faculty_code }} -
                                                {{ faculty.faculty_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_faculty')"
                                             v-html="form.errors.get('calendar_exam_faculty')"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Chuyên ngành <span class="text-danger">(*)</span></label>
                                        <select v-model="form.calendar_exam_major" name="calendar_exam_major"
                                                class="form-control select-option"
                                                :class="{'is-invalid': form.errors.has('calendar_exam_major')}">
                                            <option value="" selected disabled>Chọn chuyên ngành</option>
                                            <option disabled>---------------</option>
                                            <option v-for="major in majors" :value="major.major_id"
                                                    :hidden="major.major_status>0">{{ major.major_code }} -
                                                {{ major.major_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_major')"
                                             v-html="form.errors.get('calendar_exam_major')"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mt-3">Môn học <span class="text-danger">(*)</span></label>
                                        <select v-model="form.calendar_exam_subject" name="calendar_exam_subject"
                                                class="form-control select-option"
                                                :class="{'is-invalid': form.errors.has('calendar_exam_subject')}">
                                            <option value="" selected disabled>Chọn môn học</option>
                                            <option disabled>---------------</option>
                                            <option v-for="subject in subjects" :value="subject.subject_id"
                                                    :hidden="subject.subject_status>0">{{ subject.subject_name }}
                                            </option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_subject')"
                                             v-html="form.errors.get('calendar_exam_subject')"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mt-3">Hình thức <span class="text-danger">(*)</span></label>
                                        <select v-model="form.calendar_exam_method"
                                                name="calendar_exam_method"
                                                class="form-control select-option"
                                                :class="{'is-invalid': form.errors.has('calendar_exam_method')}">
                                            <option value="" selected disabled>Chọn hình thức</option>
                                            <option disabled>---------------</option>
                                            <option value="0">Tự luận</option>
                                            <option value="1">Trắc nghiệm</option>
                                            <option value="2">Tự luận + Trắc nghiệm</option>
                                            <option value="3">Vấn đáp</option>
                                            <option value="4">Thuyết trình</option>
                                            <option value="5">Đồ án</option>
                                        </select>
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_method')"
                                             v-html="form.errors.get('calendar_exam_method')"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="mt-3">Lịch biểu <span class="text-danger">(*)</span></label>
                                <select v-model="form.calendar_exam_schedule"
                                        name="calendar_exam_schedule"
                                        class="form-control select-option"
                                        :class="{'is-invalid': form.errors.has('calendar_exam_schedule')}">
                                    <option value="" selected disabled>Chọn lịch</option>
                                    <option disabled>---------------</option>
                                    <option v-for="schedule in schedules" :value="schedule.id">
                                        {{ schedule.start | formatFullTime }} - {{ schedule.end | formatFullTime }} ----
                                        {{ schedule.title }}
                                    </option>
                                </select>
                                <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_schedule')"
                                     v-html="form.errors.get('calendar_exam_schedule')"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mt-3">Phòng thi <span class="text-danger">(*)</span></label>
                                        <input type="text"
                                               v-model="form.calendar_exam_room"
                                               name="calendar_exam_room"
                                               class="form-control"
                                               :class="{'is-invalid': form.errors.has('calendar_exam_room')}"
                                               placeholder="Nhập phòng thi">
                                        <div class="text-danger mb-3"
                                             v-if="form.errors.has('calendar_exam_room')"
                                             v-html="form.errors.get('calendar_exam_room')"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mt-3">Địa điểm <span class="text-danger">(*)</span></label>
                                        <input type="text" v-model="form.calendar_exam_place" name="calendar_exam_place"
                                               class="form-control"
                                               :class="{'is-invalid': form.errors.has('calendar_exam_place')}"
                                               placeholder="Nhập địa điểm thi">
                                        <div class="text-danger mb-3" v-if="form.errors.has('calendar_exam_place')"
                                             v-html="form.errors.get('calendar_exam_place')"></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="mt-3">Học kỳ <span class="text-danger">(*)</span></label>
                                        <input type="number"
                                               v-model="form.calendar_exam_semester"
                                               name="calendar_exam_semester"
                                               class="form-control"
                                               :class="{'is-invalid': form.errors.has('calendar_exam_semester')}"
                                               placeholder="Nhập học kỳ">
                                        <div class="text-danger mb-3"
                                             v-if="form.errors.has('calendar_exam_semester')"
                                             v-html="form.errors.get('calendar_exam_semester')"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="mt-3">Ghi chú</label>
                                <textarea type="number"
                                          v-model="form.calendar_exam_note"
                                          name="calendar_exam_note"
                                          class="form-control"
                                          :class="{'is-invalid': form.errors.has('calendar_exam_note')}"
                                          rows="3"
                                          placeholder="...."></textarea>
                                <div class="text-danger mb-3"
                                     v-if="form.errors.has('calendar_exam_note')"
                                     v-html="form.errors.get('calendar_exam_note')"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button :disabled="form.busy" type="submit"
                                    class="btn-3d btn btn-primary background-update">
                                {{ editMode ? "Cập nhật" : "Thêm mới" }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal end-->

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header styling-modal-header-info">
                        <h5 class="modal-title styling-font-modal-header" id="DetailModalTitle">Chi tiết Khoa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table row table-borderless w-100 m-0 border"
                        	   v-for="detail in details" :key="detail.caledar_exam_id">
                            <tbody class="col-lg-6 p-0">
                                <tr>
                                    <td class="h3-strong"><h3><strong> Thông tin chi tiết</strong></h3></td>
                                </tr>
                                <tr>
                                    <td>Tiêu đề: <strong> {{ detail.title }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Nội dung: <strong> {{ detail.body }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Môn học: <strong > {{ detail.subject_name }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Bắt đầu: <strong > {{ detail.start  | formatFullTime }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Kết thúc: <strong > {{ detail.end | formatFullTime }}</strong></td>
                                </tr>
                            </tbody>
                            <tbody class="col-lg-6 p-0">
                                <tr>
                                    <td class="h3-strong"><h3><strong> Thông tin khóa học</strong></h3></td>
                                </tr>
                                <tr>
                                    <td>Khóa học:
                                        <strong>{{ detail.course_name }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Khoa:
                                        <strong>{{ detail.faculty_name }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Chuyên ngành:
                                        <strong>{{ detail.major_name }}</strong>
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
            faculties: [],
            majors: [],
            courses: [],
            subjects: [],
            schedules: [],
            exams: [],
            pagination: {
                current_page: 1,
            },
            currentEntries: 5,
            showEntries: [5, 10, 25, 50],
            query: '',
            editMode: false,
            form: new Form({
                calendar_exam_id: '',
                calendar_exam_schedule: '',
                calendar_exam_faculty: '',
                calendar_exam_course: '',
                calendar_exam_major: '',
                calendar_exam_subject: '',
                calendar_exam_room: '',
                calendar_exam_method: '',
                calendar_exam_place: '',
                calendar_exam_semester: '',
                calendar_exam_note: '',
            }),
            details: [],
        };
    },
    watch: {
        currentEntries(number) {
            if (number === 5) {
                this.pagination = 1;
                this.fetchExams();
            } else {
                this.pagination = 1;
                this.fetchExams();
            }
        },
        query(keyword) {
            if (keyword === '') {
                this.fetchExams();
            } else {
                this.pagination.current_page = 1;
                this.search();
            }
        },
    },
    mounted() {
        this.fetchExams();
        this.fetchCourses();
        this.fetchFaculties();
        this.fetchMajors();
        this.fetchSubjects();
        this.fetchSchedules();
    },
    methods: {
        empty() {
            return (this.faculties.length < 1);
        },
        fetchExams(page_url) {
            let vm = this;
            page_url = `../../api/admin/calendar-exam/lich-thi/${this.currentEntries}?page=${this.pagination.current_page}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.exams = res.data;
                    this.pagination = res.meta;
                })
                .catch(err => console.log(err));
        },
        fetchCourses(page_url) {
            let vm = this;
            page_url = '../../api/admin/edu-course/khoa-hoc/course';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.courses = res.data;
                })
                .catch(err => console.log(err));
        },
        fetchFaculties(page_url) {
            let vm = this;
            page_url = '../../api/admin/edu-faculty/khoa/faculty';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.faculties = res.data;
                })
                .catch(err => console.log(err));
        },
        fetchMajors(page_url) {
            let vm = this;
            page_url = '../../api/admin/edu-major/chuyen-nganh/major';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data;
                })
                .catch(err => console.log(err));
        },
        fetchSubjects(page_url) {
            let vm = this;
            page_url = '../../api/admin/manage/mon-hoc/subject';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data;
                })
                .catch(err => console.log(err));
        },
        fetchSchedules(page_url) {
            let vm = this;
            page_url = '../../api/admin/calendar-schedule/lich-bieu/schedule';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.schedules = res.data;
                })
                .catch(err => console.log(err));
        },
        search(page_url) {
            let vm = this;
            page_url = `../../api/admin/calendar-exam/lich-thi/search/${this.query}/${this.currentEntries}?page=${this.pagination.current_page}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.exams = res.data;
                    this.pagination = res.meta;
                })
                .catch(err => console.log(err));
        },
        create() {
            this.editMode = false;
            this.form.reset();
            this.form.clear();
            $('#ExamModal').modal('show');
        },
        store() {
            this.form.busy = true;
            this.form.post('../../api/admin/calendar-exam/lich-thi')
                .then(res => {
                    this.fetchExams();
                    $('#ExamModal').modal('hide');
                    if (this.form.successful) {
                        this.$snotify.success('Thêm mới thành công!');
                    } else {
                        this.$snotify.error('Không thể thêm Khoa', 'Lỗi');
                    }
                })
                .catch(err => console.log(err));
        },
        show(exam) {
        	this.editMode = true;
        	this.form.reset();
        	this.form.clear();
        	this.form.fill(exam);
        	$('#ExamModal').modal('show');
        },
        update() {
        	this.form.put(`../../api/admin/calendar-exam/lich-thi/${this.form.calendar_exam_id}`)
        	.then(res => {
        		this.fetchExams();
        		$('#ExamModal').modal('hide');
        		if(this.form.successful){
        			this.$snotify.success('Cập nhật Khoa thành công!');
        		}else{
        			this.$snotify.error('Không thể chỉnh sửa');
        		}
        	})
        	.catch(err => console.log(err));
        },
        destroy(calendar_exam_id) {
        	this.$snotify.clear();
        	this.$snotify.confirm('Xác nhận xóa', {
        		timeout: 5000,
        		showProgressBar: true,
        		closeOnClick: false,
        		pauseOnHover: true,
        		buttons: [{
        			text: 'Xóa',
        			action: toast =>{
        				this.$snotify.remove(toast.id);
        				axios.delete(`../../api/admin/calendar-exam/lich-thi/${calendar_exam_id}`)
        				.then(res => {
        					this.$snotify.success('Đã xóa!');
        					this.fetchExams();
        				})
        				.catch(err => console.log(err));
        			},
        			bold: false
        		},{
        			text: 'Đóng',
        			action: toast => {
        				this.$snotify.remove(toast.id);
        			},
        			bold: true
        		}]
        	});
        },
        detail(exam, page_url) {
        	let vm = this;
        	page_url = `../../api/admin/calendar-exam/lich-thi/detail/${exam.calendar_exam_id}`;
        	fetch(page_url)
        	.then(res => res.json())
        	.then(res => {
        		this.details = res.data;
        		$('#DetailModal').modal('show');
        	})
        	.catch(err => console.log(err));
        },
        reload(){
        	this.fetchExams();
        	this.query='';
        },
    }
};
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
