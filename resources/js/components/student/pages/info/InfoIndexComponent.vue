<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thông tin cá nhân</p>
        </div>

        <div class="grid">
            <div class="widget-box" v-for="student in students" :key="student.student_id">
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="widget-box-title">Thông tin cá nhân</h4>
                    </div>
                    <div class="col-md-3 float-right">
                        <router-link tag="a" class="btn btn-primary" :to="{ name: 'infostudentupdate' }">
                            Cập nhật thông tin
                        </router-link>
                    </div>
                </div>
                <div class="widget-box-content">
                    <form class="form">
                        <div class="row">
                            <div class="col-md-4 center-pic">
                                <img :src="`../public/avatar/student/${student.student_avatar}`" class="avatar-styling" alt="profile" />
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-item">
                                            <div class="form-input small active">
                                                <label for="profile-name">Họ và tên</label>
                                                <input type="text" :value="student.student_fullname" class="not-allow" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-item">
                                            <div class="form-input small active">
                                                <label for="profile-name">Mã số sinh viên</label>
                                                <input type="text" :value="student.student_code" class="not-allow" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-item">
                                            <div class="form-input small active">
                                                <label for="profile-name">Email sinh viên</label>
                                                <input type="text" :value="student.student_email" class="not-allow" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Ngày sinh</label>
                                        <input type="text" class="not-allow" :value="student.student_birthday | formatDate" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Số điện thoại</label>
                                        <input type="text" class="not-allow" :value="student.student_phone" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Giới tính</label>
                                        <div v-if="student.student_gender == 0">
                                            <input type="text" class="not-allow" value="Nam" disabled />
                                        </div>
                                        <div v-else-if="student.student_gender == 1">
                                            <input type="text" class="not-allow" value="Nữ" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Dân tộc</label>
                                        <input type="text" class="not-allow" :value="student.student_ethnic" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Tôn giáo</label>
                                        <input type="text" class="not-allow" :value="student.student_religion" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Quốc gia</label>
                                        <input type="text" class="not-allow" :value="student.student_country" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Nơi sinh</label>
                                        <input type="text" class="not-allow" :value="student.student_birth_place" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">CMND/CCCD</label>
                                        <input type="text" class="not-allow" :value="student.student_identify_card" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-item">
                                    <div class="form-input small active">
                                        <label for="profile-name">Email cá nhân</label>
                                        <input type="text" class="not-allow" :value="student.student_other_email" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-item mt-3 ">
                            <div class="form-input small active">
                                <label for="profile-name">Địa chỉ</label>
                                <input type="text" class="not-allow" :value="student.student_address" disabled />
                            </div>
                        </div>
                    </form>
                </div>

                <h4 class="widget-box-title mt-5">Thông tin lớp học</h4>
                <div class="widget-box-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-item">
                                <div class="form-input small active">
                                    <label for="profile-name">Khoá học</label>
                                    <input type="text" class="not-allow" :value="student.course_name" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-item">
                                <div class="form-input small active">
                                    <label for="profile-name">Khoa</label>
                                    <input type="text" class="not-allow" :value="student.faculty_name" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-item">
                                <div class="form-input small active">
                                    <label for="profile-name">Chuyên ngành</label>
                                    <input type="text" class="not-allow" :value="student.major_name" disabled />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-item">
                                <div class="form-input small active">
                                    <label for="profile-name">Lớp học</label>
                                    <input type="text" class="not-allow" :value="student.course_code + '-' + student.class_name" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-item">
                                <div class="form-input small active">
                                    <label for="profile-name">Trạng thái học tập</label>
                                    <div v-if="student.student_role == 0">
                                        <input type="text" class="not-allow" value="Còn đang học tại trường" disabled />
                                    </div>
                                    <div v-else-if="student.student_role == 1">
                                        <input type="text" class="not-allow" value="Đã ra trường" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            students: []
        }
    },
    mounted() {
        this.fetchInfo()
    },
    methods: {
        fetchInfo(page_url) {
            page_url = `../../api/admin/user-sv/sinh-vien/detail/${this.student_id}`
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

<style scoped>
.avatar-styling {
    width: 40%;
}
.center-pic {
    text-align: center;
}
.widget-box-title {
    font-size: 20px !important;
    color: darkred !important;
}
.not-allow {
    cursor: not-allowed;
}
</style>
