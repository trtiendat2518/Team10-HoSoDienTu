<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thanh toán học phí</p>
        </div>

        <div class="grid">
            <div class="alert alert-warning">
                <div class="mb-2 text-center">
                    <p>Hiện tại chưa tới ngày giờ để bạn thanh toán học phí</p>
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
            tuitions: []
        }
    },
    mounted() {
        this.fetchCalendarPayTuition()
    },
    methods: {
        fetchCalendarPayTuition(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/thoi-gian-thanh-toan/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.$router.push({ name: 'paytuitionindex' })
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
