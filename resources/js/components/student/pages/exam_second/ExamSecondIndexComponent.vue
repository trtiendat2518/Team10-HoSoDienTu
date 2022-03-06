<template>
    <div>
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Đăng ký thi lần 2</p>
        </div>
        <div class="grid">
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
                                <button class="btn btn-info">Đăng ký</button>
                            </td>
                        </tr>
                        <tr v-show="!exams.length">
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
            exams: []
        }
    },
    mounted() {
        this.fetchScore()
    },
    methods: {
        fetchScore(page_url) {
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/xem-diem/${this.student_id}`
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

                            if (res.data[i].register_subject_final >= res.data[i].register_subject_second) {
                                scoreFinal = (res.data[i].register_subject_final * res.data[i].subject_score_final) / 100
                            } else {
                                scoreFinal = (res.data[i].register_subject_second * res.data[i].subject_score_final) / 100
                            }

                            sum = (scoreExercise + scoreExam + scoreFinal).toFixed(1)
                            if (sum < 4) {
                                this.exams.push(res.data[i])
                            }
                        }
                    }
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
        }
    }
}
</script>

<style></style>
