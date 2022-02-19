<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">
                        Dashboard
                    </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'classstudentindex' }">
                        Danh sách lớp học
                    </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link
                        tag="a"
                        :to="{
                            name: 'classstudentdetail',
                            params: { idClass: class_id }
                        }"
                    >
                        Danh sách sinh viên
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem kế hoạch học tập
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <router-link
            class="btn btn-primary btn-lg mb-3 btn-3d"
            tag="button"
            :to="{
                name: 'classstudentdetail',
                params: { idClass: class_id }
            }"
        >
            <li class="fa fa-arrow-left"></li>
            Quay lại
        </router-link>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h2 class="card-title text-center mb-2">
                                <b>
                                    DANH SÁCH KẾ HOẠCH HỌC TẬP ĐÃ ĐĂNG KÝ
                                </b>
                            </h2>
                            <div class="row">
                                <div class="col-md-6">
                                    Mã SV:
                                    <b>
                                        {{ student_code }}
                                    </b>
                                </div>
                                <div class="col-md-6">
                                    Họ tên:
                                    <b>
                                        {{ student_fullname }}
                                    </b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Lớp:
                                    <b> {{ course_code }}-{{ class_name }} </b>
                                </div>
                                <div class="col-md-6">
                                    Học kỳ (Năm học):
                                    <b> HK{{ semester }} ({{ year_start }} - {{ year_end }}) </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-center text-white w-5">
                                        STT
                                    </th>
                                    <th class="text-center text-white w-10">
                                        Mã môn học
                                    </th>
                                    <th class="text-center text-white w-55">
                                        Tên môn học
                                    </th>
                                    <th class="text-center w-5">
                                        Số TC
                                    </th>
                                    <th class="text-center w-25">
                                        Ngày đăng ký
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="subjects.length" v-for="(subject, index) in subjects" :key="subject.subject_id">
                                    <td class="text-center">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center">
                                        {{ subject.subject_code }}
                                    </td>
                                    <td>
                                        {{ subject.subject_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ subject.subject_credit }}
                                    </td>
                                    <td class="text-center">
                                        {{ subject.register_plan_date | formatFullTime }}
                                    </td>
                                </tr>
                                <tr v-show="!subjects.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            subjects: [],
            semesters: [],
            student_code: '',
            student_fullname: '',
            class_name: '',
            course_code: '',
            year_start: '',
            year_end: '',
            register_date: '',
            semester: '',
            class_id: this.$route.params.idClass,
            student_id: this.$route.params.idStudent
        }
    },
    mounted() {
        this.fetchStudentClass()
    },
    watch: {
        $route(to, from) {
            this.class_id = to.params.idClass
            this.student_id = to.params.idStudent
        }
    },
    methods: {
        fetchStudentClass(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.student_code = res.data[0].student_code
                    this.student_fullname = res.data[0].student_fullname
                    this.class_name = res.data[0].class_name
                    this.course_code = res.data[0].course_code
                    this.year_start = res.data[0].register_plan_yearstart
                    this.year_end = res.data[0].register_plan_yearend
                    this.semester = res.data[0].register_plan_semester
                    this.register_date = res.data[0].register_plan_date
                    this.subjects = res.data
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
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
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
.btn-import {
    background-color: green;
    color: white;
}
.btn-import:hover {
    background-color: forestgreen;
    color: white;
}
.avatar-xxl {
    height: 100%;
    width: 8rem;
}
.fa-times {
    color: red;
    font-size: 20px;
}
.fa-check {
    color: green;
    font-size: 20px;
}
.background-result {
    background-color: lightgoldenrodyellow;
}
strong {
    word-break: break-word;
}
</style>
