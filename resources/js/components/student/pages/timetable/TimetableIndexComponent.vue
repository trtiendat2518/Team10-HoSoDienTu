<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Lịch học</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <router-link tag="button" class="btn btn-primary btn-calendar" :to="{ name: 'timetablecalendar' }">
                                Xem TKB Tuần
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-select">
                            <select class="form-control" v-model="filter">
                                <option value="" disabled>Chưa có lịch</option>
                                <option v-for="i in semesters" :key="i" :value="i">Học kỳ {{ i }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap">
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
                                <th class="text-center text-white">
                                    Loại
                                </th>
                                <th class="text-center">
                                    Số TC
                                </th>
                                <th class="text-center">
                                    Lịch học
                                </th>
                                <th class="text-center">
                                    Ngày bắt đầu
                                </th>
                                <th class="text-center">
                                    Ngày kết thúc
                                </th>
                                <th class="text-center">
                                    Giảng viên
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="8">
                                    <b>Năm học: {{ year_start }}-{{ year_end }} Học kỳ: {{ filter }} </b>
                                </td>
                            </tr>

                            <tr
                                v-show="subjects[filter].length"
                                v-for="(subject, index) in subjects[filter]"
                                :key="subject.register_subject_id"
                            >
                                <td class="text-center">
                                    {{ (index += 1) }}
                                </td>
                                <td class="text-center">
                                    {{ subject.subject_code }}
                                </td>
                                <td>
                                    {{ subject.subject_name }}
                                </td>
                                <td>
                                    <div v-if="subject.calendar_subject_type == 0">Lý thuyết</div>
                                    <div v-else-if="subject.calendar_subject_type == 1">Thực hành</div>
                                </td>
                                <td class="text-center">
                                    {{ subject.subject_credit }}
                                </td>
                                <td class="text-center">
                                    {{ valueCurrent(subject.calendar_subject_day, subject.calendar_subject_time) }}
                                </td>
                                <td class="text-center">
                                    {{ subject.calendar_subject_start }}
                                </td>
                                <td class="text-center">
                                    {{ subject.calendar_subject_end }}
                                </td>
                                <td class="text-center">
                                    {{ subject.lecturer_fullname }}
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            subjects: [],
            semesters: [],
            filter: '',
            year_start: '',
            year_end: ''
        }
    },
    mounted() {
        this.fetchSubjects()
    },
    methods: {
        fetchSubjects(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    let data = res.data.filter(el => {
                        const start = new Date(el.calendar_subject_start)
                        const end = new Date(el.calendar_subject_end)
                        if (today >= start && today <= end) {
                            return el
                        }
                    })
                    this.filter = data[0].register_subject_semester
                    this.year_start = data[0].register_subject_yearstart
                    this.year_end = data[0].register_subject_yearend

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
        valueCurrent(calendar_subject_day, calendar_subject_time) {
            const day = calendar_subject_day.split(', ')
            const time = calendar_subject_time.split(', ')
            let arrayDay = []
            let arrayTime = []
            let stringDay = ''
            let stringTime = ''
            let allStringDay = ''
            let allStringTime = ''

            if (day.length > 0) {
                for (let i = 0; i < day.length; i++) {
                    if (day[i] == 0) {
                        stringDay = 'Chủ nhật'
                    } else {
                        let key = Number(day[i]) + 1
                        stringDay = 'Thứ ' + key
                    }
                    arrayDay.push(stringDay)
                }
                allStringDay = arrayDay.join(', ')
            }

            if (time.length > 0) {
                for (let i = 0; i < time.length; i++) {
                    if (time[i] == 123) {
                        stringTime = 'Tiết 1-2-3'
                    } else if (time[i] == 456) {
                        stringTime = 'Tiết 4-5-6'
                    } else if (time[i] == 789) {
                        stringTime = 'Tiết 7-8-9'
                    } else if (time[i] == 101112) {
                        stringTime = 'Tiết 10-11-12'
                    } else if (time[i] == 131415) {
                        stringTime = 'Tiết 13-14-15'
                    }
                    arrayTime.push(stringTime)
                }
                allStringTime = arrayTime.join(', ')
            }
            return allStringDay + ' (' + allStringTime + ')'
        }
    }
}
</script>

<style scoped>
.btn-calendar {
    width: 20%;
    float: right;
}
</style>
