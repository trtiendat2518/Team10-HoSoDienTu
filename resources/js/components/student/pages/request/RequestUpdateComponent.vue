<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Gửi yêu cầu cho chủ nhiệm sinh viên</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="widget-box-title">Cập nhật yêu cầu</h4>
                    </div>
                    <div class="col-md-4">
                        <router-link tag="button" class="btn btn-info" :to="{ name: 'requestindex' }">
                            Xem các yêu cầu đã gửi
                        </router-link>
                    </div>
                </div>
                <div class="widget-box-content">
                    <form class="form">
                        <div class="form-item">
                            <div class="form-input small active">
                                <label for="profile-name">Tiêu đề <span>(*)</span></label>
                                <input type="text" class="half" name="request_title" v-model="request_title" />
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name">Nội dung <span>(*)</span></label>
                                <textarea
                                    name="request_content"
                                    id="request_content"
                                    v-model="request_content"
                                    v-html="request_content"
                                ></textarea>
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name" class="mb-5">Tệp đính kèm (tệp &#8804; 5MB)</label>
                                <input type="file" class="half" name="request_file" ref="file" @change="onFileChange" />
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <input type="text" class="half" v-model="request_file" disabled />
                            </div>
                        </div>
                    </form>
                    <div class="styling-center">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary styling mt-3" @click="update()">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            request_id: this.$route.params.idReq,
            student_id: this.$studentId,
            request_title: '',
            request_content: '',
            request_file: ''
        }
    },
    mounted() {
        this.show()
    },
    watch: {
        $route(to, from) {
            this.request_id = to.params.idReq
        }
    },
    methods: {
        onFileChange(e) {
            this.request_file = e.target.files[0]
        },
        show(page_url) {
            let vm = this
            page_url = `../../api/student/request-to-ft/gui-yeu-cau/${this.request_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.request_title = res.data[0].request_title
                    this.request_content = res.data[0].request_content
                    this.request_file = res.data[0].request_file
                })
                .catch(err => console.log(err))
        },
        update() {
            if (this.request_file == '') {
                let formData = new FormData()
                formData.append('student_id', this.student_id)
                formData.append('request_title', this.request_title)
                formData.append('request_content', this.request_content)
                axios
                    .post(`../../api/student/request-to-ft/gui-yeu-cau/updatedata/${this.request_id}`, formData)
                    .then(res => {
                        this.show()
                        this.$swal({
                            title: 'Cập nhật yêu cầu thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                    })
                    .catch(err => {
                        const null_content = err.response.data.errors?.request_content?.length
                        const null_title = err.response.data.errors?.request_title?.length

                        if (null_title > 0 && null_content > 0) {
                            this.$swal({
                                title: 'Vui lòng điền đầy đủ trường thông tin',
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        } else if (null_title > 0) {
                            this.$swal({
                                title: err.response.data.errors.request_title[0],
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        } else if (null_content > 0) {
                            this.$swal({
                                title: err.response.data.errors.request_content[0],
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        }
                    })
            } else {
                let formData = new FormData()
                formData.append('student_id', this.student_id)
                formData.append('request_title', this.request_title)
                formData.append('request_content', this.request_content)
                let file = this.$refs.file.files[0]
                formData.append('file', file)
                axios
                    .post(`../../api/student/request-to-ft/gui-yeu-cau/updatefile/${this.request_id}`, formData)
                    .then(res => {
                        this.show()
                        this.$swal({
                            title: 'Cập nhật yêu cầu thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                    })
                    .catch(err => {
                        const null_content = err.response.data.errors?.request_content?.length
                        const null_title = err.response.data.errors?.request_title?.length
                        const null_file = err.response.data.errors?.file?.length

                        if (null_title > 0 && null_content > 0) {
                            this.$swal({
                                title: 'Vui lòng điền đầy đủ trường thông tin',
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        } else if (null_title > 0) {
                            this.$swal({
                                title: err.response.data.errors.request_title[0],
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        } else if (null_content > 0) {
                            this.$swal({
                                title: err.response.data.errors.request_content[0],
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        } else if (null_file > 0) {
                            this.$swal({
                                title: err.response.data.errors.file[0],
                                icon: 'error',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        }
                    })
            }
        }
    }
}
</script>

<style scoped></style>
