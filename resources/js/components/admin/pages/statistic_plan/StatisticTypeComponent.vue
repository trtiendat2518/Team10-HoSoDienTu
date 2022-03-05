<template>
    <div>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'statisticindex' }">Thống kê số lượng đăng ký kế hoạch sinh viên</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết thống kê</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách sinh viên</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-nowrap">
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-white w-25">MSSV</th>
                                    <th class="text-white w-30">Họ tên</th>
                                    <th class="text-white w-30">Email</th>
                                    <th class="text-white w-5">Loại ĐK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-show="students.length" v-for="stu in students" :key="stu.student_id">
                                    <td>
                                        {{ stu.student_code }}
                                    </td>
                                    <td>
                                        {{ stu.student_fullname }}
                                    </td>
                                    <td>
                                        {{ stu.student_email }}
                                    </td>
                                    <td class="td-styling">
                                        <div v-if="stu.register_plan_type == 1">Theo gợi ý chủ nhiệm (cả lớp)</div>
                                        <div v-else-if="stu.register_plan_type == 2">Theo gợi ý chủ nhiệm (cá nhân)</div>
                                        <div v-else-if="stu.register_plan_type == 3">Theo cá nhân</div>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            course_id: this.$route.params.idCourse,
            major_id: this.$route.params.idMajor,
            semester: this.$route.params.idSemester,
            students: []
        }
    },
    mounted() {
        this.fetchStudentRegistered()
    },
    watch: {
        $route(to, from) {
            this.course_id = to.params.idCourse
            this.major_id = to.params.idMajor
            this.semester = to.params.idSemester
        }
    },
    methods: {
        fetchStudentRegistered(page_url) {
            let vm = this
            page_url = `../../api/admin/register-plan/dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-xem-loai/${this.course_id}/${this.major_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.students = res.data
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
