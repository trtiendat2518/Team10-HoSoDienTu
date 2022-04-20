<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Tổng hợp học phí</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center text-white">
                                    STT
                                </th>
                                <th class="text-center text-white">
                                    Học kỳ
                                </th>
                                <th class="text-center text-white">
                                    Học phí chưa giảm
                                </th>
                                <th class="text-center">
                                    Miễn giảm
                                </th>
                                <th class="text-center">
                                    Phải thu
                                </th>
                                <th class="text-center">
                                    Đã thu
                                </th>
                                <th class="text-center">
                                    Còn nợ
                                </th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="total.length" v-for="(pay, index) in total" :key="pay.payment_id">
                                <td class="text-center">
                                    {{ (index += 1) }}
                                </td>
                                <td class="text-center">Học kỳ {{ pay.payment_semester }}</td>
                                <td class="text-center">
                                    {{ pay.payment_fee | formatNumber }}
                                </td>
                                <td class="text-center">
                                    <div v-if="pay.payment_discount == 0">0</div>
                                    <div v-else>
                                        {{ (pay.payment_fee * (pay.payment_discount / 100)) | formatNumber }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div v-if="pay.payment_discount == 0">
                                        {{ pay.payment_fee | formatNumber }}
                                    </div>
                                    <div v-else>
                                        {{ (pay.payment_fee - pay.payment_fee * (pay.payment_discount / 100)) | formatNumber }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div v-if="pay.payment_status == 0">
                                        {{ pay.payment_fee | formatNumber }}
                                    </div>
                                    <div v-else-if="pay.payment_status == 1">0</div>
                                </td>
                                <td class="text-center">
                                    <div v-if="pay.payment_discount == 0">
                                        {{ pay.payment_paid - pay.payment_fee }}
                                    </div>
                                    <div v-else>
                                        {{
                                            (pay.payment_paid - (pay.payment_fee - pay.payment_fee * (pay.payment_discount / 100)))
                                                | formatNumber
                                        }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <router-link
                                        class="btn btn-block btn-primary"
                                        tag="button"
                                        :to="{ name: 'tuitionstudentdetail', params: { idTuitionStudent: pay.payment_id } }"
                                    >
                                        Xem chi tiết
                                    </router-link>
                                </td>
                            </tr>
                            <tr v-show="total.length">
                                <td colspan="2" class="text-center text-red"><b>Tổng cộng</b></td>
                                <td class="text-center text-red">
                                    <b>{{ sumFeeNotDiscount | formatNumber }}</b>
                                </td>
                                <td class="text-center text-red">
                                    <b>{{ sumDisCount | formatNumber }}</b>
                                </td>
                                <td class="text-center text-red">
                                    <b>{{ sumFee | formatNumber }}</b>
                                </td>
                                <td class="text-center text-red">
                                    <b>{{ sumPaid | formatNumber }}</b>
                                </td>
                                <td class="text-center text-red">
                                    <b>{{ sumNotPaid | formatNumber }}</b>
                                </td>
                            </tr>
                            <tr v-show="!total.length">
                                <td colspan="8">
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
            total: [],
            sumFeeNotDiscount: 0,
            sumDisCount: 0,
            sumFee: 0,
            sumPaid: 0,
            sumNotPaid: 0
        }
    },
    mounted() {
        this.fetchTotalPayment()
    },
    watch: {},
    methods: {
        fetchTotalPayment(page_url) {
            page_url = `../../api/student/pay-tuition/thanh-toan-hoc-phi/total-payment/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.total = res.data
                    for (let i = 0; i < this.total.length; i++) {
                        let discount = 0
                        let fee = 0
                        let notpaid = 0
                        if (this.total[i].payment_discount > 0) {
                            discount = this.total[i].payment_fee * (this.total[i].payment_discount / 100)
                            fee = this.total[i].payment_fee - discount
                            notpaid = this.total[i].payment_paid - fee
                        } else {
                            fee = this.total[i].payment_fee
                            notpaid = this.total[i].payment_paid - fee
                        }
                        this.sumFeeNotDiscount = this.total[i].payment_fee + this.sumFeeNotDiscount
                        this.sumDisCount = discount + this.sumDisCount
                        this.sumFee = fee + this.sumFee
                        this.sumPaid = this.total[i].payment_paid + this.sumPaid
                        this.sumNotPaid = notpaid + this.sumNotPaid
                    }
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
