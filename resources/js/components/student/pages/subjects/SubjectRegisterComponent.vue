<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Môn học: {{ subject_name }}</p>
        </div>

        <div class="grid" v-show="register_main == true">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <button class="btn btn-lg btn-primary" @click="button_change ? change() : store()">
                        {{ button_change ? 'Thay đổi' : 'Đăng ký' }}
                    </button>
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
                        <tbody>
                            <tr>
                                <td colspan="7">
                                    <strong>Lý thuyết</strong>
                                </td>
                            </tr>
                            <tr v-for="value in subjects[0]" :key="value.calendar_subject_id">
                                <td class="td-table text-center">
                                    <input
                                        type="radio"
                                        :value="value.calendar_subject_id"
                                        :disabled="disableLt(value)"
                                        v-model="selected_lt"
                                    />
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
                            <tr>
                                <td colspan="7">
                                    <strong>Thực hành</strong>
                                </td>
                            </tr>
                            <tr v-for="value in subjects[1]" :key="value.calendar_subject_id">
                                <td class="td-table text-center">
                                    <input
                                        type="radio"
                                        :value="value.calendar_subject_id"
                                        :disabled="disableTh(value)"
                                        v-model="selected_th"
                                    />
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

            <div class="card mt-5">
                <div class="card-header">
                    <h4 class="text-center">Kết quả đăng ký môn học: {{ subject_name }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div v-if="result_subs.length > 0">
                            <table class="table table-nowrap">
                                <thead class="result-background text-white">
                                    <tr>
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
                                            TC
                                        </th>
                                        <th class="text-center">
                                            Lịch học
                                        </th>
                                        <th class="text-center">
                                            Ngày BĐ
                                        </th>
                                        <th class="text-center">
                                            Ngày KT
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="value in result_subs" :key="value.calendar_subject_id">
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
                                            {{ value.subject_credit }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_schedule }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_start | formatDate }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_end | formatDate }}
                                        </td>
                                        <td>
                                            <button class="btn btn-block btn-primary" @click="changeMode(value)">
                                                Đổi
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-block btn-danger" @click="cancel(value)">
                                                Huỷ
                                            </button>
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
        </div>

        <div class="grid" v-show="register_again == true">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <button class="btn btn-lg btn-primary" @click="button_change ? change() : store()">
                        {{ button_change ? 'Thay đổi' : 'Đăng ký' }}
                    </button>
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
                        <tbody>
                            <tr>
                                <td colspan="7">
                                    <strong>Lý thuyết</strong>
                                </td>
                            </tr>
                            <tr v-for="value in subjects[0]" :key="value.calendar_subject_id">
                                <td class="td-table text-center">
                                    <input
                                        type="radio"
                                        :value="value.calendar_subject_id"
                                        :disabled="disableLt(value)"
                                        v-model="selected_lt"
                                    />
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
                            <tr>
                                <td colspan="7">
                                    <strong>Thực hành</strong>
                                </td>
                            </tr>
                            <tr v-for="value in subjects[1]" :key="value.calendar_subject_id">
                                <td class="td-table text-center">
                                    <input
                                        type="radio"
                                        :value="value.calendar_subject_id"
                                        :disabled="disableTh(value)"
                                        v-model="selected_th"
                                    />
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

            <div class="card mt-5">
                <div class="card-header">
                    <h4 class="text-center">Kết quả đăng ký môn học: {{ subject_name }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div v-if="result_subs.length > 0">
                            <table class="table table-nowrap">
                                <thead class="result-background text-white">
                                    <tr>
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
                                            TC
                                        </th>
                                        <th class="text-center">
                                            Lịch học
                                        </th>
                                        <th class="text-center">
                                            Ngày BĐ
                                        </th>
                                        <th class="text-center">
                                            Ngày KT
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="value in result_subs" :key="value.calendar_subject_id">
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
                                            {{ value.subject_credit }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_schedule }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_start | formatDate }}
                                        </td>
                                        <td class="text-center">
                                            {{ value.calendar_subject_end | formatDate }}
                                        </td>
                                        <td>
                                            <button class="btn btn-block btn-primary" @click="changeMode(value)">
                                                Đổi
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-block btn-danger" @click="cancel(value)">
                                                Huỷ
                                            </button>
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
            selected: [],
            selected_lt: '',
            disable_lt: false,
            selected_th: '',
            disable_th: false,
            result_subs: [],
            semester: '',
            subject_name: '',
            start_year: '',
            end_year: '',
            button_change: false,
            value_change: {},
            register_main: false,
            register_again: false,
            calendar_id: ''
        }
    },
    mounted() {
        this.fetchCalendarRegister()
        this.fetchRegisterAgain()
    },
    watch: {
        semester(value) {
            if (value != '') {
                this.fetchSubjectRegister()
                this.fetchResultSub()
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
                            this.register_main = true
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
                    let register = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.calendar_id = el.id
                            this.register_again = true
                        }
                    })
                    this.fetchSemesterAgain()
                })
                .catch(err => console.log(err))
        },
        fetchSemesterAgain(page_url) {
            page_url = `../../api/student/study-plan/dang-ky-ke-hoach-hoc-tap/subject-again-1/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.semester = res.data[0].register_plan_semester
                })
                .catch(err => console.log(err))
        },
        fetchSubjectRegister(page_url) {
            if (this.register_main == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/chon-lop-mon-hoc/${this.student_id}/${this.semester}/${this.subject_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subject_name = res.data[0].subject_name
                        const start = new Date(res.data[0].calendar_subject_start)
                        const end = new Date(res.data[0].calendar_subject_end)
                        this.start_year = start.getFullYear() - 1
                        this.end_year = end.getFullYear()

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
            } else if (this.register_again == true) {
                page_url = `../../api/student/subject-register/dang-ky-mon-hoc/chon-lop-mon-hoc-hoc-lai/${this.student_id}/${this.calendar_id}/${this.subject_id}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.subject_name = res.data[0].subject_name
                        const start = new Date(res.data[0].calendar_subject_start)
                        const end = new Date(res.data[0].calendar_subject_end)
                        this.start_year = start.getFullYear() - 1
                        this.end_year = end.getFullYear()

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
        },
        fetchResultSub(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/ket-qua-dk-con/${this.student_id}/${this.semester}/${this.subject_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.result_subs = res.data
                    this.selected_lt = ''
                    this.selected_th = ''
                    this.disable_lt = false
                    this.disable_th = false
                    if (res.data.length > 0) {
                        for (let i = 0; i < res.data.length; i++) {
                            if (res.data[i].calendar_subject_type == 0) {
                                this.selected_lt = res.data[i].calendar_subject_id
                                if (this.selected_lt != '') {
                                    this.disable_lt = true
                                } else {
                                    this.disable_lt = false
                                }
                            } else if (res.data[i].calendar_subject_type == 1) {
                                this.selected_th = res.data[i].calendar_subject_id
                                if (this.selected_th != '') {
                                    this.disable_th = true
                                } else {
                                    this.disable_th = false
                                }
                            }
                        }
                    }
                })
                .catch(err => console.log(err))
        },
        store() {
            let formData = new FormData()
            formData.append('semester', this.semester)
            formData.append('yearstart', this.start_year)
            formData.append('yearend', this.end_year)
            formData.append('student_id', this.student_id)
            this.selected = []
            if (this.disable_th == true && this.disable_lt == true) {
                this.selected = []
            } else if (this.disable_th == true || this.selected_th == '') {
                this.selected = [this.selected_lt]
            } else if (this.disable_lt == true || this.selected_lt == '') {
                this.selected = [this.selected_th]
            } else {
                this.selected = [this.selected_lt, this.selected_th]
            }

            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post('../../api/student/subject-register/dang-ky-mon-hoc', formData)
                .then(res => {
                    this.fetchSubjectRegister()
                    this.fetchResultSub()
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
        disableLt(value) {
            if (value.calendar_subject_registered == value.calendar_subject_slot) {
                return true
            }
            if (this.disable_lt === true) {
                return true
            }
            // if (this.result_subs.length > 0) {
            //     for (let i = 0; i < this.result_subs.length; i++) {
            //         if (this.result_subs[i].calendar_subject_type == 0) {
            //             const check = this.result_subs[i].calendar_subject_id
            //             if (check == '') {
            //                 return false
            //             } else {
            //                 return true
            //             }
            //         }
            //     }
            // }
        },
        disableTh(value) {
            if (value.calendar_subject_registered == value.calendar_subject_slot) {
                return true
            }
            if (this.disable_th === true) {
                return true
            }
            // if (this.result_subs.length > 0) {
            //     for (let i = 0; i < this.result_subs.length; i++) {
            //         if (this.result_subs[i].calendar_subject_type == 1) {
            //             const check = this.result_subs[i].calendar_subject_id
            //             if (check == '') {
            //                 return false
            //             } else {
            //                 return true
            //             }
            //         }
            //     }
            // }
        },
        cancel(value) {
            this.$swal({
                title: 'Bạn có chắc chắn huỷ môn ' + value.subject_name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Huỷ !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            `../../api/student/subject-register/dang-ky-mon-hoc/huy-mon-hoc/${value.calendar_subject_id}/${value.register_subject_id}`
                        )
                        .then(res => {
                            this.fetchSubjectRegister()
                            this.fetchResultSub()
                            this.$swal('Đã huỷ!', 'Huỷ môn học thành công', 'success')
                        })
                        .catch(err => console.log(err))
                }
            })
        },
        changeMode(value) {
            this.button_change = true
            if (value.calendar_subject_type == 0) {
                this.disable_lt = false
            } else if (value.calendar_subject_type == 1) {
                this.disable_th = false
            }
            this.value_change = value
        },
        change() {
            let formData = new FormData()
            formData.append('semester', this.semester)
            formData.append('yearstart', this.start_year)
            formData.append('yearend', this.end_year)
            formData.append('student_id', this.student_id)
            this.selected = []
            if (this.disable_th == true && this.disable_lt == true) {
                this.selected = []
            } else if (this.disable_th == true || this.selected_th == '') {
                this.selected = [this.selected_lt]
            } else if (this.disable_lt == true || this.selected_lt == '') {
                this.selected = [this.selected_th]
            } else {
                this.selected = [this.selected_lt, this.selected_th]
            }

            for (let i = 0; i < this.selected.length; i++) {
                formData.append('subject[]', this.selected[i])
            }
            axios
                .post(
                    `../../api/student/subject-register/dang-ky-mon-hoc/thay-doi-mon-hoc/${this.value_change.calendar_subject_id}/${this.value_change.register_subject_id}`,
                    formData
                )
                .then(res => {
                    this.fetchSubjectRegister()
                    this.fetchResultSub()
                    this.$swal({
                        title: 'Thay đổi thành công!',
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
        }
    }
}
</script>

<style scoped>
.not-allowed {
    cursor: not-allowed;
}
</style>
