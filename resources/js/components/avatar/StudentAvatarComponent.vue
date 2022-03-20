<template>
    <div class="styling">
        <router-link tag="a" to="/thong-tin-ca-nhan-sinh-vien">
            <div class="user-short-description">
                <div class="user-avatar-content">
                    <img :src="`../public/avatar/student/${student_avatar}`" class="avatar-styling" alt="profile" />
                </div>

                <p class="user-short-description-title mt-3">
                    {{ student_fullname }}
                </p>

                <p class="user-short-description-text">
                    {{ student_email }}
                </p>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            student_avatar: '',
            student_fullname: '',
            student_email: ''
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
                    this.student_avatar = res.data[0].student_avatar
                    this.student_fullname = res.data[0].student_fullname
                    this.student_email = res.data[0].student_email
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
.styling {
    text-align: center;
}
</style>
