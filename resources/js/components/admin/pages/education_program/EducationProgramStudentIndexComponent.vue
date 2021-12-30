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
                <li class="breadcrumb-item active" aria-current="page">
                    Chương trình đào tạo
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6">
                            <h3 class="card-title">Chương trình đào tạo</h3>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" v-model="value">
                                <option value="" disabled selected>
                                    Xem CTĐT của khóa học khác
                                </option>
                                <option
                                    v-for="course in courses"
                                    :key="course.course_id"
                                    :value="course.course_id"
                                >
                                    {{ course.course_code }} -
                                    {{ course.course_name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                        >
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="w-5" scope="col" rowspan="2">
                                        STT
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Mã môn học
                                    </th>
                                    <th
                                        class="text-center w-15"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Tên môn học
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Số tín chỉ
                                    </th>
                                    <th
                                        class="text-center"
                                        scope="col"
                                        colspan="2"
                                    >
                                        Số tiết (giờ)
                                    </th>
                                    <th
                                        class="text-center"
                                        scope="col"
                                        colspan="3"
                                    >
                                        Trọng số (%)
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Bắt buộc
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Khoa/Bộ môn
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Học kỳ
                                    </th>
                                    <th
                                        class="text-center w-10"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Ghi chú
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center w-5" scope="col">
                                        Lý thuyết
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Thực hành
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Bài tập
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Kiểm tra
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        Cuối kỳ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-show="programs.length"
                                    v-for="(edu, index) in programs"
                                    :key="edu.subject_id"
                                >
                                    <td class="td-table">{{ (index += 1) }}</td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_code }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_credit }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_theory_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_practice_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_exercise }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_exam }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.subject_score_final }}
                                    </td>
                                    <td class="text-center td-table">
                                        <p v-if="edu.subject_type == 0">x</p>
                                        <p v-else></p>
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.faculty_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ edu.program_detail_semester }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ nameMajor(edu) }}
                                    </td>
                                </tr>
                                <tr v-show="!programs.length">
                                    <td colspan="13">
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
            value: "",
            programs: [],
            majors: [],
            courses: [],
            course_id: "",
            faculty_id: "",
            lecturer_id: this.$teacherId
        };
    },
    mounted() {
        this.fetchPrograms();
        this.fetchMajors();
        this.fetchCourse();
    },
    watch: {
        value(course) {
            if (course != this.course_id) {
                this.value = course;
                this.filter();
            } else {
                this.value = course;
                this.fetchPrograms();
            }
        }
    },
    methods: {
        fetchPrograms(teacher, page_url) {
            teacher = this.lecturer_id;
            let vm = this;
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/${teacher}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data;
                    this.course_id = this.programs[0].course_id;
                    this.faculty_id = this.programs[0].faculty_id;
                })
                .catch(err => console.log(err));
        },
        fetchCourse(page_url) {
            let vm = this;
            page_url = `../../api/admin/edu-course/khoa-hoc/course`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.courses = res.data;
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
        nameMajor(edu) {
            if (edu.program_detail_note != null) {
                const major = this.majors.find(
                    mjr => mjr.major_code === edu.program_detail_note
                );
                return major.major_name;
            } else {
                return "";
            }
        },
        filter(page_url) {
            let vm = this;
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/filter/${this.value}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data;
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style></style>
