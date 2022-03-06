<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Chương trình đào tạo</p>
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
                        : Môn học đã rớt hoặc chưa có điểm
                    </div>
                </div>
            </div>

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
                                Số TC
                            </th>
                            <th class="text-center">
                                Bắt buộc
                            </th>
                            <th class="text-center">
                                Số tiết LT
                            </th>
                            <th class="text-center">
                                Số tiết TH
                            </th>
                            <th class="text-center">
                                Khoa/Bộ môn
                            </th>
                            <th class="text-center">
                                Ghi chú
                            </th>
                            <th class="text-center">
                                Đã học
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="i in semesters_program" :key="i">
                        <tr class="background-result">
                            <td colspan="10">
                                <b> Học kỳ {{ i }} </b>
                            </td>
                        </tr>
                        <tr
                            v-show="subjects_programs[i].length"
                            v-for="(subject, index) in subjects_programs[i]"
                            :key="subject.register_subject_id"
                        >
                            <td class="td-table text-center">
                                {{ (index += 1) }}
                            </td>
                            <td class="text-center td-table">
                                {{ subject.subject_code }}
                            </td>
                            <td class="td-table">
                                {{ subject.subject_name }}
                            </td>
                            <td class="text-center td-table">
                                {{ subject.subject_credit }}
                            </td>
                            <td class="text-center td-table">
                                <p v-if="subject.subject_type == 0">x</p>
                                <p v-else></p>
                            </td>
                            <td class="text-center">
                                {{ subject.subject_theory_period }}
                            </td>
                            <td class="text-center">
                                {{ subject.subject_practice_period }}
                            </td>
                            <td class="text-center">
                                {{ subject.faculty_name }}
                            </td>
                            <td class="text-center">
                                {{ nameMajor(subject) }}
                            </td>
                            <td class="text-center">
                                <div v-if="checkSubject(subject) > 0">
                                    <div v-if="checkSum(subject) < 4">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div v-else-if="checkSum(subject) >= 4">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
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
            subjects_programs: [],
            semesters_program: [],
            subjects: [],
            majors: []
        }
    },
    mounted() {
        this.fetchPrograms()
        this.fetchMajors()
        this.fetchSubjects()
    },
    methods: {
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
        fetchMajors(page_url) {
            let vm = this
            page_url = '../../api/admin/edu-major/chuyen-nganh/major'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.majors = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSubjects(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subjects = res.data
                })
                .catch(err => console.log(err))
        },
        nameMajor(subject) {
            if (subject.program_detail_note != 'null' && subject.program_detail_note != null) {
                const major = this.majors.find(mjr => mjr.major_code === subject.program_detail_note)
                return major.major_name
            } else {
                return ''
            }
        },
        checkSubject(subject) {
            const sub = this.subjects.filter(sj => sj.subject_id == subject.subject_id)
            return sub.length
        },
        checkSum(subject) {
            let scoreExercise = 0
            let scoreExam = 0
            let scoreFinal = 0

            this.subjects.filter(el => {
                if (el.subject_id == subject.subject_id) {
                    scoreExercise = (el.register_subject_exercise * el.subject_score_exercise) / 100
                    scoreExam = (el.register_subject_exam * el.subject_score_exam) / 100

                    if (el.register_subject_final >= el.register_subject_second) {
                        scoreFinal = (el.register_subject_final * el.subject_score_final) / 100
                    } else {
                        scoreFinal = (el.register_subject_second * el.subject_score_final) / 100
                    }
                }
            })
            return scoreExercise + scoreExam + scoreFinal
        }
    }
}
</script>

<style></style>
