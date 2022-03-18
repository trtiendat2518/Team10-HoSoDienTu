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
                    <p>Hiện tại chưa tới ngày giờ để bạn đăng ký kế hoạch học tập chính thức</p>
                </div>
            </div>
            <hr />

            <div class="row" v-show="subjects_again.length > 0">
                <div class="col-md-10">
                    <h4 class="text-center">Đăng ký học lại</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-info" @click="register()">Đăng ký</button>
                </div>
            </div>
            <div v-show="subjects_again.length > 0" class="table-responsive">
                <table class="table table-nowrap">
                    <thead class="blue-background text-white">
                        <tr>
                            <th class="text-center w-5" scope="col" rowspan="2">
                                STT
                            </th>
                            <th class="text-center w-15" scope="col" rowspan="2">
                                Mã môn học
                            </th>
                            <th class="text-center w-60" scope="col" rowspan="2">
                                Tên môn học
                            </th>
                            <th class="text-center w-10" scope="col" rowspan="2">
                                Số TC
                            </th>
                            <th class="w-10 text-center">Kế hoạch</th>
                            <th class="w-10 text-center">Huỷ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in subjects_again" :key="value.subject_id">
                            <td class="td-table text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_code }}
                            </td>
                            <td class="td-table">
                                {{ value.subject_name }}
                            </td>
                            <td class="text-center td-table">
                                {{ value.subject_credit }}
                            </td>
                            <td class="text-center">
                                <input
                                    type="checkbox"
                                    name="plansuggest_detail_program"
                                    :value="value.subject_id"
                                    :checked="checkValue(value)"
                                    :disabled="disableValue(value)"
                                    @change="select($event.target.checked, value.subject_id)"
                                />
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger" @click="cancel(value)" :disabled="disableButton(value)">Huỷ</button>
                            </td>
                        </tr>
                        <tr v-show="!subjects_again.length">
                            <td colspan="9">
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            subjects: [],
            subjects_again: [],
            selected: [],
            semester: '',
            year_start: '',
            my_subjects: []
        }
    },
    mounted() {
        this.fetchCalendarPlan()
        this.fetchCalendarAgain()
        this.fetchSubjectFail()
        this.fetchMySubject()
    },
    watch: {
        id_again(value) {
            if (value != '') {
                this.fetchRegisterAgain()
            }
        },
        semester(value) {
            if (value != '') {
                this.fetchMyPlan()
            }
        }
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
        },
        // Lay id lich
        fetchCalendarAgain(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/learn-again/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.id_again = el.id
                        }
                    })
                })
                .catch(err => console.log(err))
        },
        // Lay mon hoc thi lan 1 va lan 2 rot
        fetchSubjectFail(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/subject-fail/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                })
                .catch(err => console.log(err))
        },
        // Lay mon hoc duoc dang ky ke hoach cua lich dang mo va so sanh mon dang rot
        fetchRegisterAgain(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/subject-fail-plan/${this.id_again}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    for (let i = 0; i < res.data.length; i++) {
                        for (let j = 0; j < this.subjects.length; j++) {
                            if (res.data[i].subject_id == this.subjects[j].subject_id) {
                                this.subjects_again.push(res.data[i])
                            }
                        }
                    }
                })
                .catch(err => console.log(err))
        },
        // Lay cac mon dang hoc de lay so hoc ky gan day
        fetchMySubject(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/my-all-subject/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.semester = res.data[0].register_subject_semester + 1
                })
                .catch(err => console.log(err))
        },
        fetchMyPlan(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/my-plan-again/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.my_subjects = res.data
                    for (let i = 0; i <= res.data.length; i++) {
                        this.selected.push(res.data[i].register_plan_program)
                    }
                })
                .catch(err => console.log(err))
        },
        select(e, value) {
            if (e === true) {
                this.selected.push(value)
            } else {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
            }
        },
        register() {
            let today = new Date()
            this.year_start = today.getFullYear()
            let formData = new FormData()
            formData.append('year_start', this.year_start)
            formData.append('semester', this.semester)
            formData.append('student_id', this.student_id)
            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post('../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/register-again', formData)
                .then(res => {
                    this.fetchMyPlan()
                    this.$swal({
                        title: 'Đăng ký thành công!',
                        icon: 'success',
                        confirmButtonText: 'OK!',
                        timer: 3500
                    })
                })
                .catch(err => {
                    const null_subject = err.response.data.errors?.subject?.length
                    if (null_subject > 0) {
                        this.$swal({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: err.response.data.errors.subject[0],
                            timer: 2000
                        })
                    } else {
                        this.$swal({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Lỗi định dạng!',
                            timer: 2000
                        })
                    }
                })
        },
        checkValue(value) {
            const check = this.my_subjects.find(sub => sub.register_plan_program == value.subject_id)
            if (check) {
                return true
            } else {
                return false
            }
        },
        disableValue(value) {
            const check = this.my_subjects.find(sub => sub.register_plan_program == value.subject_id)
            if (check) {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
                return true
            } else {
                return false
            }
        },
        disableButton(value) {
            const check = this.my_subjects.find(sub => sub.register_plan_program == value.subject_id)
            if (check) {
                return false
            } else {
                return true
            }
        },
        cancel(value) {
            this.$swal({
                title: 'Bạn có chắc chắn huỷ đăng ký kế hoạch học lại?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Huỷ !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(`../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/cancel-register-again/${value.subject_id}`)
                        .then(res => {
                            this.fetchMyPlan()
                            this.$swal('Đã huỷ!', 'Huỷ thành công', 'success')
                        })
                        .catch(err => console.log(err))
                }
            })
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
    vertical-align: middle;
}
</style>
