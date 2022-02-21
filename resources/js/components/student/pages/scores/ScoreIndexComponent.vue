<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Kết quả học tập</p>
        </div>

        <div class="grid">
            <div class="alert alert-info">
                <div>
                    <p>
                        <i><u>Chú ý:</u></i>
                    </p>
                    <div>
                        <p class="fa fa-check"></p>
                        : Môn học đã đậu
                    </div>
                    <div>
                        <p class="fa fa-times"></p>
                        : Môn học đã rớt
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="radio" value="1" v-model="view_score" /> Xem điểm sinh viên
                        <input type="radio" value="2" v-model="view_score" /> Xem điểm theo CTĐT
                    </div>
                </div>
                <div class="col-md-2" v-show="view_score == 1">
                    <div class="form-group form-select">
                        <select class="form-control" v-model="filter">
                            <option value="">Xem tất cả</option>
                            <option v-for="i in semesters" :key="i" :value="i">Học kỳ {{ i }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div v-show="view_score == 1" class="table-responsive">
                <table class="table table-nowrap" v-if="filter == ''">
                    <thead class="blue-background text-white">
                        <tr>
                            <th class="text-center text-white">
                                STT
                            </th>
                            <th class="text-center text-white">
                                Mã môn học
                            </th>
                            <th class="text-center text-white">
                                Tên môn học
                            </th>
                            <th class="text-center">
                                Số TC
                            </th>
                            <th class="text-center">
                                BT (%)
                            </th>
                            <th class="text-center">
                                KT (%)
                            </th>
                            <th class="text-center">
                                CK (%)
                            </th>
                            <th></th>
                            <th class="text-center">
                                Điểm BT
                            </th>
                            <th class="text-center">
                                Điểm KT
                            </th>
                            <th class="text-center">
                                Điểm CK
                            </th>
                            <th class="text-center">
                                Điểm Tổng
                            </th>
                            <th class="text-center">
                                Điểm chữ
                            </th>
                            <th class="text-center">
                                kết quả
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="i in semesters" :key="i">
                        <tr>
                            <td colspan="14">
                                <b> Học kỳ {{ i }} </b>
                            </td>
                        </tr>

                        <tr v-show="subjects[i].length" v-for="(subject, index) in subjects[i]" :key="subject.subject_id">
                            <td class="text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_code }}
                            </td>
                            <td>
                                {{ subject.subject_name }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_credit }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exercise }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exam }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_final }}
                            </td>
                            <td></td>
                            <td class="text-center">
                                {{ subject.register_subject_exercise }}
                            </td>
                            <td class="text-center">
                                {{ subject.register_subject_exam }}
                            </td>
                            <td class="text-center">
                                {{ subject.register_subject_final }}
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    {{ scoreSum(subject) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    <div v-if="scoreSum(subject) < 4">
                                        F
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 5">
                                        D
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 5.5">
                                        D+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 6.5">
                                        C
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 7">
                                        C+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 8">
                                        B
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 8.5">
                                        B+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 9">
                                        A
                                    </div>
                                    <div v-else-if="scoreSum(subject) <= 10">
                                        A+
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    <div v-if="scoreSum(subject) < 4">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div v-else-if="scoreSum(subject) >= 4">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="background-result">
                            <td colspan="7">
                                <div>
                                    Số TC đạt được trong học kỳ:
                                    <b>
                                        {{ resultCreditSemester(i) }}
                                    </b>
                                </div>
                                <div>
                                    Điểm TB học kỳ:
                                    <b>
                                        {{ resultScoreSemester(i) }}
                                    </b>
                                </div>
                            </td>
                            <td></td>
                            <td colspan="6">
                                <div>
                                    Số TC tích lũy:
                                    <b>
                                        {{ resultCreditAll(i) }}
                                    </b>
                                </div>
                                <div>
                                    Điểm TB tích lũy:
                                    <b>
                                        {{ resultScoreAll(i) }}
                                    </b>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr v-show="!semesters.length">
                            <td colspan="14">
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-nowrap" v-else>
                    <thead class="blue-background text-white">
                        <tr>
                            <th class="text-center text-white">
                                STT
                            </th>
                            <th class="text-center text-white">
                                Mã môn học
                            </th>
                            <th class="text-center text-white">
                                Tên môn học
                            </th>
                            <th class="text-center">
                                Số TC
                            </th>
                            <th class="text-center">
                                BT (%)
                            </th>
                            <th class="text-center">
                                KT (%)
                            </th>
                            <th class="text-center">
                                CK (%)
                            </th>
                            <th></th>
                            <th class="text-center">
                                Điểm BT
                            </th>
                            <th class="text-center">
                                Điểm KT
                            </th>
                            <th class="text-center">
                                Điểm CK
                            </th>
                            <th class="text-center">
                                Điểm Tổng
                            </th>
                            <th class="text-center">
                                Điểm chữ
                            </th>
                            <th class="text-center">
                                kết quả
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="14">
                                <b> Học kỳ {{ filter }} </b>
                            </td>
                        </tr>

                        <tr v-show="subjects[filter].length" v-for="(subject, index) in subjects[filter]" :key="subject.subject_id">
                            <td class="text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_code }}
                            </td>
                            <td>
                                {{ subject.subject_name }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_credit }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exercise }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exam }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_final }}
                            </td>
                            <td></td>
                            <td class="text-center">
                                {{ subject.register_subject_exercise }}
                            </td>
                            <td class="text-center">
                                {{ subject.register_subject_exam }}
                            </td>
                            <td class="text-center">
                                {{ subject.register_subject_final }}
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    {{ scoreSum(subject) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    <div v-if="scoreSum(subject) < 4">
                                        F
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 5">
                                        D
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 5.5">
                                        D+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 6.5">
                                        C
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 7">
                                        C+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 8">
                                        B
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 8.5">
                                        B+
                                    </div>
                                    <div v-else-if="scoreSum(subject) < 9">
                                        A
                                    </div>
                                    <div v-else-if="scoreSum(subject) <= 10">
                                        A+
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="
                                        subject.register_subject_exercise == null &&
                                            subject.register_subject_exam == null &&
                                            subject.register_subject_final == null
                                    "
                                >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div v-else>
                                    <div v-if="scoreSum(subject) < 4">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div v-else-if="scoreSum(subject) >= 4">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="background-result">
                            <td colspan="7">
                                <div>
                                    Số TC đạt được trong học kỳ:
                                    <b>
                                        {{ resultCreditSemester(filter) }}
                                    </b>
                                </div>
                                <div>
                                    Điểm TB học kỳ:
                                    <b>
                                        {{ resultScoreSemester(filter) }}
                                    </b>
                                </div>
                            </td>
                            <td></td>
                            <td colspan="6">
                                <div>
                                    Số TC tích lũy:
                                    <b>
                                        {{ resultCreditAll(filter) }}
                                    </b>
                                </div>
                                <div>
                                    Điểm TB tích lũy:
                                    <b>
                                        {{ resultScoreAll(filter) }}
                                    </b>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr v-show="!semesters.length">
                            <td colspan="14">
                                <div class="alert alert-danger">
                                    Không tìm thấy kết quả phù hợp!
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div v-show="view_score == 2" class="table-responsive">
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
                                Số TC
                            </th>
                            <th class="text-center">
                                BT (%)
                            </th>
                            <th class="text-center">
                                KT (%)
                            </th>
                            <th class="text-center">
                                CK (%)
                            </th>
                            <th></th>
                            <th class="text-center">
                                Điểm BT
                            </th>
                            <th class="text-center">
                                Điểm KT
                            </th>
                            <th class="text-center">
                                Điểm CK
                            </th>
                            <th class="text-center">
                                Điểm Tổng
                            </th>
                            <th class="text-center">
                                Điểm chữ
                            </th>
                            <th class="text-center">
                                kết quả
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="i in semesters_program" :key="i">
                        <tr class="background-result">
                            <td colspan="14">
                                <b> Học kỳ {{ i }} </b>
                            </td>
                        </tr>
                        <tr v-show="subjects_programs[i].length" v-for="(subject, index) in subjects_programs[i]" :key="subject.subject_id">
                            <td class="td-table text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center td-table">
                                <a href="javscript:void(0)" @click="detail(subject.subject_id)">
                                    {{ subject.subject_code }}
                                </a>
                            </td>
                            <td class="td-table">
                                {{ subject.subject_name }}
                            </td>
                            <td class="text-center td-table">
                                {{ subject.subject_credit }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exercise }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_exam }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_score_final }}
                            </td>
                            <td></td>
                            <td class="text-center">
                                {{ subject_exercise(subject) }}
                            </td>
                            <td class="text-center">
                                {{ subject_exam(subject) }}
                            </td>
                            <td class="text-center">
                                {{ subject_final(subject) }}
                            </td>
                            <td class="text-center">
                                {{ subject_sum(subject) }}
                            </td>
                            <td class="text-center">
                                <div v-if="subject_sum(subject) < 4">
                                    F
                                </div>
                                <div v-else-if="subject_sum(subject) < 5">
                                    D
                                </div>
                                <div v-else-if="subject_sum(subject) < 5.5">
                                    D+
                                </div>
                                <div v-else-if="subject_sum(subject) < 6.5">
                                    C
                                </div>
                                <div v-else-if="subject_sum(subject) < 7">
                                    C+
                                </div>
                                <div v-else-if="subject_sum(subject) < 8">
                                    B
                                </div>
                                <div v-else-if="subject_sum(subject) < 8.5">
                                    B+
                                </div>
                                <div v-else-if="subject_sum(subject) < 9">
                                    A
                                </div>
                                <div v-else-if="subject_sum(subject) <= 10">
                                    A+
                                </div>
                            </td>
                            <td class="text-center">
                                <div v-if="subject_sum(subject) < 4">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <div v-else-if="subject_sum(subject) >= 4">
                                    <i class="fa fa-check" aria-hidden="true"></i>
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
            view_score: 1,
            subjects: [],
            semesters: [],
            subjects_programs: [],
            semesters_program: [],
            scores_program: [],
            error: {},
            filter: ''
        }
    },
    mounted() {
        this.fetchScore()
    },
    watch: {
        view_score(value) {
            if (value == 1) {
                this.fetchScore()
            } else if (value == 2) {
                this.fetchPrograms()
                this.fetchScorePrograms()
            }
        }
    },
    methods: {
        fetchScore(page_url) {
            let vm = this
            page_url = `../../api/admin/register-subject/dang-ky-mon-hoc-sv/xem-diem/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.register_subject_semester] || []
                        semester.push(item)
                        semesters[item.register_subject_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.subjects = semesters
                    this.semesters = key
                })
                .catch(err => console.log(err))
        },
        scoreSum(subject) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            scoreExercise = (subject.register_subject_exercise * subject.subject_score_exercise) / 100
            scoreExam = (subject.register_subject_exam * subject.subject_score_exam) / 100

            if (subject.register_subject_final >= subject.register_subject_second) {
                scoreFinal = (subject.register_subject_final * subject.subject_score_final) / 100
            } else {
                scoreFinal = (subject.register_subject_second * subject.subject_score_final) / 100
            }

            return scoreExercise + scoreExam + scoreFinal
        },
        resultCreditSemester(i) {
            let sum = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let j = 0; j < this.subjects[i].length; j++) {
                scoreExercise = (this.subjects[i][j].register_subject_exercise * this.subjects[i][j].subject_score_exercise) / 100
                scoreExam = (this.subjects[i][j].register_subject_exam * this.subjects[i][j].subject_score_exam) / 100
                if (this.subjects[i][j].register_subject_final >= this.subjects[i][j].register_subject_second) {
                    scoreFinal = (this.subjects[i][j].register_subject_final * this.subjects[i][j].subject_score_final) / 100
                } else {
                    scoreFinal = (this.subjects[i][j].register_subject_second * this.subjects[i][j].subject_score_final) / 100
                }

                scoreSum = scoreExercise + scoreExam + scoreFinal
                if (scoreSum >= 4) {
                    sum += parseFloat(this.subjects[i][j].subject_credit)
                }
            }
            return sum
        },
        resultScoreSemester(i) {
            let sum = 0
            let sumCredit = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let j = 0; j < this.subjects[i].length; j++) {
                scoreExercise = (this.subjects[i][j].register_subject_exercise * this.subjects[i][j].subject_score_exercise) / 100
                scoreExam = (this.subjects[i][j].register_subject_exam * this.subjects[i][j].subject_score_exam) / 100
                if (this.subjects[i][j].register_subject_final >= this.subjects[i][j].register_subject_second) {
                    scoreFinal = (this.subjects[i][j].register_subject_final * this.subjects[i][j].subject_score_final) / 100
                } else {
                    scoreFinal = (this.subjects[i][j].register_subject_second * this.subjects[i][j].subject_score_final) / 100
                }
                scoreSum += (scoreExercise + scoreExam + scoreFinal) * this.subjects[i][j].subject_credit
                sumCredit += this.subjects[i][j].subject_credit
                sum = parseFloat(scoreSum / sumCredit)
            }
            return sum.toFixed(2)
        },
        resultCreditAll(i) {
            let sum = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let l = 1; l <= i; l++) {
                for (let j = 0; j < this.subjects[l].length; j++) {
                    scoreExercise = (this.subjects[l][j].register_subject_exercise * this.subjects[l][j].subject_score_exercise) / 100
                    scoreExam = (this.subjects[l][j].register_subject_exam * this.subjects[l][j].subject_score_exam) / 100
                    if (this.subjects[l][j].register_subject_final >= this.subjects[l][j].register_subject_second) {
                        scoreFinal = (this.subjects[l][j].register_subject_final * this.subjects[l][j].subject_score_final) / 100
                    } else {
                        scoreFinal = (this.subjects[l][j].register_subject_second * this.subjects[l][j].subject_score_final) / 100
                    }

                    scoreSum = scoreExercise + scoreExam + scoreFinal

                    if (scoreSum >= 4) {
                        sum += parseFloat(this.subjects[l][j].subject_credit)
                    }
                }
            }
            return sum
        },
        resultScoreAll(i) {
            let sum = 0
            let sumCredit = 0
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0
            let scoreSum = 0
            for (let l = 1; l <= i; l++) {
                for (let j = 0; j < this.subjects[l].length; j++) {
                    scoreExercise = (this.subjects[l][j].register_subject_exercise * this.subjects[l][j].subject_score_exercise) / 100
                    scoreExam = (this.subjects[l][j].register_subject_exam * this.subjects[l][j].subject_score_exam) / 100
                    if (this.subjects[l][j].register_subject_final >= this.subjects[l][j].register_subject_second) {
                        scoreFinal = (this.subjects[l][j].register_subject_final * this.subjects[l][j].subject_score_final) / 100
                    } else {
                        scoreFinal = (this.subjects[l][j].register_subject_second * this.subjects[l][j].subject_score_final) / 100
                    }
                    scoreSum += (scoreExercise + scoreExam + scoreFinal) * this.subjects[l][j].subject_credit
                    sumCredit += parseFloat(this.subjects[l][j].subject_credit)

                    sum = parseFloat(scoreSum / sumCredit)
                }
            }
            return sum.toFixed(2)
        },
        fetchPrograms(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.program_detail_semester] || []
                        semester.push(item)
                        semesters[item.program_detail_semester] = semester
                        return semesters
                    }, {})

                    let key = Object.keys(semesters)
                    this.subjects_programs = semesters
                    this.semesters_program = key
                })
                .catch(err => console.log(err))
        },
        fetchScorePrograms(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/score/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.scores_program = res.data
                })
                .catch(err => console.log(err))
        },
        subject_exercise(subject) {
            for (let i = 0; i < this.scores_program.length; i++) {
                if (this.scores_program[i].subject_id == subject.subject_id) {
                    return this.scores_program[i].register_subject_exercise
                }
            }
        },
        subject_exam(subject) {
            for (let i = 0; i < this.scores_program.length; i++) {
                if (this.scores_program[i].subject_id == subject.subject_id) {
                    return this.scores_program[i].register_subject_exam
                }
            }
        },
        subject_final(subject) {
            for (let i = 0; i < this.scores_program.length; i++) {
                if (this.scores_program[i].subject_id == subject.subject_id) {
                    return this.scores_program[i].register_subject_final
                }
            }
        },
        subject_sum(subject) {
            for (let i = 0; i < this.scores_program.length; i++) {
                if (this.scores_program[i].subject_id == subject.subject_id) {
                    let scoreExercise = 0
                    let scoreExam = 0
                    let scoreFinal = 0

                    scoreExercise = (this.scores_program[i].register_subject_exercise * subject.subject_score_exercise) / 100
                    scoreExam = (this.scores_program[i].register_subject_exam * subject.subject_score_exam) / 100

                    if (this.scores_program[i].register_subject_final >= this.scores_program[i].register_subject_second) {
                        scoreFinal = (this.scores_program[i].register_subject_final * subject.subject_score_final) / 100
                    } else {
                        scoreFinal = (this.scores_program[i].register_subject_second * subject.subject_score_final) / 100
                    }

                    return scoreExercise + scoreExam + scoreFinal
                }
            }
        }
    }
}
</script>

<style scoped>
.background-result {
    background-color: lightgoldenrodyellow;
}
</style>
