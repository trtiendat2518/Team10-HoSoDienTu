<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Danh sách Chương trình đào tạo
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <router-link tag="button" class="btn btn-info btn-lg mb-3" :to="{ name: 'educationprogramcreate' }">
            <li class="fa fa-plus"></li>
            Tạo mới
        </router-link>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h3 class="card-title">
                                Danh sách Chương trình đào tạo
                            </h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <button class="active btn btn-danger mt-3 ml-3 btn-lg fa fa-trash" @click="destroyall()" :disabled="!selected.length"></button>
                        </div>
                        <div class="col-md-9"></div>
                        <div class="col-md-2">
                            <div class="between:flex bottom:margin-3 ml-2">
                                <div class="center:flex-items">
                                    <span class="right:marign-1">Hiển thị</span>
                                    <select class="select form-control-styling" v-model="currentEntries">
                                        <option v-for="entry in showEntries" :key="entry" :value="entry">
                                            {{ entry }}
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
                                    <th class="w-5">
                                        <input type="checkbox" class="form-control" :disabled="empty()" @click="select()" v-model="selectAll"/>
                                    </th>
                                    <th class="text-white w-20">Mã CTĐT</th>
                                    <th class="text-white w-40">
                                        Tên chương trình đào tạo
                                    </th>
                                    <th class="text-white w-10 text-center">
                                        Tổng năm học
                                    </th>
                                    <th class="text-white w-10 text-center">
                                        Tổng tín chỉ
                                    </th>
                                    <th class="text-white w-5 text-center">
                                        Trạng thái
                                    </th>
                                    <th class="w-5"></th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="programs.length" v-for="program in programs" :key="program.education_program_id">
                                    <td>
                                        <center>
                                            <input type="checkbox" :value="program.education_program_id" v-model="selected"/>
                                        </center>
                                    </td>
                                    <td>
                                        <router-link tag="a" :to="{ name: 'educationprogramdetail', params: {idProgram: program.education_program_id} }">{{ program.education_program_code }}</router-link>
                                    </td>
                                    <td>{{ nameProgram(program) }}</td>
                                    <td class="text-center">
                                        {{ program.education_program_year }}
                                    </td>
                                    <td class="text-center">
                                        {{ program.education_program_credit }}
                                    </td>
                                    <td class="td-styling text-center">
                                        <div v-if="program.education_program_status == 0">
                                            <button class="fa fa-eye btn-eye" @click="change(program.education_program_id)"></button>
                                        </div>
                                        <div v-else>
                                            <button  class="fa fa-eye-slash btn-eye-slash" @click="change(program.education_program_id)"></button>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <router-link class="active btn btn-outline-success btn-lg fa fa-pencil-square-o" tag="button" :to="{ name: 'educationprogramupdate', params: {idProgram: program.education_program_id} }"></router-link>
                                    </td>
                                    <td>
                                        <button class="active btn btn-danger btn-lg fa fa-trash" @click="destroy(program.education_program_id)"></button>
                                    </td>
                                </tr>
                                <tr v-show="!programs.length">
                                    <td colspan="8">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPrograms()"></pagination>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</template>

<script>
    import "vue-snotify/styles/material.css";
    export default {
        data() {
            return {
                faculties: [],
                majors: [],
                courses: [],
                lecturers: [],
                lecturer_id: this.$facultyId,
                lecturer_faculty: "",
                programs: [],
                education_program_id: "",
                education_program_faculty: "",
                pagination: {
                    current_page: 1
                },
                currentEntries: 5,
                showEntries: [5, 10, 25, 50],
                editMode: false,
                selected: [],
                selectAll: false,
                details: [],
            };
        },
        watch: {
            currentEntries(number) {
                if (number === 5) {
                    this.pagination = 1;
                    this.fetchPrograms();
                } else {
                    this.pagination = 1;
                    this.fetchPrograms();
                }
            },
        },
        mounted() {
            this.fetchFaculties();
            this.fetchMajors();
            this.fetchCourses();
            this.fetchPrograms();
            this.fetchLecturers();
        },
        methods: {
            empty() {
                return this.programs.length < 1;
            },
            fetchFaculties(page_url) {
                let vm = this;
                page_url = "../../api/admin/edu-faculty/khoa/faculty";
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.faculties = res.data;
                })
                .catch(err => console.log(err));
            },
            fetchMajors(page_url) {
                let vm = this;
                page_url = "../../api/admin/edu-major/chuyen-nganh/major";
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data;
                })
                .catch(err => console.log(err));
            },
            fetchCourses(page_url) {
                let vm = this;
                page_url = "../../api/admin/edu-course/khoa-hoc/course";
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.courses = res.data;
                })
                .catch(err => console.log(err));
            },
            fetchLecturers(page_url) {
                let vm = this;
                page_url = "../../api/admin/user-gv/giang-vien/lecturer";
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.lecturers = res.data;
                    this.lecturers.forEach(el => {
                        if (el.lecturer_code === this.lecturer_id) {
                            this.lecturer_faculty = el.lecturer_faculty;
                        }
                    });
                })
                .catch(err => console.log(err));
            },
            fetchPrograms(page_url) {
                let vm = this;
                page_url = `../../api/admin/program/chuong-trinh-dao-tao/showdata/${this.lecturer_id}/${this.currentEntries}?page=${this.pagination.current_page}`;
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data;
                    this.pagination = res.meta;
                })
                .catch(err => console.log(err));
            },
            nameProgram(program) {
                const faculty = this.faculties.find(
                    fct => fct.faculty_code === program.education_program_faculty
                    );
                const course = this.courses.find(
                    crs => crs.course_code === program.education_program_course
                    );

                return course.course_code + " - " + faculty.faculty_name;
            },
            change(education_program_id) {
                axios
                .patch(
                    `../../api/admin/program/chuong-trinh-dao-tao/change/${education_program_id}`
                    )
                .then(res => {
                    this.fetchPrograms();
                    this.$snotify.warning("Đã thay đổi trạng thái");
                })
                .catch(err => console.log(err));
            },
            destroy(education_program_id) {
                this.$snotify.clear();
                this.$snotify.confirm("Xác nhận xóa", {
                    timeout: 5000,
                    showProgressBar: true,
                    closeOnClick: false,
                    pauseOnHover: true,
                    buttons: [
                    {
                        text: "Xóa",
                        action: toast => {
                            this.$snotify.remove(toast.id);
                            axios
                            .delete(
                                `../../api/admin/program/chuong-trinh-dao-tao/${education_program_id}`
                                )
                            .then(res => {
                                this.$snotify.success("Đã xóa!");
                                this.fetchPrograms();
                            })
                            .catch(err => console.log(err));
                        },
                        bold: false
                    },
                    {
                        text: "Đóng",
                        action: toast => {
                            this.$snotify.remove(toast.id);
                        },
                        bold: true
                    }
                    ]
                });
            },
            destroyall() {
                this.$snotify.clear();
                this.$snotify.confirm("Xác nhận xóa", {
                    timeout: 5000,
                    showProgressBar: true,
                    closeOnClick: false,
                    pauseOnHover: true,
                    buttons: [
                    {
                        text: "Xóa",
                        action: toast => {
                            this.$snotify.remove(toast.id);
                            axios
                            .post(
                                "../../api/admin/program/chuong-trinh-dao-tao/destroyall",
                                { educationProgram: this.selected }
                                )
                            .then(res => {
                                this.$snotify.success("Đã xóa!");
                                this.fetchPrograms();
                            })
                            .catch(err => console.log(err));
                        },
                        bold: false
                    },
                    {
                        text: "Đóng",
                        action: toast => {
                            this.$snotify.remove(toast.id);
                        },
                        bold: true
                    }
                    ]
                });
            },
            select() {
                this.selected = [];
                if (!this.selectAll) {
                    for (let i in this.programs) {
                        this.selected.push(this.programs[i].education_program_id);
                    }
                }
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
        background-color: #1753fc;
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
    .styling-strong {
        word-wrap: break-word;
        white-space: pre-line;
    }
</style>
