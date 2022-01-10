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
                    <router-link
                        tag="a"
                        :to="{
                            name: 'formteacherclassindex',
                            params: { idFTClass: class_id }
                        }"
                    >
                        Lớp sinh viên
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Danh sách sinh viên
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <router-link
            class="btn btn-primary btn-lg mb-3 btn-3d"
            tag="button"
            :to="{
                name: 'formteacherclassindex',
                params: { idFTClass: class_id }
            }"
        >
            <li class="fa fa-arrow-left"></li>
            Quay lại
        </router-link>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6">
                            <h2 class="card-title">
                                <div
                                    v-if="course_code == '' && class_name == ''"
                                >
                                    <b>Danh sách sinh viên</b>
                                </div>
                                <div v-else>
                                    <b>
                                        Danh sách sinh viên lớp
                                        {{ course_code }}-{{ class_name }}
                                    </b>
                                </div>
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <input
                                type="text"
                                class="form-control mt-2"
                                v-model="query"
                                placeholder="Tìm kiếm..."
                            />
                        </div>
                    </div>

                    <div class="ml-2 mt-3">
                        <div v-if="lecturer_fullname == ''">
                            <h4>Chủ nhiệm sinh viên: Chưa có</h4>
                        </div>
                        <div v-else>
                            <h4>
                                Chủ nhiệm sinh viên:
                                <i>{{ lecturer_fullname }}</i>
                            </h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                        >
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-white w-20">
                                        Mã số sinh viên
                                    </th>
                                    <th class="text-white w-30">Họ và tên</th>
                                    <th class="text-white w-30">Email</th>
                                    <th class="w-10">Điểm</th>
                                    <th class="w-10">Kế hoạch học tập</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-show="students.length"
                                    v-for="stu in students"
                                    :key="stu.student_id"
                                >
                                    <td @click="detail(stu)">
                                        <a href="javascript:void(0)">
                                            {{ stu.student_code }}
                                        </a>
                                    </td>
                                    <td>{{ stu.student_fullname }}</td>
                                    <td>{{ stu.student_email }}</td>
                                    <td>
                                        <router-link
                                            class="btn-3d btn btn-success btn-lg fa fa-book"
                                            tag="button"
                                            :to="{
                                                name: 'classstudentscore',
                                                params: {
                                                    idClass: class_id,
                                                    idStudent: stu.student_id
                                                }
                                            }"
                                        ></router-link>
                                    </td>
                                    <td class="text-center">
                                        <router-link
                                            class="btn-3d btn btn-primary btn-lg fa fa-calendar"
                                            tag="button"
                                            :to="{
                                                name: 'classstudentplan',
                                                params: {
                                                    idClass: class_id,
                                                    idStudent: stu.student_id
                                                }
                                            }"
                                        ></router-link>
                                    </td>
                                </tr>
                                <tr v-show="!students.length">
                                    <td colspan="8">
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
                            Chi tiết tài khoản
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
                    <div
                        class="modal-body"
                        v-show="details.length"
                        v-for="info in details"
                        :key="info.student_id"
                    >
                        <center>
                            <img
                                :src="
                                    `../public/avatar/student/${info.student_avatar}`
                                "
                                class="avatar-xxl"
                                alt="profile"
                            />
                        </center>
                        <table
                            class="table row table-borderless w-100 m-0 border"
                        >
                            <tbody class="col-lg-6 p-0">
                                <tr>
                                    <td class="h3-strong td-borderight">
                                        <h3>
                                            <strong>
                                                Thông tin chi tiết Sinh viên
                                            </strong>
                                        </h3>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Họ và tên:
                                        <strong>
                                            {{ info.student_fullname }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Dân tộc:
                                        <strong
                                            v-if="info.student_ethnic == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_ethnic }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Tôn giáo:
                                        <strong
                                            v-if="info.student_religion == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_religion }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Giới tính:
                                        <strong
                                            v-if="info.student_gender == null"
                                        >
                                            -
                                        </strong>
                                        <strong
                                            v-else-if="info.student_gender == 0"
                                        >
                                            Nam
                                        </strong>
                                        <strong v-else> Nữ</strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Ngày sinh:
                                        <strong
                                            v-if="info.student_birthday == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{
                                                info.student_birthday
                                                    | formatDate
                                            }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Nơi sinh:
                                        <strong
                                            v-if="
                                                info.student_birth_place == null
                                            "
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_birth_place }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Quốc gia:
                                        <strong
                                            v-if="info.student_country == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_country }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        CMND/CCCD:
                                        <strong
                                            v-if="
                                                info.student_identify_card ==
                                                    null
                                            "
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_identify_card }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="td-borderight">
                                    <td>
                                        Địa chỉ:
                                        <strong
                                            v-if="info.student_address == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_address }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="col-lg-6 p-0">
                                <tr>
                                    <td class="h3-strong" colspan="2">
                                        <h3><strong>Thông tin Khoa</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Khóa học:
                                        <strong
                                            v-if="info.student_course == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.course_name }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Khoa:
                                        <strong
                                            v-if="info.student_faculty == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.faculty_name }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Chuyên ngành:
                                        <strong
                                            v-if="info.student_major == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.major_name }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lớp học:
                                        <strong
                                            v-if="info.student_class == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.course_code }}-{{
                                                info.class_name
                                            }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tình trạng học:
                                        <strong v-if="info.student_role == 1">
                                            Đã ra trường
                                        </strong>
                                        <strong
                                            v-else-if="info.student_role == 0"
                                        >
                                            Còn đang học
                                        </strong>
                                    </td>
                                </tr>

                                <br />
                                <tr>
                                    <td class="h3-strong">
                                        <h3>
                                            <strong>Thông tin liên lạc</strong>
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Số điện thoại:
                                        <strong
                                            v-if="info.student_phone == null"
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_phone }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Email trường:
                                        <strong>
                                            {{ info.student_email }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Email cá nhân:
                                        <strong
                                            v-if="
                                                info.student_other_email == null
                                            "
                                        >
                                            -
                                        </strong>
                                        <strong v-else>
                                            {{ info.student_other_email }}
                                        </strong>
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
            students: [],
            details: [],
            query: "",
            course_code: "",
            class_name: "",
            lecturer_fullname: "",
            class_id: this.$route.params.idFTClass
        };
    },
    mounted() {
        this.fetchStudentClass();
    },
    watch: {
        $route(to, from) {
            this.class_id = to.params.idFTClass;
        },
        query(keyword) {
            if (keyword === "") {
                this.fetchStudentClass();
            } else {
                this.search();
            }
        }
    },
    methods: {
        fetchStudentClass(page_url) {
            let vm = this;
            page_url = `../../api/admin/class-sv/lop/student-class/${this.class_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data;
                    if (res.data.length > 0) {
                        this.course_code = res.data[0].course_code;
                        this.class_name = res.data[0].class_name;
                        this.lecturer_fullname = res.data[0].lecturer_fullname;
                    }
                })
                .catch(err => console.log(err));
        },
        detail(stu, page_url) {
            let vm = this;
            page_url = `../../api/admin/user-sv/sinh-vien/detail/${stu.student_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.details = res.data;
                    $("#DetailModal").modal("show");
                })
                .catch(err => console.log(err));
        },
        search(page_url) {
            let vm = this;
            page_url = `../../api/admin/class-sv/lop/search-student-class/${this.class_id}/${this.query}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data;
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style scoped>
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
strong {
    word-break: break-word;
}
</style>
