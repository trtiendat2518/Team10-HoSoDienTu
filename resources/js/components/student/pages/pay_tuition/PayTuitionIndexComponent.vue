<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thanh toán học phí</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="alert alert-warning" v-show="!check_time">
                    <div class="mb-2 text-center">
                        <p>Hiện tại chưa tới ngày giờ để bạn thanh toán học phí</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button @click="paymentVNPAY()" class="btn btn-lg btn-info btn-vnpay" name="redirect" :disabled="check_payment">
                            Thanh toán <b><span class="text-red">VN</span><span class="text-white">PAY</span></b>
                        </button>
                        <button @click="paymentMOMO()" class="btn btn-lg btn-info btn-momo" name="redirect" :disabled="check_payment">
                            Thanh toán <b><span>MoMo</span></b>
                        </button>
                    </div>
                </div>

                <div v-show="check_time == true" class="table-responsive">
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
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Tổng số tín chỉ</td>
                                <td class="text-center">
                                    {{ sum_credit }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Tổng số tiền tín chỉ</td>
                                <td class="text-center">{{ tuition_fee | formatNumber }} VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Miễn giảm</td>
                                <td class="text-center" v-if="tuition_discount == 0">-</td>
                                <td class="text-center" v-else>{{ tuition_discount }}%</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><b>Tổng phải đóng</b></td>
                                <td class="text-center" v-if="tuition_discount == 0">
                                    <b class="text-green" v-if="check_payment">
                                        <del>{{ tuition_fee | formatNumber }} VNĐ</del>
                                    </b>
                                    <b class="text-red" v-else-if="!check_payment"> {{ tuition_fee | formatNumber }} VNĐ </b>
                                </td>
                                <td class="text-center" v-else>
                                    <b class="text-green" v-if="check_payment">
                                        <del>
                                            {{ (tuition_fee - tuition_fee * (tuition_discount / 100)) | formatNumber }}
                                            VNĐ
                                        </del>
                                    </b>
                                    <b class="text-red" v-else-if="!check_payment">
                                        {{ (tuition_fee - tuition_fee * (tuition_discount / 100)) | formatNumber }}
                                        VNĐ
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><b>Trạng thái</b></td>
                                <td class="text-center">
                                    <p v-if="check_payment" class="text-green"><b>Đã thanh toán</b></p>
                                    <p v-else-if="!check_payment" class="text-red"><b>Chưa thanh toán</b></p>
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            check_time: false,
            semester: 0,
            tuitions: [],
            subject_id: [],
            subjects: [],
            subject_name: '',
            subject_code: '',
            subject_credit: '',
            sum_credit: 0,
            tuition_fee: 0,
            tuition_discount: 0,
            check_payment: false
        }
    },
    mounted() {
        this.fetchCalendarPayTuition()
    },
    watch: {
        check_time(value) {
            if (value == true) {
                this.fetchSubjectPayTuition()
                this.paymentCheck()
            }
        },
        semester(value) {
            if (value != 0) {
                this.paymentCheck()
            }
        }
    },
    methods: {
        fetchCalendarPayTuition(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/thoi-gian-thanh-toan/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            this.semester = el.location
                            return (this.check_time = true)
                        }
                    })
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
                    this.sum_credit = 0
                    for (let i = 0; i < this.tuitions.length; i++) {
                        this.sum_credit = subjects[this.tuitions[i]][0].subject_credit + this.sum_credit
                    }
                })
                .catch(err => console.log(err))
        },
        paymentVNPAY() {
            let formData = new FormData()
            let tuition_payment = 0
            if (this.tuition_discount == 0) {
                tuition_payment = this.tuition_fee
            } else {
                tuition_payment = this.tuition_fee - this.tuition_fee * (this.tuition_discount / 100)
            }
            formData.append('tuition_fee', tuition_payment)
            axios
                .post(`../../api/student/pay-tuition/thanh-toan-hoc-phi/vnpay/${this.student_id}/${this.semester}`, formData)
                .then(res => {
                    window.open(res.data.data)
                })
                .catch(err => {
                    console.log(err)
                })
        },
        paymentMOMO() {
            let formData = new FormData()
            let tuition_payment = 0
            if (this.tuition_discount == 0) {
                tuition_payment = this.tuition_fee
            } else {
                tuition_payment = this.tuition_fee - this.tuition_fee * (this.tuition_discount / 100)
            }
            formData.append('tuition_fee', tuition_payment)
            axios
                .post(`../../api/student/pay-tuition/thanh-toan-hoc-phi/momo/${this.student_id}/${this.semester}`, formData)
                .then(res => {
                    window.open(res.data.payUrl)
                })
                .catch(err => {
                    console.log(err)
                })
        },
        paymentCheck(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/check-payment/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.tuition_fee = res.data[0].payment_fee
                    this.tuition_discount = res.data[0].payment_discount
                    if (res.data[0].payment_status == 0) {
                        this.check_payment = true
                    } else {
                        this.check_payment = false
                    }
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.text-center {
    border: none;
}
.btn-vnpay {
    float: right;
    width: 15vw;
    background-color: #005baa;
    border-color: #005baa;
    margin-right: 10px;
}
.btn-vnpay:hover {
    background-color: #0e77d2;
    border-color: #0e77d2;
}
.btn-momo {
    float: right;
    width: 15vw;
    background-color: #d82d8b;
    border-color: #d82d8b;
    margin-right: 10px;
}
.btn-momo:hover {
    background-color: #dd509d;
    border-color: #dd509d;
}
.text-green {
    color: green;
}
</style>
