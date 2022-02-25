<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Môn học: {{ subject_name }}</p>
        </div>

        <div class="grid">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <button class="btn btn-lg btn-primary">Đăng ký</button>
                </div>
                <div class="col-md-2">
                    <router-link class="btn btn-lg btn-info" tag="button" :to="{ name: 'subjectregisterindex' }">
                        Quay lại
                    </router-link>
                </div>
            </div>
            <div class="table-responsive">
                <div v-if="types.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center">
                                    Chọn
                                </th>
                                <th class="text-center">
                                    Loại
                                </th>
                                <th class="text-center">
                                    Mã môn học
                                </th>
                                <th class="text-center">
                                    Tên môn học
                                </th>
                                <th class="text-center">
                                    SL lớp
                                </th>
                                <th class="text-center">
                                    SL đăng ký
                                </th>
                                <th class="text-center">
                                    Lịch học
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="i in types" :key="i">
                            <tr>
                                <td colspan="7">
                                    <strong v-if="i == 0">Lý thuyết</strong>
                                    <strong v-else-if="i == 1">Thực hành</strong>
                                </td>
                            </tr>
                            <tr v-for="value in subjects[i]" :key="value.subject_id">
                                <td class="td-table text-center">
                                    <input type="checkbox" name="subjects" :value="value.subject_id" />
                                </td>
                                <td class="text-center td-table">
                                    <div v-if="value.calendar_subject_type == 0">Lý thuyết</div>
                                    <div v-else-if="value.calendar_subject_type == 1">Thực hành</div>
                                </td>
                                <td class="td-table">
                                    {{ value.subject_code }}
                                </td>
                                <td class="text-center td-table">
                                    {{ value.subject_name }}
                                </td>
                                <td class="text-center">
                                    {{ value.calendar_subject_slot }}
                                </td>
                                <td class="text-center">
                                    {{ value.calendar_subject_registered }}
                                </td>
                                <td class="text-center">
                                    {{ value.calendar_subject_schedule }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <div class="alert alert-danger">
                        Không tìm thấy kết quả phù hợp!
                    </div>
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
            subject_id: this.$route.params.idRSubject,
            subjects: [],
            types: [],
            semester: '',
            subject_name: ''
        }
    },
    mounted() {
        this.fetchCalendarRegister()
    },
    watch: {
        semester(value) {
            if (value != '') {
                this.fetchSubjectRegister()
            }
        }
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
                            this.semester = el.location
                        }
                    })
                })
                .catch(err => console.log(err))
        },
        fetchSubjectRegister(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/chon-lop-mon-hoc/${this.student_id}/${this.semester}/${this.subject_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    //this.subjects = res.data
                    this.subject_name = res.data[0].subject_name

                    const types = res.data.reduce((types, item) => {
                        const type = types[item.calendar_subject_type] || []
                        type.push(item)
                        types[item.calendar_subject_type] = type
                        return types
                    }, {})

                    let key = Object.keys(types)
                    this.subjects = types
                    this.types = key
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
