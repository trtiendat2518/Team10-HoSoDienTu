<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Đăng ký môn học HK{{ semester }}</p>
        </div>

        <div class="grid">
            <div class="form-group">
                <input type="radio" value="1" v-model="select_radio" /> Đúng kế hoạch
                <input type="radio" value="2" class="ml-2" v-model="select_radio" /> Theo CTĐT
                <input type="radio" value="3" class="ml-2" v-model="select_radio" /> Ngoài kế hoạch
            </div>

            <div v-show="select_radio == 1" class="table-responsive">
                <div v-if="subject_inplan.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5" scope="col" rowspan="2">
                                    STT
                                </th>
                                <th class="text-center w-15" scope="col" rowspan="2">
                                    Mã môn học
                                </th>
                                <th class="text-center w-50" scope="col" rowspan="2">
                                    Tên môn học
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Số TC
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    SL lớp
                                </th>
                                <th class="w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in subject_inplan" :key="value.subject_id">
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
                                    {{ countSubject(value) }}
                                </td>
                                <td class="text-center">
                                    <router-link
                                        class="btn btn-block btn-primary"
                                        tag="button"
                                        :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                    >
                                        Đăng ký
                                    </router-link>
                                </td>
                            </tr>
                            <tr v-show="!subject_inplan.length">
                                <td colspan="9">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
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

            <div v-show="select_radio == 2" class="table-responsive">
                <div v-if="subject_program.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5" scope="col" rowspan="2">
                                    STT
                                </th>
                                <th class="text-center w-15" scope="col" rowspan="2">
                                    Mã môn học
                                </th>
                                <th class="text-center w-50" scope="col" rowspan="2">
                                    Tên môn học
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Số TC
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    SL lớp
                                </th>
                                <th class="w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in subject_program" :key="value.subject_id">
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
                                    {{ countSubject(value) }}
                                </td>
                                <td class="text-center">
                                    <router-link
                                        class="btn btn-block btn-primary"
                                        tag="button"
                                        :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                    >
                                        Đăng ký
                                    </router-link>
                                </td>
                            </tr>
                            <tr v-show="!subject_program.length">
                                <td colspan="9">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
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

            <div v-show="select_radio == 3" class="table-responsive">
                <div v-if="subject_outplan.length > 0">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5" scope="col" rowspan="2">
                                    STT
                                </th>
                                <th class="text-center w-15" scope="col" rowspan="2">
                                    Mã môn học
                                </th>
                                <th class="text-center w-50" scope="col" rowspan="2">
                                    Tên môn học
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    Số TC
                                </th>
                                <th class="text-center w-10" scope="col" rowspan="2">
                                    SL lớp
                                </th>
                                <th class="w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in subject_outplan" :key="value.subject_id">
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
                                    {{ countSubject(value) }}
                                </td>
                                <td class="text-center">
                                    <router-link
                                        class="btn btn-block btn-primary"
                                        tag="button"
                                        :to="{ name: 'subjectregistering', params: { idRSubject: value.subject_id } }"
                                    >
                                        Đăng ký
                                    </router-link>
                                </td>
                            </tr>
                            <tr v-show="!subject_outplan.length">
                                <td colspan="9">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
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
                    <h4 class="text-center">
                        Kết quả đăng ký: <i>{{ result_subject }} môn học</i>, <i>{{ result_credit }} tín chỉ</i>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div v-if="result_all.length > 0">
                            <table class="table table-nowrap">
                                <thead class="result-background text-white">
                                    <tr>
                                        <th class="text-center w10">
                                            Loại
                                        </th>
                                        <th class="text-center w10">
                                            Mã môn học
                                        </th>
                                        <th class="text-center w30">
                                            Tên môn học
                                        </th>
                                        <th class="text-center w5">
                                            TC
                                        </th>
                                        <th class="text-center w15">
                                            Lịch học
                                        </th>
                                        <th class="text-center w10">
                                            Ngày BĐ
                                        </th>
                                        <th class="text-center w10">
                                            Ngày KT
                                        </th>
                                        <th class="w10"></th>
                                        <th class="w10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="value in result_all" :key="value.calendar_subject_id">
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
                                                Xem thêm
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-block btn-danger" @click="cancel(value)">
                                                Huỷ bỏ
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
            select_radio: 1,
            subjects: [],
            registers: [],
            subject_program: [],
            subject_inplan: [],
            subject_outplan: [],
            quantities: [],
            result_all: [],
            result_credit: 0,
            result_subject: 0,
            semester: ''
        }
    },
    mounted() {
        this.fetchCalendarRegister()
    },
    watch: {
        select_radio(value) {
            if (value == 2) {
                this.fetchSubjectProgram()
            } else if (value == 3) {
                this.fetchSubjectOutplan()
            }
        },
        semester(value) {
            if (value != '') {
                this.fetchSubjectInplan()
                this.subjectQuantity()
                this.fetchResultAll()
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
                    let register = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            return el
                        }
                    })
                    this.registers = register
                    this.semester = register[0].location
                })
                .catch(err => console.log(err))
        },
        fetchSubjectProgram(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/theo-ctdt/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subject_program = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSubjectInplan(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/theo-ke-hoach/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subject_inplan = res.data
                })
                .catch(err => console.log(err))
        },
        fetchSubjectOutplan(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/ngoai-ke-hoach/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.subject_outplan = res.data
                })
                .catch(err => console.log(err))
        },
        fetchResultAll(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/ket-qua-dk-tat-ca/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.result_all = res.data
                    this.result_subject = res.data.length
                    this.result_credit = 0
                    for (let i = 0; i < res.data.length; i++) {
                        this.result_credit = res.data[i].subject_credit + this.result_credit
                    }
                })
                .catch(err => console.log(err))
        },
        subjectQuantity(page_url) {
            page_url = `../../api/student/subject-register/dang-ky-mon-hoc/so-luong-lop-mon-hoc/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.quantities = res.data
                })
                .catch(err => console.log(err))
        },
        countSubject(value) {
            let number = this.quantities.filter(qtt => qtt.subject_id == value.subject_id)
            return number.length
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
                            this.fetchSubjectProgram()
                            this.fetchSubjectInplan()
                            this.fetchSubjectOutplan()
                            this.fetchResultAll()
                            this.$swal('Đã huỷ!', 'Huỷ môn học thành công', 'success')
                        })
                        .catch(err => console.log(err))
                }
            })
        },
        changeMode(value) {
            this.$router.push({ name: 'subjectregistering', params: { idRSubject: value.subject_id } })
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
}
</style>
