<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Cập nhật thông tin</p>
        </div>

        <div class="grid">
            <div class="widget-box" v-for="student in students" :key="student.student_id">
                <h4 class="widget-box-title">Thông tin cũ</h4>
                <div class="widget-box-content">
                    <form class="form">
                        <div class="form-item">
                            <div class="form-input small active">
                                <label for="profile-name">Số điện thoại</label>
                                <input type="text" class="half not-allow" :value="student.student_phone" disabled />
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name">Email cá nhân</label>
                                <input type="text" class="half not-allow" :value="student.student_other_email" disabled />
                            </div>
                        </div>
                    </form>
                </div>

                <h4 class="widget-box-title mt-5">Cập nhật thông tin mới</h4>
                <div class="widget-box-content">
                    <form class="form">
                        <div class="form-item">
                            <div class="form-input small active">
                                <label for="profile-name">Số điện thoại</label>
                                <input
                                    type="text"
                                    class="half"
                                    name="student_phone"
                                    placeholder="Nhập số điện thoại"
                                    v-model="form.student_phone"
                                    :class="{ 'is-invalid': form.errors.has('student_phone') }"
                                />
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('student_phone')"
                                    v-html="form.errors.get('student_phone')"
                                ></div>
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name">Email cá nhân</label>
                                <input
                                    type="text"
                                    class="half"
                                    name="student_other_email"
                                    placeholder="Nhập email cá nhân"
                                    v-model="form.student_other_email"
                                    :class="{ 'is-invalid': form.errors.has('student_other_email') }"
                                />
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('student_other_email')"
                                    v-html="form.errors.get('student_other_email')"
                                ></div>
                            </div>
                        </div>
                    </form>
                    <div class="styling-center">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-primary styling mt-3" @click="update()">Cập nhật</button>
                            </div>
                            <div class="col-md-6">
                                <router-link tag="button" class="btn btn-warning styling mt-3" :to="{ name: 'infostudentindex' }">
                                    Quay lại
                                </router-link>
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
            students: [],
            form: new Form({
                student_other_email: '',
                student_phone: ''
            })
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
        },
        update() {
            this.form
                .post(`../../api/admin/user-sv/sinh-vien/cap-nhat-thong-tin/${this.student_id}`)
                .then(res => {
                    this.fetchInfo()
                    this.$swal({
                        title: 'Cập nhật thành công!',
                        icon: 'success',
                        confirmButtonText: 'OK!',
                        timer: 3500
                    })
                    this.form.reset()
                    this.form.clear()
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.widget-box-title {
    font-size: 20px !important;
    color: darkred !important;
}
.not-allow {
    cursor: not-allowed;
}
.half {
    width: 50%;
}
.form-input {
    text-align: center;
}
.styling-center {
    text-align: center;
}
</style>
