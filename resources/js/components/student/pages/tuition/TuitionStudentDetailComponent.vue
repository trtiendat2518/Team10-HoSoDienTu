<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Học phí học kỳ</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-12">
                        <router-link class="btn btn-lg btn-secondary btn-pdf" tag="button" :to="{ name: 'tuitionstudentindex' }">
                            Quay lại
                        </router-link>
                        <button @click="printPDF()" class="btn btn-lg btn-info btn-pdf" :disabled="!check_payment">
                            In PDF
                        </button>
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
                                <th class="text-center">
                                    Số tín chỉ
                                </th>
                                <th class="text-center">
                                    Số phí tín chỉ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="tuitions.length" v-for="(tuition, index) in tuitions" :key="tuition">
                                <td class="text-center">
                                    {{ (index += 1) }}
                                </td>
                                <td class="text-center">
                                    {{ subjects[tuition][0].subject_code }}
                                </td>
                                <td>
                                    {{ subjects[tuition][0].subject_name }}
                                </td>
                                <td class="text-center">
                                    {{ subjects[tuition][0].subject_credit }}
                                </td>
                                <td class="text-center">
                                    {{ (fee * subjects[tuition][0].subject_credit) | formatNumber }}
                                </td>
                            </tr>
                            <tr v-show="!tuitions.length">
                                <td colspan="4">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <VueHtml2pdf
                    :manual-pagination="true"
                    :enable-download="true"
                    ref="DownloadComp"
                    :filename="'hoa-don-hoc-phi-hoc-ki-' + semester"
                    pdf-format="a3"
                    pdf-content-width="100%"
                    hidden
                >
                    <section slot="pdf-content">
                        <div class="center-style">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6 class="text-center text-black">BỘ GIÁO DỤC VÀ ĐÀO TẠO</h6>
                                    <h6 class="text-center text-black">TRƯỜNG ĐẠI HỌC VĂN LANG</h6>
                                    <img :src="`../public/student/img/vlu.png`" alt="vlu" class="img-style" />
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-center text-black">CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                                    <h6 class="text-center text-black">Độc lập - Tự do - Hạnh phúc</h6>
                                </div>
                            </div>
                            <h3 class="text-center mt-3">HOÁ ĐƠN ĐIỂN TỬ</h3>
                            <h6 class="text-center mt-3">Học kỳ: HK{{ semester }}</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    Họ tên: <b>{{ student_info.student_fullname }}</b>
                                </div>
                                <div class="col-md-6">MSSV: {{ student_info.student_code }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">Khoa: {{ student_info.student_faculty }}</div>
                                <div class="col-md-6">Khoá học: {{ student_info.student_course }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">Chuyên ngành: {{ student_info.student_major }}</div>
                                <div class="col-md-6">Lớp: {{ student_info.student_course_code }}-{{ student_info.student_class }}</div>
                            </div>
                            <div class="table-responsive mt-3" ref="content">
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
                                            <th class="text-center">
                                                Số tín chỉ
                                            </th>
                                            <th class="text-center">
                                                Số phí tín chỉ
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-show="tuitions.length" v-for="(tuition, index) in tuitions" :key="tuition">
                                            <td class="text-center">
                                                {{ (index += 1) }}
                                            </td>
                                            <td class="text-center">
                                                {{ subjects[tuition][0].subject_code }}
                                            </td>
                                            <td>
                                                {{ subjects[tuition][0].subject_name }}
                                            </td>
                                            <td class="text-center">
                                                {{ subjects[tuition][0].subject_credit }}
                                            </td>
                                            <td class="text-center">
                                                {{ (fee * subjects[tuition][0].subject_credit) | formatNumber }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Đã đóng</td>
                                            <td class="text-center">{{ payment_paid | formatNumber }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Phương thức</td>
                                            <td class="text-center">{{ payment_type }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    Ngày in: <i>{{ print_date }}</i>
                                </div>
                            </div>
                        </div>
                    </section>
                </VueHtml2pdf>
            </div>
        </div>
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
export default {
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            student_id: this.$studentId,
            payment_id: this.$route.params.idTuitionStudent,
            tuitions: [],
            subjects: [],
            semester: 0,
            fee: 0,
            payment_paid: 0,
            payment_type: '',
            print_date: '',
            check_payment: false,
            student_info: {
                student_fullname: '',
                student_code: '',
                student_class: '',
                student_course: '',
                student_course_code: '',
                student_major: '',
                student_faculty: ''
            }
        }
    },
    mounted() {
        this.fetchDetailPayment()
        this.fetchDetailTuition()
    },
    watch: {
        semester(value) {
            if (value != 0) {
                this.fetchSubjectPayTuition()
            }
        }
    },
    methods: {
        fetchDetailPayment(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/detail-payment/${this.payment_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.payment_paid = res.data[0].payment_paid
                    this.semester = res.data[0].payment_semester
                    this.payment_type = res.data[0].payment_code.split('_')[0]
                    if (res.data[0].payment_status == 0) {
                        this.check_payment = true
                    } else {
                        this.check_payment = false
                    }
                })
                .catch(err => console.log(err))
        },
        fetchDetailTuition(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.fee = res.data[0].tuition_fee
                })
                .catch(err => console.log(err))
        },
        fetchSubjectPayTuition(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/mon-hoc/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const subjects = res.data.reduce((subjects, item) => {
                        const subject = subjects[item.subject_id] || []
                        subject.push(item)
                        subjects[item.subject_id] = subject
                        return subjects
                    }, {})
                    this.tuitions = Object.keys(subjects)
                    this.subjects = subjects

                    this.student_info.student_fullname = res.data[0].student_fullname
                    this.student_info.student_code = res.data[0].student_code
                    this.student_info.student_course = res.data[0].course_name
                    this.student_info.student_course_code = res.data[0].course_code
                    this.student_info.student_faculty = res.data[0].faculty_name
                    this.student_info.student_major = res.data[0].major_name
                    this.student_info.student_class = res.data[0].class_name
                })
                .catch(err => console.log(err))
        },
        printPDF() {
            const date = new Date()
            const day = date.getDate()
            const month = date.getMonth() + 1
            const year = date.getFullYear()
            this.print_date = 'Ngày ' + day + ' tháng ' + month + ' năm ' + year
            this.$refs.DownloadComp.generatePdf()
        }
    }
}
</script>

<style scoped>
.btn-pdf {
    float: right;
    width: 10vw;
    margin-right: 10px;
}
</style>
