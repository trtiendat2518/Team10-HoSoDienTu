<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Lịch thi</p>
        </div>
        <div class="grid">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group form-select">
                        <select class="form-control" v-model="filter">
                            <option value="" disabled>Học kỳ</option>
                            <option v-for="i in semesters" :key="i" :value="i">Học kỳ {{ i }}</option>
                        </select>
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
                                Lần thi
                            </th>
                            <th class="text-center">
                                Ngày thi
                            </th>
                            <th class="text-center">
                                Giờ thi
                            </th>
                            <th class="text-center">
                                Phòng thi
                            </th>
                            <th class="text-center">
                                Hình thức thi
                            </th>
                            <th class="text-center">
                                Thời gian làm bài (phút)
                            </th>
                            <th class="text-center">
                                Địa điểm
                            </th>
                            <th class="text-center">
                                Kỳ thi
                            </th>
                            <th class="text-center">
                                Ghi chú
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in exams[filter]" :key="value.calendar_exam_id">
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
                                <div v-if="value.calendarId == 2">Lần 1</div>
                                <div v-else-if="value.calendarId == 3">Lần 2</div>
                            </td>
                            <td class="text-center">
                                {{ value.start | formatDate }}
                            </td>
                            <td class="text-center">
                                {{ value.start | formatTime }}
                            </td>
                            <td class="text-center">
                                {{ value.calendar_exam_room }}
                            </td>
                            <td class="text-center td-table">
                                <div v-if="value.calendarId == 0">Tự luận</div>
                                <div v-else-if="value.calendarId == 1">Trắc nghiệm</div>
                                <div v-else-if="value.calendarId == 2">Tự luận + Trắc nghiệm</div>
                                <div v-else-if="value.calendarId == 3">Vấn đáp</div>
                                <div v-else-if="value.calendarId == 4">Thuyết trình</div>
                                <div v-else-if="value.calendarId == 5">Đồ án</div>
                            </td>
                            <td class="text-center">
                                {{ timeExam(value) }}
                            </td>
                            <td class="text-center">
                                {{ value.calendar_exam_place }}
                            </td>
                            <td class="text-center">HK{{ value.calendar_exam_semester }}</td>
                            <td class="text-center">
                                {{ value.calendar_exam_note }}
                            </td>
                        </tr>
                        <tr v-show="!exams[filter].length">
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
            exams: [],
            semesters: [],
            filter: ''
        }
    },
    mounted() {
        this.fetchExam()
    },
    methods: {
        fetchExam(page_url) {
            let vm = this
            page_url = `../../api/admin/calendar-exam/lich-thi/sinh-vien/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const semesters = res.data.reduce((semesters, item) => {
                        const semester = semesters[item.calendar_exam_semester] || []
                        semester.push(item)
                        semesters[item.calendar_exam_semester] = semester
                        return semesters
                    }, {})

                    const today = new Date()
                    for (let i = 0; i < res.data.length; i++) {
                        const end = new Date(res.data[i].end)
                        if (today < end) {
                            this.filter = res.data[i].calendar_exam_semester
                        }
                    }

                    let key = Object.keys(semesters)
                    this.exams = semesters
                    this.semesters = key
                })
                .catch(err => console.log(err))
        },
        timeExam(value) {
            let start = new Date(value.start)
            let end = new Date(value.end)
            let minutes = 0

            let time = end - start
            var diffHrs = Math.floor((time % 86400000) / 3600000)
            var diffMins = Math.round(((time % 86400000) % 3600000) / 60000)

            for (let i = 0; i < diffHrs; i++) {
                minutes = 60 + minutes
            }
            return minutes + diffMins
        }
    }
}
</script>

<style></style>
