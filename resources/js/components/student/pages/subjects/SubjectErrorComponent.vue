<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Đăng ký môn học</p>
        </div>

        <div class="grid">
            <div class="alert alert-warning">
                <div class="mb-2 text-center">
                    <p>Hiện tại chưa tới ngày giờ để bạn đăng ký môn học</p>
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
            id_again: '',
            subjects: []
        }
    },
    mounted() {
        this.fetchCalendarRegister()
        this.fetchSubjectFail()
    },
    methods: {
        fetchCalendarRegister(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/thoi-gian-dang-ky/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.$router.push({ name: 'subjectregisterindex' })
                        }
                    })
                })
                .catch(err => console.log(err))
        },
        fetchRegisterAgain(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/learn-again/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.$router.push({ name: 'subjectregisterindex' })
                        }
                    })
                })
                .catch(err => console.log(err))
        },
        fetchSubjectFail(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/subject-fail/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (res.data.length > 0) {
                        this.fetchRegisterAgain()
                    }
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
