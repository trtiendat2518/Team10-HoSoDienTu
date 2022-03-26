<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Chi tiết yêu cầu</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="widget-box-title">
                            Trạng thái yêu cầu:
                            <span v-if="request_status == 0"> Chờ xử lý</span>
                            <span class="text-green" v-else-if="request_status == 1"> Đã chấp nhận</span>
                            <span class="text-red" v-else-if="request_status == 2"> Bị từ chối</span>
                        </h4>
                    </div>
                    <div class="col-md-4">
                        <router-link tag="button" class="btn btn-info" :to="{ name: 'requestindex' }">
                            Quay lại
                        </router-link>
                    </div>
                </div>
                <div class="widget-box-content">
                    <form class="form">
                        <div class="form-item">
                            <div class="form-input small active">
                                <label for="profile-name">Tiêu đề</label>
                                <input type="text" class="half" name="request_title" v-model="request_title" disabled />
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name">Nội dung</label>
                                <textarea name="request_content" id="request_content" v-html="request_content" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-item mt-3" v-show="request_file != null">
                            <div class="form-input small active">
                                <input type="text" class="half" v-model="request_file" disabled />
                            </div>
                        </div>
                        <div class="form-item mt-3">
                            <div class="form-input small active">
                                <label for="profile-name">GVCN trả lời</label>
                                <b><span class="half text-area-span form-control" v-html="request_reply" disabled/></b>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            request_id: this.$route.params.idReq,
            student_id: this.$studentId,
            request_title: '',
            request_content: '',
            request_file: '',
            request_reply: '',
            request_status: ''
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
        show(page_url) {
            let vm = this
            page_url = `../../api/student/request-to-ft/gui-yeu-cau/${this.request_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.request_title = res.data[0].request_title
                    this.request_content = res.data[0].request_content
                    this.request_file = res.data[0].request_file
                    this.request_reply = res.data[0].request_reply
                    this.request_status = res.data[0].request_status
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.text-green {
    color: forestgreen;
}
.text-red {
    color: red;
}
.text-area-span {
    border-radius: 12px;
    height: 150px;
    color: #3e3f5e;
    margin-top: 10px;
}
</style>
