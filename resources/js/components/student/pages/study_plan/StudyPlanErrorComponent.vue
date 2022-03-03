<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Kế hoạch học tập</p>
        </div>

        <div class="grid">
            <router-link tag="button" class="btn btn-block btn-lg btn-secondary" :to="{ name: 'studyplanhistory' }">
                Lịch sử ĐK
            </router-link>
            <div class="alert alert-warning">
                <div class="mb-2 text-center">
                    <p>Hiện tại chưa tới ngày giờ để bạn đăng ký kế hoạch học tập</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId
        }
    },
    mounted() {
        this.fetchCalendarPlan()
    },
    methods: {
        fetchCalendarPlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/thoi-gian-dang-ky/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.$router.push({ name: 'studyplanindex' })
                        }
                    })
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
}
</style>
