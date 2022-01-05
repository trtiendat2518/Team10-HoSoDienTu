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

        <router-link
            tag="button"
            class="btn btn-lg btn-primary mb-3 btn-3d"
            :to="{ name: 'educationprogramstudentindex' }"
        >
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
        </router-link>

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
                                        class="text-center w-15"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Mã môn học
                                    </th>
                                    <th
                                        class="text-center w-30"
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
                                        Số TC
                                    </th>
                                    <th
                                        class="text-center"
                                        scope="col"
                                        colspan="2"
                                    >
                                        Số tiết (giờ)
                                    </th>
                                    <th
                                        class="text-center w-5"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Bắt buộc
                                    </th>
                                    <th
                                        class="text-center w-15"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Khoa/Bộ môn
                                    </th>
                                    <th
                                        class="text-center w-15"
                                        scope="col"
                                        rowspan="2"
                                    >
                                        Ghi chú
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center w-5" scope="col">
                                        LT
                                    </th>
                                    <th class="text-center w-5" scope="col">
                                        TH
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="i in semesters" :key="i">
                                <tr>
                                    <td colspan="9">
                                        <b> Học kỳ {{ i }} </b>
                                    </td>
                                </tr>
                                <tr
                                    v-for="(value, index) in value_programs[i]"
                                    :key="value.subject_id"
                                >
                                    <td class="td-table">
                                        {{ (index += 1) }}
                                    </td>
                                    <td class="text-center td-table">
                                        <a
                                            href="javscript:void(0)"
                                            @click="detail(value.subject_id)"
                                        >
                                            {{ value.subject_code }}
                                        </a>
                                    </td>
                                    <td class="td-table">
                                        {{ value.subject_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_credit }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_theory_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.subject_practice_period }}
                                    </td>
                                    <td class="text-center td-table">
                                        <p v-if="value.subject_type == 0">
                                            x
                                        </p>
                                        <p v-else></p>
                                    </td>
                                    <td class="text-center td-table">
                                        {{ value.faculty_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ nameMajor(value) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        colspan="3"
                                        class="text-right text-require"
                                    >
                                        Tổng học phần Bắt buộc:
                                    </td>
                                    <td class="text-center text-require">
                                        {{ sum_credit_require(i) }}
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <b>Tổng học phần Tự chọn:</b>
                                    </td>
                                    <td class="text-center">
                                        <b>{{ sum_credit_option(i) }}</b>
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!semesters.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
                        <h5
                            class="modal-title styling-font-modal-header"
                            id="DetailModalTitle"
                        >
                            Chi tiết môn học
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                            v-for="detail in details"
                            :key="detail.subject_id"
                        >
                            <thead class="detail-background text-white">
                                <tr>
                                    <th class="text-center">Tên thành phần</th>
                                    <th class="text-center">Trọng số</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        Điểm bài tập
                                    </td>
                                    <td class="text-center">
                                        {{ detail.subject_score_exercise }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm kiểm tra
                                    </td>
                                    <td class="text-center">
                                        {{ detail.subject_score_exam }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        Điểm thi
                                    </td>
                                    <td class="text-center">
                                        {{ detail.subject_score_final }}%
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary btn-3d"
                            data-dismiss="modal"
                        >
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end-->
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
            semesters: [],
            value_programs: [],
            details: [],
            course_id: "",
            faculty_id: "",
            current_semester: "",
            render_data: {},
            class_id: this.$route.params.idEPStudent
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
        },
        $route(to, from) {
            this.class_id = to.params.idEPStudent;
        }
    },
    methods: {
        fetchPrograms(page_url) {
            let vm = this;
            page_url = `../../api/admin/edu-program-sv/chuong-trinh-dao-tao-sinh-vien/${this.class_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.programs = res.data;
                    if (res.data.length > 0) {
                        this.course_id = this.programs[0].course_id;
                        this.faculty_id = this.programs[0].faculty_id;

                        const semesters = this.programs.reduce(
                            (semesters, item) => {
                                const semester =
                                    semesters[item.program_detail_semester] ||
                                    [];
                                semester.push(item);
                                semesters[
                                    item.program_detail_semester
                                ] = semester;
                                return semesters;
                            },
                            {}
                        );

                        let key = Object.keys(semesters);
                        this.value_programs = semesters;
                        this.semesters = key;
                    }
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
        nameMajor(value) {
            if (value.program_detail_note != null) {
                const major = this.majors.find(
                    mjr => mjr.major_code === value.program_detail_note
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

                    const semesters = this.programs.reduce(
                        (semesters, item) => {
                            const semester =
                                semesters[item.program_detail_semester] || [];
                            semester.push(item);
                            semesters[item.program_detail_semester] = semester;
                            return semesters;
                        },
                        {}
                    );
                    let key = Object.keys(semesters);
                    //const value = Object.values(semesters);
                    this.value_programs = semesters;
                    this.semesters = key;
                })
                .catch(err => console.log(err));
        },
        detail(subject_id, page_url) {
            let vm = this;
            page_url = `../../api/admin/manage/mon-hoc/detail/${subject_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.details = res.data;
                    $("#DetailModal").modal("show");
                })
                .catch(err => console.log(err));
        },
        sum_credit_require(i) {
            let sum = 0;
            for (let j = 0; j < this.value_programs[i].length; j++) {
                if (this.value_programs[i][j].subject_type == 0) {
                    sum += parseFloat(this.value_programs[i][j].subject_credit);
                }
            }
            return sum;
        },
        sum_credit_option(i) {
            let sum = 0;
            for (let j = 0; j < this.value_programs[i].length; j++) {
                if (this.value_programs[i][j].subject_type > 0) {
                    sum += parseFloat(this.value_programs[i][j].subject_credit);
                }
            }
            return sum;
        }
    }
};
</script>

<style>
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
.styling-strong {
    word-wrap: break-word;
    white-space: pre-line;
}
.btn-3d {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
}
.detail-background {
    background-color: #2e384d;
}
.text-require {
    color: red;
    font-weight: bold;
}
</style>
