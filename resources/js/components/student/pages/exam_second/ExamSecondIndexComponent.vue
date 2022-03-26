<template>
    <div>
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Đăng ký thi lần 2</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center">
                                    STT
                                </th>
                                <th class="text-center">
                                    Mã môn học
                                </th>
                                <th class="text-center">
                                    Tên môn học
                                </th>
                                <th class="text-center">
                                    Điểm lần 1
                                </th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in exams" :key="value.calendar_exam_id">
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
                                    {{ subject_socre(value) }}
                                </td>
                                <td class="text-center">
                                    <input
                                        type="checkbox"
                                        name="subject"
                                        :value="value.subject_id"
                                        @change="select($event.target.checked, value.subject_id)"
                                        :checked="checkValue(value)"
                                        :disabled="disableValue(value)"
                                    />
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="cancel(value)" :disabled="disableCancel(value)">
                                        Huỷ
                                    </button>
                                </td>
                            </tr>
                            <tr v-show="!exams.length">
                                <td colspan="5">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn width-btn btn-info mt-3" @click="store()">Đăng ký</button>
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
            exams: [],
            selected: [],
            subjects: []
        }
    },
    mounted() {
        this.fetchScore()
        this.fetchSubjects()
    },
    methods: {
        fetchScore(page_url) {
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/xem-thi-lan-2/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    let scoreExercise = 0
                    let scoreExam = 0
                    let scoreFinal = 0
                    let sum = 0
                    for (let i = 0; i < res.data.length; i++) {
                        if (
                            res.data[i].register_subject_exercise != null &&
                            res.data[i].register_subject_exam != null &&
                            res.data[i].register_subject_final != null
                        ) {
                            scoreExercise = (res.data[i].register_subject_exercise * res.data[i].subject_score_exercise) / 100
                            scoreExam = (res.data[i].register_subject_exam * res.data[i].subject_score_exam) / 100
                            scoreFinal = (res.data[i].register_subject_final * res.data[i].subject_score_final) / 100

                            sum = (scoreExercise + scoreExam + scoreFinal).toFixed(1)
                            if (sum < 4) {
                                this.exams.push(res.data[i])
                            }
                        }
                    }
                })
                .catch(err => console.log(err))
        },
        fetchSubjects(page_url) {
            page_url = `../../api/admin/exam-second/dang-ky-thi-lan-2/sinh-vien/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                })
                .catch(err => console.log(err))
        },
        subject_socre(value) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            scoreExercise = (value.register_subject_exercise * value.subject_score_exercise) / 100
            scoreExam = (value.register_subject_exam * value.subject_score_exam) / 100

            if (value.register_subject_final >= value.register_subject_second) {
                scoreFinal = (value.register_subject_final * value.subject_score_final) / 100
            } else {
                scoreFinal = (value.register_subject_second * value.subject_score_final) / 100
            }

            return (scoreExercise + scoreExam + scoreFinal).toFixed(1)
        },
        select(e, value) {
            if (e === true) {
                this.selected.push(value)
            } else {
                let index = this.selected.indexOf(value)
                this.selected.splice(index, 1)
            }
        },
        store() {
            let formData = new FormData()
            formData.append('student_id', this.student_id)
            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post('../../api/admin/exam-second/dang-ky-thi-lan-2', formData)
                .then(res => {
                    this.$swal({
                        title: 'Đăng ký thành công!',
                        icon: 'success',
                        confirmButtonText: 'OK!',
                        timer: 3500
                    })
                    this.selected = []
                    this.fetchSubjects()
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
        cancel(value) {
            this.$swal({
                title: 'Bạn có chắc chắn huỷ đăng ký ' + value.subject_name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Huỷ !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(`../../api/admin/exam-second/dang-ky-thi-lan-2/huy-bo/${this.student_id}/${value.subject_id}`)
                        .then(res => {
                            this.$swal('Đã huỷ!', 'Huỷ thành công', 'success')
                            this.fetchSubjects()
                        })
                        .catch(err => console.log(err))
                }
            })
        },
        checkValue(value) {
            const check = this.subjects.find(sub => sub.exam_second_subject == value.subject_id)
            if (check) {
                return true
            } else {
                return false
            }
        },
        disableValue(value) {
            const check = this.subjects.find(sub => sub.exam_second_subject == value.subject_id)
            if (check) {
                return true
            } else {
                return false
            }
        },
        disableCancel(value) {
            const check = this.subjects.find(sub => sub.exam_second_subject == value.subject_id)
            if (check) {
                return false
            } else {
                return true
            }
        }
    }
}
</script>

<style scoped>
.width-btn {
    width: 20%;
    float: right;
}
td {
    vertical-align: middle !important;
}
</style>
